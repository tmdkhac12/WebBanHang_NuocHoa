<?php
// Nếu chưa có session thì khởi động
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Đường dẫn tuyệt đối đến thư mục gốc của project (WebBanHang_NuocHoa)
define('ROOT_PATH', realpath(__DIR__ . '/../../'));

// Đường dẫn URL gốc (ví dụ: http://webbanhang_nuochoa.test/)
define("BASE_URL", "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . "/");
?>
