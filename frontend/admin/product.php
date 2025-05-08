<?php
require_once '../../backend/controller/ProductController.php';

$productController = new ProductController();

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$products = $productController->getAllProducts($limit, $offset);
$totalProducts = $productController->getTotalProducts();
$totalPages = ceil($totalProducts / $limit);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <?php include "./components/common-head.php"; ?>
</head>

<body class="sb-nav-fixed">
    <?php include "./components/header.php"; ?>
    <div id="layoutSidenav">
        <?php include "./components/sidebar.php"; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Product</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Mã sản phẩm</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá bán</th>
                                        <th>Tên thương hiệu</th>
                                        <th>Hành động</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($products)): ?>
                                        <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td><?php echo $product['ma_nuoc_hoa']; ?></td>
                                                <td><?php echo $product['ten_nuoc_hoa']; ?></td>
                                                <td><?php echo $product['gia_ban']; ?></td>
                                                <td><?php echo $product['ten_thuong_hieu']; ?></td>
                                                <td>
                                                    <a class="btn btn-success btn-sm btn-view" data-id="<?= $product['ma_nuoc_hoa'] ?>">View</a>
                                                    <a class="btn btn-warning btn-sm btn-update" data-id="<?= $product['ma_nuoc_hoa'] ?>">Update</a>
                                                    <a class="btn btn-danger btn-sm btn-delete"  data-id="<?= $product['ma_nuoc_hoa'] ?>">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4">Không có sản phẩm nào.</td>
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
            <?php include "./components/footer.php"; ?>
        </div>
    </div>
    <div class="modal" id="staticBackdrop4" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <!-- password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="password1">Tên sản phẩm</label>
                            <input type="text" id="name" class="form-control" />
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="email1">Tên thương hiệu</label>
                            <input type="text" id="thuonghieu" class="form-control" />
                        </div>

                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="description">Mô tả</label>
                            <textarea id="description" class="form-control" rows="4" style="resize: vertical;"></textarea>
                        </div>


                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="email1">Giá bán</label>
                            <input type="text" id="username" class="form-control" />
                        </div>
                        <!-- password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="password1">Password</label>
                            <input type="password" id="password" class="form-control" />
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
    <?php include "./components/common-scripts.php"; ?>
</body>
<script>
    $(document).ready(function() {
        function loadProductData(productId, isUpdate) {
            $.ajax({
                url: '../../backend/api/ProductAPI.php?action=getProductByID&id=' + productId, 
                method: 'GET',
                dataType: 'json',
                success: function(product) {
                    console.log("Product data:", product);
                    console.log("Product image path:", product.hinh_anh);
                    $('#name').val(product.ten_nuoc_hoa);
                    $('#email').val(product.gia_ban); 
                    $('#thuonghieu').val(product.ten_thuong_hieu); 
                    $('#description').val(product.mo_ta); 
                    if (product.hinh_anh) {
                        $('#avatar-img').attr('src', '../images/' + product.hinh_anh).show();
                        $('#avatar-preview').show(); // Hiển thị thẻ div chứa ảnh
                    } else {
                        $('#avatar-preview').attr('src', '../images/'+product.hinh_anh).show(); // Hình ảnh mặc định
                    }
                    $('#staticBackdrop4 input').prop('disabled', !isUpdate);
                    $('#staticBackdrop4 button[type="submit"]').toggle(isUpdate);

                    var modal = new bootstrap.Modal(document.getElementById('staticBackdrop4'));
                    modal.show();
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi khi lấy dữ liệu sản phẩm:', error);
                    alert('Không thể lấy dữ liệu sản phẩm. Vui lòng thử lại!');
                }
            });
        }

        $('.btn-view').on('click', function(e) {
            e.preventDefault();
            var productId = $(this).data('id');
            loadProductData(productId, false); // false: chỉ xem
        });

        $('.btn-update').on('click', function(e) {
            e.preventDefault();
            var productId = $(this).data('id');
            loadProductData(productId, true); // true: cập nhật
        });
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            var productId = $(this).data('id');

            if (confirm('Are you sure you want to delete this product?')) {
                $.ajax({
                    url: '../../backend/api/ProductAPI.php?action=deleteProduct&id=' + productId,
                    method: 'DELETE',
                    success: function(response) {
                        alert('Product deleted successfully!');
                        location.reload(); 
                    },
                    error: function(xhr, status, error) {
                        console.error('Delete error:', error);
                        alert('Failed to delete product. Please try again.');
                    }
                });
            }
        });
    });

    document.getElementById('avatar').addEventListener('change', function(event) {
        var file = event.target.files[0]; // Lấy tệp đã chọn
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Hiển thị ảnh đã chọn
                var imgElement = document.getElementById('avatar-img');
                imgElement.src = e.target.result; // Cập nhật đường dẫn ảnh
                document.getElementById('avatar-preview').style.display = 'block'; // Hiển thị ảnh
            };
            reader.readAsDataURL(file); // Đọc tệp ảnh dưới dạng URL
        }
    });
</script>

</html>