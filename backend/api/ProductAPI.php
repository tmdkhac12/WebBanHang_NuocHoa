<?php
require_once __DIR__ . "/../controller/ProductController.php";

header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : '';

try {
    $productController = new ProductController();

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
            $productNameSearch = isset($data['productNameSearch']) ? trim($data['productNameSearch']) : '';
            $page = isset($data['page']) && is_numeric($data['page']) && $data['page'] > 0 ? (int)$data['page'] : 1;
            $limit = 9;
            $offset = ($page - 1) * $limit;

            $result = $productController->filterProducts($gender, $minPrice, $maxPrice, $productNameSearch, $limit, $offset);
            echo json_encode($result);
            break;

        case 'getFeaturedProducts':
            $featuredProducts = $productController->getFeaturedProducts();
            echo json_encode($featuredProducts);
            break;

        case 'getProductByID':
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $productId = (int)$_GET['id'];
                $product = $productController->getProductByID($productId);
                if ($product) {
                    echo json_encode($product);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Sản phẩm không tồn tại']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Thiếu ID sản phẩm hoặc ID không hợp lệ']);
            }
            break;
        case 'deleteProduct':
            if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
                http_response_code(405);
                echo json_encode(['error' => 'Phương thức không được hỗ trợ']);
                break;
            }
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $productId = (int)$_GET['id'];
                $deleted = $productController->deleteProduct($productId);
        
                if ($deleted) {
                    echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được xóa']);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Không thể xóa sản phẩm. Sản phẩm có thể không tồn tại']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID sản phẩm không hợp lệ']);
            }
            break;
        case 'updateProduct':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = $_POST;
                $productId = isset($data['productId']) ? (int)$data['productId'] : null;
                $name = isset($data['name']) ? $data['name'] : '';
                $brand = isset($data['brand']) ? $data['brand'] : '';
                $description = isset($data['description']) ? $data['description'] : '';
                $price = isset($data['price']) ? (float)$data['price'] : 0;
                $gender = isset($data['gioitinh']) ? $data['gioitinh'] : '';
                $nongdo = isset($data['nongdo']) ? (int)$data['nongdo'] : null;

                
                $notes = [];
                  if (isset($_POST['notes']) && is_array($_POST['notes'])) {
                    foreach ($_POST['notes'] as $key => $note) {
                        $ma_not_huong = isset($note['ma_not_huong']) ? $note['ma_not_huong'] : null;
                        $loai = isset($note['loai']) ? $note['loai'] : null;
                         if ($ma_not_huong && $loai) {
                            $notes[] = ['ma_not_huong' => $ma_not_huong, 'loai' => $loai];
                                 }
                    }
                }

               
                if ($productId && $name && $brand && $description && $price && !empty($notes)) {
                    $updated = $productController->updateProduct($productId, $name, $price, $description, $brand,   $gender , $nongdo, $notes);

                    if ($updated) {
                        echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được cập nhật']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['success' => false, 'message' => 'Không thể cập nhật sản phẩm']);
                    }
                } else {
                    http_response_code(400);
                    header('Content-Type: application/json');
                    echo json_encode(['error' => 'Dữ liệu không hợp lệ']);
                }

            }
            break;


        default:
            echo json_encode(['error' => 'Hành động không hợp lệ']);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Lỗi server: ' . $e->getMessage()]);
}
