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
                                                        <a class="btn btn-success btn-sm" href="#">View</a>
                                                        <a class="btn btn-warning btn-sm btn-update" data-id="<?= $user['ma_khach_hang'] ?>">Update</a>
                                                        <a class="btn btn-danger btn-sm" href="#">Delete</a>
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
        <?php include "./components/common-scripts.php"; ?>
    </body>
</html>