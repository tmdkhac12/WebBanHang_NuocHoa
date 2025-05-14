<?php
require_once 'auth.php';
requireAdmin();
require_once '../../backend/controller/UserController.php';
$userController = new UserController(); // Lấy danh sách người dùng

$limit = 8; // Số người dùng trên mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$users = $userController->getAllUsers($limit, $offset);
$totalUsers = $userController->getTotalUsers();
$totalPages = ceil($totalUsers / $limit);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables - SB Admin</title>
    <?php include 'components/common-head.php'; ?>
</head>

<body class="sb-nav-fixed">
    <?php include './components/header.php'; ?>
    <div id="layoutSidenav">
        <?php include './components/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Người dùng</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Người dùng</li>
                    </ol>
                    <div class="row align-items-center mb-3">
                        <!-- Tìm kiếm với nút tích hợp -->
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" id="searchUser" class="form-control" placeholder="Tìm kiếm người dùng...">
                                <button class="btn btn-outline-primary" id="btnSearchUser">Tìm</button>
                            </div>
                        </div>

                        <!-- Nút thêm người dùng -->
                        <div class="col-md-8 text-end">
                            <button class="btn btn-primary" id="btnAddUser" data-bs-toggle="modal" data-bs-target="#staticBackdrop4">
                                Thêm người dùng
                            </button>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Mã khách hàng</th>
                                        <th>Tài khoản</th>
                                        <th>Mật khẩu</th>
                                        <th>Tên khách hàng</th>
                                        <th>Email</th>
                                        <th>Quyền hạn</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo $user['ma_khach_hang']; ?></td>
                                            <td><?php echo $user['username']; ?></td>
                                            <td><?php echo $user['password']; ?></td>
                                            <td><?php echo $user['ten_khach_hang']; ?></td>
                                            <td><?php echo $user['email']; ?></td>
                                            <td><?php echo $user['quyen_han'] == 'admin' ? 'Quản trị viên' : 'Người dùng'; ?></td>
                                            <td><?php echo $user['trang_thai_tai_khoan'] == 1 ? 'Hoạt động' : 'Khóa'; ?>
                                            <td>
                                                <a class="btn btn-success btn-sm btn-view" data-id="<?= $user['ma_khach_hang'] ?>">View</a>
                                                <a class="btn btn-warning btn-sm btn-update" data-id="<?= $user['ma_khach_hang'] ?>">Update</a>
                                                <!-- <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $user['ma_khach_hang'] ?>" data-name="<?= $user['username'] ?>">Delete</a> -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end mb-0">
                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </main>
            <?php include "components/footer.php"; ?>
        </div>
    </div>
    <div class="modal" id="staticBackdrop4" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="name">Tên Khách hàng</label>
                            <input type="text" id="name" class="form-control" />
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="email">Email address</label>
                            <input type="email" id="email" class="form-control" />
                            <div class="invalid-feedback" id="emailError"></div>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="username">UserName</label>
                            <input type="text" id="username" class="form-control" />
                            <div class="invalid-feedback" id="usernameError"></div>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="password">Password</label>
                            <input type="text" id="password" class="form-control" />
                            <div class="invalid-feedback" id="passwordError"></div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="trangthai">Trạng thái</label>
                                    <select id="trangthai" class="form-select">
                                        <option value="1">Hoạt động</option>
                                        <option value="0">Khoá</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="role">Quyền hạn</label>
                                    <select id="quyenhan" class="form-select">
                                        <option value="user">Người dùng</option>
                                        <option value="admin">Quản trị viên</option>
                                    </select>
                                    <div class="invalid-feedback" id="roleError"></div>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <?php include "components/common-scripts.php"; ?>
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

            const userData = {
                name: $('#name').val().trim(),
                email: $('#email').val().trim(),
                username: $('#username').val().trim(),
                password: $('#password').val().trim(),
                status: $('#trangthai').val().trim(),
                quyenhan: $('#quyenhan').val().trim()
            };
            console.log(userData);  
            $('.invalid-feedback').text('');
            $('.form-control').removeClass('is-invalid');

            let isValid = true;
            if (!userData.name) {
                $('#nameError').text('Tên khách hàng không được bỏ trống.');
                $('#name').addClass('is-invalid');
                isValid = false;
            }
            if (!userData.email) {
                $('#emailError').text('Email không được bỏ trống.');
                $('#email').addClass('is-invalid');
                isValid = false;
            }
            if (!userData.username) {
                $('#usernameError').text('Username không được bỏ trống.');
                $('#username').addClass('is-invalid');
                isValid = false;
            }
            if (!userData.password) {
                $('#passwordError').text('Password không được bỏ trống.');
                $('#password').addClass('is-invalid');
                isValid = false;
            }
            if (!isValid) {
                return;
            }
            if (isUpdateMode) {
                $.ajax({
                    url: '../../backend/api/UserAPI.php?action=updateUser',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(userData),
                    success: function(response) {
                        if (response.success) {
                            alert('Người dùng đã được cập nhật thành công!');
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
        $('.btn-update').on('click', function(e) {
            e.preventDefault();
            isUpdateMode = true;
            userIdToUpdate = $(this).data('id');
            console.log(userIdToUpdate);
            loadUserData(userIdToUpdate, true);
        });

        // Khi nhấn nút "Xem"
        $('.btn-view').on('click', function(e) {
            e.preventDefault();
            const userId = $(this).data('id');
            loadUserData(userId, false);
        });

        // Hàm load dữ liệu người dùng
        function loadUserData(userId, isUpdate) {
            $.ajax({
                url: '../../backend/api/UserAPI.php?action=getUserById&id=' + userId,
                method: 'GET',
                dataType: 'json',
                success: function(user) {
                    $('#modalTitle').text(isUpdate ? 'Cập nhật người dùng' : 'Xem thông tin người dùng');
                    resetUserForm();
                    $('#name').val(user.ten_khach_hang);
                    $('#email').val(user.email);
                    $('#username').val(user.username);
                    $('#password').val(user.password);
                    $('#trangthai').val(user.trang_thai_tai_khoan);
                    $('#quyenhan').val(user.quyen_han);

                    if (!isUpdate) {
                        $('#staticBackdrop4 input, #staticBackdrop4 select').prop('disabled', true);
                        $('#saveUserButton').hide();
                    } else {
                        $('#staticBackdrop4 input, #staticBackdrop4 select').prop('disabled', false);
                        $('#username').prop('readonly', true);
                        $('#saveUserButton').show();
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

    $('#staticBackdrop4').on('hidden.bs.modal', function() {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });
</script>


</html>