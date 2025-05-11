<?php
require_once __DIR__ . "/../controller/NotHuongController.php";

header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : '';
try {
    $notHuongController = new NotHuongController();
    switch($action){
        case 'getAllNotHuong':
            echo json_encode($notHuongController->getAllNotHuong());
            break;
        default:
            echo json_encode(['error' => 'Lỗi server: ' . $e->getMessage()]);
 
    }
}
catch(Exception $e)
{
     echo json_encode(['error' => 'Lỗi server: ' . $e->getMessage()]);
   
}