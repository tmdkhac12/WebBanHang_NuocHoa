<?php 
session_start();


?>

<!DOCTYPE html>
<html lang="vi">
    <head>
        <title>XXIV - Store</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <link rel="stylesheet" href="./css/style.css" />
    </head>
    <body>
        <?php require 'components/header.php'?>

        <main>
            <div class="checkout-container">
                <div class="checkout-header">
                    <h1>Thanh toán</h1>
                </div>
                <div class="checkout-content">
                    <div class="checkout-form">
                        <div class="form-section">
                            <h2 class="form-section-title">Thông tin giao hàng</h2>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="firstName" placeholder="Họ" />
                                        <label for="firstName">Họ</label>
                                        <div class="invalid-feedback">Vui lòng nhập họ của bạn</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="lastName" placeholder="Tên" />
                                        <label for="lastName">Tên</label>
                                        <div class="invalid-feedback">Vui lòng nhập tên của bạn</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="Email" />
                                        <label for="email">Email</label>
                                        <div class="invalid-feedback">Vui lòng nhập email hợp lệ</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="phone" placeholder="Số điện thoại" />
                                        <label for="phone">Số điện thoại</label>
                                        <div class="invalid-feedback">Vui lòng nhập số điện thoại hợp lệ</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="address" placeholder="Địa chỉ" />
                                        <label for="address">Địa chỉ</label>
                                        <div class="invalid-feedback">Vui lòng nhập địa chỉ của bạn</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2 class="form-section-title">Phương thức thanh toán</h2>
                            <div class="payment-methods">
                                <div class="payment-method selected" data-method="cash">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <div>Tiền mặt</div>
                                </div>
                                <div class="payment-method" data-method="credit">
                                    <i class="fas fa-credit-card"></i>
                                    <div>Thẻ tín dụng</div>
                                </div>
                                <div class="payment-method" data-method="bank">
                                    <i class="fas fa-university"></i>
                                    <div>Chuyển khoản</div>
                                </div>
                            </div>

                            <div id="creditCardForm" class="mt-4" style="display: none">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="cardNumber"
                                                placeholder="Số thẻ"
                                            />
                                            <label for="cardNumber">Số thẻ</label>
                                            <div class="invalid-feedback">Vui lòng nhập số thẻ hợp lệ</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="cardName"
                                                placeholder="Tên chủ thẻ"
                                            />
                                            <label for="cardName">Tên chủ thẻ</label>
                                            <div class="invalid-feedback">Vui lòng nhập tên chủ thẻ</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="expiryDate"
                                                placeholder="MM/YY"
                                            />
                                            <label for="expiryDate">Ngày hết hạn (MM/YY)</label>
                                            <div class="invalid-feedback">
                                                Vui lòng nhập ngày hết hạn đúng định dạng MM/YY
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="cvv" placeholder="CVV" />
                                            <label for="cvv">CVV</label>
                                            <div class="invalid-feedback">Vui lòng nhập mã CVV (3-4 số)</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="order-summary">
                        <h2 class="order-summary-title">Đơn hàng của bạn</h2>
                        <div class="order-items" id="orderItems">
                            <!-- Order items will be loaded dynamically -->
                        </div>

                        <div class="order-total">
                            <div class="total-row">
                                <span>Tạm tính:</span>
                                <span id="subtotal">0₫</span>
                            </div>
                            <div class="total-row">
                                <span>Phí vận chuyển:</span>
                                <span>Miễn phí</span>
                            </div>
                            <div class="total-row final">
                                <span>Tổng cộng:</span>
                                <span class="total-price" id="total">0₫</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-checkout">
                            <i class="fas fa-lock me-2"></i>Xác nhận đặt hàng
                        </button>
                    </div>
                </div>
            </div>
        </main>

        <?php require 'components/footer.php'?>


        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
        <script src="/frontend/js/checkout.js"></script>
    </body>
</html>
