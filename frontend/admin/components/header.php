<?php
// Luôn include config.php bằng đường dẫn tuyệt đối
require_once realpath(__DIR__ . '/../../../backend/config/config.php');
?>


<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.php">Admin</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <span style="color: white;">Welcome, <?php echo $_SESSION['username']; ?>!</span>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a id="logoutButton" class="dropdown-item" href="/WebBanHang_NuocHoa/frontend/admin/logout.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
<script>
    document.getElementById("logoutButton").addEventListener("click", function (e) {
        e.preventDefault(); // Ngăn hành vi mặc định của thẻ <a>
        fetch("/backend/api/UserAPI.php?action=logout")
            .then((respond) => {
            return respond.json();
            })
            .then((data) => {
            alert(data.message);
            localStorage.removeItem("nuochoas");
            window.location.href = "/frontend/index.php";
            })
            .catch((error) => {
            console.log(error);
            });
        });
</script>