<!DOCTYPE html>
<html lang="vi">
    <head>
        <title>Thanh toán - Nước hoa XXIV</title>
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
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="province" onchange="loadDistricts()">
                                            <option value="" selected disabled>Chọn tỉnh/thành</option>
                                            <option value="hcm">TP. Hồ Chí Minh</option>
                                            <option value="hanoi">Hà Nội</option>
                                            <option value="danang">Đà Nẵng</option>
                                        </select>
                                        <label for="province">Tỉnh/Thành phố</label>
                                        <div class="invalid-feedback">Vui lòng chọn tỉnh/thành phố</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="district" onchange="loadWards()" disabled>
                                            <option value="" selected disabled>Chọn quận/huyện</option>
                                        </select>
                                        <label for="district">Quận/Huyện</label>
                                        <div class="invalid-feedback">Vui lòng chọn quận/huyện</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="ward" disabled>
                                            <option value="" selected disabled>Chọn phường/xã</option>
                                        </select>
                                        <label for="ward">Phường/Xã</label>
                                        <div class="invalid-feedback">Vui lòng chọn phường/xã</div>
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
        <script src="./main.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Load cart data from localStorage
                function loadCartData() {
                    const cartDataString = localStorage.getItem("cartData");
                    if (cartDataString) {
                        try {
                            const cartData = JSON.parse(cartDataString);
                            displayCartData(cartData);
                        } catch (error) {
                            console.error("Error parsing cart data:", error);
                            alert("Có lỗi khi tải dữ liệu giỏ hàng");
                            window.location.href = "giohang.html";
                        }
                    } else {
                        // Nếu không có dữ liệu, quay về trang giỏ hàng
                        window.location.href = "giohang.html";
                    }
                }

                // Display cart data
                function displayCartData(cartData) {
                    const orderItemsContainer = document.getElementById("orderItems");
                    orderItemsContainer.innerHTML = "";

                    cartData.items.forEach((item) => {
                        const itemElement = document.createElement("div");
                        itemElement.className = "order-item";
                        itemElement.innerHTML = `
                            <img src="${item.image}" alt="${item.name}" class="order-item-image" />
                            <div class="order-item-details">
                                <div class="order-item-name">${item.name}</div>
                                <div class="order-item-quantity">Số lượng: ${item.quantity}</div>
                                <div class="order-item-price">${item.price}</div>
                            </div>
                        `;
                        orderItemsContainer.appendChild(itemElement);
                    });

                    // Update totals
                    document.getElementById("subtotal").textContent = cartData.subtotal;
                    document.getElementById("total").textContent = cartData.total;
                }

                // Load cart data when page loads
                loadCartData();

                // Payment method selection
                const paymentMethods = document.querySelectorAll(".payment-method");
                const creditCardForm = document.getElementById("creditCardForm");

                paymentMethods.forEach((method) => {
                    method.addEventListener("click", function () {
                        // Xóa selected class từ tất cả các phương thức
                        paymentMethods.forEach((m) => m.classList.remove("selected"));
                        // Thêm selected class cho phương thức được chọn
                        this.classList.add("selected");

                        // Kiểm tra nếu là thẻ tín dụng thì hiện form
                        if (this.getAttribute("data-method") === "credit") {
                            creditCardForm.style.display = "block";
                        } else {
                            creditCardForm.style.display = "none";
                        }
                    });
                });

                // Form validation
                const form = document.querySelector(".checkout-form");
                const requiredFields = form.querySelectorAll(
                    'input[type="text"], input[type="email"], input[type="tel"], select'
                );
                const checkoutButton = document.querySelector(".btn-checkout");

                // Xóa thông báo lỗi khi người dùng bắt đầu nhập hoặc chọn
                requiredFields.forEach((field) => {
                    field.addEventListener("focus", function () {
                        this.classList.remove("is-invalid");
                    });

                    if (field.tagName === "SELECT") {
                        field.addEventListener("change", function () {
                            this.classList.remove("is-invalid");
                        });
                    } else {
                        field.addEventListener("input", function () {
                            this.classList.remove("is-invalid");
                        });
                    }
                });

                checkoutButton.addEventListener("click", function (e) {
                    e.preventDefault();
                    let isValid = true;

                    // Validate required fields for shipping information
                    const shippingFields = [
                        {
                            field: document.getElementById("firstName"),
                            pattern: /^[A-Za-zÀ-ỹ\s]{2,}$/,
                            message: "Họ phải có ít nhất 2 ký tự và chỉ chứa chữ cái",
                        },
                        {
                            field: document.getElementById("lastName"),
                            pattern: /^[A-Za-zÀ-ỹ\s]{2,}$/,
                            message: "Tên phải có ít nhất 2 ký tự và chỉ chứa chữ cái",
                        },
                        {
                            field: document.getElementById("email"),
                            pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                            message: "Email không hợp lệ",
                        },
                        {
                            field: document.getElementById("phone"),
                            pattern: /^[0-9]{10,11}$/,
                            message: "Số điện thoại phải có 10-11 số",
                        },
                        {
                            field: document.getElementById("address"),
                            pattern: /.{5,}/,
                            message: "Địa chỉ phải có ít nhất 5 ký tự",
                        },
                        { field: document.getElementById("province"), message: "Vui lòng chọn tỉnh/thành phố" },
                        { field: document.getElementById("district"), message: "Vui lòng chọn quận/huyện" },
                        { field: document.getElementById("ward"), message: "Vui lòng chọn phường/xã" },
                    ];

                    // Kiểm tra thông tin giao hàng
                    shippingFields.forEach(({ field, pattern, message }) => {
                        if (field.tagName === "SELECT") {
                            if (!field.value || field.disabled) {
                                isValid = false;
                                field.classList.add("is-invalid");
                                field.nextElementSibling.nextElementSibling.textContent = message;
                            }
                        } else {
                            if (!field.value || (pattern && !pattern.test(field.value))) {
                                isValid = false;
                                field.classList.add("is-invalid");
                                field.nextElementSibling.nextElementSibling.textContent = message;
                            }
                        }
                    });

                    // Chỉ validate thông tin thẻ tín dụng khi phương thức thanh toán là thẻ tín dụng
                    const selectedPaymentMethod = document.querySelector(".payment-method.selected");
                    if (selectedPaymentMethod && selectedPaymentMethod.getAttribute("data-method") === "credit") {
                        const creditCardFields = [
                            {
                                field: document.getElementById("cardNumber"),
                                pattern: /^[0-9]{16}$/,
                                message: "Số thẻ phải có đúng 16 số",
                            },
                            {
                                field: document.getElementById("cardName"),
                                pattern: /^[A-Za-zÀ-ỹ\s]{3,}$/,
                                message: "Tên chủ thẻ phải có ít nhất 3 ký tự và chỉ chứa chữ cái",
                            },
                            {
                                field: document.getElementById("expiryDate"),
                                pattern: /^(0[1-9]|1[0-2])\/([0-9]{2})$/,
                                message: "Ngày hết hạn phải đúng định dạng MM/YY",
                            },
                            {
                                field: document.getElementById("cvv"),
                                pattern: /^[0-9]{3,4}$/,
                                message: "CVV phải có 3-4 số",
                            },
                        ];

                        creditCardFields.forEach(({ field, pattern, message }) => {
                            if (!field.value || !pattern.test(field.value)) {
                                isValid = false;
                                field.classList.add("is-invalid");
                                field.nextElementSibling.nextElementSibling.textContent = message;
                            }
                        });
                    }

                    if (isValid) {
                        // Xử lý đặt hàng thành công
                        alert("Đặt hàng thành công!");
                        // Xóa dữ liệu giỏ hàng
                        localStorage.removeItem("cartData");
                        // Chuyển về trang chủ
                        window.location.href = "index.html";
                    }
                });
            });

            const locationData = {
                hcm: {
                    name: "TP. Hồ Chí Minh",
                    districts: {
                        quan1: {
                            name: "Quận 1",
                            wards: ["Phường Bến Nghé", "Phường Bến Thành", "Phường Cô Giang", "Phường Cầu Kho"],
                        },
                        quan2: {
                            name: "Quận 2",
                            wards: [
                                "Phường An Phú",
                                "Phường Bình An",
                                "Phường Bình Trưng Đông",
                                "Phường Bình Trưng Tây",
                            ],
                        },
                        quan3: {
                            name: "Quận 3",
                            wards: ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5"],
                        },
                    },
                },
                hanoi: {
                    name: "Hà Nội",
                    districts: {
                        hoankiemdistrict: {
                            name: "Quận Hoàn Kiếm",
                            wards: ["Phường Hàng Bạc", "Phường Hàng Bồ", "Phường Hàng Đào", "Phường Hàng Gai"],
                        },
                        dongdadistrict: {
                            name: "Quận Đống Đa",
                            wards: ["Phường Cát Linh", "Phường Văn Miếu", "Phường Quốc Tử Giám", "Phường Láng Thượng"],
                        },
                        caugiaydistrict: {
                            name: "Quận Cầu Giấy",
                            wards: ["Phường Dịch Vọng", "Phường Mai Dịch", "Phường Nghĩa Đô", "Phường Nghĩa Tân"],
                        },
                    },
                },
                danang: {
                    name: "Đà Nẵng",
                    districts: {
                        haichaudistrict: {
                            name: "Quận Hải Châu",
                            wards: ["Phường Hải Châu 1", "Phường Hải Châu 2", "Phường Nam Dương", "Phường Phước Ninh"],
                        },
                        sontradistrict: {
                            name: "Quận Sơn Trà",
                            wards: ["Phường An Hải Bắc", "Phường An Hải Đông", "Phường An Hải Tây", "Phường Mân Thái"],
                        },
                        nguhanhsondistrict: {
                            name: "Quận Ngũ Hành Sơn",
                            wards: ["Phường Mỹ An", "Phường Khuê Mỹ", "Phường Hoà Quý", "Phường Hoà Hải"],
                        },
                    },
                },
            };

            function loadDistricts() {
                const provinceSelect = document.getElementById("province");
                const districtSelect = document.getElementById("district");
                const wardSelect = document.getElementById("ward");

                districtSelect.innerHTML = "<option selected disabled>Chọn quận/huyện</option>";
                wardSelect.innerHTML = "<option selected disabled>Chọn phường/xã</option>";

                const selectedProvince = provinceSelect.value;
                if (selectedProvince && locationData[selectedProvince]) {
                    districtSelect.disabled = false;
                    wardSelect.disabled = true;

                    const districts = locationData[selectedProvince].districts;
                    for (let key in districts) {
                        const option = document.createElement("option");
                        option.value = key;
                        option.textContent = districts[key].name;
                        districtSelect.appendChild(option);
                    }
                } else {
                    districtSelect.disabled = true;
                    wardSelect.disabled = true;
                }
            }

            function loadWards() {
                const provinceSelect = document.getElementById("province");
                const districtSelect = document.getElementById("district");
                const wardSelect = document.getElementById("ward");

                wardSelect.innerHTML = "<option selected disabled>Chọn phường/xã</option>";

                const selectedProvince = provinceSelect.value;
                const selectedDistrict = districtSelect.value;

                if (
                    selectedProvince &&
                    selectedDistrict &&
                    locationData[selectedProvince]?.districts[selectedDistrict]
                ) {
                    wardSelect.disabled = false;

                    const wards = locationData[selectedProvince].districts[selectedDistrict].wards;
                    wards.forEach((ward) => {
                        const option = document.createElement("option");
                        option.value = ward;
                        option.textContent = ward;
                        wardSelect.appendChild(option);
                    });
                } else {
                    wardSelect.disabled = true;
                }
            }
        </script>
    </body>
</html>
