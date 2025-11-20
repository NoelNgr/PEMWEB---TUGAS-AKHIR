<?php
session_start();
include '../conn.php';

$fullname  = trim($_POST['fullname']);
$email     = trim($_POST['email']);
$whatsapp  = trim($_POST['whatsapp']);
$password  = trim($_POST['password']);

if (empty($fullname) || empty($email) || empty($whatsapp) || empty($password)) {
    echo "<script>alert('Form tidak boleh kosong!'); window.history.back();</script>";
    exit();
}

// ---- Check duplicate email dengan prepared statement
$cek = $conn->prepare("SELECT id_pelanggan FROM user WHERE email = ?");
$cek->bind_param("s", $email);
$cek->execute();
$hasil = $cek->get_result();

if ($hasil->num_rows > 0) {
    echo "<script>alert('Email sudah digunakan, gunakan email lain.'); window.location='../../public/register.php';</script>";
    exit();
}

// ---- Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// ---- Insert user baru
// Pastikan tabel user sudah punya kolom 'role'
$insert = $conn->prepare("INSERT INTO user (fullname, email, whatsapp, password, role) VALUES (?, ?, ?, ?, 'user')");
$insert->bind_param("ssss", $fullname, $email, $whatsapp, $hashedPassword);

if ($insert->execute()) {
    echo "<script>alert('Registrasi berhasil, silakan login.'); window.location='../../public/login.php';</script>";
} else {
    echo "<script>alert('Gagal melakukan registrasi!');</script>";
}

$insert->close();
$cek->close();
$conn->close();
?>
