<?php
session_start();

require __DIR__ . "/../backend/controller/HoaDonController.php";
require __DIR__ . "/../backend/util/Formatter.php";

if (!isset($_SESSION["username"])) {
    echo '<script>
        alert("Bạn cần đăng nhập để truy cập trang này!");
        window.location.href = "login.php";
    </script>';
    exit();
}

$hoaDonController = new HoaDonController();
$hoadons = $hoaDonController->getAllHoaDon($_SESSION["user_id"]);

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
                    
                    <!-- Kiểm tra xem mục này có bị thụt lề -->
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="list-group-item border-0 py-2">
                            <button onclick="window.location.href='/frontend/admin/index.php'" class="btn btn-link text-muted text-decoration-none shadow-none">Trang Quản Lý</button>
                        </li>
                    <?php endif; ?>

                    <li class="list-group-item border-0 py-2">
                        <button class="btn btn-link text-muted text-decoration-none shadow-none" id="logout-btn">Đăng Xuất</button>
                    </li>
                </ul>
            </div>
            <div class="col-9 p-5">
                <div class="tab-content">
                    <div class="tab-pane show fade active" id="account-tab">
                        <form id="acoount-form" action="" method="post">
                            <p>Tên đăng nhập</p>
                            <input type="text" id="input_username" class="form-control" value="<?php echo $_SESSION["username"] ?>" disabled>
                            <p>Họ và tên</p>
                            <div class="d-flex">
                                <input type="text" id="input_hoten" class="form-control" value="<?php echo isset($_SESSION["ten_khach_hang"]) ? $_SESSION["ten_khach_hang"] : ""; ?>" disabled>
                                <button type="button" id="editBtn-hoten" class="btn btn-outline-secondary px-2 ml-1">✏️</button>
                            </div>
                            <p>Địa chỉ email</p>
                            <div class="d-flex">
                                <input type="text" id="input_email" class="form-control" value="<?php echo (isset($_SESSION["email"]) ? $_SESSION["email"] : "") ?>" disabled>
                                <button type="button" id="editBtn-email" class="btn btn-outline-secondary px-2 ml-1">✏️</button>
                            </div>

                            <h2 class="pt-5 pb-2">Thay đổi mật khẩu</h2>

                            <p>Mật khẩu hiện tại (bỏ trống nếu không đổi)</p>
                            <input type="password" id="input_currentpass" class="form-control">
                            <p>Mật khẩu mới (bỏ trống nếu không đổi)</p>
                            <input type="password" id="input-password" class="form-control">
                            <p>Xác nhận mật khẩu mới</p>
                            <input type="password" id="cf-password" class="form-control">
                            <button type="submit" class="btn btn-primary mt-4 float-right">Lưu thay đổi</button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="order-tab">
                        <!-- Start table -->
                        <?php
                        if (!$hoadons) {
                            echo "Bạn chưa có đơn hàng nào!";
                        } else {
                        ?>
                            <?php
                            foreach ($hoadons as $hoadon) {
                                // Mỗi hóa đơn là 1 table  
                                $maHoaDon = $hoadon[0]["ma_hoa_don"];
                            ?>
                                <table class="table table-bordered">
                                    <tr>
                                        <th colspan="5" class="text-primary">
                                            <span class="d-flex justify-content-between">
                                                <p class="m-0 my-1">Địa chỉ nhận hàng: </p>
                                                <p class="m-0 my-1">Người Nhận: </p>
                                            </span>
                                            <span class="d-flex justify-content-between">
                                                <p class="m-0 my-1"><?php echo $hoadon[0]["dia_chi_giao_hang"]; ?></p>
                                                <p class="m-0 my-1"><?php echo $hoadon[0]["ten_nguoi_nhan"] . " (" . $hoadon[0]["so_dien_thoai_nguoi_nhan"] . ")"; ?></p>
                                            </span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-center bg-primary text-white">
                                            Đơn hàng ngày: <?php echo formatDateTime($hoadon[0]["thoi_gian"]); ?>
                                        </th>
                                    </tr>
                                    <tr class="bg-light text-dark text-center">
                                        <td><strong>STT</strong></td>
                                        <td><strong>Sản Phẩm</strong></td>
                                        <td><strong>Đơn Giá</strong></td>
                                        <td><strong>Số Lượng</strong></td>
                                        <td><strong>Thành Tiền</strong></td>
                                    </tr>
                                    <?php
                                    $currentLength = count($hoadon);
                                    $i = 0;
                                    foreach ($hoadon as $chiTietHoaDon) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i + 1;
                                                                    $i = $i + 1; ?></td>
                                            <td><?php echo $chiTietHoaDon["ten_nuoc_hoa"] . " - " . $chiTietHoaDon["dung_tich"] . "ml"; ?></td>
                                            <td class="text-right"><?php echo formatCurrency($chiTietHoaDon["gia_ban"]); ?></td>
                                            <td class="text-center"><?php echo $chiTietHoaDon["so_luong_mua"]; ?></td>
                                            <td class="text-right"><?php echo formatCurrency($chiTietHoaDon["gia_ban"] * $chiTietHoaDon["so_luong_mua"]); ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <th colspan="4" class="text-dark bg-light">TỔNG TIỀN:</th>
                                        <th class="text-danger text-right bg-light"><?php echo formatCurrency($hoadon[0]["tong_tien"]); ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">
                                            Trạng thái đơn hàng:
                                            <span class="badge <?php
                                                                $trangthai = $hoadon[0]["trang_thai_don_hang"];
                                                                if ($trangthai === "Chờ xác nhận") {
                                                                    echo "badge-primary";
                                                                } elseif ($trangthai === "Đang xử lý") {
                                                                    echo "badge-warning";
                                                                } elseif ($trangthai === "Đã giao") {
                                                                    echo "badge-success";
                                                                } else {
                                                                    echo "badge-danger";
                                                                }
                                                                ?> p-2"><?php echo $hoadon[0]["trang_thai_don_hang"]; ?></span>
                                        </th>
                                        <td class="text-center">
                                            <button onclick="addHuyDonHandler(this)" 
                                                    id="btn-huydon<?php echo $maHoaDon; ?>" 
                                                    data-maHoaDon="<?php echo $maHoaDon; ?>" 
                                                    class="btn <?php if ($trangthai === "Chờ xác nhận") echo "btn-danger";else echo "btn-secondary"; ?> btn-sm" 
                                                    <?php if ($trangthai !== "Chờ xác nhận") {echo "disabled"; } ?>>
                                            Hủy Đơn</button>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Gap between invoice -->
                                <p class="py-2"></p>
                            <?php
                            }
                            ?>
                        <?php
                        }
                        ?>
                        <!-- End Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php require "./components/footer.php" ?>

</body>

</html>