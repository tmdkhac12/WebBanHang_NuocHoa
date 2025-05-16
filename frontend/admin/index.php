<?php
require_once 'auth.php';
requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>XXIV Store - Admin</title>
    <?php include "./components/common-head.php" ?>
</head>

<body class="sb-nav-fixed">
    <?php include "./components/header.php" ?>
    <div id="layoutSidenav">
        <?php include "./components/sidebar.php" ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 mb-4">Trang chủ</h1>

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Primary Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Warning Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Success Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">Danger Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <b>Thống kê tình hình kinh doanh</b>
                        </div>
                        <div class="card-body">
                            <form id="statForm" class="row g-3 mb-3">
                                <div class="col-md-3">
                                    <label>Từ ngày</label>
                                    <input type="date" id="fromDate" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Đến ngày</label>
                                    <input type="date" id="toDate" class="form-control" required>
                                </div>
                                <div class="col-md-3 align-self-end">
                                    <button type="submit" class="btn btn-primary">Xem thống kê</button>
                                </div>
                            </form>
                            <h5>Sản phẩm bán ra</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="statProductTable">
                                    <thead>
                                        <tr>
                                            <th>Tên sản phẩm</th>
                                            <th>Số lượng bán</th>
                                            <th>Tổng tiền</th>
                                            <th>Xem hóa đơn</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Tổng thu</th>
                                            <th id="totalRevenue"></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div id="bestWorstProduct" class="mb-3"></div>
                            <h5>Top 5 khách hàng doanh thu cao nhất</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="statCustomerTable">
                                    <thead>
                                        <tr>
                                            <th>Tên khách hàng</th>
                                            <th>Email</th>
                                            <th>Tổng doanh thu</th>
                                            <th>Xem hóa đơn</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Thông tin khách hàng
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>
                                    <tr>
                                        <td>Garrett Winters</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>63</td>
                                        <td>2011/07/25</td>
                                        <td>$170,750</td>
                                    </tr>
                                    <tr>
                                        <td>Ashton Cox</td>
                                        <td>Junior Technical Author</td>
                                        <td>San Francisco</td>
                                        <td>66</td>
                                        <td>2009/01/12</td>
                                        <td>$86,000</td>
                                    </tr>
                                    <tr>
                                        <td>Cedric Kelly</td>
                                        <td>Senior Javascript Developer</td>
                                        <td>Edinburgh</td>
                                        <td>22</td>
                                        <td>2012/03/29</td>
                                        <td>$433,060</td>
                                    </tr>
                                    <tr>
                                        <td>Airi Satou</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>33</td>
                                        <td>2008/11/28</td>
                                        <td>$162,700</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php require "./components/footer.php" ?>
        </div>
    </div>
    <?php include "./components/common-scripts.php" ?>
</body>
<script>
    $('#statForm').on('submit', function(e) {
    console.log('submit');
    e.preventDefault();
    const fromDate = $('#fromDate').val();
    const toDate = $('#toDate').val();
    console.log(fromDate, toDate);
    $.ajax({
        url: '../../backend/api/ThongKeAPI.php?action=statistic',
        method: 'GET',
        data: { fromDate, toDate },
        dataType: 'json',
        success: function(res) {
            console.log(res);
            // Render sản phẩm
            let html = '';
            let max = 0, min = Infinity, best = '', worst = '';
            let total = 0;
            res.products.forEach(p => {
                html += `<tr>
                    <td>${p.ten_nuoc_hoa}</td>
                    <td>${p.so_luong_ban}</td>
                    <td>${Number(p.tong_tien).toLocaleString('vi-VN')}</td>
                    <td><a href="#" class="btn btn-sm btn-info btn-view-orders" data-product="${p.ten_nuoc_hoa}">Xem hóa đơn</a></td>
                </tr>`;
                total += Number(p.tong_tien);
                if (p.so_luong_ban > max) { max = p.so_luong_ban; best = p.ten_nuoc_hoa; }
                if (p.so_luong_ban < min) { min = p.so_luong_ban; worst = p.ten_nuoc_hoa; }
            });
            $('#statProductTable tbody').html(html);
            $('#totalRevenue').text(total.toLocaleString('vi-VN'));
            $('#bestWorstProduct').html(
                `<b>Bán chạy nhất:</b> ${best} (${max}) &nbsp; | &nbsp; <b>Bán ế nhất:</b> ${worst} (${min})`
            );

            // Render khách hàng
            html = '';
            res.customers.forEach(c => {
                html += `<tr>
                    <td>${c.ten_khach_hang}</td>
                    <td>${c.email}</td>
                    <td>${Number(c.tong_doanh_thu).toLocaleString('vi-VN')}</td>
                    <td><a href="#" class="btn btn-sm btn-info btn-view-orders-customer" data-customer="${c.ma_khach_hang}">Xem hóa đơn</a></td>
                </tr>`;
            });
            $('#statCustomerTable tbody').html(html);
        }
    });
});
</script>
</html>