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
        if (!isLoggedIn) {
            alert("Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!");
            window.location.href = "login.php";
            return;
        }

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
        if (!isLoggedIn) {
            alert("Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!");
            window.location.href = "login.php";
            return;
        }

        const selectedSize = parseInt(document.querySelector(".size-btn.active").dataset.size);

        buyNow();
        // console.log(JSON.parse(localStorage.getItem("buynow")));
        alert(`Đã chọn mua ngay ${parseInt(document.querySelector("input").value)} sản phẩm "${productTitle}" (${selectedSize}ml)`);
        window.location.href = "checkout.php";
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

function buyNow() {
    const size = [5, 10, 15, 20, 30, 50, 75, 90, 100, 125, 150, 200];

    const urlParams = new URLSearchParams(window.location.search);

    const product_id = parseInt(urlParams.get('id')); 
    const price = document.querySelector(".product-price").innerHTML || "";
    const s_selectedSize = document.querySelector(".size-btn.active").getAttribute("data-size") + "ml";
    const quantity = parseInt(document.querySelector("input").value) || "1";

    const cartItems = {
            product_id: product_id,
            image: document.querySelector("#product-image")?.src || "",
            name: document.querySelector("h1.product-title")?.textContent + " - " + s_selectedSize || "",
            price, 
            quantity,
            subtotal: formatPrice(parseCurrency(price) * quantity) || "",
            size_id: size.indexOf(parseInt(document.querySelector("button").getAttribute("data-size"))) + 1 || "",
        };

    const buyNow = {
        items: [cartItems],
        subtotal:
            cartItems.subtotal,
        total: cartItems.subtotal
    };

    localStorage.setItem("buynow", JSON.stringify(buyNow));
}

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

function parseCurrency(str) {
    return parseInt(str.replace(/[^\d]/g, ""), 10);
}