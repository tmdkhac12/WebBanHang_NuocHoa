<?php
require __DIR__ . "/../config/connection.php";

class ProductModel {
    private $connection;

    public function __construct() {
        $this->connection = getConnection();
        if (!$this->connection) {
            throw new Exception("Không thể kết nối tới cơ sở dữ liệu.");
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function getAllProducts($limit, $offset) {
        $sql = "SELECT n.ma_nuoc_hoa, n.hinh_anh, n.ten_nuoc_hoa, n.gia_ban, t.ten_thuong_hieu 
                FROM nuochoa n 
                LEFT JOIN thuonghieu t ON n.ma_thuong_hieu = t.ma_thuong_hieu 
                LIMIT ? OFFSET ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();
        return $products;
    }

    public function getTotalProducts() {
        $sql = "SELECT COUNT(*) as total 
                FROM nuochoa n 
                LEFT JOIN thuonghieu t ON n.ma_thuong_hieu = t.ma_thuong_hieu";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $total = $result->fetch_assoc()['total'];
        $stmt->close();
        return $total;
    }

    private function buildFilterConditions($gender, $minPrice, $maxPrice, $brandSearch) {
        $conditions = ['sql' => '', 'types' => '', 'params' => []];

        if (!empty($gender)) {
            $placeholders = implode(',', array_fill(0, count($gender), '?'));
            $conditions['sql'] .= " AND n.gioi_tinh IN ($placeholders)";
            $conditions['types'] .= str_repeat('s', count($gender));
            $conditions['params'] = array_merge($conditions['params'], $gender);
        }

        if ($minPrice !== null && $maxPrice !== null && is_numeric($minPrice) && is_numeric($maxPrice)) {
            if ($minPrice == 0) {
                $conditions['sql'] .= " AND n.gia_ban <= ?";
                $conditions['types'] .= "d";
                $conditions['params'][] = $maxPrice;
            } elseif ($maxPrice == 999999999) {
                $conditions['sql'] .= " AND n.gia_ban >= ?";
                $conditions['types'] .= "d";
                $conditions['params'][] = $minPrice;
            } else {
                $conditions['sql'] .= " AND n.gia_ban BETWEEN ? AND ?";
                $conditions['types'] .= "dd";
                $conditions['params'][] = $minPrice;
                $conditions['params'][] = $maxPrice;
            }
        }

        if ($brandSearch) {
            $brandSearch = $this->connection->real_escape_string($brandSearch);
            $conditions['sql'] .= " AND t.ten_thuong_hieu LIKE ?";
            $conditions['types'] .= "s";
            $conditions['params'][] = "%$brandSearch%";
        }

        return $conditions;
    }

    public function filterProducts($gender, $minPrice, $maxPrice, $brandSearch, $limit, $offset) {
        $conditions = $this->buildFilterConditions($gender, $minPrice, $maxPrice, $brandSearch);

        $sql = "SELECT n.ma_nuoc_hoa, n.hinh_anh, n.ten_nuoc_hoa, n.gia_ban, t.ten_thuong_hieu 
                FROM nuochoa n 
                LEFT JOIN thuonghieu t ON n.ma_thuong_hieu = t.ma_thuong_hieu 
                WHERE 1=1" . $conditions['sql'];
        $sql .= " ORDER BY n.gia_ban ASC LIMIT ? OFFSET ?";
        $conditions['types'] .= "ii";
        $conditions['params'][] = $limit;
        $conditions['params'][] = $offset;

        $stmt = $this->connection->prepare($sql);
        if (!empty($conditions['params'])) {
            $stmt->bind_param($conditions['types'], ...$conditions['params']);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $stmt->close();

        $totalSql = "SELECT COUNT(*) as total 
                     FROM nuochoa n 
                     LEFT JOIN thuonghieu t ON n.ma_thuong_hieu = t.ma_thuong_hieu 
                     WHERE 1=1" . $conditions['sql'];
        $totalStmt = $this->connection->prepare($totalSql);
        if (!empty($conditions['params']) && count($conditions['params']) > 2) {
            $totalTypes = substr($conditions['types'], 0, -2);
            $totalParams = array_slice($conditions['params'], 0, -2);
            $totalStmt->bind_param($totalTypes, ...$totalParams);
        }
        $totalStmt->execute();
        $totalResult = $totalStmt->get_result();
        $total = $totalResult->fetch_assoc()['total'];
        $totalStmt->close();

        return ['products' => $products, 'total' => $total];
    }

    public function getProductById($id) {
        $sql = "SELECT n.ma_nuoc_hoa, n.hinh_anh, n.ten_nuoc_hoa, n.gia_ban, n.gioi_tinh, n.mo_ta, t.ten_thuong_hieu 
                FROM nuochoa n 
                LEFT JOIN thuonghieu t ON n.ma_thuong_hieu = t.ma_thuong_hieu 
                WHERE n.ma_nuoc_hoa = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($product) {
            $sql = "SELECT d.dung_tich 
                    FROM dungtich d 
                    JOIN dungtich_nuochoa dn ON d.ma_dung_tich = dn.ma_dung_tich 
                    WHERE dn.ma_nuoc_hoa = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $dungtich = [];
            while ($row = $result->fetch_assoc()) {
                $dungtich[] = $row['dung_tich'];
            }
            $stmt->close();
            $product['dung_tich'] = $dungtich;

            $sql = "SELECT n.nong_do 
                    FROM nongdo n 
                    JOIN nongdo_nuochoa nn ON n.ma_nong_do = nn.ma_nong_do 
                    WHERE nn.ma_nuoc_hoa = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $nongdo = [];
            while ($row = $result->fetch_assoc()) {
                $nongdo[] = $row['nong_do'];
            }
            $stmt->close();
            $product['nong_do'] = $nongdo;

            $sql = "SELECT n.not_huong, nn.loai 
                    FROM nothuong n 
                    JOIN nothuong_nuochoa nn ON n.ma_not_huong = nn.ma_not_huong 
                    WHERE nn.ma_nuoc_hoa = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $nothuong = ['huong_dau' => [], 'huong_giua' => [], 'huong_cuoi' => []];
            while ($row = $result->fetch_assoc()) {
                if ($row['loai'] == 'Hương đầu') {
                    $nothuong['huong_dau'][] = $row['not_huong'];
                } elseif ($row['loai'] == 'Hương giữa') {
                    $nothuong['huong_giua'][] = $row['not_huong'];
                } elseif ($row['loai'] == 'Hương cuối') {
                    $nothuong['huong_cuoi'][] = $row['not_huong'];
                }
            }
            $stmt->close();
            $product['nothuong'] = $nothuong;
        }

        return $product;
    }
}
?>