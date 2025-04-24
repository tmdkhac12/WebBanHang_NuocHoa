<?php
require_once __DIR__ . "/../config/connection.php";

class HoaDonModel
{
    public function getAllHoaDonOf($maKhachHang)
    {
        $connection = getConnection();

        $sql = "SELECT hd.ma_hoa_don, hd.thoi_gian, hd.tong_tien, hd.trang_thai_don_hang, ct.so_luong_mua, dc.ten_nguoi_nhan, dc.so_dien_thoai_nguoi_nhan, dc.dia_chi_giao_hang, nh.ten_nuoc_hoa, dt_nh.gia_ban, dt.dung_tich
                FROM hoadon hd
                INNER JOIN chitiethoadon ct on hd.ma_hoa_don = ct.ma_hoa_don
                INNER JOIN nuochoa nh on ct.ma_nuoc_hoa = nh.ma_nuoc_hoa
                INNER JOIN dungtich_nuochoa dt_nh on ct.ma_nuoc_hoa = dt_nh.ma_nuoc_hoa AND ct.ma_dung_tich = dt_nh.ma_dung_tich
                INNER JOIN diachi dc on hd.ma_dia_chi = dc.ma_dia_chi
                INNER JOIN dungtich dt on dt_nh.ma_dung_tich = dt.ma_dung_tich
                WHERE hd.ma_khach_hang = ?
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

    public function huyDonHang($maHoaDon)
    {
        $connection = getConnection();

        $sql = "UPDATE hoadon SET trang_thai_don_hang = 'Đã hủy' WHERE ma_hoa_don = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("i", $maHoaDon);
        $statement->execute();

        return ($statement->affected_rows > 0 ? true : false);
    }

    public function addHoaDon($connection, $maKhachHang, $maDiaChi, $thoiGian, $tongTien, $trangThai) {
        $sql = "INSERT INTO hoadon (ma_khach_hang, ma_dia_chi, thoi_gian, tong_tien, trang_thai_don_hang) 
                VALUES (?,?,?,?,?)";
        $statement = $connection->prepare($sql);
        $statement->bind_param("iisds", $maKhachHang, $maDiaChi, $thoiGian, $tongTien, $trangThai);
        $statement->execute();

        return ($statement->affected_rows > 0 ? $connection->insert_id : false);
    }
}
