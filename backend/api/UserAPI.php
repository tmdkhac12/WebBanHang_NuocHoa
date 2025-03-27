<?php 
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
    
    default:
        echo json_encode(["error" => "Invalid Action"]);
        break;
}
?>