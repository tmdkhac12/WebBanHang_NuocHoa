<nav class="navbar navbar-expand-lg bg-white shadow-sm py-2 m-0">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <img src="<?php 
                echo '/frontend/images/XXIV-Logo-2.svg';
            ?>" alt="" width="55px" height="55px">
        </a>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav gap-3">
                <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="gioiThieu.php">Giới thiệu</a></li>
                <li class="nav-item"><a class="nav-link" href="sanpham.php">Sản phẩm</a></li>
            </ul>
        </div>
        <div class="d-flex gap-3">
            <a href="<?php
                if (isset($_SESSION["username"])) {
                    echo "user.php";
                } else {
                    echo "login.php";
                }
            ?>" class="text-dark"><i class="fas fa-user"></i></a>
            <a href="giohang.php" class="text-dark"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </div>

</nav>