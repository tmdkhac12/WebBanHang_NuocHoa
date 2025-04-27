<?php
session_start();

require __DIR__ . "/../backend/controller/ProductController.php";
require __DIR__ . "/../backend/util/Formatter.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nuochoas"])) {
    $nuochoasStorage = json_decode($_POST["nuochoas"], true);

    $productController = new ProductController();
    $nuochoasCart = $productController->getProductsInList($nuochoasStorage);

    // echo "<pre>";
    // echo var_dump($nuochoasCart);
    // echo "</pre>";

    // echo "<pre>";
    // echo var_dump($nuochoasStorage);
    // echo "</pre>";
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Giỏ hàng - Nước hoa XXIV</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
    <!-- Header -->
    <?php require 'components/header.php' ?>

    <main>
        <div class="cart">
            <div class="container">
                <div class="cart-inner">
                    <div class="cart-header">
                        <h1 class="h2 mb-0">Giỏ hàng</h1>
                    </div>

                    <div class="cart-items">
                        <form class="cart-form" id="cartForm">
                            <!-- Cart Header -->
                            <div class="cart-table-header mb-3">
                                <div
                                    class="row align-items-center text-center py-2 d-none d-lg-flex"
                                    style="border-bottom: 2px solid #eee">
                                    <div class="col-md-5">
                                        <span class="fw-bold">Sản phẩm</span>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="fw-bold">Đơn giá</span>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="fw-bold">Số lượng</span>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="fw-bold">Tạm tính</span>
                                    </div>
                                    <div class="col-md-1">
                                        <span class="fw-bold">Xoá</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Empty Cart Message -->
                            <div id="empty-cart-message" class="text-center py-5" style="display: none">
                                <div class="mb-4">
                                    <i class="fas fa-shopping-cart fa-3x text-muted"></i>
                                </div>
                                <h3 class="mb-4">Chưa có sản phẩm nào trong giỏ hàng</h3>
                                <a href="/frontend/sanpham.php" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Quay trở lại cửa hàng
                                </a>
                            </div>

                            <!-- Cart Items Container -->
                            <div id="cart-items-container">
                                <!-- Cart Item 1 -->
                                <?php
                                $i = 0;
                                foreach ($nuochoasCart as $nuochoa) {
                                ?>
                                    <div class="cart-item" index=<?php echo $i; ?> product-id=<?php echo $nuochoasStorage[$i]["id"]; ?> size_id=<?php echo $nuochoa["ma_dung_tich"]; ?>>
                                        <div class="row align-items-center row-gap-3">
                                            <div class="col-md-2">
                                                <img
                                                    src="/frontend/images/<?php echo $nuochoa["hinh_anh"]; ?>"
                                                    class="product-image img-fluid" />
                                            </div>
                                            <div class="col-md-3">
                                                <h5 class="mb-1"><?php echo $nuochoa["ten_nuoc_hoa"] . " - " . $nuochoa["dung_tich"] . "ml"; ?></h5>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="price"><?php echo formatCurrency($nuochoa["gia_ban"]) . " đ"; ?></span>
                                            </div>
                                            <div class="col-md-2 d-flex justify-content-center">
                                                <div class="quantity-control d-flex">
                                                    <button type="button" class="quantity-btn minus">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input
                                                        type="number"
                                                        class="quantity-input"
                                                        value="<?php echo $nuochoasStorage[$i]["soluong"]; ?>"
                                                        min="1"
                                                        max="99" />
                                                    <button type="button" class="quantity-btn plus">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="subtotal"><?php echo formatCurrency($nuochoa["gia_ban"] * $nuochoasStorage[$i]["soluong"]) . " đ"; ?></span>
                                            </div>
                                            <div class="col-md-1 text-end">
                                                <button type="button" class="remove-item">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                $i++;
                                }
                                ?>
                            </div>
                        </form>

                        <!-- Checkout Section -->
                        <div class="checkout-section">
                            <div class="row">
                                <div class="col-md-12 col-lg-6 offset-lg-6">
                                    <div class="card border-0 bg-transparent">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-3">
                                                <span>Tạm tính:</span>
                                                <span>15.800.000₫</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-3">
                                                <span>Phí vận chuyển:</span>
                                                <span>Miễn phí</span>
                                            </div>
                                            <hr />
                                            <div class="d-flex justify-content-between mb-4">
                                                <span class="h5">Tổng cộng:</span>
                                                <span class="total-price">15.800.000₫</span>
                                            </div>
                                            <button
                                                type="button"
                                                class="btn btn-checkout w-100"
                                                id="checkoutButton">
                                                <i class="fas fa-lock me-2"></i>Tiến hành thanh toán
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php require 'components/footer.php' ?>
</body>


<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="/frontend/js/giohang.js"></script>
</body>

</html>