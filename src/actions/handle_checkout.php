<?php
session_start();
include '../../src/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama   = $_POST['nama'] ?? '';
    $email  = $_SESSION['email'];     // ambil dari session login
    $metode = $_POST['metode'] ?? '';

    $cart = $_SESSION['cart'] ?? [];
    $total = 0;

    foreach ($cart as $item) {
        $qty = isset($item['qty']) ? (int)$item['qty'] : 1;
        $total += ((int)$item['price']) * $qty;
    }

    $status = "Berhasil";

    // Query baru sesuai tabel terbaru
    $stmt = $conn->prepare(
        "INSERT INTO orders 
        (nama_pelanggan, email, total, status, metode_pembayaran) 
        VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param("ssiss", $nama, $email, $total, $status, $metode);

    if ($stmt->execute()) {

        //ini
    // Ambil id order terbaru
    $idOrder = $conn->insert_id;

    // Loop setiap item di cart dan simpan ke order_detail
    foreach ($cart as $item) {

        $id_produk   = $item['id'] ?? $item['id_produk'] ?? 0;
        $nama_produk = mysqli_real_escape_string($conn, $item['name'] ?? $item['nama'] ?? '');
        $brand       = mysqli_real_escape_string($conn, $item['brand'] ?? '');
        $warna       = mysqli_real_escape_string($conn, $item['warna'] ?? '');
        $ukuran      = mysqli_real_escape_string($conn, $item['ukuran'] ?? '');
        $qty         = (int)($item['qty'] ?? 1);
        $harga       = (int)($item['price'] ?? 0);
        $subtotal    = $qty * $harga;

        $sqlDetail = "
            INSERT INTO order_detail 
            (id_order, id_produk, nama_produk, brand, warna, ukuran, qty, harga, subtotal)
            VALUES 
            ('$idOrder', '$id_produk', '$nama_produk', '$brand', '$warna', '$ukuran', '$qty', '$harga', '$subtotal')
        ";

        $conn->query($sqlDetail);
    }

    // Simpan data order terakhir
    $_SESSION['last_order'] = [
        'total' => $total,
        'status' => $status,
        'metode' => $metode
    ];

    unset($_SESSION['cart']);
    header("Location: ../../public/checkout_success.php");
    exit();
}

}
