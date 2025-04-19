<?php 
require __DIR__ . "/../config/connection.php";

class HoaDonModel {
    public function getAllHoaDonOf($maKhachHang) {
        $connection = getConnection();

        $sql = "SELECT hd.ma_hoa_don, hd.thoi_gian, hd.tong_tien, hd.trang_thai_don_hang, ct.so_luong_mua, dc.ten_nguoi_nhan, dc.so_dien_thoai_nguoi_nhan, dc.dia_chi_giao_hang, n.ten_nuoc_hoa, n.gia_ban
                From hoadon hd
                INNER JOIN chitiethoadon ct on hd.ma_hoa_don = ct.ma_hoa_don 
                INNER JOIN khachhang kh on hd.ma_khach_hang = kh.ma_khach_hang
                INNER JOIN diachi dc on hd.ma_dia_chi = dc.ma_dia_chi
                INNER JOIN nuochoa n on ct.ma_nuoc_hoa = n.ma_nuoc_hoa
                WHERE hd.ma_khach_hang =  ?
                ORDER BY hd.thoi_gian DESC
                ";

        $statement = $connection->prepare($sql);
        $statement->bind_param("i", $maKhachHang);
        $statement->execute();

        $hoadons = [];
        $queryResult = $statement->get_result();
        while ($row = $queryResult->fetch_assoc()) {
            $hoadons[] = $row;
        }

        $statement->close();
        $connection->close();
        return (count($hoadons) > 0 ? $hoadons : null);
    }

    public function huyDonHang($maHoaDon) {
        $connection = getConnection();

        $sql = "UPDATE hoadon SET trang_thai_don_hang = 'Đã hủy' WHERE ma_hoa_don = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("i", $maHoaDon);
        $statement->execute();

        return ($statement->affected_rows > 0 ? true : false);
    }
}
?>