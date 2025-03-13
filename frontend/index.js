document.addEventListener("DOMContentLoaded", function () {
    const menuLinks = document.querySelectorAll(".menu-link");
    const sections = document.querySelectorAll(".content-section");
    const productList = document.getElementById("product-list");
    const detailSection = document.getElementById("detail");
    const backToProducts = document.getElementById("backToProducts");

    // 🏷️ **1. Xử lý chuyển tab navbar**
    menuLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const sectionId = this.getAttribute("data-section");

            sections.forEach(section => section.style.display = "none");
            document.getElementById(sectionId).style.display = "block";
        });
    });

    // 🏷️ **2. Hàm hiển thị chi tiết sản phẩm**
    function showDetail(productId) {
        fetch(`http://127.0.0.1/DoAnWeb2/WebBanHang_NuocHoa/frontend/product.php?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error("Lỗi:", data.error);
                    return;
                }

                // 🖼️ Hiển thị thông tin sản phẩm
                document.getElementById("hinh_1").src = data.hinh_1;
                document.getElementById("ten_nuoc_hoa").textContent = data.ten_nuoc_hoa;
                document.getElementById("thuong_hieu").textContent = data.thuong_hieu;
                document.getElementById("gioi_tinh").textContent = data.gioi_tinh;
                document.getElementById("dung_tich").textContent = data.dung_tich;
                document.getElementById("gia_ban").textContent = new Intl.NumberFormat("vi-VN").format(data.gia_ban);
                document.getElementById("mo_ta").textContent = data.mo_ta;

                // Ẩn danh sách sản phẩm, hiện chi tiết sản phẩm
                sections.forEach(section => section.style.display = "none");
                detailSection.style.display = "block";
            })
            .catch(error => console.error("Lỗi khi tải dữ liệu:", error));
    }

    // 🏷️ **3. Lắng nghe sự kiện click vào sản phẩm**
    productList.addEventListener("click", function (event) {
        let target = event.target.closest(".product-card");
        if (target) {
            let productId = target.getAttribute("data-id");
            console.log("ID sản phẩm:", productId);
            showDetail(productId);
        }
    });

    // 🏷️ **4. Xử lý nút quay lại danh sách sản phẩm**
    backToProducts.addEventListener("click", function () {
        sections.forEach(section => section.style.display = "none");
        document.getElementById("products").style.display = "block"; // Hiển thị lại trang sản phẩm
    });

    // 🏷️ **5. Tải danh sách sản phẩm từ index.php**
    function loadProducts(page = 1) {
        fetch(`http://localhost/DoAnWeb2/WebBanHang_NuocHoa/backend/index.php?page=${page}`)
            .then(response => response.text())
            .then(data => {
                productList.innerHTML = data;

                // Gán lại sự kiện click vào sản phẩm sau khi load xong
                document.querySelectorAll(".product-card").forEach(card => {
                    card.addEventListener("click", function () {
                        let productId = this.getAttribute("data-id");
                        showDetail(productId);
                    });
                });

                // Gán sự kiện click cho nút phân trang
                document.querySelectorAll(".page-link").forEach(link => {
                    link.addEventListener("click", function (e) {
                        e.preventDefault();
                        let page = this.getAttribute("data-page");
                        loadProducts(page);
                    });
                });
            })
            .catch(error => console.error("Lỗi khi tải danh sách sản phẩm:", error));
    }

    loadProducts(); // 🚀 Load sản phẩm khi trang mở

    // 🏷️ **6. Hiển thị danh sách thương hiệu**
    const brands = [
        { src: "https://xxivstore.com/wp-content/uploads/2023/11/Nuoc-hoa-Clive-Christian.png", alt: "Clive Christian" },
        { src: "https://xxivstore.com/wp-content/uploads/2023/11/Nuoc-hoa-Xerjoff.png", alt: "Xerjoff" },
        { src: "https://xxivstore.com/wp-content/uploads/2024/11/Penhaligons.png", alt: "Penhaligon's" },
        { src: "https://xxivstore.com/wp-content/uploads/2022/08/Hang-nuoc-hoa-Zoologist.png", alt: "Zoologist" },
        { src: "https://xxivstore.com/wp-content/uploads/2021/03/nuoc-hoa-mfk.png", alt: "MFK" },
        { src: "https://xxivstore.com/wp-content/uploads/2021/03/nuoc-hoa-by-kilian.png", alt: "By Kilian" },
        { src: "https://xxivstore.com/wp-content/uploads/2023/11/Nuoc-hoa-Ex-Nihilo.png", alt: "Ex Nihilo" },
        { src: "https://xxivstore.com/wp-content/uploads/2022/07/159133030_1044233219399119_4321418372070751780_n.png", alt: "Unknown Brand" },
        { src: "https://xxivstore.com/wp-content/uploads/2021/03/nuoc-hoa-le-labo.png", alt: "Le Labo" },
        { src: "https://xxivstore.com/wp-content/uploads/2021/07/Nasomatto.png", alt: "Nasomatto" },
        { src: "https://xxivstore.com/wp-content/uploads/2024/01/logo-roja-parfum-1.png", alt: "Roja Parfums" },
        { src: "https://xxivstore.com/wp-content/uploads/2022/04/Ormonde-Jayne.png", alt: "Ormonde Jayne" }
    ];

    const brandsContainer = document.querySelector(".brands-container");

    brands.forEach(brand => {
        const brandItem = document.createElement("div");
        brandItem.classList.add("brand-item");

        const img = document.createElement("img");
        img.src = brand.src;
        img.alt = brand.alt;

        brandItem.appendChild(img);
        brandsContainer.appendChild(brandItem);
    });

    // 🏷️ **7. Slider sản phẩm**
    const sliderWrapper = document.querySelector(".swiper-wrapper");
    const tabButtons = document.querySelectorAll(".tab-button");

    function loadFeaturedProducts(category) {
        fetch(`http://localhost/DoAnWeb2/WebBanHang_NuocHoa/frontend/product.php?gender=${category}`)
            .then(response => response.json())
            .then(products => {
                sliderWrapper.innerHTML = ""; // Xóa sản phẩm cũ

                if (!Array.isArray(products)) {
                    console.error("Dữ liệu API không hợp lệ:", products);
                    sliderWrapper.innerHTML = "<p>Không thể tải sản phẩm.</p>";
                    return;
                }

                products.forEach(product => {
                    const slide = document.createElement("div");
                    slide.classList.add("swiper-slide");
                    slide.innerHTML = `
                        <div class="product-card" data-id="${product.ma_nuoc_hoa}">
                            <img src="${product.hinh_1}" alt="${product.ten_nuoc_hoa}">
                            <h4>${product.ten_nuoc_hoa}</h4>
                            <strong>${new Intl.NumberFormat('vi-VN').format(product.gia_ban)} đ</strong>
                        </div>
                    `;
                    sliderWrapper.appendChild(slide);
                });

                swiper.update();
            })
            .catch(error => {
                console.error("Lỗi tải dữ liệu:", error);
                sliderWrapper.innerHTML = "<p>Không thể tải sản phẩm.</p>";
            });
    }

    let swiper = new Swiper(".product-slider", {
        slidesPerView: 4,
        spaceBetween: 20,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            1200: { slidesPerView: 4 },
            1024: { slidesPerView: 3 },
            768: { slidesPerView: 2 },
            576: { slidesPerView: 1 },
            340: { slidesPerView: 1 }
        }
    });

    tabButtons.forEach(button => {
        button.addEventListener("click", function () {
            tabButtons.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");
            loadFeaturedProducts(this.dataset.category);
        });
    });

    loadFeaturedProducts("Nam");
});
