<?php
// src/actions/delete_product.php
session_start();
require_once __DIR__ . '/../conn.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../public/unauthorized.php");
    exit();
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: ../../public/admin/products.php");
    exit();
}

// ambil gambar lalu hapus record
$res = $conn->prepare("SELECT image FROM products WHERE id = ?");
$res->bind_param("i", $id);
$res->execute();
$r = $res->get_result()->fetch_assoc();
$res->close();

$del = $conn->prepare("DELETE FROM products WHERE id = ?");
$del->bind_param("i", $id);
if ($del->execute()) {
    $uploadDir = __DIR__ . '/../../public/uploads/';
    if (!empty($r['gambar']) && file_exists($uploadDir . $r['image'])) {
        @unlink($uploadDir . $r['gambar']);
    }
    header("Location: ../../public/admin/products.php");
    exit();
} else {
    echo "Error: " . $del->error;
}
$del->close();
$conn->close();
