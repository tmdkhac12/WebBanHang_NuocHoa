<?php
require_once '../../backend/controller/UserController.php';
$userController = new UserController();
$users = $userController->getAllUsers(); // Lấy danh sách người dùng
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
                    <h1 class="mt-4">User</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">User</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Tên khách hàng</th>
                                        <th>Email</th>
                                        <th>User name</th>
                                        <th>Password</th>
                                        <th>Hành Động</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo $user['ten_khach_hang']; ?></td>
                                            <td><?php echo $user['email']; ?></td>
                                            <td><?php echo $user['username']; ?></td>
                                            <td><?php echo $user['password']; ?></td>
                                            <td>
                                                <a class="btn btn-success btn-sm" href="#">View</a>
                                                <a class="btn btn-warning btn-sm btn-update" data-id="<?= $user['ma_khach_hang'] ?>">Update</a>
                                                <a class="btn btn-danger btn-sm" href="#">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
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
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <!-- password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="password1">Tên Khách hàng</label>
                            <input type="password" id="password1" class="form-control" />
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="email1">Email address</label>
                            <input type="email" id="email1" class="form-control" />
                        </div>

                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="email1">UserName</label>
                            <input type="email" id="email1" class="form-control" />
                        </div>
                        <!-- password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="password1">Password</label>
                            <input type="password" id="password1" class="form-control" />
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="avatar">Avatar</label>
                            <input type="file" id="avatar" class="form-control" accept="image/*" />
                        </div>

                        <div id="avatar-preview" class="mb-4" style="display: none;">
                        <img id="avatar-img" src="" alt="Avatar Preview" style="width: 200px; height: 200px;" />
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
        // Khi nhấn vào nút "Update"
        $('.btn-update').on('click', function(e) {
            e.preventDefault(); // Ngăn chuyển trang

            // Lấy ID người dùng từ thuộc tính data-id của nút
            var userId = $(this).data('id');
            console.log("User ID: " + userId);
            var modal = new bootstrap.Modal(document.getElementById('staticBackdrop4'));
            modal.show();
        });
    });

    document.getElementById('avatar').addEventListener('change', function(event) {
        var file = event.target.files[0];  // Lấy tệp đã chọn
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Hiển thị ảnh đã chọn
                var imgElement = document.getElementById('avatar-img');
                imgElement.src = e.target.result;  // Cập nhật đường dẫn ảnh
                document.getElementById('avatar-preview').style.display = 'block';  // Hiển thị ảnh
            };
            reader.readAsDataURL(file);  // Đọc tệp ảnh dưới dạng URL
        }
    });
</script>

</html>