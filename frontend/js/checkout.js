document.addEventListener("DOMContentLoaded", function () {
    // Load cart data from localStorage
    function loadCartData() {
        if (localStorage.getItem("buynow")) {
            try {
                let cartData = JSON.parse(localStorage.getItem("buynow"));
                displayCartData(cartData);
            } catch (error) {
                console.log(JSON.parse(localStorage.getItem("buynow")));
                console.log(JSON.parse(localStorage.getItem("cartData")));
                console.error("Error parsing cart data:", error);
                alert("Có lỗi khi tải dữ liệu giỏ hàng buynow ");
                window.location.href = "giohang.php";
            }
        } else if (localStorage.getItem("cartData")) {
            try {
                let cartData = JSON.parse(localStorage.getItem("cartData"));
                displayCartData(cartData);
            } catch (error) {
                console.error("Error parsing cart data:", error);
                alert("Có lỗi khi tải dữ liệu giỏ hàng cartData");
                window.location.href = "giohang.php";
            }
        } else {
            // Nếu không có dữ liệu, quay về trang giỏ hàng
            window.location.href = "giohang.php";
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

    // Remove buynow storage if user change url
    document.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", function (e) {
            localStorage.removeItem("buynow");
        });
    });

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
            // {
            //     field: document.getElementById("email"),
            //     pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            //     message: "Email không hợp lệ",
            // },
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
            // { field: document.getElementById("province"), message: "Vui lòng chọn tỉnh/thành phố" },
            // { field: document.getElementById("district"), message: "Vui lòng chọn quận/huyện" },
            // { field: document.getElementById("ward"), message: "Vui lòng chọn phường/xã" },
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
        const selectedPaymentMethod = document.querySelector(
            ".payment-method.selected"
        );
        if (
            selectedPaymentMethod &&
            selectedPaymentMethod.getAttribute("data-method") === "credit"
        ) {
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
            // 1. Lấy các thông tin cần thiết
            const o_cartData = JSON.parse(localStorage.getItem("cartData"));
            const o_buynow = JSON.parse(localStorage.getItem("buynow"));
            const isBuyNow = o_buynow ? true : false;

            const fullName = (
                shippingFields[0].field.value +
                " " +
                shippingFields[1].field.value
            ).trim();
            const phone = shippingFields[2].field.value.trim();
            const address = shippingFields[3].field.value.trim();

            // 2. Lưu thành 1 object
            const checkoutInfo = {
                diachi: {
                    fullName,
                    phone,
                    address,
                },
                hoadon: {
                    thoigian: getCurrentDateTimeString(),
                    tongtien: parseCurrency(o_buynow ? o_buynow.total : o_cartData.total),
                    trangthai: "Chờ xác nhận",
                },
                chitiet: o_buynow ? o_buynow.items : o_cartData.items,
            };
            console.log(checkoutInfo);
            // 3. Gọi API tạo hóa đơn
            fetch("/backend/api/HoaDonAPI.php?action=taoHoaDon", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(checkoutInfo),
            })
                .then((respond) => {
                    return respond.json();
                })
                .then((data) => {
                    // console.log(data);

                    alert(data.message);
                    if (data.success) {
                        if (isBuyNow) {
                            window.location.href = "index.php";
                            localStorage.removeItem("buynow");
                        } else {
                            window.location.href = "index.php";
                            localStorage.clear();
                        }
                    }
                })
                .catch((error) => {
                    console.log(error);
                });

            // Xử lý đặt hàng thành công
            // console.log(checkoutInfo)
        }
    });
});

const locationData = {
    hcm: {
        name: "TP. Hồ Chí Minh",
        districts: {
            quan1: {
                name: "Quận 1",
                wards: [
                    "Phường Bến Nghé",
                    "Phường Bến Thành",
                    "Phường Cô Giang",
                    "Phường Cầu Kho",
                ],
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
                wards: [
                    "Phường Hàng Bạc",
                    "Phường Hàng Bồ",
                    "Phường Hàng Đào",
                    "Phường Hàng Gai",
                ],
            },
            dongdadistrict: {
                name: "Quận Đống Đa",
                wards: [
                    "Phường Cát Linh",
                    "Phường Văn Miếu",
                    "Phường Quốc Tử Giám",
                    "Phường Láng Thượng",
                ],
            },
            caugiaydistrict: {
                name: "Quận Cầu Giấy",
                wards: [
                    "Phường Dịch Vọng",
                    "Phường Mai Dịch",
                    "Phường Nghĩa Đô",
                    "Phường Nghĩa Tân",
                ],
            },
        },
    },
    danang: {
        name: "Đà Nẵng",
        districts: {
            haichaudistrict: {
                name: "Quận Hải Châu",
                wards: [
                    "Phường Hải Châu 1",
                    "Phường Hải Châu 2",
                    "Phường Nam Dương",
                    "Phường Phước Ninh",
                ],
            },
            sontradistrict: {
                name: "Quận Sơn Trà",
                wards: [
                    "Phường An Hải Bắc",
                    "Phường An Hải Đông",
                    "Phường An Hải Tây",
                    "Phường Mân Thái",
                ],
            },
            nguhanhsondistrict: {
                name: "Quận Ngũ Hành Sơn",
                wards: [
                    "Phường Mỹ An",
                    "Phường Khuê Mỹ",
                    "Phường Hoà Quý",
                    "Phường Hoà Hải",
                ],
            },
        },
    },
};

function loadDistricts() {
    const provinceSelect = document.getElementById("province");
    const districtSelect = document.getElementById("district");
    const wardSelect = document.getElementById("ward");

    districtSelect.innerHTML =
        "<option selected disabled>Chọn quận/huyện</option>";
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

        const wards =
            locationData[selectedProvince].districts[selectedDistrict].wards;
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

function getCurrentDateTimeString() {
    const now = new Date();

    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, "0"); // Tháng bắt đầu từ 0
    const day = String(now.getDate()).padStart(2, "0");

    const hours = String(now.getHours()).padStart(2, "0");
    const minutes = String(now.getMinutes()).padStart(2, "0");
    const seconds = String(now.getSeconds()).padStart(2, "0");

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

function parseCurrency(str) {
    // Xóa dấu chấm ngăn cách hàng nghìn và ký tự "đ", sau đó chuyển về số
    return parseFloat(str.replace(/\./g, "").replace(/[^\d]/g, ""), 10);
}
