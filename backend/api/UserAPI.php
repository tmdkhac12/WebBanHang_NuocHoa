<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . "/../controller/UserController.php";

$userController = new UserController();

$action = "";
if (isset($_GET["action"])) {
    $action = $_GET["action"];
}

switch ($action) {
    case 'getAllUsers':
        // echo ở đây ghi dữ liệu vào output stream của HTTP respond tức là đối tượng Respond khi fetch 
        // nên nó không hiển thị ở dạng html trên client  
        // echo json_encode($userController->getAllUsers());
        // break;
    case 'login': {
        header('Content-Type: application/json');

        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        if (!$username || !$password) {
            echo json_encode([
                "success" => false,
                "message" => "Thiếu tên đăng nhập hoặc mật khẩu."
            ]);
            exit;
        }

        // Gọi controller để lấy tài khoản
        $account = $userController->getAccount($username, $password);

        if (isset($account)) {
            $_SESSION["user_id"] = $account["ma_khach_hang"];
            $_SESSION["username"] = $account["username"];
            $_SESSION["email"] = $account["email"];
            $_SESSION["ten_khach_hang"] = $account["ten_khach_hang"];
            $_SESSION["role"] = $account["quyen_han"];

            echo json_encode([
                "success" => true,
                "message" => "Đăng nhập thành công",
                "quyen_han" => $account["quyen_han"] // ✅ CHỈ đặt ở đây!
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Username hoặc password không chính xác"
            ]);
        }
        break;
    }
    case 'logout': {
            if (isset($_SESSION["username"])) {
                session_unset();
                session_destroy();

                echo json_encode(["success" => true, "message" => "Đăng xuất thành công"]);
            } else {
                echo json_encode(["success" => true, "message" => "Bạn chưa đăng nhập!"]);
            }
            break;
        }
    case 'addUser': {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!empty($data['username']) && !empty($data['password'])) {
            $name = $data['name'];
            $email = $data['email'];
            $username = $data['username'];
            $password = $data['password'];
            $status = $data['status'];
            $quyenhan = $data['quyenhan'];

            $result = $userController->addUser($name, $email, $username, $password, $status, $quyenhan);
            
            switch ($result) {
                case 1:
                    echo json_encode(['success' => true, 'message' => 'Người dùng đã được thêm thành công!']);
                    break;
                case -1:
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Username đã tồn tại!']);
                    break;
                case 0:
                default:
                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => 'Không thể thêm người dùng.']);
                    break;
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
        }
        break;
    }
    case 'searchUsers': {
        $keyword = $_GET['keyword'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 8;
        $offset = ($page - 1) * $limit;
        $users = $userController->searchUsers($keyword, $limit, $offset);
        $total = $userController->getTotalSearchUsers($keyword);
        echo json_encode([
            "success" => true,
            "users" => $users,
            "total" => $total
        ]);
        exit();
    }
    case 'getUserById':
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];
            $user = $userController->getUserById($userId);
            if ($user) {
                echo json_encode($user);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "User not found"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Missing user ID"]);
        }
        break;
    case 'updateUser': {
            // Get Fetch data
            $data = json_decode(file_get_contents("php://input"), true);
            $hoten = $data["name"] ?? null;
            $email = $data["email"] ?? null;
            $username = $data["username"] ?? null;
            $currentPassword = $data["password"] ?? null;
            $newPassword = $data["newPassword"] ?? null;
            $quyenhan = $data["quyenhan"] ?? null;
            $trangThai = $data["status"] ?? null;

            $currentRole = $userController->getUserRoleByUsername($username); // truy vấn role hiện tại trong DB

            // Nếu người dùng đang là admin và bị hạ xuống làm user
            if ($currentRole === "admin" && $quyenhan === "user") {
                $adminCount = $userController->getAdminCount();
                if ($adminCount <= 1) {
                    echo json_encode([
                        "success" => false,
                        "message" => "Không thể thay đổi quyền hạn. Hệ thống cần ít nhất một quản trị viên."
                    ]);
                    exit();
                }
            }



            // Call controller
            if (!empty($newPassword)) {
        // Có newPassword ⇒ kiểm tra mật khẩu cũ và đổi mật khẩu
                $code = $userController->updateUser(
                    $hoten, $email, $username, $currentPassword, $newPassword, $quyenhan, $trangThai
                );
            } else {
                // Không có newPassword ⇒ chỉ cập nhật thông tin
                $code = $userController->updateUserInfoFromAdmin(
                    $hoten, $email, $username,$currentPassword, $quyenhan, $trangThai
                );
            }
            // Check code

            switch ($code) {
                case 1:
                    // If success then recreate session
                    $_SESSION["email"] = $email;
                    $_SESSION["ten_khach_hang"] = $hoten;

                    echo json_encode(["success" => true, "message" => "Cập nhật thông tin thành công!"]);
                    break;
                case -1:
                    echo json_encode(["success" => false, "message" => "Có lỗi, vui lòng thử lại sau!"]);
                    break;
                case -2:
                    echo json_encode(["success" => false, "message" => "Mật khẩu hiện tại không chính xác!"]);
                    break;
                default:
                    # code...
                    break;
            }
            break;
        }
    default:
        http_response_code(400);
        echo json_encode(["error" => "Invalid Action"]);
        break;
}
