// chitietSP.js
document.addEventListener("DOMContentLoaded", () => {
    const decreaseQtyBtn = document.getElementById("decreaseQty");
    const increaseQtyBtn = document.getElementById("increaseQty");
    const quantityInput = document.getElementById("quantity");
    const addToCartBtn = document.querySelector(".add-to-cart");
    const buyNowBtn = document.getElementById("buyNow");
    const sizeButtons = document.querySelectorAll(".size-btn");
    const priceElement = document.getElementById("product-price");
    const productTitle = document.querySelector(".product-title").textContent;

    // Quantity selector functionality
    let quantity = parseInt(quantityInput.value);

    decreaseQtyBtn.addEventListener("click", () => {
        if (quantity > 1) {
            quantity--;
            quantityInput.value = quantity;
        }
    });

    increaseQtyBtn.addEventListener("click", () => {
        quantity++;
        quantityInput.value = quantity;
    });

    // Size selection functionality
    sizeButtons.forEach(button => {
        button.addEventListener("click", () => {
            sizeButtons.forEach(btn => btn.classList.remove("active"));
            button.classList.add("active");

            // Update price based on selected size
            const price = parseFloat(button.dataset.price);
            priceElement.textContent = price.toLocaleString('vi-VN') + ' đ';
        });
    });

    // Add to Cart button
    addToCartBtn.addEventListener("click", () => {
        const selectedSize = document.querySelector(".size-btn.active").dataset.size;
        const selectedPrice = parseFloat(document.querySelector(".size-btn.active").dataset.price).toLocaleString('vi-VN');
        alert(`Đã thêm ${quantity} sản phẩm "${productTitle}" (${selectedSize}ml, ${selectedPrice} đ) vào giỏ hàng!`);
    });

    // Buy Now button
    buyNowBtn.addEventListener("click", () => {
        const selectedSize = document.querySelector(".size-btn.active").dataset.size;
        const selectedPrice = parseFloat(document.querySelector(".size-btn.active").dataset.price).toLocaleString('vi-VN');
        alert(`Đã chọn mua ngay ${quantity} sản phẩm "${productTitle}" (${selectedSize}ml, ${selectedPrice} đ)!`);
    });
});