<?php session_start(); ?>
<?php
require_once __DIR__ . "/../backend/model/ProductModel.php";

$productModel = new ProductModel();
$productId = isset($_GET['id']) ? $_GET['id'] : null;

if ($productId) {
    $product = $productModel->getProductById($productId);
    $huong_dau = [];
    $huong_giua = [];
    $huong_cuoi = [];

    foreach ($product['nothuong'] as $nh) {
        switch ($nh['loai']) {
            case 'Hương đầu':
                $huong_dau[] = htmlspecialchars($nh['name']);
                break;
            case 'Hương giữa':
                $huong_giua[] = htmlspecialchars($nh['name']);
                break;
            case 'Hương cuối':
                $huong_cuoi[] = htmlspecialchars($nh['name']);
                break;
        }
    }

    if (!$product) {
        die("Sản phẩm không tồn tại.");
    }
} else {
    die("Không có ID sản phẩm được cung cấp.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XXIV Store - <?php echo htmlspecialchars($product['ten_nuoc_hoa']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="./css/chitietSP.css">
    <script defer src="./js/chitietSP.js"></script>
</head>

<body>
    <!-- Header -->
    <?php require 'components/header.php' ?>

    <div class="content">
        <div class="container my-5">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Tổng quan</a></li>
                    <li class="breadcrumb-item"><a href="#">Thương hiệu</a></li>
                    <li class="breadcrumb-item"><a href="#"><?php echo htmlspecialchars($product['ten_thuong_hieu']); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['ten_nuoc_hoa']); ?></li>
                </ol>
            </nav>

            <!-- Product Details -->
            <div class="row product-details">
                <!-- Product Image -->
                <div class="col-md-6">
                    <div class="product-image-wrapper">
                        <img src="./images/<?php echo htmlspecialchars($product['hinh_anh']); ?>" alt="<?php echo htmlspecialchars($product['ten_nuoc_hoa']); ?>" class="img-fluid product-image" id="product-image">
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-md-6">
                    <h1 class="product-title"><?php echo htmlspecialchars($product['ten_nuoc_hoa']); ?></h1>
                    <h6><?php echo htmlspecialchars($product['ten_thuong_hieu']); ?></h6>
                    <p class="product-gender"><i class="fas fa-venus-mars"></i> <?php echo htmlspecialchars($product['gioi_tinh']); ?></p>
                    <p class="product-price" id="product-price"><?php echo number_format($product['dung_tich'][0]['gia_ban'], 0, ',', '.') . ' đ'; ?></p>

                    <div class="mb-4">
                        <label class="form-label">Dung tích:</label>
                        <div class="btn-group" role="group">
                            <?php foreach ($product['dung_tich'] as $index => $dt): ?>
                                <button type="button" class="btn btn-outline-secondary size-btn <?php echo $index === 0 ? 'active' : ''; ?>"
                                    data-size="<?php echo htmlspecialchars($dt['dung_tich']); ?>"
                                    data-price="<?php echo $dt['gia_ban']; ?>">
                                    <?php echo htmlspecialchars($dt['dung_tich']); ?>ml
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Nồng độ:</label>
                        <p>
                            <?php
                            $names = array_map(function($item) {
                                return htmlspecialchars($item['name']);
                            }, $product['nong_do']);
                            echo implode(', ', $names);
                            ?>
                        </p>
                    </div>

                    <div class="mb-4 quantity-selector">
                        <label class="form-label">Số lượng:</label>
                        <div class="input-group w-20">
                            <button class="btn btn-outline-secondary" type="button" id="decreaseQty">-</button>
                            <input type="text" class="form-control text-center" id="quantity" value="1" readonly>
                            <button class="btn btn-outline-secondary" type="button" id="increaseQty">+</button>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-3">
                        <button class="btn btn-outline-primary flex-fill add-to-cart">THÊM VÀO GIỎ HÀNG</button>
                    </div>

                    <div class="additional-info mb-3">
                        <button class="btn btn-danger w-100 buy-now-btn" id="buyNow">
                            <span class="d-block"><strong>MUA NGAY</strong></span>
                            <span class="d-block">Giao Tận Nơi Hỏa Tốc Tại Các Hàng</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Features and Description -->
            <div class="product-info-wrapper mt-4">
                <!-- Product Features -->
                <div class="product-features">
                    <h2 class="section-title">Đặc điểm</h2>
                    <div class="feature-item">
                        <span class="feature-label">Hương đầu</span>
                        <span class="feature-value"><?php echo implode(', ', $huong_dau); ?></span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-label">Hương giữa</span>
                        <span class="feature-value"><?php echo implode(', ', $huong_giua); ?></span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-label">Hương cuối</span>
                        <span class="feature-value"><?php echo implode(', ', $huong_cuoi); ?></span>
                    </div>
                </div>

                <!-- Product Description -->
                <div class="product-description mt-3">
                    <h2 class="section-title">Mô tả</h2>
                    <p><?php echo htmlspecialchars($product['mo_ta']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require 'components/footer.php' ?>

    <script>
        const isLoggedIn = <?= isset($_SESSION["user_id"]) ? "true" : "false" ?>;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</body>

</html>