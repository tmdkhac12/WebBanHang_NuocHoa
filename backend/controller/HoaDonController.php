<?php
require_once __DIR__ . "/../model/HoaDonModel.php";
require_once __DIR__ . "/../model/DiaChiModel.php";
require_once __DIR__ . "/../model/ChiTietHoaDonModel.php";
require_once __DIR__ . "/../config/connection.php";

class HoaDonController
{
    private $hoaDonModel;

    function __construct()
    {
        $this->hoaDonModel = new HoaDonModel();
    }

    public function getAllHoaDon($limit = 10, $offset = 0) {
        return $this->hoaDonModel->getAllHoaDon($limit, $offset);
    }
    
    public function getTotalOrders()
    {
        return $this->hoaDonModel->getTotalOrders();
    }

    public function getAllHoaDonOf($maKhachHang)
    {
        $hoadons = $this->hoaDonModel->getAllHoaDonOf($maKhachHang);

        if (!isset($hoadons)) {
            return null;
        }

        $hoadons_grouped = $this->groupHoaDonByMa($hoadons);

        return $hoadons_grouped;
    }

    public function huyDonHang($maDonHang)
    {
        return $this->hoaDonModel->huyDonHang($maDonHang);
    }

    public function addFullHoaDon($maKhachHang, $diachi, $hoadon, $chitiets)
    {
        $connection = getConnection();
        $connection->begin_transaction();

        try {
            $diaChiModel = new DiaChiModel();
            $chiTietHoaDonModel = new ChiTietHoaDonModel();

            // 1. Thêm địa chỉ giao hàng
            $maDiaChi = $diaChiModel->addDiaChi(
                $connection,
                $maKhachHang,
                $diachi["fullName"],
                $diachi["phone"],
                $diachi["address"]
            );
            if (!$maDiaChi) throw new Exception("Không thể thêm địa chỉ");

            // 2. Tạo hóa đơn
            $maHoaDon = $this->hoaDonModel->addHoaDon(
                $connection,
                $maKhachHang,
                $maDiaChi,
                $hoadon["thoigian"],
                $hoadon["tongtien"],
                $hoadon["trangthai"]
            );
            if (!$maHoaDon) throw new Exception("Không thể thêm hóa đơn");

            // 3. Thêm chi tiết hóa đơn
            foreach ($chitiets as $chitiet) {
                $success = $chiTietHoaDonModel->addChiTiet(
                    $connection,
                    $chitiet,
                    $maHoaDon
                );
                if (!$success) throw new Exception("Lỗi thêm chi tiết hóa đơn");
            }

            $connection->commit();
            return ["success" => true, "message" => "Thanh toán thành công"];
        } catch (Exception $e) {
            $connection->rollback();
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    // Private Functions
    private function groupHoaDonByMa($hoadons)
    {
        $hoadons_grouped = [];
        $maTruocDo = null;
        $groupIndex = -1;

        foreach ($hoadons as $item) {
            if ($item['ma_hoa_don'] !== $maTruocDo) {
                $groupIndex++; // Tăng index nhóm khi gặp mã hóa đơn mới
                $maTruocDo = $item['ma_hoa_don'];
            }

            $hoadons_grouped[$groupIndex][] = $item;
        }

        return $hoadons_grouped;
    }
}
