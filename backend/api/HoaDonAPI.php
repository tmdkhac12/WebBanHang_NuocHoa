<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . "/../controller/HoaDonController.php";

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
    case 'getHoaDonByID': {
        try {
            if (!isset($_GET['id'])) {
                echo json_encode(["success" => false, "message" => "Thiếu mã hóa đơn"]);
                exit();
            }
            $maHoaDon = intval($_GET['id']);
            $hoaDon = $hoaDonController->getHoaDonByID($maHoaDon);

            if (!$hoaDon) {
                echo json_encode(["success" => false, "message" => "Không tìm thấy hóa đơn"]);
            } else {
                echo json_encode(["success" => true, "data" => $hoaDon]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Lỗi server: " . $e->getMessage()]);
        }
        exit();
    }
    case 'taoHoaDon': 
        try {
            // Get checkoutInfo from body fetch when user onclick 
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($_SESSION["user_id"])) {
                echo json_encode(["message" => "Chưa đăng nhập"]);
                break;
            }

            $maKhachHang = $_SESSION["user_id"];
            $diachi = $data["diachi"];
            $hoadon = $data["hoadon"];
            $chitiets = $data["chitiet"];

            echo json_encode($hoaDonController->addFullHoaDon($maKhachHang, $diachi, $hoadon, $chitiets));
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["message" => "Lỗi server: " . $e->getMessage()]);
        }
        
        break;
    default:
        http_response_code(400);
        echo json_encode(["error" => "Invalid Action"]);
        break;
}
