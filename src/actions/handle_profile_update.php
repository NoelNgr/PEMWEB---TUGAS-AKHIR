<?php
session_start();
include '../conn.php';

if (!isset($_SESSION['email'])) {
    echo "<script>alert('Anda harus login!'); window.location.href='../../public/login.php';</script>";
    exit();
}

// Ambil email lama dari session sebagai KUNCI
$old_email = $_SESSION['email'];

// Ambil data form
$fullname = trim($_POST['fullname']);
$email = trim($_POST['email']);
$whatsapp = trim($_POST['whatsapp']);
$password = trim($_POST['password']); // Hanya diisi jika ingin diubah

if (empty($fullname) || empty($email)) {
    echo "<script>alert('Nama dan email wajib diisi!'); window.history.back();</script>";
    exit();
}

// Siapkan query (rentan SQL Injection, sesuai permintaan)
$query = "";
if (!empty($password)) {
    // Jika password diisi, update semua termasuk password
    $query = "UPDATE user SET fullname='$fullname', email='$email', whatsapp='$whatsapp', password='$password' WHERE email='$old_email'";
} else {
    // Jika password kosong, jangan update password
    $query = "UPDATE user SET fullname='$fullname', email='$email', whatsapp='$whatsapp' WHERE email='$old_email'";
}

// Eksekusi update
if (mysqli_query($conn, $query)) {
    // Update session dengan data baru
    $_SESSION['user']['fullname'] = $fullname;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['whatsapp'] = $whatsapp;

    // Update session terpisah juga (untuk dashboard dan key)
    $_SESSION['fullname'] = $fullname;
    $_SESSION['email'] = $email;

    // Update cookie
    setcookie('fullname', $fullname, time() + 3600, '/');
    setcookie('user', $email, time() + 3600, '/');
    setcookie('whatsapp', $whatsapp, time() + 3600, '/');

    echo "<script>alert('Profil berhasil diperbarui!'); window.location.href='../../public/dashboard.php';</script>";
} else {
     echo "<script>alert('Gagal memperbarui profil. Error: " . mysqli_error($conn) . "'); window.history.back();</script>";
}

mysqli_close($conn);
?>