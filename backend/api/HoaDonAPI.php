<?php
header('Content-Type: application/json');

require __DIR__ . "/../controller/HoaDonController.php";

$hoaDonController = new HoaDonController();

$action = isset($_GET['action']) ? $_GET['action'] : '';


switch ($action) {
    case 'huydon':
        // Get maDonHang from body fetch when user onclick 
        $data = json_decode(file_get_contents("php://input"), true);
        $maHoaDon = $data["maHoaDon"];

        $isSuccess = $hoaDonController->huyDonHang($maHoaDon);
        if ($isSuccess) {
            echo json_encode(["success" => true, "message" => "Đơn hàng đã được hủy!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Có lỗi, vui lòng thử lại sau!"]);
        }
        break;
    default:
        http_response_code(400);
        echo json_encode(["error" => "Invalid Action"]);
        break;
}
