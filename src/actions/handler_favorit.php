<?php
session_start();
include '../../src/conn.php'; 

if (!isset($_SESSION['email']) || !isset($_SESSION['id_pelanggan'])) {
    echo "<script>alert('Anda harus login untuk melakukan aksi ini.'); window.location.href = '../../login.php';</script>";
    exit();
}

// Terima dari POST atau GET
$action = $_POST['action'] ?? $_GET['action'] ?? '';
$product_id_raw = $_POST['product_id'] ?? $_GET['product_id'] ?? '';
$from_favorit = $_POST['from_favorit'] ?? $_GET['from_favorit'] ?? '0';

// Validasi
if (empty($product_id_raw)) {
    echo "<script>alert('Product ID tidak ditemukan!'); window.history.back();</script>";
    exit();
}

$safe_product_id = (int)$product_id_raw;
$safe_id_pelanggan = (int)$_SESSION['id_pelanggan'];

// Redirect URL
$final_redirect_url = ($from_favorit == '1') 
    ? "../../public/favorit.php" 
    : "../../public/product_detail.php?id=$safe_product_id";

if ($safe_product_id === 0) {
    echo "<script>alert('Produk ID tidak valid!'); window.location.href = '../../dashboard.php';</script>";
    exit();
}

if ($action === 'add') {
    
    $check_query = "SELECT id FROM favorit 
                    WHERE id_pelanggan = '$safe_id_pelanggan' 
                    AND products_id = '$safe_product_id'";
    
    $check_result = mysqli_query($conn, $check_query); 
    
    if (mysqli_num_rows($check_result) == 0) {
        
        $insert_query = "INSERT INTO favorit (id_pelanggan, products_id) 
                         VALUES ('$safe_id_pelanggan', '$safe_product_id')";
        
        if (mysqli_query($conn, $insert_query)) { 
            echo "<script>alert('Produk berhasil ditambahkan ke favorit.'); window.location.href = '$final_redirect_url';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan produk.'); window.location.href = '$final_redirect_url';</script>";
        }
    } else {
        echo "<script>alert('Produk sudah ada di favorit.'); window.location.href = '$final_redirect_url';</script>";
    }
    
} elseif ($action === 'remove') {
    
    $delete_query = "DELETE FROM favorit 
                     WHERE products_id = '$safe_product_id' 
                     AND id_pelanggan = '$safe_id_pelanggan'
                     LIMIT 1";
    
    if (mysqli_query($conn, $delete_query)) {
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>alert('Produk berhasil dihapus dari favorit.'); window.location.href = '$final_redirect_url';</script>";
        } else {
            echo "<script>alert('Produk tidak ditemukan di favorit.'); window.location.href = '$final_redirect_url';</script>";
        }
    } else {
        echo "<script>alert('Gagal menghapus produk.'); window.location.href = '$final_redirect_url';</script>";
    }
    
} else {
    echo "<script>alert('Action tidak valid!'); window.location.href = '../../dashboard.php';</script>";
}

mysqli_close($conn);
exit();
?>