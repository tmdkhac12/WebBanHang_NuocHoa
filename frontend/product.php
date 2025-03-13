<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    $pdo = new PDO("mysql:host=localhost;dbname=webnuochoa;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Lỗi kết nối database: " . $e->getMessage()]);
    exit();
}

// Định nghĩa URL đường dẫn ảnh
$image_base_url = "http://localhost/DoAnWeb2/WebBanHang_NuocHoa/backend/images/";

// 🚀 **1. Trả về chi tiết sản phẩm khi có ID**
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    try {
        $stmt = $pdo->prepare("
            SELECT 
                n.ten_nuoc_hoa, 
                t.ten_thuong_hieu AS thuong_hieu, 
                n.gioi_tinh, 
                d.dung_tich, 
                n.gia_ban, 
                n.mo_ta,
                n.hinh_1
            FROM nuochoa n
            JOIN thuonghieu t ON n.ma_thuong_hieu = t.ma_thuong_hieu
            JOIN dungtich d ON n.ma_dung_tich = d.ma_dung_tich
            WHERE n.ma_nuoc_hoa = ?
        ");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Nếu hình ảnh không phải URL, thêm đường dẫn ảnh
            if (!filter_var($product["hinh_1"], FILTER_VALIDATE_URL)) {
                $product["hinh_1"] = $image_base_url . $product["hinh_1"];
            }

            echo json_encode($product, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(["error" => "Không tìm thấy sản phẩm"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => "Lỗi truy vấn: " . $e->getMessage()]);
    }
    exit();
}

// 🚀 **2. Trả về danh sách sản phẩm nổi bật**
$gender = isset($_GET['gender']) ? $_GET['gender'] : 'Nam';

try {
    $stmt = $pdo->prepare("SELECT ma_nuoc_hoa, ten_nuoc_hoa, gia_ban, hinh_1 
                           FROM nuochoa WHERE noi_bat = 1 AND gioi_tinh = ?");
    $stmt->execute([$gender]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($products) {
        // Thêm đường dẫn ảnh nếu thiếu
        foreach ($products as &$product) {
            if (!filter_var($product["hinh_1"], FILTER_VALIDATE_URL)) {
                $product["hinh_1"] = $image_base_url . $product["hinh_1"];
            }
        }

        echo json_encode($products, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(["message" => "Không có sản phẩm nổi bật"]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Lỗi truy vấn: " . $e->getMessage()]);
}
?>
