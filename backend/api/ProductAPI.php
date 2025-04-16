<?php
require_once __DIR__ . "/../model/ProductModel.php";

header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : '';

try {
    $productModel = new ProductModel();

    switch ($action) {
        case 'filterProducts':
            $data = json_decode(file_get_contents("php://input"), true);
            if (!$data) {
                echo json_encode(['error' => 'Dữ liệu JSON không hợp lệ']);
                break;
            }

            $gender = isset($data['gender']) && is_array($data['gender']) ? $data['gender'] : [];
            $minPrice = isset($data['minPrice']) && is_numeric($data['minPrice']) ? $data['minPrice'] : null;
            $maxPrice = isset($data['maxPrice']) && is_numeric($data['maxPrice']) ? $data['maxPrice'] : null;
            $productNameSearch = isset($data['productNameSearch']) ? trim($data['productNameSearch']) : ''; // Đổi từ brandSearch
            $page = isset($data['page']) && is_numeric($data['page']) && $data['page'] > 0 ? (int)$data['page'] : 1;
            $limit = 9;
            $offset = ($page - 1) * $limit;

            $result = $productModel->filterProducts($gender, $minPrice, $maxPrice, $productNameSearch, $limit, $offset);
            echo json_encode($result);
            break;

        case 'getFeaturedProducts':
            $featuredProducts = [
                'nam' => [],
                'nu' => [],
                'unisex' => []
            ];

            $genders = ['Nam', 'Nu', 'Unisex'];
            foreach ($genders as $gender) {
                $sql = "SELECT n.ma_nuoc_hoa, n.ten_nuoc_hoa, n.gia_ban, n.hinh_anh, t.ten_thuong_hieu, COALESCE(SUM(ct.so_luong_mua), 0) as total_sold
                        FROM nuochoa n
                        LEFT JOIN thuonghieu t ON n.ma_thuong_hieu = t.ma_thuong_hieu
                        LEFT JOIN chitiethoadon ct ON n.ma_nuoc_hoa = ct.ma_nuoc_hoa
                        WHERE n.gioi_tinh = ?
                        GROUP BY n.ma_nuoc_hoa
                        ORDER BY total_sold DESC
                        LIMIT 6";

                $stmt = $productModel->getConnection()->prepare($sql);
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

            echo json_encode($featuredProducts);
            break;

        default:
            echo json_encode(['error' => 'Hành động không hợp lệ']);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Lỗi server: ' . $e->getMessage()]);
}
?>