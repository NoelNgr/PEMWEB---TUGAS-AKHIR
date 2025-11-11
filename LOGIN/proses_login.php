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
    $row = mysqli_fetch_assoc($result);
    $_SESSION['email'] = $row['email'];       // tetap simpan email
    $_SESSION['fullname'] = $row['fullname']; // tambahkan fullname
    $_SESSION['status'] = "login";
    
    echo "<script>alert('Login berhasil!'); window.location='../DASHBOARD/dashboard.php';</script>";
} else {
    echo "<script>alert('Email atau password salah!'); window.location='login.php';</script>";
}
