<?php
session_start();
include '../conn.php';


$email = $_POST['email'];
$password = $_POST['password'];

if (!$email || !$password) {
    echo "<script>alert('Email dan password harus diisi'); window.location.href='login.php';</script>";
    exit();
} 

$query = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $_SESSION['email'] = $email;
    $_SESSION['status'] = "login";
    setcookie('user', $email, time() + 3600, '/');
    echo "<script>alert('Login berhasil!'); window.location='../DASHBOARD/dashboard.php';</script>";
} else {
     echo "<script>alert('Email atau password tidak ditemukan'); window.location='login.php';</script>";
}
