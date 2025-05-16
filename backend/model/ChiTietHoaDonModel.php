<?php
require_once __DIR__ . "/../config/connection.php";

class ChiTietHoaDonModel
{
    public function addChiTiet($connection, $chitiet, $maHoaDon)
    {
        // 1. Lấy giá bán từ bảng dungtich_nuochoa
        $sqlGetGia = "SELECT gia_ban FROM dungtich_nuochoa WHERE ma_nuoc_hoa = ? AND ma_dung_tich = ?";
        $stmt = $connection->prepare($sqlGetGia);
        $stmt->bind_param("ii", $chitiet["product_id"], $chitiet["size_id"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $giaBan = 0;

        if ($row = $result->fetch_assoc()) {
            $giaBan = $row["gia_ban"];
        } else {
            throw new Exception("Không tìm thấy giá bán cho sản phẩm (ma_nuoc_hoa = {$chitiet['product_id']}, ma_dung_tich = {$chitiet['size_id']})");
        }

        // 2. Insert vào chi tiết hóa đơn
        $sqlInsert = "INSERT INTO chitiethoadon (ma_nuoc_hoa, ma_dung_tich, ma_hoa_don, so_luong_mua, gia_ban)
                    VALUES (?, ?, ?, ?, ?)";
        $stmtInsert = $connection->prepare($sqlInsert);
        $stmtInsert->bind_param(
            "iiiid",
            $chitiet["product_id"],
            $chitiet["size_id"],
            $maHoaDon,
            $chitiet["quantity"],
            $giaBan
        );
        $stmtInsert->execute();

        return ($stmtInsert->affected_rows > 0);
    }

}
