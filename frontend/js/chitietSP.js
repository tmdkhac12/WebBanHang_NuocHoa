// chitietSP.js
document.addEventListener("DOMContentLoaded", () => {
    const decreaseQtyBtn = document.getElementById("decreaseQty");
    const increaseQtyBtn = document.getElementById("increaseQty");
    const quantityInput = document.getElementById("quantity");
    const addToCartBtn = document.querySelector(".add-to-cart");
    const buyNowBtn = document.getElementById("buyNow");
    const sizeButtons = document.querySelectorAll(".size-btn");

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
        });
    });

    // Add to Cart button
    addToCartBtn.addEventListener("click", () => {
        const selectedSize = document.querySelector(".size-btn.active").dataset.size;
        alert(`Đã thêm ${quantity} sản phẩm "Allure Homme Sport Superleggera" (${selectedSize}) vào giỏ hàng!`);
    });

    // Buy Now button
    buyNowBtn.addEventListener("click", () => {
        const selectedSize = document.querySelector(".size-btn.active").dataset.size;
        alert(`Đã chọn mua ngay ${quantity} sản phẩm "Allure Homme Sport Superleggera" (${selectedSize})!`);
        // You can redirect to a checkout page or perform other actions here
    });
});