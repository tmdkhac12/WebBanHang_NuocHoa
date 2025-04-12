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
        $isExistAccount = $userController->isExistUsernameAndPassword($username, $password);

        // If account exist then create Session 
        if ($isExistAccount) {
            $_SESSION["username"] = $username;
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

        // If username existed 
        if ($userController->isExistUsername($username)) {
            echo json_encode(["success" => false, "message" => "Username đã tồn tại!"]);
        } else {
            $success = $userController->addUser($hoten, $email, $username, $password, $status);
            echo json_encode(["success" => $success, "message" => $success ? "Đăng ký tài khoản thành công!" : "Có lỗi xảy ra, đăng ký tài khoản thất bại vui lòng thử lại sau!"]);
        }
        break;
    }
    default:
        http_response_code(400);
        echo json_encode(["error" => "Invalid Action"]);
        break;
}
?>