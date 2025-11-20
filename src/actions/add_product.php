<?php
session_start();
require_once __DIR__ . '/../conn.php';

// Middleware admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../public/unauthorized.php");
    exit();
}

// Ambil input
$name       = trim($_POST['name'] ?? '');
$price      = (int) ($_POST['price'] ?? 0);
$brand      = trim($_POST['brand'] ?? '');
$deskripsi  = trim($_POST['deskripsi'] ?? '');
$stok       = (int) ($_POST['stok'] ?? 0);
$rating     = trim($_POST['rating'] ?? '');

$warnaText  = trim($_POST['warna'] ?? '');
$ukuranText = trim($_POST['ukuran'] ?? '');

// Validasi dasar
if ($name === '' || $price <= 0) {
    echo "<script>alert('Nama dan harga produk wajib diisi.'); window.history.back();</script>";
    exit();
}

// Pecah berdasarkan koma → array
$warnaArr = $warnaText !== '' ? array_map('trim', explode(',', $warnaText)) : [];
$ukuranArr = $ukuranText !== '' ? array_map('intval', explode(',', $ukuranText)) : [];

// Convert ke JSON
$warnaJSON  = json_encode($warnaArr, JSON_UNESCAPED_UNICODE);
$ukuranJSON = json_encode($ukuranArr, JSON_UNESCAPED_UNICODE);


$uploadDir = __DIR__ . '/../../public/uploads/';
$filename = null;

if (!empty($_FILES['image']['name'])) {

    $file = $_FILES['image'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    $allowed = ['jpg','jpeg','png','webp'];

    if (!in_array($ext, $allowed)) {
        echo "<script>alert('Format gambar tidak didukung.'); window.history.back();</script>";
        exit();
    }

    $filename = uniqid("prod_", true) . "." . $ext;

    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
        echo "<script>alert('Upload gambar gagal!'); window.history.back();</script>";
        exit();
    }
}

$stmt = $conn->prepare("INSERT INTO products 
    (name, price, brand, image, deskripsi, warna, ukuran, rating, stok) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

$stmt->bind_param(
    "sisssssdi",
    $name,
    $price,
    $brand,
    $filename,
    $deskripsi,
    $warnaJSON,
    $ukuranJSON,
    $rating,
    $stok
);

if ($stmt->execute()) {
    header("Location: ../../public/admin/products.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
