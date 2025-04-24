<?php
require_once __DIR__ . "/../config/connection.php";

class ChiTietHoaDonModel
{
    public function addChiTiet($connection, $chitiet, $maHoaDon)
    {
        $sql = "INSERT INTO chitiethoadon (ma_nuoc_hoa, ma_dung_tich, ma_hoa_don, so_luong_mua)
                VALUES (?, ?, ?, ?);";
        $statement = $connection->prepare($sql);
        $statement->bind_param("iiii", $chitiet["product_id"], $chitiet["size_id"], $maHoaDon, $chitiet["quantity"]);
        $statement->execute();

        return ($statement->affected_rows > 0 ? true : false);;
    }
}
