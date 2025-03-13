<?php
// Cấu hình CORS cho phép truy cập từ mọi domain
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Kết nối CSDL
$servername = "localhost";
$username = "root";
$password = "";
$database = "webnuochoa";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die(json_encode(["error" => "Kết nối thất bại: " . $conn->connect_error]));
}

// Định nghĩa số sản phẩm mỗi trang
$limit = 9;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);
$start_page = ($page - 1) * $limit;

// Lấy danh sách sản phẩm bằng Prepared Statement
$sql = "SELECT ma_nuoc_hoa, ten_nuoc_hoa, gia_ban, hinh_1 FROM nuochoa LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $start_page, $limit);
$stmt->execute();
$result = $stmt->get_result();

// Lấy tổng số sản phẩm để tính phân trang
$total_sql = "SELECT COUNT(*) AS total FROM nuochoa";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $limit);

$output = '<div class="row">';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $image_path = filter_var($row["hinh_1"], FILTER_VALIDATE_URL) ? $row["hinh_1"] : 
                      "http://localhost/DoAnWeb2/WebBanHang_NuocHoa/backend/images/" . $row["hinh_1"];

        $output .= '<div class="col-md-4 mb-4 product-card" data-id="' . htmlspecialchars($row["ma_nuoc_hoa"]) . '">
            <div class="card">
                <a href="#" class="product-link" data-id="' . htmlspecialchars($row["ma_nuoc_hoa"]) . '">
                    <img src="' . htmlspecialchars($image_path) . '" class="card-img-top" alt="' . htmlspecialchars($row["ten_nuoc_hoa"]) . '">
                </a>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="#" class="product-link text-warning" data-id="' . htmlspecialchars($row["ma_nuoc_hoa"]) . '">' . 
                        htmlspecialchars($row["ten_nuoc_hoa"]) . '</a>
                    </h5>
                    <p class="card-text">' . number_format($row["gia_ban"], 0, ',', '.') . ' VND</p>
                    <a href="#" class="btn btn-primary product-link" data-id="' . htmlspecialchars($row["ma_nuoc_hoa"]) . '">Mua ngay</a>
                </div>
            </div>
        </div>';
    }
} else {
    $output .= "<p class='text-center w-100'>Không có sản phẩm nào.</p>";
}

$output .= '</div>'; // Kết thúc div.row

// --------- 🔹 CẬP NHẬT ĐOẠN CODE PHÂN TRANG (Fix lỗi $end_page) --------- //
$visible_pages = 5; // Số trang hiển thị tối đa
$half_visible = floor($visible_pages / 2);

$start_page = max(1, $page - $half_visible);
$end_page = min($total_pages, $page + $half_visible);

// Điều chỉnh lại để đảm bảo hiển thị đủ số trang mong muốn
if ($end_page - $start_page + 1 < $visible_pages) {
    if ($start_page == 1) {
        $end_page = min($total_pages, $visible_pages);
    } else {
        $start_page = max(1, $end_page - $visible_pages + 1);
    }
}

// Tạo pagination
$output .= '<div class="pagination mt-4 d-flex justify-content-center">';

if ($page > 1) {
    $output .= '<a href="#" class="page-link" data-page="' . ($page - 1) . '">«</a> ';
}

// Luôn hiển thị trang đầu tiên nếu cần
if ($start_page > 1) {
    $output .= '<a href="#" class="page-link" data-page="1">1</a> ';
    if ($start_page > 2) {
        $output .= '<span class="dots">...</span> ';
    }
}

// Hiển thị các trang ở giữa
for ($i = $start_page; $i <= $end_page; $i++) {
    $activeClass = ($i == $page) ? 'active' : '';
    $output .= '<a href="#" class="page-link ' . $activeClass . '" data-page="' . $i . '">' . $i . '</a> ';
}

// Luôn hiển thị trang cuối cùng nếu cần
if ($end_page < $total_pages) {
    if ($end_page < $total_pages - 1) {
        $output .= '<span class="dots">...</span> ';
    }
    $output .= '<a href="#" class="page-link" data-page="' . $total_pages . '">' . $total_pages . '</a> ';
}

if ($page < $total_pages) {
    $output .= '<a href="#" class="page-link" data-page="' . ($page + 1) . '">»</a>';
}

$output .= '</div>'; // Kết thúc phân trang

echo $output;

// Đóng kết nối
$stmt->close();
$conn->close();
?>
