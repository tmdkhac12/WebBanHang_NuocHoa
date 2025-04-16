document.addEventListener("DOMContentLoaded", function () {
    const productContainer = document.getElementById("product-list");
    const tabs = document.querySelectorAll(".tab");
    let swiperInstance = null;
    let perfumes = { nam: [], nu: [], unisex: [] }; // Dữ liệu sẽ được lấy từ API

    function destroySwiper() {
        if (swiperInstance) {
            swiperInstance.destroy(true, true);
            swiperInstance = null;
        }
    }

    function renderProducts(category) {
        productContainer.innerHTML = "";
        perfumes[category].slice(0, 6).forEach(perfume => {
            const productCard = `
                <div class="swiper-slide">
                    <div class="product-card p-3 text-center" data-id="${perfume.ma_nuoc_hoa}" style="cursor: pointer;">
                        <img src="./images/${perfume.hinh_anh}" alt="${perfume.ten_nuoc_hoa}" class="product-image mb-2">
                        <h5 class="text-danger fw-bold">${perfume.ten_thuong_hieu}</h5>
                        <p class="mb-1">${perfume.ten_nuoc_hoa}</p>
                        <p class="text-success fw-bold">${formatPrice(perfume.gia_ban)}</p>
                    </div>
                </div>`;
            productContainer.innerHTML += productCard;
        });

        // Thêm sự kiện nhấp chuột để chuyển hướng đến trang chi tiết sản phẩm
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', () => {
                const productId = card.getAttribute('data-id');
                window.location.href = `chitietSP.php?id=${productId}`;
            });
        });

        destroySwiper();

        swiperInstance = new Swiper(".swiper-container", {
            slidesPerView: 4,
            spaceBetween: 20,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                1024: { slidesPerView: 4 },
                768: { slidesPerView: 3 },
                480: { slidesPerView: 1 }
            }
        });
    }

    // Hàm định dạng giá
    const formatPrice = (price) => {
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " đ";
    };

    // Lấy dữ liệu từ API
    fetch('/backend/api/ProductAPI.php?action=getFeaturedProducts', {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        perfumes = data; // Gán dữ liệu từ API vào perfumes
        renderProducts("nam"); // Hiển thị tab "Nam" mặc định
    })
    .catch(error => {
        console.error('Error fetching featured products:', error);
        productContainer.innerHTML = '<div class="text-center text-danger">Có lỗi xảy ra khi tải dữ liệu.</div>';
    });

    tabs.forEach(tab => {
        tab.addEventListener("click", function () {
            document.querySelector(".tab.active").classList.remove("active");
            this.classList.add("active");
            renderProducts(this.dataset.category);
        });
    });
});