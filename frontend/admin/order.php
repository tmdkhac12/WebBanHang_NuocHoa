<?php
require_once '../../backend/controller/HoaDonController.php';

$orderController = new HoaDonController();

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$orders = $orderController->getAllHoaDon($limit, $offset);
// $totalOrders = $orderController->getTotalHo();
// $totalPages = ceil($totalOrders / $limit);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Order List</title>
    <?php include "./components/common-head.php" ?>
</head>

<body class="sb-nav-fixed">
    <?php include "./components/header.php" ?>
    <div id="layoutSidenav">
        <?php include "./components/sidebar.php" ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Order</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Order</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Mã hoá đơn</th>
                                        <th>Tổng tiền</th>
                                        <th>Thời gian</th>
                                        <th>Tên khách hàng</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ giao hàng</th>
                                        <th>Trạng thái đơn hàng</th>
                                        <th>Hàng động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($orders)): ?>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td><?php echo $order['ma_hoa_don']; ?></td>
                                                <td><?php echo number_format($order['tong_tien'], 0, ',', '.'); ?> VND</td>
                                                <td><?php echo $order['thoi_gian']; ?></td>
                                                <td><?php echo $order['ten_khach_hang']; ?></td>
                                                <td><?php echo $order['so_dien_thoai_nguoi_nhan']; ?></td>
                                                <td><?php echo $order['dia_chi_giao_hang']; ?></td>
                                                <td><?php echo $order['trang_thai_don_hang']; ?></td>
                                                <td>
                                                    <a class="btn btn-success btn-sm" href="#">View</a>
                                                    <a class="btn btn-warning btn-sm" href="#">Update</a>
                                                    <a class="btn btn-danger btn-sm" href="#">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7">Không có đơn hàng nào.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <nav>
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            </main>
            <?php include "./components/footer.php" ?>
        </div>
    </div>
    <?php include "./components/common-scripts.php" ?>
</body>

</html>