<?php
require_once 'auth.php';
requireAdmin();
require_once '../../backend/controller/HoaDonController.php';

$orderController = new HoaDonController();

$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$orders = $orderController->getAllHoaDon($limit, $offset);
$totalOrders = $orderController->getTotalOrders(); // Tổng số đơn hàng
$totalPages = ceil($totalOrders / $limit); // Tổng số trang
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
                    <h1 class="mt-4">Đơn hàng</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Đơn hàng</li>
                    </ol>
                    <div class="row align-items-center mb-3">
                        <!-- Tìm kiếm với nút tích hợp -->
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" id="searchUser" class="form-control" placeholder="Tìm kiếm đơn hàng...">
                                <button class="btn btn-outline-primary" id="btnSearchUser">Tìm</button>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Mã hoá đơn</th>
                                        <th>Tổng tiền</th>
                                        <th>Thời gian</th>
                                        <th>Tên khách hàng</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ giao hàng</th>
                                        <th>Trạng thái đơn hàng</th>
                                        <th>Hành động</th>
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
                                                    <a class="btn btn-success btn-sm btn-view" data-id="<?= $order['ma_hoa_don'] ?>">View</a>
                                                    <a class="btn btn-warning btn-sm btn-update" data-id="<?= $order['ma_hoa_don'] ?>">Update</a>
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
                    <div class="card-footer">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end mb-0">
                            
                            </ul>
                        </nav>
                    </div>
                </div>
            </main>
            <?php include "./components/footer.php" ?>
        </div>
    </div>
    <div class="modal" id="staticBackdrop4" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Thông tin đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="name">Tên Khách hàng</label>
                            <input type="text" id="name" class="form-control" readonly />
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="email">Số điện thoại</label>
                            <input type="text" id="soDienThoai" class="form-control" readonly />
                            <div class="invalid-feedback" id="emailError"></div>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="password">Thời gian</label>
                            <input type="text" id="thoiGian" class="form-control" readonly />
                            <div class="invalid-feedback" id="passwordError"></div>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="password">Tổng tiền</label>
                            <input type="text" id="tongTien" class="form-control" readonly />
                            <div class="invalid-feedback" id="passwordError"></div>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="username">Địa chỉ</label>
                            <input type="text" id="diaChi" class="form-control" />
                            <div class="invalid-feedback" id="diaChiError"></div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="trangthai">Trạng thái đơn hàng</label>
                                    <select id="trangthai" class="form-select">
                                        <option value="Đang sử lý">Đang sử lý</option>
                                        <option value="Đã giao">Đã giao</option>
                                        <option value="Đã huỷ">Đã huỷ</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <h5 id="orderDetailTitle">Chi tiết đơn hàng</h5>
                        <div class="table-responsive" id="orderDetailSection">
                            <table class="table table-bordered" id="orderDetailTable">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dữ liệu sẽ được thêm bằng JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveChangesButton">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include "./components/common-scripts.php" ?>
