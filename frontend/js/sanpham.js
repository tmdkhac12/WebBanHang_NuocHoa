document.addEventListener("DOMContentLoaded", () => {
    console.log("DOMContentLoaded event fired");

    const productGrid = document.getElementById("productGrid");
    const genderFilters = document.querySelectorAll('input[type="checkbox"][id^="gender"]');
    const priceFilters = document.querySelectorAll('input[name="priceRange"]');
    const resultCount = document.getElementById("resultCount");
    const pagination = document.getElementById("pagination");
    const productNameSearch = document.getElementById("productNameSearch"); // Đổi từ brandSearch
    const clearFiltersBtn = document.getElementById("clearFilters");

    if (!clearFiltersBtn) {
        console.error("Không tìm thấy nút clearFilters! Kiểm tra ID trong HTML.");
    } else {
        console.log("Nút clearFilters đã được tìm thấy.");
    }

    const productsPerPage = 9;
    let currentPage = 1;
    let totalProducts = 0;
    let lastTotalProducts = 0;
    let abortController = null;

    const formatPrice = (price) => {
    if (price === null || price === undefined) {
        return "Giá chưa cập nhật";  // or any placeholder text you prefer
    }
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + "đ";
};

    const renderProducts = (products, total) => {
        console.log("renderProducts called with products:", products, "total:", total);
        productGrid.innerHTML = "";
        if (products.length === 0) {
            productGrid.innerHTML = '<div class="text-center text-muted">Không tìm thấy sản phẩm phù hợp. Hãy thử thay đổi bộ lọc!</div>';
        } else {
            products.forEach(product => {
                console.log("Rendering product:", product);
                const productCard = `
                    <div class="col-sm-6 col-lg-4">
                        <div class="product-card" data-id="${product.ma_nuoc_hoa}" style="cursor: pointer;">
                            <img src="./images/${product.hinh_anh}" alt="${product.ten_nuoc_hoa}" loading="lazy">
                            <h5>${product.ten_nuoc_hoa}</h5>
                            <p>${product.ten_thuong_hieu}</p>
                            <p>${formatPrice(product.gia_ban)}</p>
                        </div>
                    </div>
                `;
                productGrid.innerHTML += productCard;
            });

            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', () => {
                    const productId = card.getAttribute('data-id');
                    window.location.href = `chitietSP.php?id=${productId}`;
                });
            });
        }

        totalProducts = total;
        const start = (currentPage - 1) * productsPerPage + 1;
        const end = Math.min(currentPage * productsPerPage, totalProducts);
        resultCount.textContent = `Hiển thị ${start}-${end} của ${totalProducts} kết quả`;
        renderPagination();
        lastTotalProducts = totalProducts;
    };

    const renderPagination = () => {
        console.log("renderPagination called, totalPages:", Math.ceil(totalProducts / productsPerPage));
        pagination.innerHTML = "";
        const totalPages = Math.ceil(totalProducts / productsPerPage);

        const prevLi = document.createElement("li");
        prevLi.className = `page-item ${currentPage === 1 ? "disabled" : ""}`;
        prevLi.innerHTML = `<a class="page-link" href="#"><i class="fas fa-angle-double-left"></i></a>`;
        prevLi.addEventListener("click", (e) => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                fetchProducts();
            }
        });
        pagination.appendChild(prevLi);

        for (let i = 1; i <= totalPages; i++) {
            const pageLi = document.createElement("li");
            pageLi.className = `page-item ${i === currentPage ? "active" : ""}`;
            pageLi.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            pageLi.addEventListener("click", (e) => {
                e.preventDefault();
                currentPage = i;
                fetchProducts();
            });
            pagination.appendChild(pageLi);
        }

        const nextLi = document.createElement("li");
        nextLi.className = `page-item ${currentPage === totalPages ? "disabled" : ""}`;
        nextLi.innerHTML = `<a class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a>`;
        nextLi.addEventListener("click", (e) => {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                fetchProducts();
            }
        });
        pagination.appendChild(nextLi);
    };

    const fetchProducts = () => {
        console.log("fetchProducts called, currentPage:", currentPage);
        productGrid.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Đang tải...</div>';

        if (abortController) {
            abortController.abort();
        }
        abortController = new AbortController();

        const selectedGenders = Array.from(genderFilters)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value === "Nữ" ? "Nu" : checkbox.value);

        const selectedPriceRange = Array.from(priceFilters)
            .find(radio => radio.checked)?.value;
        let minPrice = null;
        let maxPrice = null;
        if (selectedPriceRange && selectedPriceRange !== "all") {
            const [min, max] = selectedPriceRange.split('-');
            minPrice = parseInt(min);
            maxPrice = parseInt(max);
        }

        const productNameSearchValue = productNameSearch.value.trim(); // Đổi từ brandSearchValue

        const requestBody = {
            gender: selectedGenders.length > 0 ? selectedGenders : initialGender ? [initialGender] : [],
            productNameSearch: productNameSearchValue, // Đổi từ brandSearch
            page: currentPage
        };

        if (minPrice !== null && maxPrice !== null) {
            requestBody.minPrice = minPrice;
            requestBody.maxPrice = maxPrice;
        }

        console.log("Sending request with data:", requestBody);
        console.log("Final requestBody before stringify:", requestBody);
    console.log("Final JSON:", JSON.stringify(requestBody));
        fetch('/backend/api/ProductAPI.php?action=filterProducts', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(requestBody),
            signal: abortController.signal
        })
        .then(response => {
            console.log("Response status:", response.status);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log("Data received from API:", data);
            if (data.error) {
                productGrid.innerHTML = `<div class="text-center text-danger">${data.error}</div>`;
            } else {
                renderProducts(data.products || [], data.total || 0);
            }
        })
        .catch(error => {
            if (error.name === 'AbortError') {
                console.log("Fetch aborted");
            } else {
                console.error('Error fetching products:', error);
                productGrid.innerHTML = '<div class="text-center text-danger">Có lỗi xảy ra khi tải dữ liệu. Vui lòng thử lại sau.</div>';
            }
        });
    };

    const debounce = (func, delay) => {
        let timeoutId;
        return (...args) => {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => func(...args), delay);
        };
    };

    const resetPageAndFetch = () => {
        console.log("resetPageAndFetch called");
        currentPage = 1;
        fetchProducts();
    };

    const debouncedFetchProducts = debounce(resetPageAndFetch, 300);

    let initialGender = null;
    const applyGenderFilterFromURL = () => {
        console.log("applyGenderFilterFromURL called");
        const urlParams = new URLSearchParams(window.location.search);
        let gender = urlParams.get("gender");
        if (gender) {
            if (gender === "Nữ") gender = "Nu";
            const validGenders = ["Nam", "Nu", "Unisex"];
            if (validGenders.includes(gender)) {
                initialGender = gender;
                const genderCheckbox = document.getElementById(`gender${gender}`);
                if (genderCheckbox) {
                    genderCheckbox.checked = true;
                }
            } else {
                console.warn("Invalid gender value in URL:", gender);
            }
        }
    };

    const resetFilters = () => {
        console.log("resetFilters called");
        console.log("Resetting gender filters...");
        genderFilters.forEach(checkbox => {
            checkbox.checked = false;
            console.log(`Checkbox ${checkbox.id} unchecked`);
        });
        console.log("Resetting price filters...");
        priceFilters.forEach(radio => {
            radio.checked = radio.value === "all";
            console.log(`Radio ${radio.id} set to ${radio.checked}`);
        });
        console.log("Clearing product name search...");
        productNameSearch.value = ""; // Đổi từ brandSearch
        console.log("Resetting currentPage and initialGender...");
        currentPage = 1;
        initialGender = null;
        console.log("Calling fetchProducts...");
        fetchProducts();
    };

    applyGenderFilterFromURL();
    fetchProducts();

    genderFilters.forEach(filter => filter.addEventListener("change", debouncedFetchProducts));
    priceFilters.forEach(filter => filter.addEventListener("change", debouncedFetchProducts));
    productNameSearch.addEventListener("input", debouncedFetchProducts); // Đổi từ brandSearch

    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener("click", (e) => {
            e.preventDefault();
            console.log("Clear filters button clicked");
            resetFilters();
        });
    } else {
        console.error("Không thể gắn sự kiện cho clearFiltersBtn vì không tìm thấy nút!");
    }
});