<?php
require_once __DIR__ . "/../config/connection.php";

class DiaChiModel
{
    public function addDiaChi($connection, $maKhachHang, $tenNguoiNhan, $phone, $address)
    {
        $sql = "INSERT INTO diachi (ma_khach_hang, ten_nguoi_nhan, so_dien_thoai_nguoi_nhan, dia_chi_giao_hang)
                VALUES (?, ?, ?, ?);";
        $statement = $connection->prepare($sql);
        $statement->bind_param("isss", $maKhachHang, $tenNguoiNhan, $phone, $address);
        $statement->execute();

        return ($statement->affected_rows > 0 ? $connection->insert_id : false);
    }
}
