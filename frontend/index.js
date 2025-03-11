document.addEventListener("DOMContentLoaded", function () {
    const menuLinks = document.querySelectorAll(".menu-link");
    const sections = document.querySelectorAll(".content-section");

    menuLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const sectionId = this.getAttribute("data-section");
            sections.forEach(section => {
                section.style.display = "none";
            });
            document.getElementById(sectionId).style.display = "block";
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
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
});

document.addEventListener("DOMContentLoaded", function () {
    const products = {
        men: [
            { src: "https://xxivstore.com/wp-content/uploads/2022/09/Marie-Jeanne-Vetiver-Santal-300x300.png", name: "Marie Jeanne", desc: "Vetiver Santal", price: "5.250.000 đ" },
            { src: "https://xxivstore.com/wp-content/uploads/2020/06/Nuoc-hoa-Creed-Aventus-300x300.png", name: "Creed", desc: "Aventus", price: "6.000.000 đ" },
            { src: "https://xxivstore.com/wp-content/uploads/2022/06/Kilian-Angels-Share-300x300.png", name: "By Kilian", desc: "Angel’s Share", price: "4.900.000 đ" },
            { src: "https://xxivstore.com/wp-content/uploads/2022/07/Enigma-300x300.png", name: "Roja Parfum", desc: "Enigma Parfum Cologne", price: "8.700.000 đ" },
            { src: "https://xxivstore.com/wp-content/uploads/2022/06/LOrchestre-Piano-Santal-300x300.png", name: "L’Orchestre Parfum", desc: "Piano Santal", price: "1.500.000 đ" },
            { src: "https://xxivstore.com/wp-content/uploads/2023/11/D600-300x300.png", name: "Carner Barcelona", desc: "D600", price: "2.850.000 đ" }
        ],
        women: [
            { src: "https://xxivstore.com/wp-content/uploads/2021/07/XXIV-Store-Nasnomatto-Narcotic-V-300x300.png", name :"Nasomatto", desc: "Nasomatto Narcotic V", price: "3.850.000 đ"},
            { src: "https://xxivstore.com/wp-content/uploads/2023/12/Nuoc-hoa-Ex-Nihilo-Fleur-Narcotique-300x300.png", name :"Ex Nihilo", desc: "Fleur Narcotique", price: "900.000 đ"},
            { src: "https://xxivstore.com/wp-content/uploads/2020/06/baccarat-rouge-540-extrait-extrait-de-parfum-70ml-359-300x300.png", name :"Maison Francis Kurkdijan", desc: "Baccarat Rouge 540 Extrait", price: "6.300.000 đ"},
            { src: "https://xxivstore.com/wp-content/uploads/2020/06/6bb559193c12a192157b071aa6c2f153-300x300.png", name :"Tom Ford", desc: "Lost Cherry", price: "7.500.000 đ"},
            { src: "https://xxivstore.com/wp-content/uploads/2020/06/rolling-in-love-eau-de-parfum-50ml-677-300x300.png", name :"By Kilian", desc: "Rolling in love", price: "6.300.000 đ"},
            { src: "https://xxivstore.com/wp-content/uploads/2022/06/Lorchestre-Rose-Trombone-300x300.png", name :" L’Orchestre Parfum", desc: " L’Orchestre Rose Trombone", price: "4.600.000 đ"},
            { src: "https://xxivstore.com/wp-content/uploads/2022/11/Nuoc-hoa-Paris-Cheri-300x300.png", name :" Astrophil Stella", desc: " Paris Chéri", price: "5.300.000 đ"},
            { src: "https://xxivstore.com/wp-content/uploads/2022/10/Nuoc-hoa-Masque-Milano-Lost-Alice-300x300.png", name :"Masque Milano ", desc: " Lost Alice", price: "4.200.000 đ"},
            { src: "https://xxivstore.com/wp-content/uploads/2020/06/Good-girl-gond-Bad-50ml-300x300.png", name :"By Kilian ", desc: "Good Girl Gone Bad", price: "6.100.000"},
        ],
        unisex: [
            { src: "https://xxivstore.com/wp-content/uploads/2022/09/Marie-Jeanne-Vetiver-Santal-300x300.png", name: "Marie Jeanne", desc: "Vetiver Santal", price: "5.250.000 đ" },
            { src: "https://xxivstore.com/wp-content/uploads/2020/06/Nuoc-hoa-Creed-Aventus-300x300.png", name: "Creed", desc: "Aventus", price: "6.000.000 đ" },
            { src: "https://xxivstore.com/wp-content/uploads/2022/06/Kilian-Angels-Share-300x300.png", name: "By Kilian", desc: "Angel’s Share", price: "4.900.000 đ" },
            { src: "https://xxivstore.com/wp-content/uploads/2022/07/Enigma-300x300.png", name: "Roja Parfum", desc: "Enigma Parfum Cologne", price: "8.700.000 đ" },
            { src: "https://xxivstore.com/wp-content/uploads/2022/06/LOrchestre-Piano-Santal-300x300.png", name: "L’Orchestre Parfum", desc: "Piano Santal", price: "1.500.000 đ" },
            { src: "https://xxivstore.com/wp-content/uploads/2023/11/D600-300x300.png", name: "Carner Barcelona", desc: "D600", price: "2.850.000 đ" }
        ]
    };

    const sliderWrapper = document.querySelector(".swiper-wrapper");
    const tabButtons = document.querySelectorAll(".tab-button");

    function loadProducts(category) {
        sliderWrapper.innerHTML = "";
        products[category].forEach(product => {
            const slide = document.createElement("div");
            slide.classList.add("swiper-slide");
            slide.innerHTML = `
                <div class="product-card">
                    <img src="${product.src}" alt="${product.name}">
                    <h4>${product.name}</h4>
                    <p>${product.desc}</p>
                    <strong>${product.price}</strong>
                </div>
            `;
            sliderWrapper.appendChild(slide);
        });
        swiper.update();
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
            1024: { slidesPerView: 4 },
            768: { slidesPerView: 3 },
            576: { slidesPerView: 2 },
            0: { slidesPerView: 1 }
        }
    });

    tabButtons.forEach(button => {
        button.addEventListener("click", function () {
            tabButtons.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");
            loadProducts(this.dataset.category);
        });
    });

    loadProducts("men"); // Mặc định hiển thị nước hoa nam
});

document.addEventListener("DOMContentLoaded", function () {
    const menuLinks = document.querySelectorAll(".menu-link");
    const sections = document.querySelectorAll(".content-section");

    menuLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const sectionId = this.getAttribute("data-section");
            sections.forEach(section => {
                section.style.display = "none";
            });
            document.getElementById(sectionId).style.display = "block";
        });
    });
});