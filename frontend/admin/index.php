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
                        <div class="row">
                            <!-- Tổng số đơn hàng -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-3 p-2 text-center">
                                    <div class="card-body py-2">
                                        <div class="h5 mb-1">Tổng số đơn hàng</div>
                                        <div class="fs-4 fw-bold dashboard-total-orders"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tổng doanh thu -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-3 p-2 text-center">
                                    <div class="card-body py-2">
                                        <div class="h5 mb-1">Tổng doanh thu</div>
                                        <div class="fs-4 fw-bold dashboard-total-revenue"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Số đơn hàng hôm nay -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-3 p-2 text-center">
                                    <div class="card-body py-2">
                                        <div class="h5 mb-1">Số đơn hàng hôm nay</div>
                                        <div class="fs-4 fw-bold dashboard-orders-today"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Khách hàng đã mua hàng -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-3 p-2 text-center">
                                    <div class="card-body py-2">
                                        <div class="h5 mb-1">Khách hàng đã mua hàng</div>
                                        <div class="fs-4 fw-bold dashboard-customers"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-5   ">
                            <div class="card-header">
                                <b><h5>Thống kê tình hình kinh doanh</h5></b>
                            </div>
                            <div class="mb-4" style="max-width: 400px; margin: 0 auto;">
                                <canvas id="productPieChart" height="200"></canvas>
                                <div id="bestWorstProduct" class="mt-2 mb-2 text-primary"></div>
                            </div>
                            
                            <div class="card-body">
                                <form id="statForm1" class="row g-3 mb-3">
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
                                            <tr class="text-center">
                                                <th>Tên sản phẩm</th>
                                                <th>Số lượng bán</th>
                                                <th>Tổng tiền sản phẩm bán được </th>
                                                <th>Xem hóa đơn</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr class="text-center">
                                                <th colspan="2">Tổng thu</th>
                                                <th id="totalRevenue"></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <b><h5>Danh sách khách hàng có doanh thu cao nhất</h5></b>
                            </div>
                            <div class="mb-4" style="max-width: 100%">
                                        <canvas id="topCustomersChart" height="60"></canvas>
                                    </div>
                            <div class="card-body">
                                <form id="statForm2" class="row g-3 mb-3">
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
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="topCustomersTable">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Mã khách hàng</th>
                                                <th>Tên khách hàng</th>
                                                <th>Doanh Thu</th>
                                                <th>Xem hóa đơn</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                </div>
            </main>
            <?php require "./components/footer.php" ?>
        </div>
    </div>
    <div class="modal fade" id="customerOrdersModal" tabindex="-1" aria-labelledby="customerOrdersModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customerOrdersModalLabel">Danh sách hóa đơn của khách hàng</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <thead>
            <tr class="text-center">
              <th>Mã hóa đơn</th>
              <th>Ngày đặt</th>
              <th>Tổng tiền hoá đơn</th>
              <th>Trạng thái</th>
            </tr>
          </thead>
          <tbody id="customerOrdersTableBody">
            <!-- Dữ liệu sẽ được JS render -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
    <?php include "./components/common-scripts.php" ?>
