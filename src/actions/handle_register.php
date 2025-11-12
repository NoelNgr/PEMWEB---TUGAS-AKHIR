<?php
session_start();
include '../conn.php';

$fullname = trim($_POST['fullname']);
$email = trim($_POST['email']);
$whatsapp = trim($_POST['whatsapp']);
$password = trim($_POST['password']);

if (empty($fullname) || empty($email) || empty($whatsapp) || empty($password)) {
       echo "<script>alert('Form tidak boleh kosong!'); window.history.back();</script>";
       exit();
}

// 1. Cek Duplikat (rentan SQL Injection)
$cekDuplikat = "SELECT * FROM user WHERE email='$email'";
$result = mysqli_query($conn, $cekDuplikat);

if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('email sudah ada, gunakan email lainnya'); window.location='../../public/register.php';</script>";
    exit();
}

// 2. Insert User Baru (rentan SQL Injection)
$query = "INSERT INTO user (fullname, email, whatsapp, password) VALUES ('$fullname', '$email', '$whatsapp', '$password')";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Registrasi berhasil, silakan login.'); window.location.href='../../public/login.php';</script>";
    
    // Set session dan cookie setelah berhasil
    $_SESSION['user'] = [
        'fullname' => $fullname,
        'email' => $email,
        'whatsapp' => $whatsapp
    ];
    setcookie('user', $email, time() + 3600, '/');
    setcookie('fullname', $fullname, time() + 3600, '/');
    setcookie('whatsapp', $whatsapp, time() + 3600, '/');
    
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>