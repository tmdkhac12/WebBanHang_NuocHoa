<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Đọc dữ liệu JSON từ JavaScript
$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

// Kết nối DB (giả sử bạn đã có đoạn này)
require_once 'config.php';

// Truy vấn user
$stmt = $conn->prepare("SELECT * FROM khach_hang WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['mat_khau'])) {
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['quyen_han'];

    // Trả JSON về cho JavaScript
    echo json_encode([
        'success' => true,
        'redirect' => ($user['quyen_han'] === 'admin') ? '/frontend/admin/index.php' : '/frontend/user.php'
    ]);
    exit();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Sai tên đăng nhập hoặc mật khẩu!'
    ]);
    exit();
}
