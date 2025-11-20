<?php
session_start();
require_once __DIR__ . '/../conn.php';

// middleware admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../public/unauthorized.php");
    exit();
}

$id         = $_POST['id'];
$name       = trim($_POST['name']);
$price      = (int) $_POST['price'];
$brand      = trim($_POST['brand']);
$stok       = (int) $_POST['stok'];
$deskripsi  = trim($_POST['deskripsi']);
$rating     = trim($_POST['rating']);

$warnaArr  = array_map('trim', explode(',', $_POST['warna']));
$ukuranArr = array_map('intval', explode(',', $_POST['ukuran']));

$warnaJSON  = json_encode($warnaArr, JSON_UNESCAPED_UNICODE);
$ukuranJSON = json_encode($ukuranArr, JSON_UNESCAPED_UNICODE);

// Ambil gambar lama
$resultOld = mysqli_query($conn, "SELECT image FROM products WHERE id=$id");
$old = mysqli_fetch_assoc($resultOld);
$oldImage = $old['image'];

// Upload gambar baru jika ada
$filename = $oldImage;

if (!empty($_FILES['image']['name'])) {
    $file = $_FILES['image'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, ['jpg','jpeg','png','webp'])) {
        echo "<script>alert('Format gambar tidak valid'); window.history.back();</script>";
        exit;
    }

    $filename = uniqid("prod_", true) . "." . $ext;
    move_uploaded_file($file['tmp_name'], __DIR__ . '/../../public/uploads/' . $filename);

    // Hapus file lama
    if ($oldImage && file_exists(__DIR__ . '/../../public/uploads/' . $oldImage)) {
        unlink(__DIR__ . '/../../public/uploads/' . $oldImage);
    }
}

// Update DB
$stmt = $conn->prepare("
    UPDATE products 
    SET name=?, price=?, brand=?, image=?, deskripsi=?, warna=?, ukuran=?, rating=?, stok=?
    WHERE id=?
");

$stmt->bind_param(
    "sisssssdii",
    $name,
    $price,
    $brand,
    $filename,
    $deskripsi,
    $warnaJSON,
    $ukuranJSON,
    $rating,
    $stok,
    $id
);

if ($stmt->execute()) {
    header("Location: ../../public/admin/products.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
