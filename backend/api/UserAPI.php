<?php
session_start();
header('Content-Type: application/json');

require __DIR__ . "/../controller/UserController.php";

$userController = new UserController();

$action = "";
if (isset($_GET["action"])) {
    $action = $_GET["action"];
}

switch ($action) {
    case 'getAllUsers':
        // echo ở đây ghi dữ liệu vào output stream của HTTP respond tức là đối tượng Respond khi fetch 
        // nên nó không hiển thị ở dạng html trên client  
        echo json_encode($userController->getAllUsers());
        break;
    case 'login': {
            // Get username and password from body fetch when user onclick 
            $data = json_decode(file_get_contents("php://input"), true);
            $username = $data["username"];
            $password = $data["password"];

            // Call Controller
            $account = $userController->getAccount($username, $password);

            // If account exist then create Session 
            if (isset($account)) {
                $_SESSION["user_id"] = $account["ma_khach_hang"];
                $_SESSION["username"] = $account["username"];
                $_SESSION["email"] = $account["email"];
                $_SESSION["ten_khach_hang"] = $account["ten_khach_hang"];
                echo json_encode(["success" => true, "message" => "Đăng nhập thành công"]);
            } else {
                echo json_encode(["success" => false, "message" => "Username hoặc password không chính xác"]);
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
            // Get Fetch data
            $data = json_decode(file_get_contents("php://input"), true);
            $hoten = $data["hoten"];
            $email = $data["email"];
            $username = $data["username"];
            $password = $data["password"];
            $status = $data["status"];

            // Call controller 
            $code = $userController->registerUser($hoten, $email, $username, $password, $status);

            if ($code == -1) {
                echo json_encode(["success" => false, "message" => "Username đã tồn tại!"]);
            } else {
                $success = ($code == 1 ? true : false);
                echo json_encode(["success" => $success, "message" => $success ? "Đăng ký tài khoản thành công!" : "Có lỗi xảy ra, đăng ký tài khoản thất bại vui lòng thử lại sau!"]);
            }
            break;
        }
    case 'updateUser': {
            // Get Fetch data
            $data = json_decode(file_get_contents("php://input"), true);
            $hoten = $data["hoten"];
            $email = $data["email"];
            $username = $data["username"];
            $currentPassword = $data["currentPassword"];
            $newPassword = $data["newPassword"];

            // Call controller
            $code = $userController->updateUser($hoten, $email, $username, $currentPassword, $newPassword);

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
