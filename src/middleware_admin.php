<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['email'])) {
    header("Location: ../../public/login.php");
    exit();
}

// Cek apakah role user adalah admin
if ($_SESSION['role'] !== 'admin') {
    // Kalau bukan admin, lempar ke halaman lain
    header("Location: ../../public/unauthorized.php");
    exit();
}
