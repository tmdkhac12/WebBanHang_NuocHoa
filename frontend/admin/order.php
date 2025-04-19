<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables - SB Admin</title>
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
                                        <th>Tên khách hàng</th>
                                        <th>Địa chỉ</th>
                                        <th>Thời gian</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái đơn hàng</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tatyana Fitzpatrick</td>
                                        <td>Regional Director</td>
                                        <td>London</td>
                                        <td>19</td>
                                        <td>2010/03/17</td>
                                        <td>$385,750</td>
                                        <td>
                                            <a class="btn btn-success btn-sm" href="#">View</a>
                                            <a class="btn btn-warning btn-sm" href="#">Update</a>
                                            <a class="btn btn-danger btn-sm" href="#">Delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include "./components/footer.php" ?>
        </div>
    </div>
    <?php include "./components/common-scripts.php" ?>
</body>

</html>