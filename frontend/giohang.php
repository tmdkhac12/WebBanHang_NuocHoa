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
            <?php require 'components/header.php'?>  
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
                                            style="border-bottom: 2px solid #eee"
                                        >
                                            <div class="col-md-6">
                                                <span class="fw-bold">Sản phẩm</span>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="fw-bold">Giá</span>
                                            </div>
                                            <div class="col-md-1">
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
                                        <a href="index.html" class="btn btn-primary">
                                            <i class="fas fa-arrow-left me-2"></i>Quay trở lại cửa hàng
                                        </a>
                                    </div>

                                    <!-- Cart Items Container -->
                                    <div id="cart-items-container">
                                       
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
                                                        type="bchecutton"
                                                        class="btn btn-checkout w-100"
                                                        id="checkoutButton"
                                                    >
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
            <?php require 'components/footer.php'?>
            
            <!-- Bootstrap JavaScript Libraries -->
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
            <script src="./main.js"></script>
            <script src="js/giohang.js"></script>
        </body>
    </html>
