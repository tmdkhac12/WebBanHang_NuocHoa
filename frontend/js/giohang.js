async function handleCheckout() {
    try {
        // Lấy dữ liệu từ các sản phẩm trong giỏ hàng
        const cartItems = Array.from(document.querySelectorAll(".cart-item")).map((item) => {
            return {
                product_id: parseInt(item.getAttribute("product-id")) || "",
                image: item.querySelector("img")?.src || "",
                name: item.querySelector("h5")?.textContent || "",
                price: item.querySelector(".price")?.textContent || "",
                quantity: parseInt(item.querySelector(".quantity-input").value) || "1",
                subtotal: item.querySelector(".subtotal")?.textContent || "",
                size_id: parseInt(item.getAttribute("size_id")) || "",
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
        window.location.href = "checkout.php";
    } catch (error) {
        console.error("Error details:", error);
        alert("Không thể xử lý đơn hàng: " + error.message);
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const ao_nuochoasStorage = JSON.parse(localStorage.getItem("nuochoas")) || [];

    // Gắn sự kiện click cho nút checkout
    document.getElementById("checkoutButton").addEventListener("click", handleCheckout);

    // Quantity buttons functionality
    document.querySelectorAll(".quantity-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const input = this.parentElement.querySelector(".quantity-input");
            const currentValue = parseInt(input.value);

            //Lấy index của sản phẩm trong ao_nuochoasStorage 
            const index = parseInt(this.closest(".cart-item").getAttribute("index"));

            if (this.classList.contains("plus")) {
                input.value = currentValue + 1;

                // Lưu thay đổi số lượng vào localStorage
                ao_nuochoasStorage[index].soluong++;
                localStorage.setItem("nuochoas", JSON.stringify(ao_nuochoasStorage));
            } else if (this.classList.contains("minus") && currentValue > 1) {
                input.value = currentValue - 1;

                ao_nuochoasStorage[index].soluong--;
                localStorage.setItem("nuochoas", JSON.stringify(ao_nuochoasStorage));
            }

            updateSubtotal(this.closest(".cart-item"));
        });
    });

    // Quantity outfocus envent
    document.querySelectorAll(".quantity-input").forEach((quantityInput) => {
        quantityInput.addEventListener("focusout", () => {
            if (quantityInput.value < 1) {
                quantityInput.value = 1;
            }

            //Lấy index của sản phẩm trong ao_nuochoasStorage 
            const index = parseInt(quantityInput.closest(".cart-item").getAttribute("index"));

            // Cập nhật giá 
            updateSubtotal(quantityInput.closest(".cart-item"));
            updateTotal();

            // Lưu Local Storage 
            ao_nuochoasStorage[index].soluong = quantityInput.value;
            localStorage.setItem("nuochoas", JSON.stringify(ao_nuochoasStorage));
        });

        quantityInput.addEventListener("keydown", function (event) {
            if (event.key === "Enter") {
                event.preventDefault(); 
                quantityInput.blur(); 
            }
        })
    })


    // Remove item functionality
    document.querySelectorAll(".remove-item").forEach((button) => {
        button.addEventListener("click", function () {
            const index = parseInt(this.closest(".cart-item").getAttribute("index"));

            if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
                this.closest(".cart-item").remove();
                updateTotal();
                checkEmptyCart();

                // Xóa phần tử thứ index 
                ao_nuochoasStorage.splice(index, 1);
                localStorage.setItem("nuochoas", JSON.stringify(ao_nuochoasStorage));

                console.log(ao_nuochoasStorage);
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
                .replace("₫", "") + "đ"
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
    updateTotal();
    sendLocalStorage();

    window.addEventListener("load", function () {
        sessionStorage.removeItem("nuochoas_submitted");
    });
});

function sendLocalStorage() {
    const nuochoas = localStorage.getItem("nuochoas");

    if (nuochoas && !sessionStorage.getItem("nuochoas_submitted")) {
        const form = document.createElement("form");
        form.method = "POST";
        form.style.display = "none";

        const input = document.createElement("input");
        input.name = "nuochoas";
        input.value = nuochoas;

        form.appendChild(input);
        document.body.appendChild(form);

        // Đánh dấu đã submit
        sessionStorage.setItem("nuochoas_submitted", "true");

        form.submit();
    }
}