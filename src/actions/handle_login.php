<?php
session_start();
include '../conn.php';

$email = $_POST['email'];
$password = $_POST['password'];

if (!$email || !$password) {
    echo "<script>alert('Email dan password harus diisi'); window.location.href='../../public/login.php';</script>";
    exit();
}

// Gunakan Prepared Statement agar aman
$stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah user ditemukan
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    // Verifikasi password (pastikan saat register pakai password_hash)
    if (password_verify($password, $row['password'])) {

        // Simpan session
        $_SESSION['id_pelanggan'] = $row['id_pelanggan'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['status'] = "login";

        if (!empty($row['foto_profil'])) {
            $_SESSION['foto_profil'] = $row['foto_profil'];
        }

        setcookie('user', $row['email'], time() + 3600, '/');
        setcookie('fullname', $row['fullname'], time() + 3600, '/');

        // Redirect berdasarkan role
        if ($row['role'] === 'admin') {
            echo "<script>alert('Login sebagai Admin'); window.location='../../public/admin/index.php';</script>";
        } else {
            echo "<script>alert('Login berhasil!'); window.location='../../public/dashboard.php';</script>";
        }

    } else {
        echo "<script>alert('Password salah!'); window.location='../../public/login.php';</script>";
    }
} else {
    echo "<script>alert('Email tidak ditemukan!'); window.location='../../public/login.php';</script>";
}

$stmt->close();
$conn->close();
?>
