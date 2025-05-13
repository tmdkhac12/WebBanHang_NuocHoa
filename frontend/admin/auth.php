<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireAdmin() {
    if (!isset($_SESSION['username'])) {
        header('Location: /frontend/login.php');
        exit();
    }

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: /frontend/no_permission.php');
        exit();
    }
}
