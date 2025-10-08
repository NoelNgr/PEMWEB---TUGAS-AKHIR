<?php
session_start();

$fullname = $_POST['fullname'] ?? '';
$email = $_POST['email'] ?? '';
$whatsapp = $_POST['whatsapp'] ?? '';
$password = $_POST['password'] ?? '';

if ($fullname === '' || $email === '') {
    echo "<script>alert('Nama dan email wajib diisi!'); window.history.back();</script>";
    exit();
}

// untuk update session user
$_SESSION['user']['fullname'] = $fullname;
$_SESSION['user']['email'] = $email;
$_SESSION['user']['whatsapp'] = $whatsapp;

if ($password !== '') {
    $_SESSION['user']['password'] = $password;
}
// untuk update cookie
setcookie('fullname', $fullname, time() + 3600, '/');
setcookie('user', $email, time() + 3600, '/');
setcookie('whatsapp', $whatsapp, time() + 3600, '/');

echo "<script>alert('Profil berhasil diperbarui!'); window.location.href='dashboard.php';</script>";
exit();
?>