<?php
session_start();

// Inisialisasi cart kalau belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $product = [
        'name' => $_POST['product_name'],
        'price' => $_POST['product_price'],
        'brand' => $_POST['product_brand'],
        'qty' => 1
    ];

    // Cek apakah produk sudah ada
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['name'] === $product['name']) {
            $item['qty']++;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $_SESSION['cart'][] = $product;
    }
}

// Hapus item dari keranjang
if (isset($_GET['remove'])) {
    $removeIndex = (int) $_GET['remove'];
    if (isset($_SESSION['cart'][$removeIndex])) {
        unset($_SESSION['cart'][$removeIndex]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // rapikan index
    }
}

// Redirect balik ke dashboard
header("Location: dashboard.php");
exit();
