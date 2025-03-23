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
    <script defer src="./js/sanpham.js"></script>
</head>
<body>
    <?php include 'components/header.php' ?>

    <div class="container my-5">
        <div class="row">
            <!-- Filter Section -->
            <div class="col-md-3">
                <div class="filter-section">
                    <h5 class="filter-title">Lọc sản phẩm</h5>
                    <div class="mb-4">
                        <label class="filter-title">Tìm theo thương hiệu</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" id="brandSearch" placeholder="Tìm thương hiệu...">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="filter-title">Giới tính</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Nam" id="genderNam">
                            <label class="form-check-label" for="genderNam">Nam</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Nữ" id="genderNu">
                            <label class="form-check-label" for="genderNu">Nữ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Unisex" id="genderUnisex">
                            <label class="form-check-label" for="genderUnisex">Unisex</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="filter-title">Mức giá</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="priceRange" id="price1" value="0-3000000">
                            <label class="form-check-label" for="price1">Dưới 3.000.000đ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="priceRange" id="price2" value="3000000-5000000">
                            <label class="form-check-label" for="price2">3.000.000đ - 5.000.000đ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="priceRange" id="price3" value="5000000-10000000">
                            <label class="form-check-label" for="price3">5.000.000đ - 10.000.000đ</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="priceRange" id="price4" value="10000000-999999999">
                            <label class="form-check-label" for="price4">Trên 10.000.000đ</label>
                        </div>
                    </div>
                    <button class="btn btn-outline-secondary w-100" id="clearFilters">Xóa bộ lọc</button>
                </div>
            </div>
            <!-- Product Grid Section -->
            <div class="col-md-9">
                <div class="mb-3">
                    <h2 class="section-title">Tất cả sản phẩm</h2>
                    <p class="text-muted" id="resultCount">Hiển thị 1-9 của 15 kết quả</p>
                </div>
                <div class="row" id="productGrid"></div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center" id="pagination"></ul>
                </nav>
            </div>
        </div>
    </div>
    <?php include 'components/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</body>
</html>