<?php
require_once '../model/ThongKeModel.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$model = new ThongKeModel();

switch ($action) {
    case 'statistic': {
        $fromDate = $_GET['fromDate'] ?? '';
        $toDate = $_GET['toDate'] ?? '';
        $products = $model->getProductStats($fromDate, $toDate);
        $customers = $model->getTopCustomers($fromDate, $toDate);
        echo json_encode([
            'success' => true,
            'products' => $products,
            'customers' => $customers
        ]);
        break;
    }
}