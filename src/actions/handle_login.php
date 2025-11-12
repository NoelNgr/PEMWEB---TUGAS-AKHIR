<?php
session_start();
include '../conn.php';

$email = $_POST['email'];
$password = $_POST['password'];

if (!$email || !$password) {
    echo "<script>alert('Email dan password harus diisi'); window.location.href='../../public/login.php';</script>";
    exit();
} 

// Kueri asli Anda (rentan SQL Injection)
$query = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    
    // Set session
    $_SESSION['email'] = $row['email'];
    $_SESSION['fullname'] = $row['fullname'];
    $_SESSION['status'] = "login";
    
    // Simpan data user lengkap ke session
    $_SESSION['user'] = [
        'fullname' => $row['fullname'],
        'email' => $row['email'],
        'whatsapp' => $row['whatsapp'] ?? ''
    ];
    
    // Simpan foto profil ke session jika ada
    if (!empty($row['foto_profil'])) {
         $_SESSION['foto_profil'] = $row['foto_profil'];
    }
    
    echo "<script>alert('Login berhasil!'); window.location='../../public/dashboard.php';</script>";
} else {
    echo "<script>alert('Email atau password salah!'); window.location='../../public/login.php';</script>";
}

mysqli_close($conn);
?>