<?php
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
                        <div class="col-md-8 text-end pe-3 ">
                            <button class="btn btn-primary me-6" id="btnAddUser" data-bs-toggle="modal" data-bs-target="#staticBackdrop4">
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
                                        <th>Tên khách hàng</th>
                                        <th>Email</th>
                                        <th>Tài khoản</th>
                                        <th>Mật khẩu</th>
                                        <th>Hành động</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo $user['ma_khach_hang']; ?></td>
                                            <td><?php echo $user['ten_khach_hang']; ?></td>
                                            <td><?php echo $user['email']; ?></td>
                                            <td><?php echo $user['username']; ?></td>
                                            <td><?php echo $user['password']; ?></td>
                                            <td>
                                                <a class="btn btn-success btn-sm btn-view" data-id="<?= $user['ma_khach_hang'] ?>">View</a>
                                                <a class="btn btn-warning btn-sm btn-update" data-id="<?= $user['ma_khach_hang'] ?>">Update</a>

                                                <a class="btn btn-danger btn-sm" href="#">Delete</a>
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
            <? include "components/footer.php"; ?>
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
                    <form>
                        <!-- password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="password1">Tên Khách hàng</label>
                            <input type="text" id="name" class="form-control" />
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="email1">Email address</label>
                            <input type="email" id="email" class="form-control" />
                        </div>

                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="email1">UserName</label>
                            <input type="text" id="username" class="form-control" />
                        </div>
                        <!-- password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="password1">Password</label>
                            <input type="password" id="password" class="form-control" />
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
    </div>
    <?php include "components/common-scripts.php"; ?>
</body>
<script>
    $(document).ready(function() {
        function loadUserData(userId, isUpdate) {
            $.ajax({
                url: '../../backend/api/UserAPI.php?action=getUserById&id=' + userId, // Đường dẫn đến API
                method: 'GET',
                data: {
                    id: userId
                },
                dataType: 'json',
                success: function(user) {
                    console.log("User data:", user);
                    console.log("Avatar path:", user.avatar);
                    $('#name').val(user.ten_khach_hang);
                    $('#email').val(user.email);
                    $('#username').val(user.username);
                    $('#password').val(user.password);

                    $('#staticBackdrop4 input').prop('disabled', !isUpdate);
                    $('#staticBackdrop4 button[type="submit"]').toggle(isUpdate);

                    var modal = new bootstrap.Modal(document.getElementById('staticBackdrop4'));
                    modal.show();
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi khi lấy dữ liệu người dùng:', error);
                    alert('Không thể lấy dữ liệu người dùng. Vui lòng thử lại!');
                }
            });
        }

        // Khi click nút "View"
        $('.btn-view').on('click', function(e) {
            e.preventDefault();
            var userId = $(this).data('id');
            loadUserData(userId, false); // false: xem
        });

        // Khi click nút "Update"
        $('.btn-update').on('click', function(e) {
            e.preventDefault();
            var userId = $(this).data('id');
            loadUserData(userId, true); // true: cập nhật
        });
    });
    // document.getElementById('avatar').addEventListener('change', function(event) {
    //     var file = event.target.files[0];  // Lấy tệp đã chọn
    //     if (file) {
    //         var reader = new FileReader();
    //         reader.onload = function(e) {
    //             // Hiển thị ảnh đã chọn
    //             var imgElement = document.getElementById('avatar-img');
    //             imgElement.src = e.target.result;  // Cập nhật đường dẫn ảnh
    //             document.getElementById('avatar-preview').style.display = 'block';  // Hiển thị ảnh
    //         };
    //         reader.readAsDataURL(file);  // Đọc tệp ảnh dưới dạng URL
    //     }
    // });
</script>

</html>