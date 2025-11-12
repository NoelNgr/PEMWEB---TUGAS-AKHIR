<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $nohp = $_POST['nohp'] ?? '';
    $metode = $_POST['metode'] ?? '';
    $cart = $_SESSION['cart'] ?? [];
    $total = 0;
    
    foreach ($cart as $item) {
        $total += (int)$item['price'] * (int)($item['qty'] ?? 1);
    }

    $order = [
        'nama' => $nama,
        'alamat' => $alamat,
        'nohp' => $nohp,
        'metode' => $metode,
        'cart' => $cart,
        'total' => $total,
        'tanggal' => date('Y-m-d H:i:s')
    ];
    
    $ordersFile = '../data/orders.json';
    $orders = [];
    if (file_exists($ordersFile)) {
        $ordersData = file_get_contents($ordersFile);
        if ($ordersData) {
             $orders = json_decode($ordersData, true);
        }
    }
    
    // Tambah pesanan baru
    $orders[] = $order;
    
    // Tulis kembali ke file dengan format yang rapi
    $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES;
    if (file_put_contents($ordersFile, json_encode($orders, $options))) {
        // Simpan info untuk halaman sukses
        $_SESSION['last_order'] = [
            'total' => $total,
            'metode' => $metode
        ];

        unset($_SESSION['cart']);
        header('Location: ../../public/checkout_success.php');
        exit();
    } else {
        echo "<script>alert('Gagal menyimpan pesanan. Silakan coba lagi.'); window.history.back();</script>";
    }

} else {
    header('Location: ../../public/checkout.php');
    exit();
}
?>