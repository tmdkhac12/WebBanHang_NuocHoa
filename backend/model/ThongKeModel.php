<?php
require_once __DIR__ . "/../config/connection.php";

class ThongKeModel {
    public function getProductStats($from, $to) {
        $conn = getConnection();
        $sql = "SELECT 
                    nh.ten_nuoc_hoa, 
                    dt.dung_tich,
                    SUM(ct.so_luong_mua) AS so_luong_ban,
                    SUM(dt_nh.gia_ban * ct.so_luong_mua) AS tong_tien
                FROM hoadon hd
                INNER JOIN chitiethoadon ct ON hd.ma_hoa_don = ct.ma_hoa_don
                INNER JOIN nuochoa nh ON ct.ma_nuoc_hoa = nh.ma_nuoc_hoa
                INNER JOIN dungtich_nuochoa dt_nh ON ct.ma_nuoc_hoa = dt_nh.ma_nuoc_hoa AND ct.ma_dung_tich = dt_nh.ma_dung_tich
                INNER JOIN dungtich dt ON dt_nh.ma_dung_tich = dt.ma_dung_tich
                WHERE hd.trang_thai_don_hang = 'Đã giao'
                AND hd.thoi_gian BETWEEN ? AND ?
                GROUP BY nh.ten_nuoc_hoa, dt.dung_tich
                ORDER BY so_luong_ban DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $from, $to);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) $data[] = $row;
        $stmt->close();
        $conn->close();
        return $data;
    }

    public function getTopCustomers($from, $to) {
        $conn = getConnection();
        $sql = "SELECT kh.ma_khach_hang, kh.ten_khach_hang, kh.email, SUM(hd.tong_tien) AS tong_doanh_thu
                FROM hoadon hd
                JOIN khachhang kh ON hd.ma_khach_hang = kh.ma_khach_hang
                WHERE hd.thoi_gian BETWEEN ? AND ?
                GROUP BY kh.ma_khach_hang
                ORDER BY tong_doanh_thu DESC
                LIMIT 5";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $from, $to);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) $data[] = $row;
        $stmt->close();
        $conn->close();
        return $data;
    }
}