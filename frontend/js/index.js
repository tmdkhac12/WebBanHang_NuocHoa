document.addEventListener("DOMContentLoaded", function () {
    const perfumes = {
        "nam": [
            { brand: "Creed", name: "Aventus", price: "6.000.000 đ", image: "./images/aventus.png" },
            { brand: "By Kilian", name: "Angel’s Share", price: "4.900.000 đ", image: "./images/angels-share.png" },
            { brand: "Roja Parfum", name: "Enigma Parfum Cologne", price: "8.700.000 đ", image: "./images/enigma.png" },
            { brand: "Clive Christian", name: "X Masculine", price: "11.000.000 đ", image: "./images/x-masculine.png" },
            { brand: "Xerjoff", name: "Xerjoff Naxos", price: "6.100.000 đ", image: "./images/naxos.png" },
            { brand: "Parfums de Marly", name: "Herod", price: "5.550.000 đ", image: "./images/herod.png" }
        ],
        "nu": [
            { brand: "Chanel", name: "Coco Mademoiselle", price: "5.200.000 đ", image: "./images/coco-mademoiselle.png" },
            { brand: "Dior", name: "Miss Dior", price: "4.800.000 đ", image: "./images/miss-dior.png" },
            { brand: "YSL", name: "Libre Intense", price: "4.500.000 đ", image: "./images/libre-intense.png" }
        ],
        "unisex": [
            { brand: "Le Labo", name: "Santal 33", price: "7.000.000 đ", image: "./images/santal-33.png" },
            { brand: "Maison Francis Kurkdjian", name: "Baccarat Rouge 540", price: "8.200.000 đ", image: "./images/baccarat-rouge.png" },
            { brand: "Tom Ford", name: "Oud Wood", price: "7.500.000 đ", image: "./images/oud-wood.png" }
        ]
    };

    const productContainer = document.getElementById("product-list");
    const tabs = document.querySelectorAll(".tab");
    let swiperInstance = null;

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
                    <div class="product-card p-3 text-center">
                        <img src="${perfume.image}" alt="${perfume.name}" class="product-image mb-2">
                        <h5 class="text-danger fw-bold">${perfume.brand}</h5>
                        <p class="mb-1">${perfume.name}</p>
                        <p class="text-success fw-bold">${perfume.price}</p>
                    </div>
                </div>`;
            productContainer.innerHTML += productCard;
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

    tabs.forEach(tab => {
        tab.addEventListener("click", function () {
            document.querySelector(".tab.active").classList.remove("active");
            this.classList.add("active");
            renderProducts(this.dataset.category);
        });
    });

    renderProducts("nam");
});