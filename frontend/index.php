<?php session_start(); ?>

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
    <link rel="stylesheet" href="./css/index.css">
    <script defer src="./js/index.js"></script>
</head>
<body>
    <?php require 'components/header.php'?>
    
    <div class="content">
        <div class="container my-5">
            <h1 class="text-center fw-bold">Sản phẩm nổi bật</h1>
            <div class="tabs d-flex justify-content-center my-3">
                <span class="tab active" data-category="nam">Nước hoa nam</span>
                <span class="tab" data-category="nu">Nước hoa nữ</span>
                <span class="tab" data-category="unisex">Unisex</span>
            </div>
            <div class="swiper-container">
                <div class="swiper-wrapper" id="product-list"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
    <?php require 'components/footer.php'?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</body>
</html>
