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
        window.location.href = "checkout.php";
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