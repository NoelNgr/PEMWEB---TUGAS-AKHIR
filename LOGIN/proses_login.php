<?php
session_start();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// cookies
if ($email === 'user@gmail.com' && $password === '111111') {
    $_SESSION['user'] = $email;
    setcookie('user', $email, time() + 3600, '/');
    header('Location:../DASHBOARD/dashboard.php');
    exit();
} else {
    echo "<script>alert('Email atau password salah'); window.location.href='login.php';</script>";
}