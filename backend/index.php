<?php
// Cho phép frontend truy cập API từ bất kỳ domain nào
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Thông tin kết nối CSDL
$servername = "localhost";
$username = "root";
$password = "";
$database = "webnuochoa";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Số sản phẩm mỗi trang
$limit = 6;

// Lấy trang hiện tại từ request (nếu không có thì mặc định là 1)
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $limit;

// Truy vấn danh sách sản phẩm với phân trang
$sql = "SELECT ma_nuoc_hoa, ten_nuoc_hoa, gia_ban, hinh_1 FROM nuochoa LIMIT $start, $limit";
$result = $conn->query($sql);

// Truy vấn tổng số sản phẩm để tính số trang
$total_sql = "SELECT COUNT(*) AS total FROM nuochoa";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $limit);

$output = '<div class="row">';

// Hiển thị sản phẩm
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Kiểm tra nếu hình ảnh là URL hay chỉ là tên file
        $image_path = $row["hinh_1"];
        if (!filter_var($image_path, FILTER_VALIDATE_URL)) {
            $image_path = "http://localhost/DoAnWeb2/WebBanHang_NuocHoa/backend/images/" . $image_path;
        }

        $output .= '<div class="col-md-4 mb-4 product-card" data-id="' . $row["ma_nuoc_hoa"] . '">
        <div class="card">
            <a href="#" class="product-link" data-id="' . $row["ma_nuoc_hoa"] . '">
                <img src="' . $image_path . '" class="card-img-top" alt="' . $row["ten_nuoc_hoa"] . '">
            </a>
            <div class="card-body">
                <h5 class="card-title"><a href="#" class="product-link" style="color: orange;" data-id="' . $row["ma_nuoc_hoa"] . '">' . $row["ten_nuoc_hoa"] . '</a></h5>
                <p class="card-text">' . number_format($row["gia_ban"], 0, ',', '.') . ' VND</p>
                <a href="#" class="btn btn-primary product-link" data-id="' . $row["ma_nuoc_hoa"] . '">Mua ngay</a>
            </div>
        </div>
    </div>';


    }
} else {
    $output .= "<p>Không có sản phẩm nào.</p>";
}

$output .= '</div>'; // Kết thúc div.row

// Thêm điều hướng phân trang
$output .= '<div class="pagination mt-4 d-flex justify-content-center">';
for ($i = 1; $i <= $total_pages; $i++) {
    $activeClass = ($i == $page) ? 'active' : '';
    $output .= '<a href="#" class="page-link ' . $activeClass . '" data-page="' . $i . '">' . $i . '</a> ';
}
$output .= '</div>';

echo $output;
$conn->close();
?>
