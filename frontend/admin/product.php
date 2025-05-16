<?php
require_once 'auth.php';
requireAdmin();
require_once '../../backend/controller/ProductController.php';

$productController = new ProductController();

$limit = 8;
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
    <style>
        .select2-container--default .select2-dropdown {
            z-index: 9999 !important; 
        }
    </style>
    
    
</head>

<body class="sb-nav-fixed">
    <?php include "./components/header.php"; ?>
    <div id="layoutSidenav">
        <?php include "./components/sidebar.php"; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Sản phẩm</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Sản phẩm</li>
                    </ol>
                    <div class="row align-items-center mb-3">
                        <!-- Tìm kiếm với nút tích hợp -->
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" id="searchUser" class="form-control" placeholder="Tìm kiếm sản phẩm...">
                                <button class="btn btn-outline-primary" id="btnSearchUser">Tìm</button>
                            </div>
                        </div>

                        <!-- Nút thêm người dùng -->
                        <div class="col-md-8 text-end pe-5 ">
                            <button class="btn btn-primary me-6" id="btnAddUser" data-bs-toggle="modal" data-bs-target="#staticBackdrop4">
                                Thêm sản phẩm
                            </button>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-bordered">
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
                                               <td>
                                                    <?php 
                                                        echo isset($product['gia_ban']) 
                                                            ? number_format($product['gia_ban'], 0, ',', '.') . ' VND' 
                                                            : '0 VND'; 
                                                    ?>
                                                </td>
                                                <td><?php echo $product['ten_thuong_hieu']; ?></td>
                                                <td>
                                                    <a class="btn btn-success btn-sm btn-view" data-id="<?= $product['ma_nuoc_hoa'] ?>">View</a>
                                                    <a class="btn btn-warning btn-sm btn-update" data-id="<?= $product['ma_nuoc_hoa'] ?>">Update</a>
                                                    <a class="btn btn-danger btn-sm btn-delete" data-id="<?= $product['ma_nuoc_hoa'] ?>">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5">Không có sản phẩm nào.</td>
                                        </tr>
                                    <?php endif; ?>
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


            <?php include "./components/footer.php"; ?>
        </div>
    </div>
    <div class="modal" id="staticBackdrop4" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modal-title">Thông tin sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm" enctype="multipart/form-data">
                        <input type="hidden" id="productId" name="productId" />
                        <input type="hidden" id="formMode" value="add">

                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="password1">Tên sản phẩm</label>
                            <input type="text" id="name" class="form-control" />
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="brand">Tên thương hiệu</label>
                            <select id="thuonghieu" class="form-select">
                                <option value="">-- Chọn thương hiệu --</option>
                            </select>
                        </div>

                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="description">Mô tả</label>
                            <textarea id="description" class="form-control" rows="4" style="resize: vertical;"></textarea>
                        </div>


                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="email1">Giá bán</label>
                            <input type="text" id="price" class="form-control" />
                        </div>


                        <div class="row">
                            <div class="col-6">
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="nongdo">Nồng độ</label>
                                    <select id="nongdo" class="form-select">
                                       
                                    </select>

                                </div>
                            </div>

                            <div class="col-6">
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="gioitinh">Giới tính</label>
                                    <select id="gioitinh" class="form-select">
                                        <option value="Nam">Nam</option>
                                        <option value="Nữ">Nữ</option>
                                        <option value="Unisex">Unisex</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div data-mdb-input-init class="form-outline mb-4">
                            <label for="huongdau" class="form-label">Hương đầu</label>
                            <select id="huongdau" name="states[]" multiple="multiple" style="width: 100%;">
                                
                            </select>
                        </div>

                        <div data-mdb-input-init class="form-outline mb-4">
                            <label for="huonggiua" class="form-label">Hương giua</label>
                            <select id="huonggiua" name="abc" multiple="multiple" style="width: 100%;">
                                
                            </select>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label for="huongcuoi" class="form-label">Hương cuoi</label>
                            <select id="huongcuoi" name="bdas" multiple="multiple" style="width: 100%;">
                                
                            </select>
                        </div>

                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="avatar">Ảnh sản phẩm</label>
                            <input type="file" id="avatar" class="form-control" accept="image/*" />
                            <input type="hidden" id="existingImage" name="existingImage" />
                        </div>

                        <div id="avatar-preview" class="mb-4" style="display: none;">
                            <img id="avatar-img" src="" alt="Avatar Preview" style="width: 200px; height: 200px;" />
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">Save changes</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include "./components/common-scripts.php"; ?>
</body>
<script>
    $('.dataTables_info').remove();

    $(document).ready(function() {
        
        function loadProductData(productId, isUpdate) {
            
            $.ajax({
                url: '../../backend/api/ProductAPI.php?action=getProductByID&id=' + productId,
                method: 'GET',
                dataType: 'json',
                success: function(product) {

                    console.log("Product data:", product);
                    console.log("Product image path:", product.hinh_anh);
                    console.log("Initializing Select2...");
                    const nongDoId = product.nong_do?.[0]?.id;
                    $('#formMode').val('update'); 
                    $('.js-example-basic-multiple').select2();
                    populateBrands(product.ten_thuong_hieu);
                    populateNongDo(nongDoId);
                    $('#name').val(product.ten_nuoc_hoa);

                    $('#price').val(product.gia_ban);
                    $('#description').val(product.mo_ta);
                    $('#existingImage').val(product.hinh_anh);
                    $('#productId').val(product.ma_nuoc_hoa);
                    

                    $('#huongdau').empty().trigger('change');
                    $('#huonggiua').empty().trigger('change');
                    $('#huongcuoi').empty().trigger('change');

                    
                    $('#huongdau, #huonggiua, #huongcuoi').select2();
                    const notHuong = product.nothuong || [];

                    const huongDauItems = notHuong.filter(n => n.loai === 'Hương đầu');
                    const huongDauIds = huongDauItems.map(n => n.id);


                    const huongGiuaItems = notHuong.filter(n => n.loai === 'Hương giữa');
                    const huongGiuaIds = huongGiuaItems.map(n => n.id);

                 

                    const huongCuoiItems = notHuong.filter(n => n.loai === 'Hương cuối');
                    const huongCuoiIds = huongCuoiItems.map(n => n.id);

                    

                    
                    $('#huongdau').val(huongDauIds).trigger('change');
                    $('#huonggiua').val(huongGiuaIds).trigger('change');
                    $('#huongcuoi').val(huongCuoiIds).trigger('change');;
                    populateNotHuongOptions({
                        huongDau: huongDauIds,
                        huongGiua: huongGiuaIds,
                        huongCuoi: huongCuoiIds
                    });
                    $('#nongdo').val((product.nong_do));
                    $('#gioitinh').val((product.gioi_tinh));

                    if (product.hinh_anh) {
                        $('#avatar-img').attr('src', '../images/' + product.hinh_anh).show();
                        $('#avatar-preview').show(); // Hiển thị thẻ div chứa ảnh
                    } else {
                        $('#avatar-preview').attr('src', '../images/' + product.hinh_anh).show(); // Hình ảnh mặc định
                    }
                    $('#staticBackdrop4 input, #staticBackdrop4 textarea, #staticBackdrop4 select').prop('disabled', !isUpdate);

                    $('#avatar').closest('.form-outline').toggle(isUpdate);

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

        $(document).on('click', '.btn-view', function(e) {
            e.preventDefault();
            var productId = $(this).data('id');
            loadProductData(productId, false); // false: chỉ xem
        });

        $(document).on('click', '.btn-update', function(e) {
            e.preventDefault();
            var productId = $(this).data('id');
            loadProductData(productId, true); // true: cập nhật
        });

        $(document).on('click', '.btn-delete', function(e) {
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
        $('#productForm').on('submit', function(e) {
            e.preventDefault();
            const mode = $('#formMode').val(); 
            const isUpdate = mode === 'update';

            var name = $('#name').val();
            var brand = $('#thuonghieu').val();
            var description = $('#description').val();
            var price = $('#price').val();
            var imageFile = $('#avatar')[0].files[0];
            var productId = $('#productId').val();
            var gioitinh = $('#gioitinh').val();
            var nongdo = $('#nongdo').val();
            var existingImage = $('#existingImage').val();
            var formData = new FormData();
            if (imageFile) {
                formData.append('newImage', imageFile);
                console.log('New image file:', imageFile);
            } else {
                formData.append('existingImage', existingImage );
                console.log('Existing image path:', existingImage);
            } 

            formData.append('productId', productId);
            formData.append('name', name);
            formData.append('brand', brand);
            formData.append('description', description);
            formData.append('price', price);
            formData.append('gioitinh' , gioitinh);
            formData.append('nongdo', nongdo);
            

            
            var huongDau = $('#huongdau').val() || [];
            var huongGiua = $('#huonggiua').val() || [];
            var huongCuoi = $('#huongcuoi').val() || [];

            let index = 0;

            huongDau.forEach(function(ma_not_huong) {
                formData.append(`notes[${index}][ma_not_huong]`, ma_not_huong);
                formData.append(`notes[${index}][loai]`, 'Hương đầu');
                index++;
            });

            huongGiua.forEach(function(ma_not_huong) {
                formData.append(`notes[${index}][ma_not_huong]`, ma_not_huong);
                formData.append(`notes[${index}][loai]`, 'Hương giữa');
                index++;
            });

            huongCuoi.forEach(function(ma_not_huong) {
                formData.append(`notes[${index}][ma_not_huong]`, ma_not_huong);
                formData.append(`notes[${index}][loai]`, 'Hương cuối');
                index++;
            });

           
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            $.ajax({
                 url: isUpdate ? '../../backend/api/ProductAPI.php?action=updateProduct' 
                                : '../../backend/api/ProductAPI.php?action=createProduct',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    alert('Product updated!');
                    location.reload();
                },
                error: function(error) {
                    console.error('Error updating:', error);
                    alert('Failed to update product.');
                    console.log('Error details:', error);
                }
            });
        });



        $('#btnAddUser').on('click', function () {
            $('#productForm input, #productForm select, #productForm textarea').prop('disabled', false);

            $('#formMode').val('add'); 
            $('#productId').val(''); // clear productId
            $('#name').val('');
            $('#price').val('');
            $('#description').val('');
            $('#avatar').val('');
            $('#existingImage').val('');
            $('#avatar-img').hide();
            $('#thuonghieu').empty();
            $('#gioitinh').val('');
            $('#nongdo').val('');
            $('#huongdau, #huonggiua, #huongcuoi').select2();


            
            $('#huongdau').val(null).trigger('change');
            $('#huonggiua').val(null).trigger('change');
            $('#huongcuoi').val(null).trigger('change');

          
            populateBrands();
            populateNongDo();
            populateNotHuongOptions();

             $('#avatar').closest('.form-outline').toggle(true);

            $('#staticBackdrop4 button[type="submit"]').toggle(true);

            $('.js-example-basic-multiple').select2();

             $('#modal-title').text('Thêm sản phẩm');
            $('#submitBtn').text('Thêm');
            

        });
    });

    function populateBrands(selectedBrandName = null) {
        $.ajax({
            url: '../../backend/api/ThuongHieuAPI.php?action=getAllBrands',
            method: 'GET',
            dataType: 'json',
            success: function(brands) {
                const $select = $('#thuonghieu');
                  $select.empty();

                brands.forEach(brand => {
                    const selected = selectedBrandName == brand.ten_thuong_hieu ? 'selected' : '';
                    $select.append(`<option value="${brand.ma_thuong_hieu}" ${selected}>${brand.ten_thuong_hieu}</option>`);
                });
            },
            error: function() {
                alert('Không thể tải danh sách thương hiệu.');
            }
        });
    }
    function populateNongDo(selectedNongDoID = null) {
        $.ajax({
            url: '../../backend/api/NongDoAPI.php?action=getAllNongDo',
            method: 'GET',
            dataType: 'json',
            success: function(nongdos) {
                const $select = $('#nongdo');
                  $select.empty();

                nongdos.forEach(nongdo => {
                    const selected = selectedNongDoID == nongdo.ma_nong_do ? 'selected' : '';
                    $select.append(`<option value="${nongdo.ma_nong_do}" ${selected}>${nongdo.nong_do}</option>`);
                });
            },
            error: function() {
                alert('Không thể tải danh sách nong do.');
            }
        });
    }
    function populateNotHuongOptions(selectedHuongIds = {}) {
    $.ajax({
        url: '../../backend/api/NotHuongAPI.php?action=getAllNotHuong',
        method: 'GET',
        dataType: 'json',
        success: function(nothuongs) {
            console.log("NotHuong data:", nothuongs);

            nothuongs.forEach(note => {
                const option1 = new Option(note.not_huong, note.ma_not_huong, false, false);
                const option2 = new Option(note.not_huong, note.ma_not_huong, false, false);
                const option3 = new Option(note.not_huong, note.ma_not_huong, false, false);
                
                $('#huongdau').append(option1);
                $('#huonggiua').append(option2);
                $('#huongcuoi').append(option3);
            });

        
            if (selectedHuongIds.huongDau) {
                $('#huongdau').val(selectedHuongIds.huongDau).trigger('change');
            }
            if (selectedHuongIds.huongGiua) {
                $('#huonggiua').val(selectedHuongIds.huongGiua).trigger('change');
            }
            if (selectedHuongIds.huongCuoi) {
                $('#huongcuoi').val(selectedHuongIds.huongCuoi).trigger('change');
            }
        },
        error: function() {
            alert('Không thể tải danh sách nốt hương.');
        }
    });
}


    //tim kiem phan trang
    function loadProducts(keyword = '', page = 1) {
        $.ajax({
            url: '../../backend/api/ProductAPI.php?action=searchProducts',
            method: 'GET',
            data: {
                keyword: keyword,
                page: page,
                limit: 8
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    renderProductTable(response.products);
                    renderPagination(response.total, page, keyword);
                }
            }
        });
    }

    $('#btnSearchUser').on('click', function() {
        const keyword = $('#searchUser').val().trim();
        loadProducts(keyword, 1);
    });

    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        const keyword = $('#searchUser').val().trim();
        loadProducts(keyword, page);
    });

    function renderProductTable(products) {
        let html = '';
        if (products.length === 0) {
            html = '<tr><td colspan="5">Không có sản phẩm nào.</td></tr>';
        } else {
            products.forEach(product => {
                html += `<tr>
                    <td>${product.ma_nuoc_hoa}</td>
                    <td>${product.ten_nuoc_hoa}</td>
                    <td>${product.gia_ban ? Number(product.gia_ban).toLocaleString('vi-VN') + ' VND' : '0 VND'}</td>
                    <td>${product.ten_thuong_hieu || ''}</td>
                    <td>
                        <a class="btn btn-success btn-sm btn-view" data-id="${product.ma_nuoc_hoa}">View</a>
                        <a class="btn btn-warning btn-sm btn-update" data-id="${product.ma_nuoc_hoa}">Update</a>
                        <a class="btn btn-danger btn-sm btn-delete" data-id="${product.ma_nuoc_hoa}">Delete</a>
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
    $(document).ready(function() {

        // Gọi hàm này để khi vừa load trang sẽ hiển thị danh sách đơn hàng và phân trang mặc định
        loadProducts('', 1);
    });
    $('.dataTables_info').remove();
</script>

</html>