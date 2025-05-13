<?php 
session_start();

if (isset($_SESSION["username"])) {
    header("Location: /frontend/user.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <!-- External Libs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <!-- Our Files -->
    <!-- CSS -->
    <link rel="stylesheet" href="./css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- JS -->
    <script src="./js/login.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php require 'components/header.php'?>

    <div class="login-page py-5">
        <div class="form w-50">
            <form id="login-form" class="login-form" action="" method="post">
                <input id="username" name='username' type="text" placeholder="Tên đăng nhập" required>
                <input id="password" name="password" type="password" placeholder="Mật khẩu" required>
                <button type="submit">Đăng Nhập</button>
                <p class="message">Bạn chưa có tài khoản? <a id="signup" href="#">Đăng ký</a></p>
                <p id="error-message" class="p-0" style="color: red;"></p>
            </form>
        </div>
    </div>

    <div class="signup-page py-5" style="display: none;">
        <div class="form w-50">
            <form id="register-form" class="login-form" action="" method="post">
                <input id="username" type="text" placeholder="Tên đăng nhập*" required>
                <input id="password" type="password" placeholder="Mật khẩu*" required>
                <input id="confirmPassword" type="password" placeholder="Nhập lại mật khẩu*" required>
                <button type="submit">Đăng Ký</button>
                <p class="message">Bạn đã có tài khoản? <a id="login" href="#">Đăng Nhập</a></p>
                <p id="error-message" class="p-0" style="color: red;"></p>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php require 'components/footer.php'?>
</body>

</html>