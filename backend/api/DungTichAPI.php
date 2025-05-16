<?php
require_once __DIR__ . "/../controller/DungTichController.php";

header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : '';
try {
    $dungTichController = new DungTichController();
    switch($action){
        case 'getAllDungTich':
            echo json_encode($dungTichController->getAllDungTich());
            break;
        default:
            echo json_encode(['error' => 'Hành động không hợp lệ']);
    }
}
catch(Exception $e)
{
    echo json_encode(['error' => 'Lỗi server: ' . $e->getMessage()]);
}
