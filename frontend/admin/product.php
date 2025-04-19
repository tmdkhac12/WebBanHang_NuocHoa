<!DOCTYPE html>
<html lang="en">
    <head>  
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Tables - SB Admin</title>
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
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td><?php echo $product['name']; ?></td>
                                                <td><?php echo $product['position']; ?></td>
                                                <td><?php echo $product['office']; ?></td>
                                                <td><?php echo $product['age']; ?></td>
                                                <td><?php echo $product['start_date']; ?></td>
                                                <td><?php echo $product['salary']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include "./components/footer.php"; ?>
            </div>
        </div>
        <?php include "./components/common-scripts.php"; ?>
    </body>
</html>
