<?php 
session_start();

if (!isset($_SESSION["username"])) {
    echo '<script>
        alert("Bạn cần đăng nhập để truy cập trang này!");
        window.location.href = "login.php";
    </script>';
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XXIV Store</title>

    <!-- BS4 Libs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous" defer></script>

    <!-- CSS -->
    <link rel="stylesheet" href="./css/user.css">

    <!-- JS -->
    <script src="./js/user.js" defer></script>
</head>

<body>
    <!-- Header -->
    <?php require "./components/header.php" ?>

    <section class="container-fluid py-4">
        <h2 class="mb-4">Thông tin tài khoản</h2>

        <div class="row">
            <div class="col-3 border-right">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item border-0 py-2">
                        <button class="btn btn-link text-muted text-decoration-none shadow-none active" data-toggle="tab" data-target="#account-tab">Trang Tài Khoản</button>
                    </li>
                    <li class="list-group-item border-0 py-2">
                        <button class="btn btn-link text-muted text-decoration-none shadow-none" data-toggle="tab" data-target="#order-tab">Đơn Hàng</button>
                    </li>
                    <li class="list-group-item border-0 py-2">
                        <button class="btn btn-link text-muted text-decoration-none shadow-none" id="logout-btn">Đăng Xuất</button>
                    </li>
                </ul>
            </div>
            <div class="col-9 p-5">
                <div class="tab-content">
                    <div class="tab-pane show fade active" id="account-tab">
                        <p>Họ và tên</p>
                        <input type="text" class="form-control" value="Nguyễn Văn A" disabled>
                        <p>Tên đăng nhập</p>
                        <input type="text" class="form-control" value="abc" disabled>
                        <p>Địa chỉ email</p>
                        <input type="text" class="form-control" value="nguyenvana@gmail.com" disabled>

                        <h2 class="pt-5 pb-2">Thay đổi mật khẩu</h2>
                        <p>Mật khẩu hiện tại</p>
                        <input type="text" class="form-control">
                        <p>Mật khẩu mới</p>
                        <input type="password" class="form-control">
                        <p>Xác nhận mật khẩu mới</p>
                        <input type="password" class="form-control">
                        <button type="button" class="btn btn-primary mt-4 float-right">Lưu thay đổi</button>
                    </div>

                    <div class="tab-pane fade" id="order-tab">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="5" class="text-primary">
                                    Địa chỉ nhận hàng: <br>
                                    273 An Dương Vương, P3, Q5
                                </th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-center bg-primary text-white">
                                    Đơn hàng ngày: 24/02/2025, 3:25:32 PM
                                </th>
                            </tr>
                            <tr class="bg-light text-dark text-center">
                                <td><strong>STT</strong></td>
                                <td><strong>Sản Phẩm</strong></td>
                                <td><strong>Đơn Giá</strong></td>
                                <td><strong>Số Lượng</strong></td>
                                <td><strong>Thành Tiền</strong></td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Lelabo Another 13</td>
                                <td>7,900,000</td>
                                <td>1</td>
                                <td>7,900,000</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Tomford Neroli Portofino</td>
                                <td>6,800,000</td>
                                <td>1</td>
                                <td>6,800,000</td>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-dark bg-light">TỔNG TIỀN:</th>
                                <th class="text-danger bg-light">14,700,000</th>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-right">
                                    Trạng thái đơn hàng: 
                                    <span class="badge badge-success p-2">Đã Giao Hàng</span>
                                </th>
                                <td class="text-center">
                                    <button class="btn btn-secondary btn-sm" disabled>Hủy Đơn</button>
                                </td>
                            </tr>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php require "./components/footer.php" ?>
    
</body>

</html>