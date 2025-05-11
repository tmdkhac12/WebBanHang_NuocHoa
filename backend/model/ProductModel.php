<?php
require_once __DIR__ . "/../config/connection.php";

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
        $sql = "SELECT n.ma_nuoc_hoa, n.hinh_anh, n.ten_nuoc_hoa, dn.gia_ban, t.ten_thuong_hieu 
        FROM nuochoa n 
        LEFT JOIN thuonghieu t ON n.ma_thuong_hieu = t.ma_thuong_hieu 
        LEFT JOIN dungtich_nuochoa dn ON n.ma_nuoc_hoa = dn.ma_nuoc_hoa AND dn.ma_dung_tich = 6
        WHERE n.tinh_trang = 1
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
                LEFT JOIN thuonghieu t ON n.ma_thuong_hieu = t.ma_thuong_hieu
                where n.tinh_trang = 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $total = $result->fetch_assoc()['total'];
        $stmt->close();
        return $total;
    }

    private function buildFilterConditions($gender, $minPrice, $maxPrice, $productNameSearch) {
        $conditions = ['sql' => '', 'types' => '', 'params' => []];

        if (!empty($gender)) {
            $placeholders = implode(',', array_fill(0, count($gender), '?'));
            $conditions['sql'] .= " AND n.gioi_tinh IN ($placeholders)";
            $conditions['types'] .= str_repeat('s', count($gender));
            $conditions['params'] = array_merge($conditions['params'], $gender);
        }

        if ($minPrice !== null && $maxPrice !== null && is_numeric($minPrice) && is_numeric($maxPrice)) {
            if ($minPrice == 0) {
                $conditions['sql'] .= " AND dn.gia_ban <= ?";
                $conditions['types'] .= "d";
                $conditions['params'][] = $maxPrice;
            } elseif ($maxPrice == 999999999) {
                $conditions['sql'] .= " AND dn.gia_ban >= ?";
                $conditions['types'] .= "d";
                $conditions['params'][] = $minPrice;
            } else {
                $conditions['sql'] .= " AND dn.gia_ban BETWEEN ? AND ?";
                $conditions['types'] .= "dd";
                $conditions['params'][] = $minPrice;
                $conditions['params'][] = $maxPrice;
            }
        }

        if ($productNameSearch) {
            $productNameSearch = $this->connection->real_escape_string($productNameSearch);
            $conditions['sql'] .= " AND n.ten_nuoc_hoa LIKE ?";
            $conditions['types'] .= "s";
            $conditions['params'][] = "%$productNameSearch%";
        }

        return $conditions;
    }

    public function filterProducts($gender, $minPrice, $maxPrice, $productNameSearch, $limit, $offset) {
        $conditions = $this->buildFilterConditions($gender, $minPrice, $maxPrice, $productNameSearch);

       $sql = "SELECT n.ma_nuoc_hoa, n.hinh_anh, n.ten_nuoc_hoa, dn.gia_ban, t.ten_thuong_hieu 
        FROM nuochoa n 
        LEFT JOIN thuonghieu t ON n.ma_thuong_hieu = t.ma_thuong_hieu 
        LEFT JOIN dungtich_nuochoa dn ON n.ma_nuoc_hoa = dn.ma_nuoc_hoa AND dn.ma_dung_tich = 6
        WHERE n.tinh_trang = 1" . $conditions['sql'];
        $sql .= " ORDER BY dn.gia_ban ASC LIMIT ? OFFSET ?";
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
             LEFT JOIN dungtich_nuochoa dn ON n.ma_nuoc_hoa = dn.ma_nuoc_hoa AND dn.ma_dung_tich = 6
             WHERE n.tinh_trang = 1" . $conditions['sql'];
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
        $sql = "SELECT n.ma_nuoc_hoa, n.hinh_anh, n.ten_nuoc_hoa, n.gioi_tinh, n.mo_ta, t.ten_thuong_hieu , dn.gia_ban
                FROM nuochoa n 
                LEFT JOIN thuonghieu t ON n.ma_thuong_hieu = t.ma_thuong_hieu 
                INNER JOIN dungtich_nuochoa dn ON n.ma_nuoc_hoa = dn.ma_nuoc_hoa
                WHERE n.ma_nuoc_hoa = ? and n.tinh_trang = 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($product) {
            $sql = "SELECT d.dung_tich, dn.gia_ban 
                    FROM dungtich d 
                    JOIN dungtich_nuochoa dn ON d.ma_dung_tich = dn.ma_dung_tich 
                    WHERE dn.ma_nuoc_hoa = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $dungtich = [];
            while ($row = $result->fetch_assoc()) {
                $dungtich[] = [
                    'dung_tich' => $row['dung_tich'],
                    'gia_ban' => $row['gia_ban']
                ];
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

            $sql = "SELECT n.not_huong, nn.loai ,n.ma_not_huong
                    FROM nothuong n 
                    JOIN nothuong_nuochoa nn ON n.ma_not_huong = nn.ma_not_huong 
                    WHERE nn.ma_nuoc_hoa = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $nothuong = [];
            while ($row = $result->fetch_assoc()) {
                $nothuong[] = [
                    'id' => $row['ma_not_huong'],
                    'loai' => $row['loai'],
                    'name' => $row['not_huong']
                ];
            }
            $stmt->close();
            $product['nothuong'] = $nothuong;
        }

        return $product;
    }

    public function getFeaturedProducts() {
        $featuredProducts = [
            'nam' => [],
            'nu' => [],
            'unisex' => []
        ];

        $genders = ['Nam', 'Nu', 'Unisex'];
        foreach ($genders as $gender) {
            $sql = "SELECT n.ma_nuoc_hoa, n.ten_nuoc_hoa, dn.gia_ban, n.hinh_anh, t.ten_thuong_hieu, COALESCE(SUM(ct.so_luong_mua), 0) as total_sold
                    FROM nuochoa n
                    LEFT JOIN thuonghieu t ON n.ma_thuong_hieu = t.ma_thuong_hieu
                    LEFT JOIN dungtich_nuochoa dn ON n.ma_nuoc_hoa = dn.ma_nuoc_hoa AND dn.ma_dung_tich = 6
                    LEFT JOIN chitiethoadon ct ON n.ma_nuoc_hoa = ct.ma_nuoc_hoa AND ct.ma_dung_tich = 6
                    WHERE n.gioi_tinh =  ?  and n.tinh_trang = 1
                    GROUP BY n.ma_nuoc_hoa
                    ORDER BY total_sold DESC
                    LIMIT 6";

            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("s", $gender);
            $stmt->execute();
            $result = $stmt->get_result();

            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = [
                    'ma_nuoc_hoa' => $row['ma_nuoc_hoa'],
                    'ten_nuoc_hoa' => $row['ten_nuoc_hoa'],
                    'gia_ban' => $row['gia_ban'],
                    'hinh_anh' => $row['hinh_anh'],
                    'ten_thuong_hieu' => $row['ten_thuong_hieu'],
                    'total_sold' => $row['total_sold'] ?: 0
                ];
            }
            $stmt->close();

            $key = strtolower($gender);
            $featuredProducts[$key] = $products;
        }

        return $featuredProducts;
    }

    public function getProductsInList($nuochoas) {
        $sql = "SELECT n.ma_nuoc_hoa, n.ten_nuoc_hoa, n.gioi_tinh, n.hinh_anh, dt.dung_tich, dt.ma_dung_tich, dtnh.gia_ban
                FROM nuochoa n 
                INNER JOIN dungtich dt on dt.dung_tich = ?
                INNER JOIN dungtich_nuochoa dtnh on dt.ma_dung_tich = dtnh.ma_dung_tich and n.ma_nuoc_hoa = dtnh.ma_nuoc_hoa
                WHERE n.ma_nuoc_hoa = ? and n.tinh_trang = 1";
        $statement = $this->connection->prepare($sql);

        $products = [];
        foreach ($nuochoas as $nuochoa) {
            $id = $nuochoa["id"];
            $dungtich = $nuochoa["dungtich"];

            $statement->bind_param("ii", $dungtich, $id);
            $statement->execute();

            $row = $statement->get_result()->fetch_assoc(); 

            $products[] = $row;
        }

        return (count($products) > 0 ? $products : null);
    }
   
    public function deleteProduct($productId) {
            $sql = "UPDATE nuochoa SET tinh_trang = 0 WHERE ma_nuoc_hoa = ?";
            
           
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                
                error_log("Error preparing statement: " . $this->connection->error);
                return false;
            }
        
            $stmt->bind_param("i", $productId);
            
            $success = $stmt->execute();
            if (!$success) {
                error_log("Error executing delete statement: " . $stmt->error);
                return false;
            }
        
            $stmt->close();
            
            return $success;
    }
    public function updateProduct($productId, $name, $price, $description, $brand, $notes = []) {
        if (!is_int($brand) && !ctype_digit($brand)) {
            return false;
        }

        $sql = "UPDATE nuochoa 
                SET ten_nuoc_hoa = ?, mo_ta = ?, ma_thuong_hieu = ? 
                WHERE ma_nuoc_hoa = ?";

        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            error_log("Error preparing update statement: " . $this->connection->error);
            return false;
        }

        $stmt->bind_param("sssi", $name, $description, $brand, $productId);
        $success = $stmt->execute();

        if (!$success) {
            error_log("Error executing update statement: " . $stmt->error);
            return false;
        }

        $stmt->close();

        
        $deleteStmt = $this->connection->prepare("DELETE FROM nothuong_nuochoa WHERE ma_nuoc_hoa = ?");
        if ($deleteStmt) {
            $deleteStmt->bind_param("i", $productId);
            $deleteStmt->execute();
            $deleteStmt->close();
        }

        
        if (!empty($notes)) {
            $insertStmt = $this->connection->prepare(
                "INSERT INTO nothuong_nuochoa (ma_nuoc_hoa, ma_not_huong, loai) VALUES (?, ?, ?)"
            );

            if (!$insertStmt) {
                error_log("Error preparing insert note statement: " . $this->connection->error);
                return false;
            }

            foreach ($notes as $note) {
                $ma_not_huong = $note['ma_not_huong'] ?? null;
                $loai = $note['loai'] ?? null;

                if ($ma_not_huong && $loai) {
                    $insertStmt->bind_param("iis", $productId, $ma_not_huong, $loai);
                    $insertStmt->execute();
                }
            }

            $insertStmt->close();
        }

        return true;
    }
        
    
}
?>