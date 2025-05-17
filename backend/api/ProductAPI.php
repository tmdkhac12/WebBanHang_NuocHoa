<?php
require_once __DIR__ . "/../controller/ProductController.php";

header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : '';

function handleImageUpload($fieldName = 'newImage', $uploadDir = null)
{
    if (!$uploadDir) {
        $uploadDir = __DIR__ . '/frontend/images/';
    }

    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $fileTmpPath = $_FILES[$fieldName]['tmp_name'];
    $originalFileName = basename($_FILES[$fieldName]['name']);
    $safeFileName = preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $originalFileName);

    $destination = $uploadDir . $safeFileName;

    if (move_uploaded_file($fileTmpPath, $destination)) {
        return $safeFileName;
    }

    return false;
}
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
                $ma_dung_tich = (int)$_GET['ma_dung_tich'];
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
        case 'getProductByIdDT':
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $productId = (int)$_GET['id'];
                $ma_dung_tich = (int)$_GET['ma_dung_tich'];
                $product = $productController->getProductByIdDT($productId, $ma_dung_tich);
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
                $requiredFields = [
                    'name' => 'Tên sản phẩm',

                    'price' => 'Giá',

                    'dungtich' => 'Dung tích'
                ];

                foreach ($requiredFields as $field => $label) {
                    if (!isset($data[$field]) || trim($data[$field]) === '') {
                        http_response_code(400);
                        echo json_encode(['error' => "$label không được để trống"]);
                        exit;
                    }
                }
                if (!is_int($data['price']) && !ctype_digit($data['price'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Giá phải là 1 số nguyên']);
                    exit;
                }
                $productId = isset($data['productId']) ? (int)$data['productId'] : null;
                $name = isset($data['name']) ? $data['name'] : '';
                $brand = isset($data['brand']) ? $data['brand'] : '';
                $description = isset($data['description']) ? $data['description'] : '';
                $price = isset($data['price']) ? (int)$data['price'] : 0;
                $gender = isset($data['gioitinh']) ? $data['gioitinh'] : '';
                $nongdo = isset($data['nongdo']) ? (int)$data['nongdo'] : null;
                $dungtich = isset($data['dungtich']) ? (int)$data['dungtich'] : 0;

                $uploadDir = dirname(__DIR__, 2) . '/frontend/images/';

                if (isset($_FILES['newImage']) && $_FILES['newImage']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['newImage']['tmp_name'];
                    $originalFileName = basename($_FILES['newImage']['name']);

                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    $fileMimeType = mime_content_type($fileTmpPath);

                    if (!in_array($fileMimeType, $allowedTypes)) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Invalid file type. Only JPEG, PNG, GIF, and WEBP images are allowed.']);
                        exit;
                    }

                    $safeFileName = preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $originalFileName);
                    $destination = $uploadDir . $safeFileName;

                    if (move_uploaded_file($fileTmpPath, $destination)) {
                        $finalImage = $safeFileName;
                    } else {
                        http_response_code(400);
                        echo json_encode(['error' => 'Failed to move uploaded file.']);
                        exit;
                    }
                } elseif (isset($_POST['existingImage'])) {
                    $finalImage = $_POST['existingImage'];
                } else {
                    $finalImage = null;
                }

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



                $updated = $productController->updateProduct($productId, $name, $price, $description, $brand,   $gender, $nongdo, $finalImage, $dungtich, $notes);

                if ($updated) {
                    echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được cập nhật']);
                } else {
                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => 'Không thể cập nhật sản phẩm']);
                }
            }
            break;
        case 'createProduct':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = $_POST;
                $requiredFields = [
                    'name' => 'Tên sản phẩm',

                    'price' => 'Giá',

                    'dungtich' => 'Dung tích'
                ];

                foreach ($requiredFields as $field => $label) {
                    if (!isset($data[$field]) || trim($data[$field]) === '') {
                        http_response_code(400);
                        echo json_encode(['error' => "$label không được để trống"]);
                        exit;
                    }
                }
                if (!is_int($data['price']) && !ctype_digit($data['price'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Giá phải là 1 số nguyên']);
                    exit;
                }
                if (!is_int($data['dungtich']) && !ctype_digit($data['dungtich'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Dung tích phải là 1 số nguyên']);
                    exit;
                }

                $name = isset($data['name']) ? $data['name'] : '';
                $brand = isset($data['brand']) ? $data['brand'] : '';
                $description = isset($data['description']) ? $data['description'] : '';
                $price = isset($data['price']) ? (int)$data['price'] : 0;
                $gender = isset($data['gioitinh']) ? $data['gioitinh'] : '';
                $nongdo = isset($data['nongdo']) ? (int)$data['nongdo'] : null;
                $dungtich = isset($data['dungtich']) ? (int)$data['dungtich'] : 0;
                $uploadDir = dirname(__DIR__, 2) . '/frontend/images/';

                if (isset($_FILES['newImage']) && $_FILES['newImage']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['newImage']['tmp_name'];
                    $originalFileName = basename($_FILES['newImage']['name']);

                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    $fileMimeType = mime_content_type($fileTmpPath);

                    if (!in_array($fileMimeType, $allowedTypes)) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Invalid file type. Only JPEG, PNG, GIF, and WEBP images are allowed.']);
                        exit;
                    }

                    $safeFileName = preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $originalFileName);
                    $destination = $uploadDir . $safeFileName;

                    if (move_uploaded_file($fileTmpPath, $destination)) {
                        $finalImage = $safeFileName;
                    } else {
                        http_response_code(400);
                        echo json_encode(['error' => 'Failed to move uploaded file.']);
                        exit;
                    }
                } elseif (isset($_POST['existingImage'])) {
                    $finalImage = $_POST['existingImage'];
                } else {
                    $finalImage = null;
                }
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



                $updated = $productController->createProduct($name, $price, $description, $brand,   $gender, $nongdo, $finalImage, $dungtich, $notes);

                if ($updated) {
                    echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được tao']);
                } else {
                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => 'Không thể tao sản phẩm']);
                }
            }

            break;

        case 'searchProducts': {
                $keyword = $_GET['keyword'] ?? '';
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 8;
                $offset = ($page - 1) * $limit;
                $products = $productController->searchProducts($keyword, $limit, $offset);
                $total = $productController->getTotalSearchProducts($keyword);
                echo json_encode([
                    "success" => true,
                    "products" => $products,
                    "total" => $total
                ]);
                exit();
            }
        case 'getAllProductByDungTich':

        default:
            http_response_code(400);
            echo json_encode(['error' => 'Hành động không hợp lệ']);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Lỗi server: ' . $e->getMessage()]);
}
