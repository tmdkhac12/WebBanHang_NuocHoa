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
                WHERE 1=1" . $conditions['sql'];
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
        $sql = "SELECT n.ma_nuoc_hoa, n.hinh_anh, n.ten_nuoc_hoa, n.gioi_tinh, n.mo_ta, t.ten_thuong_hieu 
                FROM nuochoa n 
                LEFT JOIN thuonghieu t ON n.ma_thuong_hieu = t.ma_thuong_hieu 
                WHERE n.ma_nuoc_hoa = ?";
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
                    WHERE n.gioi_tinh = ?
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
                WHERE n.ma_nuoc_hoa = ?";
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
        // Start a transaction to ensure data integrity
        $this->connection->begin_transaction();
        
        try {
            // First, delete related records in the chitiethoadon table
            $deleteCTHDSql = "DELETE FROM chitiethoadon WHERE ma_nuoc_hoa = ?";
            $stmt = $this->connection->prepare($deleteCTHDSql);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $stmt->close();
    
            // Next, delete related records in the dungtich_nuochoa table
            $deleteRelatedSql = "DELETE FROM dungtich_nuochoa WHERE ma_nuoc_hoa = ?";
            $stmt = $this->connection->prepare($deleteRelatedSql);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $stmt->close();
    
            // Now delete the product from the nuochoa table
            $sql = "DELETE FROM nuochoa WHERE ma_nuoc_hoa = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $stmt->close();
    
            // Commit the transaction
            $this->connection->commit();
            
            return true; // Successfully deleted product and related records
        } catch (Exception $e) {
            // If any error occurs, roll back the transaction
            $this->connection->rollback();
            error_log("Error deleting product: " . $e->getMessage());
            return false;
        }
    }
    
        
    
}
?>