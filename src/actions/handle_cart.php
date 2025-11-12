<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $id = $_POST['product_id'] ?? '';
    $name = $_POST['product_name'] ?? '';
    $price = (int) ($_POST['product_price'] ?? 0);
    $brand = $_POST['product_brand'] ?? '';
    $warna = $_POST['warna'] ?? '';
    $ukuran = $_POST['ukuran'] ?? '';
    $qty = 1;

    // Gabungkan produk yang sama + warna + ukuran
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['name'] === $name && $item['warna'] === $warna && $item['ukuran'] === $ukuran) {
            $item['qty']++;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'brand' => $brand,
            'warna' => $warna,
            'ukuran' => $ukuran,
            'qty' => $qty
        ];
    }
}

if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

header("Location: ../../public/dashboard.php");
exit();
