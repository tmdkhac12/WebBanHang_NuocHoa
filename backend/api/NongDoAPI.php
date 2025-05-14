<?php
require_once __DIR__ . "/../controller/NongDoController.php";

header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : '';
try {
    $nongDoController = new NongDoController();
    switch($action){
        case 'getAllNongDo':
            echo json_encode($nongDoController->getAllNongDo());
            break;
        default:
            echo json_encode(['error' => 'Lỗi server: ' . $e->getMessage()]);
 
    }
}
catch(Exception $e)
{
     echo json_encode(['error' => 'Lỗi server: ' . $e->getMessage()]);
   
}