</body>
<script>
    $(document).ready(function() {
        let isUpdateMode = false;
        let userIdToUpdate = null;

        // Reset form
        function resetUserForm() {
            $('#userForm')[0].reset();
            $('#name, #email, #username, #password').val('');
            $('#staticBackdrop4 input').prop('disabled', false);
            $('#staticBackdrop4 select').prop('disabled', false);
            $('#username').prop('readonly', false);
            $('#saveUserButton').show();
        }

        // Khi nhấn nút "Thêm người dùng"
        $('#btnAddUser').on('click', function() {
            isUpdateMode = false;
            userIdToUpdate = null;
            $('#modalTitle').text('Thêm người dùng');
            resetUserForm();
            var modal = new bootstrap.Modal(document.getElementById('staticBackdrop4'));
            modal.show();
        });

        // Xử lý sự kiện submit của form
        $('#userForm').on('submit', function(e) {
            e.preventDefault(); // Ngăn hành vi mặc định của form

            const orderData = {
                maHoaDon: userIdToUpdate,
                diaChi: $('#diaChi').val().trim(),
                trangThai: $('#trangthai').val().trim()
            };
            console.log(orderData);
            $('.invalid-feedback').text('');
            $('.form-control').removeClass('is-invalid');

            let isValid = true;
            if (orderData.diaChi.length === 0) {
                $('#diaChiError').text('Địa chỉ không được để trống .');
                $('#diaChi').addClass('is-invalid');
                isValid = false;
            }
            if (!isValid) {
                return;
            }
            if (isUpdateMode) {
                $.ajax({
                    url: '../../backend/api/HoaDonAPI.php?action=updateHoaDon',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(orderData),
                    success: function(response) {
                        if (response.success) {
                            alert('Đơn hàng đã được cập nhật thành công!');
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.message.includes('Email đã tồn tại')) {
                            $('#emailError').text(response.message);
                            $('#email').addClass('is-invalid');
                        }

                        console.error('Lỗi khi cập nhật người dùng:', error);
                    }
                });
            } else {
                $.ajax({
                    url: '../../backend/api/UserAPI.php?action=addUser',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(userData),
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload(); // Reload lại trang
                        } else {
                            alert(response.message); // Hiển thị thông báo lỗi
                        }
                    },
                    error: function(xhr, status, error) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.message.includes('Username đã tồn tại')) {
                            $('#usernameError').text(response.message);
                            $('#username').addClass('is-invalid');
                        }
                        if (response.message.includes('Email đã tồn tại')) {
                            $('#emailError').text(response.message);
                            $('#email').addClass('is-invalid');
                        }

                        console.error('Lỗi khi thêm người dùng:', error);
                    }
                });
            }
        });

        // Khi nhấn nút "Cập nhật"
        $(document).on('click', '.btn-update', function(e) {
            e.preventDefault();
            isUpdateMode = true;
            userIdToUpdate = $(this).data('id');
            loadOrderData(userIdToUpdate, true);
        });

        $(document).on('click', '.btn-view', function(e) {
            e.preventDefault();
            const hoaDonId = $(this).data('id');
            loadOrderData(hoaDonId, false);
        });

        // Hàm load dữ liệu người dùng
        function loadOrderData(hoaDonId, isUpdate) {
            if (isUpdate) {
                userIdToUpdate = hoaDonId;
            }
            $.ajax({
                url: '../../backend/api/HoaDonAPI.php?action=getDetailHoaDonByID&id=' + hoaDonId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    const hoadon = response.data;
                    $('#modalTitle').text(isUpdate ? 'Cập nhật đơn hàng' : 'Thông tin đơn hàng');
                    resetUserForm();
                    $('#name').val(hoadon.ten_khach_hang);
                    $('#soDienThoai').val(hoadon.so_dien_thoai_nguoi_nhan);
                    $('#username').val(hoadon.username);
                    $('#diaChi').val(hoadon.dia_chi_giao_hang);
                    $('#thoiGian').val(hoadon.thoi_gian);
                    $('#tongTien').val(numberFormat(hoadon.tong_tien));
                    $('#trangthai').val(hoadon.trang_thai_don_hang);

                    if (!isUpdate) {
                        $('#orderDetailSection').show();
                        $('#orderDetailTitle').show();
                        $('#staticBackdrop4 input, #staticBackdrop4 select').prop('disabled', true);
                        $('#saveChangesButton').hide();
                        let html = '';
                        if (hoadon.chi_tiet && hoadon.chi_tiet.length > 0) {
                            hoadon.chi_tiet.forEach(function(item) {
                                html += `<tr>
                                    <td>${item.ten_nuoc_hoa}</td>
                                    <td>${numberFormat(item.gia_ban)}</td>
                                    <td>${item.so_luong_mua}</td>
                                    <td>${numberFormat(hoadon.tong_tien)}</td>
                                </tr>`;
                            });
                        } else {
                            html = '<tr><td colspan="4" class="text-center">Không có dữ liệu</td></tr>';
                        }
                        $('#orderDetailTable tbody').html(html);
                    } else {
                        $('#orderDetailSection').hide();
                        $('#orderDetailTitle').hide();
                        $('#staticBackdrop4 input, #staticBackdrop4 select').prop('disabled', false);
                        $('#username').prop('readonly', true);
                        $('#saveChangesButton').show();
                    }
                    var modal = new bootstrap.Modal(document.getElementById('staticBackdrop4'));
                    modal.show();
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi khi lấy dữ liệu người dùng:', error);
                    alert('Không thể lấy dữ liệu người dùng. Vui lòng thử lại!');
                }
            });
        }
    });

    //tim kiem phan trang

    function loadOrders(keyword = '', page = 1) {
        $.ajax({
            url: '../../backend/api/HoaDonAPI.php?action=searchHoaDon',
            method: 'GET',
            data: {
                keyword: keyword,
                page: page,
                limit: 8
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    renderOrderTable(response.orders);
                    renderPagination(response.total, page, keyword);
                }
            }
        });
    }

    $('#btnSearchUser').on('click', function() {
        const keyword = $('#searchUser').val().trim();
        loadOrders(keyword, 1);
    });

    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        const keyword = $('#searchUser').val().trim();
        loadOrders(keyword, page);
    });

    $('#staticBackdrop4').on('hidden.bs.modal', function() {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

    function renderOrderTable(orders) {
        let html = '';
        if (!orders || orders.length === 0) {
            html = '<tr><td colspan="8">Không có đơn hàng nào.</td></tr>';
        } else {
            orders.forEach(order => {
                html += `<tr>
                    <td>${order.ma_hoa_don}</td>
                    <td>${numberFormat(order.tong_tien)}</td>
                    <td>${order.thoi_gian}</td>
                    <td>${order.ten_khach_hang}</td>
                    <td>${order.so_dien_thoai_nguoi_nhan}</td>
                    <td>${order.dia_chi_giao_hang}</td>
                    <td>${order.trang_thai_don_hang}</td>
                    <td>
                        <a class="btn btn-success btn-sm btn-view" data-id="${order.ma_hoa_don}">View</a>
                        <a class="btn btn-warning btn-sm btn-update" data-id="${order.ma_hoa_don}">Update</a>
                    </td>
                </tr>`;
            });
        }
        $('#datatablesSimple tbody').html(html);
    }
    function renderPagination(total, currentPage, keyword) {
        const totalPages = Math.ceil(total / 8);
        let html = '';
        for (let i = 1; i <= totalPages; i++) {
            html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>`;
        }
        $('.pagination').html(html);
    }
    function numberFormat(number) {
        return number.toLocaleString('vi-VN');
    }

    $(document).ready(function() {
        // Gọi hàm này để khi vừa load trang sẽ hiển thị danh sách đơn hàng và phân trang mặc định
        loadOrders('', 1);
    });
</script>

</html>