</body>
<script>
    $(document).ready(function() {
        $.ajax({
            url: '../../backend/api/ThongKeAPI.php?action=dashboard',
            method: 'GET',
            dataType: 'json',
            success: function(res) {
                $('.dashboard-total-orders').text(res.totalOrders);
                $('.dashboard-total-revenue').text(Number(res.totalRevenue).toLocaleString('vi-VN') + '₫');
                $('.dashboard-orders-today').text(res.ordersToday);
                $('.dashboard-customers').text(res.customers);
            }
        });
    });

    $(document).ready(function() {
    // Lấy top khách hàng của cả năm và render bảng + biểu đồ
        const year = new Date().getFullYear();
        const from = `${year}-01-01`;
        const to = `${year}-12-31`;
        $.ajax({
            url: '../../backend/api/ThongKeAPI.php?action=topCustomers',
            method: 'GET',
            data: { from, to },
            dataType: 'json',
            success: function(customers) {
                let html = '';
                customers.forEach((c, i) => {
                    html += `<tr>
                        <td>${c.ma_khach_hang}</td>
                        <td>${c.ten_khach_hang}</td>
                        <td>${Number(c.tong_doanh_thu).toLocaleString('vi-VN')}₫</td>
                        <td>
                            <a href="#" class="btn btn-info btn-sm btn-view-orders-customer" data-customer="${c.ma_khach_hang}">
                                Xem hoá đơn
                            </a>
                        </td>
                    </tr>`;
                });
                $('#topCustomersTable tbody').html(html);
                renderTopCustomersChart(customers); // Vẽ biểu đồ sau khi render bảng
            }
        });
    });

    $(document).on('click', '.btn-view-orders-customer', function(e) {
        e.preventDefault();
        const customerId = $(this).data('customer');
        const fromDate = $(this).data('from') || '';
        const toDate = $(this).data('to') || '';
        $.ajax({
            url: '../../backend/api/HoaDonAPI.php?action=getByCustomer',
            method: 'GET',
            data: { customerId, from: fromDate, to: toDate },
            dataType: 'json',
            success: function(res) {
                let html = '';
                if (res && res.length > 0) {
                    res.forEach(order => {
                        html += `<tr>
                            <td>${order.ma_hoa_don}</td>
                            <td>${order.thoi_gian}</td>
                            <td>${Number(order.tong_tien).toLocaleString('vi-VN')}₫</td>
                            <td>${order.trang_thai_don_hang}</td>
                        </tr>`;
                    });
                } else {
                    html = '<tr><td colspan="4" class="text-center">Không có hóa đơn nào</td></tr>';
                }
                $('#customerOrdersTableBody').html(html);
                $('#customerOrdersModal').modal('show');
            }
        });
    });

    $('#statForm2').on('submit', function(e) {
        e.preventDefault();
        const fromDate = $('#statForm2 #fromDate').val();
        const toDate = $('#statForm2 #toDate').val();
        $.ajax({
            url: '../../backend/api/ThongKeAPI.php?action=topCustomers',
            method: 'GET',
            data: { from: fromDate, to: toDate },
            dataType: 'json',
            success: function(customers) {
                let html = '';
                customers.forEach((c, i) => {
                    html += `<tr>
                        <td>${c.ma_khach_hang}</td>
                        <td>${c.ten_khach_hang}</td>
                        <td>${Number(c.tong_doanh_thu).toLocaleString('vi-VN')}₫</td>
                        <td>
                            <a href="#" class="btn btn-info btn-sm btn-view-orders-customer"
                            data-customer="${c.ma_khach_hang}"
                            data-from="${fromDate || ''}"
                            data-to="${toDate || ''}">
                                Xem hoá đơn
                            </a>
                        </td>
                    </tr>`;
                });
                $('#topCustomersTable tbody').html(html);
                renderTopCustomersChart(customers);
            }
        });
    });

    function renderTopCustomersChart(customers) {
        const labels = customers.map(c => c.ten_khach_hang);
        const data = customers.map(c => c.tong_doanh_thu);

        // Kiểm tra đúng kiểu đối tượng Chart trước khi destroy
        if (window.topCustomersChart && typeof window.topCustomersChart.destroy === 'function') {
            window.topCustomersChart.destroy();
        }

        const ctx = document.getElementById('topCustomersChart').getContext('2d');
        window.topCustomersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN');
                            }
                        }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }
    // Thống kê sản phẩm bán ra
    $(document).ready(function() {
        const year = new Date().getFullYear();
        const from = `${year}-01-01`;
        const to = `${year}-12-31`;
        $.ajax({
            url: '../../backend/api/ThongKeAPI.php?action=statistic',
            method: 'GET',
            data: { from, to },
            dataType: 'json',
            success: function(res) {
                let html = '';
                let total = 0;
                let max = -Infinity, min = Infinity;
                let best = '', worst = '';
                res.products.forEach(p => {
                    html += `<tr>
                        <td>${p.ten_nuoc_hoa}</td>
                        <td>${p.so_luong_ban}</td>
                        <td>${Number(p.tong_tien).toLocaleString('vi-VN')}</td>
                        <td>
                            <a href="#" class="btn btn-info btn-sm btn-view-orders-product"
                            data-product="${p.ten_nuoc_hoa}"
                            data-from="${from}"
                            data-to="${to}">
                                Xem hóa đơn
                            </a>
                        </td>
                    </tr>`;
                    total += Number(p.tong_tien);
                    if (Number(p.so_luong_ban) > max) {
                        max = Number(p.so_luong_ban);
                        best = p.ten_nuoc_hoa;
                    }
                    if (Number(p.so_luong_ban) < min) {
                        min = Number(p.so_luong_ban);
                        worst = p.ten_nuoc_hoa;
                    }
                });
                $('#statProductTable tbody').html(html);
                $('#totalRevenue').text(total.toLocaleString('vi-VN'));
                $('#bestWorstProduct').html(
                    `<b>Bán chạy nhất:</b> ${best} (${max}) &nbsp; | &nbsp; <b>Bán ế nhất:</b> ${worst} (${min})`
                );
                renderProductPieChart(res.products);
                if (res.products.length > 0) {
                    let max = -Infinity, min = Infinity;
                    let best = '', worst = '';
                    res.products.forEach(p => {
                        if (Number(p.so_luong_ban) > max) {
                            max = Number(p.so_luong_ban);
                            best = p.ten_nuoc_hoa;
                        }
                        if (Number(p.so_luong_ban) < min) {
                            min = Number(p.so_luong_ban);
                            worst = p.ten_nuoc_hoa;
                        }
                    });
                    $('#bestWorstProduct').html(
                        `<b>Bán chạy nhất:</b> ${best} (${max}) &nbsp; | &nbsp; <b>Bán ế nhất:</b> ${worst} (${min})`
                    );
                } else {
                    $('#bestWorstProduct').html('');
                }
            }
        });
    });

    $(document).on('click', '.btn-view-orders-product', function(e) {
        e.preventDefault();
        $('#customerOrdersModalLabel').text('Danh sách hóa đơn chứa sản phẩm');
        const productName = $(this).data('product');
        const fromDate = $(this).data('from') || '';
        const toDate = $(this).data('to') || '';
        $.ajax({
            url: '../../backend/api/HoaDonAPI.php?action=getByProduct',
            method: 'GET',
            data: { productName, from: fromDate, to: toDate },
            dataType: 'json',
            success: function(res) {
                let html = '';
                if (res && res.length > 0) {
                    res.forEach(order => {
                        html += `<tr>
                            <td>${order.ma_hoa_don}</td>
                            <td>${order.thoi_gian}</td>
                            <td>${Number(order.tong_tien).toLocaleString('vi-VN')}₫</td>
                            <td>${order.trang_thai_don_hang}</td>
                        </tr>`;
                    });
                } else {
                    html = '<tr><td colspan="4" class="text-center">Không có hóa đơn nào</td></tr>';
                }
                $('#customerOrdersTableBody').html(html);
                $('#customerOrdersModal').modal('show');
            }
        });
    });

    function renderProductPieChart(products) {
        const labels = products.map(p => p.ten_nuoc_hoa);
        const data = products.map(p => Number(p.so_luong_ban));

        // Hủy chart cũ nếu có
        if (window.productPieChart && typeof window.productPieChart.destroy === 'function') {
            window.productPieChart.destroy();
        }

        const ctx = document.getElementById('productPieChart').getContext('2d');
        window.productPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Số lượng bán',
                    data: data,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                        '#9966FF', '#FF9F40', '#C9CBCF', '#FF6384',
                        '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    $('#statForm1').on('submit', function(e) {
        e.preventDefault();
        const fromDate = $('#statForm1 #fromDate').val();
        const toDate = $('#statForm1 #toDate').val();
        $.ajax({
            url: '../../backend/api/ThongKeAPI.php?action=statistic',
            method: 'GET',
            data: { from: fromDate, to: toDate },
            dataType: 'json',
            success: function(res) {
                let html = '';
                let total = 0;
                let max = -Infinity, min = Infinity;
                let best = '', worst = '';
                res.products.forEach(p => {
                    html += `<tr>
                        <td>${p.ten_nuoc_hoa}</td>
                        <td>${p.so_luong_ban}</td>
                        <td>${Number(p.tong_tien).toLocaleString('vi-VN')}</td>
                        <td>
                            <a href="#" class="btn btn-info btn-sm btn-view-orders-product"
                            data-product="${p.ten_nuoc_hoa}"
                            data-from="${fromDate}"
                            data-to="${toDate}">
                                Xem hóa đơn
                            </a>
                        </td>
                    </tr>`;
                    total += Number(p.tong_tien);
                    if (Number(p.so_luong_ban) > max) {
                        max = Number(p.so_luong_ban);
                        best = p.ten_nuoc_hoa;
                    }
                    if (Number(p.so_luong_ban) < min) {
                        min = Number(p.so_luong_ban);
                        worst = p.ten_nuoc_hoa;
                    }
                });
                $('#statProductTable tbody').html(html);
                $('#totalRevenue').text(total.toLocaleString('vi-VN'));
                $('#bestWorstProduct').html(
                    `<b>Bán chạy nhất:</b> ${best} (${max}) &nbsp; | &nbsp; <b>Bán ế nhất:</b> ${worst} (${min})`
                );
                renderProductPieChart(res.products);
            }
        });
    });
</script>

</html>