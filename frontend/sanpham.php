<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XXIV Store - Nâng cấp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="./css/sanpham.css">
    <link rel="stylesheet" href="./css/index.css">
    <script defer src="./js/sanpham.js"></script>
</head>
<body>
    <?php include 'components/header.php' ?>

    <div class="container my-5">
        <div class="row">
            <!-- Filter Section -->
            <div class="col-md-3 filter-section">
                <h5 class="filter-title">THƯƠNG HIỆU</h5>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" id="brandSearch" placeholder="Tìm kiếm nhãn hiệu">
                </div>
                <ul class="list-unstyled brand-list">
                    <li><a href="#" class="text-muted">acqua di parma</a></li>
                    <li><a href="#" class="text-muted">afnan</a></li>
                    <li><a href="#" class="text-muted">al haramain</a></li>
                    <li><a href="#" class="text-muted">amouage</a></li>
                    <li><a href="#" class="text-muted">armaf</a></li>
                    <li><a href="#" class="text-muted">art de parfum</a></li>
                    <li><a href="#" class="text-muted">astrophil & stella</a></li>
                </ul>

                <h5 class="filter-title mt-4">GIỚI TÍNH</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Nam" id="genderMale">
                    <label class="form-check-label" for="genderMale">Nam</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Nữ" id="genderFemale">
                    <label class="form-check-label" for="genderFemale">Nữ</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Unisex" id="genderUnisex">
                    <label class="form-check-label" for="genderUnisex">Unisex</label>
                </div>

                <h5 class="filter-title mt-4">GIÁ CẢ</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="priceRange" id="price1" value="1500000-3000000">
                    <label class="form-check-label" for="price1">1.500.000đ - 3.000.000đ</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="priceRange" id="price2" value="3000000-5000000">
                    <label class="form-check-label" for="price2">3.000.000đ - 5.000.000đ</label>
                </div>

                <button class="btn btn-outline-secondary mt-3 w-100" id="clearFilters">Xóa bộ lọc</button>
            </div>

            <!-- Product Grid Section -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="section-title">SẢN PHẨM</h5>
                    <div>
                        <span id="resultCount">Hiện thị 1-8 của 8 kết quả</span>
                    </div>
                </div>
                <div class="row" id="productGrid">
                    <!-- Products will be dynamically inserted here -->
                </div>
                <!-- Pagination Section -->
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center" id="pagination">
                        <!-- Pagination buttons will be dynamically inserted here -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <?php include 'components/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</body>
</html>