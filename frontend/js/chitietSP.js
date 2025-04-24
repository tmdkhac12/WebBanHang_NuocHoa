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
        const id = parseInt(window.location.href.slice(-1));
        const selectedSize = parseInt(document.querySelector(".size-btn.active").dataset.size);

        const productInfo = {
            id: id,
            soluong: quantity,
            dungtich: selectedSize
        };
        addProductToLocalStorage(productInfo);
        alert(`Thêm thành công ${quantity} sản phẩm`);
    });

    // Buy Now button
    buyNowBtn.addEventListener("click", () => {
        const selectedSize = document.querySelector(".size-btn.active").dataset.size;
        const selectedPrice = parseFloat(document.querySelector(".size-btn.active").dataset.price).toLocaleString('vi-VN');
        alert(`Đã chọn mua ngay ${quantity} sản phẩm "${productTitle}" (${selectedSize}ml, ${selectedPrice} đ)!`);
    });
});

function addProductToLocalStorage(productInfo) {
    // Lấy dữ liệu hiện tại từ localStorage hoặc khởi tạo mảng rỗng
    let nuochoas = JSON.parse(localStorage.getItem("nuochoas")) || [];

    // Kiểm tra xem sản phẩm đã tồn tại chưa và lấy ra index của sản phẩm 
    // trong array nuochoas (trùng id và selectedSize)
    const existingIndex = nuochoas.findIndex(item =>
        item.id === productInfo.id && item.dungtich === productInfo.dungtich
    );

    if (existingIndex !== -1) {
        nuochoas[existingIndex].soluong += productInfo.soluong;
    } else {
        nuochoas.push(productInfo);
    }

    // Lưu lại vào localStorage
    localStorage.setItem("nuochoas", JSON.stringify(nuochoas));
}