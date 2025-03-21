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
        <main>
        <?php require 'components/header.php'?>
            < class="cart">
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
                                    <!-- Cart Item 1 -->
                                    <div class="cart-item">
                                        <div class="row align-items-center row-gap-3">
                                            <div class="col-md-2">
                                                <img
                                                    src="https://xxivstore.com/wp-content/uploads/2025/02/Kilian-Old-Fashioned-300x300.png"
                                                    alt="Old Fashioned"
                                                    class="product-image img-fluid"
                                                />
                                            </div>
                                            <div class="col-md-4">
                                                <h5 class="mb-1">Old Fashioned - 50ml</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="price">6.700.000₫</span>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="quantity-control">
                                                    <button type="button" class="quantity-btn plus">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <input
                                                        type="number"
                                                        class="quantity-input"
                                                        value="2"
                                                        min="1"
                                                        max="99"
                                                    />
                                                    <button type="button" class="quantity-btn minus">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="subtotal">13.400.000₫</span>
                                            </div>
                                            <div class="col-md-1 text-end">
                                                <button type="button" class="remove-item">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cart Item 2 -->
                                    <div class="cart-item">
                                        <div class="row align-items-center row-gap-3">
                                            <div class="col-md-2">
                                                <img
                                                    src="https://xxivstore.com/wp-content/uploads/2025/02/Kira-Matcha-Latte-300x300.png"
                                                    alt="Matcha Latte"
                                                    class="product-image img-fluid"
                                                />
                                            </div>
                                            <div class="col-md-4">
                                                <h5 class="mb-1">Matcha Latte - 50ml</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="price">1.200.000₫</span>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="quantity-control">
                                                    <button type="button" class="quantity-btn plus">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <input
                                                        type="number"
                                                        class="quantity-input"
                                                        value="2"
                                                        min="1"
                                                        max="99"
                                                    />
                                                    <button type="button" class="quantity-btn minus">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <span class="subtotal">2.400.000₫</span>
                                            </div>
                                            <div class="col-md-1 text-end">
                                                <button type="button" class="remove-item">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
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
            <?php require 'components/footer.php'?>
        </main>
        
        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
        <script src="./main.js"></script>
        <script>
            // Hàm xử lý checkout
            async function handleCheckout() {
                try {
                    // Lấy dữ liệu từ các sản phẩm trong giỏ hàng
                    const cartItems = Array.from(document.querySelectorAll(".cart-item")).map((item) => {
                        return {
                            product_id: item.querySelector('input[name="product_id[]"]')?.value || "",
                            image: item.querySelector("img")?.src || "",
                            name: item.querySelector("h5")?.textContent || "",
                            price: item.querySelector(".price")?.textContent || "",
                            quantity: item.querySelector(".quantity-input")?.value || "1",
                            subtotal: item.querySelector(".subtotal")?.textContent || "",
                        };
                    });

                    const cartData = {
                        items: cartItems,
                        subtotal:
                            document.querySelector(".card-body .d-flex:first-child span:last-child")?.textContent ||
                            "0₫",
                        total: document.querySelector(".total-price")?.textContent || "0₫",
                    };

                    // Lưu vào localStorage thay vì gọi API trong môi trường development
                    localStorage.setItem("cartData", JSON.stringify(cartData));
                    console.log("Cart data saved:", cartData);

                    // Chuyển đến trang checkout
                    window.location.href = "checkout.html";
                } catch (error) {
                    console.error("Error details:", error);
                    alert("Không thể xử lý đơn hàng: " + error.message);
                }
            }

            document.addEventListener("DOMContentLoaded", function () {
                // Gắn sự kiện click cho nút checkout
                document.getElementById("checkoutButton").addEventListener("click", handleCheckout);

                // Quantity buttons functionality
                document.querySelectorAll(".quantity-btn").forEach((button) => {
                    button.addEventListener("click", function () {
                        const input = this.parentElement.querySelector(".quantity-input");
                        const currentValue = parseInt(input.value);

                        if (this.classList.contains("plus")) {
                            input.value = currentValue + 1;
                        } else if (this.classList.contains("minus") && currentValue > 1) {
                            input.value = currentValue - 1;
                        }

                        updateSubtotal(this.closest(".cart-item"));
                    });
                });

                // Remove item functionality
                document.querySelectorAll(".remove-item").forEach((button) => {
                    button.addEventListener("click", function () {
                        if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
                            this.closest(".cart-item").remove();
                            updateTotal();
                            checkEmptyCart();
                        }
                    });
                });

                // Update subtotal for an item
                function updateSubtotal(cartItem) {
                    const price = parseInt(cartItem.querySelector(".price").textContent.replace(/[^\d]/g, ""));
                    const quantity = parseInt(cartItem.querySelector(".quantity-input").value);
                    const subtotal = price * quantity;
                    cartItem.querySelector(".subtotal").textContent = formatPrice(subtotal);
                    updateTotal();
                }

                // Update total price
                function updateTotal() {
                    const subtotals = Array.from(document.querySelectorAll(".subtotal")).map((el) =>
                        parseInt(el.textContent.replace(/[^\d]/g, ""))
                    );
                    const total = subtotals.reduce((sum, current) => sum + current, 0);
                    document.querySelector(".total-price").textContent = formatPrice(total);
                    document.querySelector(".card-body .d-flex:first-child span:last-child").textContent =
                        formatPrice(total);
                }

                // Format price with Vietnamese currency
                function formatPrice(price) {
                    return (
                        new Intl.NumberFormat("vi-VN", {
                            style: "currency",
                            currency: "VND",
                        })
                            .format(price)
                            .replace("₫", "") + "₫"
                    );
                }

                // Check if cart is empty
                function checkEmptyCart() {
                    const cartItems = document.querySelectorAll(".cart-item");
                    const emptyMessage = document.getElementById("empty-cart-message");
                    const cartItemsContainer = document.getElementById("cart-items-container");
                    const cartTableHeader = document.querySelector(".cart-table-header");
                    const checkoutSection = document.querySelector(".checkout-section");

                    if (cartItems.length === 0) {
                        emptyMessage.style.display = "block";
                        cartTableHeader.style.display = "none";
                        cartItemsContainer.style.display = "none";
                        if (checkoutSection) {
                            checkoutSection.style.display = "none";
                        }
                    } else {
                        emptyMessage.style.display = "none";
                        cartTableHeader.style.display = "block";
                        cartItemsContainer.style.display = "block";
                        if (checkoutSection) {
                            checkoutSection.style.display = "block";
                        }
                    }
                }

                // Initial check for empty cart
                checkEmptyCart();
            });
        </script>
    </body>
</html>
