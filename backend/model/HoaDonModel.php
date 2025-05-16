<?php
require_once __DIR__ . "/../config/connection.php";

class HoaDonModel
{
    public function getAllHoaDon($limit, $offset) {
        $connection = getConnection();
    
        $sql = "SELECT hd.ma_hoa_don, hd.thoi_gian, hd.tong_tien, hd.trang_thai_don_hang, 
                       c.ten_khach_hang, dc.ten_nguoi_nhan, dc.so_dien_thoai_nguoi_nhan, dc.dia_chi_giao_hang
                FROM hoadon hd
                LEFT JOIN khachhang c ON hd.ma_khach_hang = c.ma_khach_hang
                LEFT JOIN diachi dc ON hd.ma_dia_chi = dc.ma_dia_chi
                ORDER BY hd.thoi_gian 
                LIMIT ? OFFSET ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("ii", $limit, $offset);
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

    public function getHoaDonByID($maHoaDon)
    {
        $connection = getConnection();

        $sql = "SELECT hd.ma_hoa_don, hd.thoi_gian, hd.tong_tien, hd.trang_thai_don_hang,dc.ma_dia_chi,
                    c.ten_khach_hang, dc.ten_nguoi_nhan, dc.so_dien_thoai_nguoi_nhan, dc.dia_chi_giao_hang
                FROM hoadon hd
                LEFT JOIN khachhang c ON hd.ma_khach_hang = c.ma_khach_hang
                LEFT JOIN diachi dc ON hd.ma_dia_chi = dc.ma_dia_chi
                WHERE hd.ma_hoa_don = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("i", $maHoaDon);
        $statement->execute();

        $result = $statement->get_result();
        $hoaDon = $result->fetch_assoc();

        $statement->close();
        $connection->close();

        return $hoaDon ? $hoaDon : null;
    }

    public function getDetailHoaDonByID($maHoaDon)
    {
        $connection = getConnection();

        $sql = "SELECT hd.ma_hoa_don, hd.thoi_gian, hd.tong_tien, hd.trang_thai_don_hang,
                    ct.so_luong_mua, dc.ten_nguoi_nhan, dc.so_dien_thoai_nguoi_nhan, dc.dia_chi_giao_hang,
                    nh.ten_nuoc_hoa, dt_nh.gia_ban, dt.dung_tich , kh.ten_khach_hang, dc.ma_dia_chi
                FROM hoadon hd
                INNER JOIN chitiethoadon ct ON hd.ma_hoa_don = ct.ma_hoa_don
                INNER JOIN nuochoa nh ON ct.ma_nuoc_hoa = nh.ma_nuoc_hoa
                INNER JOIN dungtich_nuochoa dt_nh ON ct.ma_nuoc_hoa = dt_nh.ma_nuoc_hoa AND ct.ma_dung_tich = dt_nh.ma_dung_tich
                INNER JOIN diachi dc ON hd.ma_dia_chi = dc.ma_dia_chi
                INNER JOIN dungtich dt ON dt_nh.ma_dung_tich = dt.ma_dung_tich
                INNER JOIN khachhang kh ON kh.ma_khach_hang = hd.ma_khach_hang
                WHERE hd.ma_hoa_don = ?
                ORDER BY hd.thoi_gian DESC";

        $statement = $connection->prepare($sql);
        $statement->bind_param("i", $maHoaDon);
        $statement->execute();
        $result = $statement->get_result();

        $chiTiet = [];
        $hoaDonInfo = null;
        while ($row = $result->fetch_assoc()) {
            // Lấy thông tin hóa đơn từ dòng đầu tiên
            if ($hoaDonInfo === null) {
                $hoaDonInfo = [
                    'ten_khach_hang' => $row['ten_khach_hang'],
                    'ma_hoa_don' => $row['ma_hoa_don'],
                    'thoi_gian' => $row['thoi_gian'],
                    'tong_tien' => $row['tong_tien'],
                    'trang_thai_don_hang' => $row['trang_thai_don_hang'],
                    'ten_nguoi_nhan' => $row['ten_nguoi_nhan'],
                    'so_dien_thoai_nguoi_nhan' => $row['so_dien_thoai_nguoi_nhan'],
                    'dia_chi_giao_hang' => $row['dia_chi_giao_hang'],
                    'ma_dia_chi' => $row['ma_dia_chi'],
                ];
            }
            // Thêm chi tiết sản phẩm
            $chiTiet[] = [
                'ten_nuoc_hoa' => $row['ten_nuoc_hoa'],
                'dung_tich' => $row['dung_tich'],
                'gia_ban' => $row['gia_ban'],
                'so_luong_mua' => $row['so_luong_mua'],
            ];
        }
        $statement->close();
        $connection->close();

        if ($hoaDonInfo === null) {
            return null;
        }

        $hoaDonInfo['chi_tiet'] = $chiTiet;
        return $hoaDonInfo;
    }
    
    public function getTotalOrders()
    {
        $connection = getConnection(); 
        $sql = "SELECT COUNT(*) as total FROM hoadon"; // Giả sử bảng hóa đơn là `hoa_don`
        $result = $connection->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }

        return 0; 
    }

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

    public function updateTrangThai($maHoaDon, $trangThai)
    {
        $connection = getConnection();
        $sql = "UPDATE hoadon SET trang_thai_don_hang = ? WHERE ma_hoa_don = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("si", $trangThai, $maHoaDon);
        $result = $stmt->execute();
        $stmt->close();
        $connection->close();
        return $result;
    }

    public function searchHoaDon($keyword, $limit, $offset) {
        $connection = getConnection();
        $keyword = "%$keyword%";
        $sql = "SELECT hd.*, kh.ten_khach_hang, dc.so_dien_thoai_nguoi_nhan, dc.dia_chi_giao_hang
                FROM hoadon hd
                LEFT JOIN khachhang kh ON hd.ma_khach_hang = kh.ma_khach_hang
                LEFT JOIN diachi dc ON hd.ma_dia_chi = dc.ma_dia_chi
                WHERE kh.ten_khach_hang LIKE ? 
                OR dc.so_dien_thoai_nguoi_nhan LIKE ? 
                OR dc.dia_chi_giao_hang LIKE ?
                ORDER BY hd.thoi_gian
                LIMIT ? OFFSET ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sssii", $keyword, $keyword, $keyword, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        $stmt->close();
        $connection->close();
        return $orders;
    }

    public function getTotalSearchHoaDon($keyword) {
        $connection = getConnection();
        $keyword = "%$keyword%";
        $sql = "SELECT COUNT(*) as total
                FROM hoadon hd
                LEFT JOIN khachhang kh ON hd.ma_khach_hang = kh.ma_khach_hang
                LEFT JOIN diachi dc ON hd.ma_dia_chi = dc.ma_dia_chi
                WHERE kh.ten_khach_hang LIKE ? 
                OR dc.so_dien_thoai_nguoi_nhan LIKE ? 
                OR dc.dia_chi_giao_hang LIKE ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sss", $keyword, $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        $connection->close();
        return $row['total'];
    }
}
