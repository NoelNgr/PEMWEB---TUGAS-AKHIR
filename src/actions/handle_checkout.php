<?
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
    $stmt = $conn->prepare("INSERT INTO orders 
        (nama_pelanggan, email, total, status, metode_pembayaran) 
        VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param("ssiss", $nama, $email, $total, $status, $metode);

    if ($stmt->execute()) {

        $_SESSION['last_order'] = [
            'total' => $total,
            'status' => $status,
            'metode' => $metode
        ];

        unset($_SESSION['cart']);
        header("Location: ../../public/checkout_success.php");
        exit();
    } else {
        echo "Gagal menyimpan ke database: " . $conn->error;
    }
}
