// sanpham.js
const products = [
    { name: "Esencia Eau de Parfum", brand: "Loewe", price: 4500000, image: "path_to_image/esencia.jpg", gender: "Unisex" },
    { name: "AlUla", brand: "Penhaligon's", price: 3800000, image: "path_to_image/alula.jpg", gender: "Unisex" },
    { name: "Solaris", brand: "Penhaligon's", price: 2850000, image: "path_to_image/solaris.jpg", gender: "Unisex" },
    { name: "001 Man EDP", brand: "Loewe", price: 3550000, image: "path_to_image/001man.jpg", gender: "Nam" },
    { name: "001 Woman EDT", brand: "Loewe", price: 3200000, image: "path_to_image/001woman.jpg", gender: "Nữ" },
    { name: "Old Fashioned", brand: "By Kilian", price: 6700000, image: "path_to_image/oldfashioned.jpg", gender: "Unisex" },
    { name: "Coromandel", brand: "Chanel", price: 6700000, image: "path_to_image/coromandel.jpg", gender: "Unisex" },
    { name: "Esencia Eau de Parfum", brand: "Loewe", price: 4500000, image: "path_to_image/esencia.jpg", gender: "Unisex" },
    { name: "AlUla", brand: "Penhaligon's", price: 3800000, image: "path_to_image/alula.jpg", gender: "Unisex" },
    { name: "Solaris", brand: "Penhaligon's", price: 2850000, image: "path_to_image/solaris.jpg", gender: "Unisex" },
    { name: "001 Man EDP", brand: "Loewe", price: 3550000, image: "path_to_image/001man.jpg", gender: "Nam" },
    { name: "001 Woman EDT", brand: "Loewe", price: 3200000, image: "path_to_image/001woman.jpg", gender: "Nữ" },
    { name: "Old Fashioned", brand: "By Kilian", price: 6700000, image: "path_to_image/oldfashioned.jpg", gender: "Unisex" },
    { name: "Coromandel", brand: "Chanel", price: 6700000, image: "path_to_image/coromandel.jpg", gender: "Unisex" },
    { name: "Rice Milk", brand: "Kira Parfum", price: 1100000, image: "path_to_image/ricemilk.jpg", gender: "Unisex" }
];

document.addEventListener("DOMContentLoaded", () => {
    const productGrid = document.getElementById("productGrid");
    const genderFilters = document.querySelectorAll('input[type="checkbox"][id^="gender"]');
    const priceFilters = document.querySelectorAll('input[name="priceRange"]');
    const clearFiltersBtn = document.getElementById("clearFilters");
    const resultCount = document.getElementById("resultCount");
    const pagination = document.getElementById("pagination");

    const productsPerPage = 9; // 9 products per page
    let currentPage = 1;
    let filteredProducts = [...products];

    // Function to format price with dots (e.g., 4500000 -> 4.500.000đ)
    const formatPrice = (price) => {
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + "đ";
    };

    // Function to render products for the current page
    const renderProducts = () => {
        productGrid.innerHTML = "";
        const start = (currentPage - 1) * productsPerPage;
        const end = start + productsPerPage;
        const productsToShow = filteredProducts.slice(start, end);

        productsToShow.forEach(product => {
            const productCard = `
                <div class="col-md-4">
                    <div class="product-card">
                        <img src="${product.image}" alt="${product.name}">
                        <h6>${product.name}</h6>
                        <p>${formatPrice(product.price)}</p>
                    </div>
                </div>
            `;
            productGrid.innerHTML += productCard;
        });

        // Update result count
        const totalProducts = filteredProducts.length;
        const displayedProducts = Math.min(end, totalProducts);
        resultCount.textContent = `Hiện thị ${start + 1}-${displayedProducts} của ${totalProducts} kết quả`;

        // Render pagination
        renderPagination();
    };

    // Function to render pagination
    const renderPagination = () => {
        pagination.innerHTML = "";
        const totalPages = Math.ceil(filteredProducts.length / productsPerPage);

        // Previous button
        const prevLi = document.createElement("li");
        prevLi.className = `page-item ${currentPage === 1 ? "disabled" : ""}`;
        prevLi.innerHTML = `<a class="page-link" href="#">Trước</a>`;
        prevLi.addEventListener("click", (e) => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                renderProducts();
            }
        });
        pagination.appendChild(prevLi);

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            const pageLi = document.createElement("li");
            pageLi.className = `page-item ${i === currentPage ? "active" : ""}`;
            pageLi.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            pageLi.addEventListener("click", (e) => {
                e.preventDefault();
                currentPage = i;
                renderProducts();
            });
            pagination.appendChild(pageLi);
        }

        // Next button
        const nextLi = document.createElement("li");
        nextLi.className = `page-item ${currentPage === totalPages ? "disabled" : ""}`;
        nextLi.innerHTML = `<a class="page-link" href="#">Sau</a>`;
        nextLi.addEventListener("click", (e) => {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                renderProducts();
            }
        });
        pagination.appendChild(nextLi);
    };

    // Function to filter products
    const filterProducts = () => {
        filteredProducts = [...products];

        // Filter by gender
        const selectedGenders = Array.from(genderFilters)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);
        if (selectedGenders.length > 0) {
            filteredProducts = filteredProducts.filter(product => selectedGenders.includes(product.gender));
        }

        // Filter by price
        const selectedPriceRange = Array.from(priceFilters)
            .find(radio => radio.checked)?.value;
        if (selectedPriceRange) {
            const [minPrice, maxPrice] = selectedPriceRange.split("-").map(Number);
            filteredProducts = filteredProducts.filter(product => 
                product.price >= minPrice && product.price <= maxPrice
            );
        }

        // Reset to first page after filtering
        currentPage = 1;
        renderProducts();
    };

    // Function to clear all filters
    const clearFilters = () => {
        genderFilters.forEach(checkbox => (checkbox.checked = false));
        priceFilters.forEach(radio => (radio.checked = false));
        document.getElementById("brandSearch").value = "";
        filteredProducts = [...products];
        currentPage = 1;
        renderProducts();
    };

    // Initial render
    renderProducts();

    // Add event listeners for filters
    genderFilters.forEach(filter => filter.addEventListener("change", filterProducts));
    priceFilters.forEach(filter => filter.addEventListener("change", filterProducts));
    clearFiltersBtn.addEventListener("click", clearFilters);
});