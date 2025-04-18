
localStorage.setItem("cart", JSON.stringify([
    {
        name: "Old Fashioned - 50ml",
        price: 6700000,
        quantity: 2,
        image: "https://xxivstore.com/wp-content/uploads/2025/02/Kilian-Old-Fashioned-300x300.png"
    },
    {
        name: "Matcha Latte - 50ml",
        price: 1200000,
        quantity: 2,
        image: "https://xxivstore.com/wp-content/uploads/2025/02/Kira-Matcha-Latte-300x300.png"
    }
]));
localStorage.clear();
document.addEventListener("DOMContentLoaded", function () {
    const cartItems = JSON.parse(localStorage.getItem("cart")) || [];
    const cartContainer = document.getElementById("cart-items-container");
    const emptyCartMessage = document.getElementById("empty-cart-message");

    if (cartItems.length === 0) {
        emptyCartMessage.style.display = "block";
        cartContainer.innerHTML = "";
        return;
    }

    emptyCartMessage.style.display = "none";

    cartItems.forEach(item => {
        const subtotal = item.price * item.quantity;
        const cartItem = document.createElement("div");
        cartItem.className = "cart-item";
        cartItem.innerHTML = `
            <div class="row align-items-center row-gap-3">
                <div class="col-md-2">
                    <img src="${item.image}" alt="${item.name}" class="product-image img-fluid" />
                </div>
                <div class="col-md-4">
                    <h5 class="mb-1">${item.name}</h5>
                </div>
                <div class="col-md-2">
                    <span class="price">${item.price.toLocaleString()}₫</span>
                </div>
                <div class="col-md-1">
                    <div class="quantity-control">
                        <button type="button" class="quantity-btn plus"><i class="fas fa-plus"></i></button>
                        <input type="number" class="quantity-input" value="${item.quantity}" min="1" max="99" />
                        <button type="button" class="quantity-btn minus"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="col-md-2">
                    <span class="subtotal">${subtotal.toLocaleString()}₫</span>
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="remove-item"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        `;
        cartContainer.appendChild(cartItem);
    });
});

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
        alert(JSON.stringify(cartItems, null, 2));


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