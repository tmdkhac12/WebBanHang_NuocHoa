<?php
require_once __DIR__ . "/../controller/ThuongHieuController.php";

header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : '';
try {
    $thuongHieuController = new ThuongHieuController();
    switch($action){
        case 'getAllBrands':
            echo json_encode($thuongHieuController->getAllBrand());
            break;
        default:
            echo json_encode(['error' => 'Lỗi server: ' . $e->getMessage()]);
 
    }
}
catch(Exception $e)
{
     echo json_encode(['error' => 'Lỗi server: ' . $e->getMessage()]);
   
}