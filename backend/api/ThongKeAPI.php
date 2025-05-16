<?php
require_once '../model/ThongKeModel.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$model = new ThongKeModel();

switch ($action) {
    case 'statistic': {
        $from = $_GET['from'] ?? '';
        $to = $_GET['to'] ?? '';
        $products = $model->getProductStats($from, $to);
        $customers = $model->getTopCustomers($from, $to);
        echo json_encode([
            'success' => true,
            'products' => $products,
            'customers' => $customers
        ]);
        break;
    }
    case 'topCustomers':
        $from = $_GET['from'] ?? '';
        $to = $_GET['to'] ?? '';
        $data = $model->getTopCustomers($from, $to);
        echo json_encode($data);
        break;
    case 'dashboard':
        $data = $model->getDashboardStats();
        echo json_encode($data);
        break;
}