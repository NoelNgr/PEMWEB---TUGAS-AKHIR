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
        $total += $item['price'] * ($item['qty'] ?? 1);
    }

    // Simpan data pesanan
    $order = [
        'nama' => $nama,
        'alamat' => $alamat,
        'nohp' => $nohp,
        'metode' => $metode,
        'cart' => $cart,
        'total' => $total,
        'tanggal' => date('Y-m-d H:i:s')
    ];
    
    $orders = [];
    if (file_exists('orders.json')) {
        $orders = json_decode(file_get_contents('orders.json'), true);
    }
    $orders[] = $order;
    file_put_contents('orders.json', json_encode($orders, JSON_PRETTY_PRINT));

    // Kosongkan keranjang
    unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout Berhasil - KALC3R</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .success-container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }

        .success-icon {
            color: #28a745;
            font-size: 60px;
            margin-bottom: 20px;
        }

        h2 {
            color: #3a3aeb;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .payment-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: left;
        }

        .payment-info p {
            margin: 10px 0;
            line-height: 1.5;
        }

        .payment-code {
            font-size: 20px;
            font-weight: bold;
            color: #3a3aeb;
            padding: 10px;
            background: #e9ecef;
            border-radius: 5px;
            margin: 10px 0;
        }

        .back-button {
            display: inline-block;
            padding: 12px 25px;
            background: #3a3aeb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: background 0.3s;
        }

        .back-button:hover {
            background: #2828d0;
        }

        .alert {
            color: #856404;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            padding: 12px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <i class="fas fa-check-circle success-icon"></i>
        <h2>Checkout Berhasil!</h2>
        
        <div class="payment-info">
            <?php if ($metode === 'qris'): ?>
                <p>Silakan scan QRIS berikut untuk pembayaran:</p>
                <img src="qris-sample.png" alt="QRIS" style="max-width: 200px; margin: 15px 0;">
                <div class="alert">
                    <i class="fas fa-info-circle"></i>
                    Pembayaran akan diverifikasi secara otomatis
                </div>
            <?php elseif ($metode === 'va'): ?>
                <p>Silakan transfer ke Virtual Account berikut:</p>
                <div class="payment-code">1234 5678 9012 3456</div>
                <p><strong>Bank:</strong> Bank Mandiri</p>
                <p><strong>Total Pembayaran:</strong> Rp <?= number_format($total) ?></p>
                <div class="alert">
                    <i class="fas fa-info-circle"></i>
                    Pembayaran akan diverifikasi secara otomatis setelah transfer
                </div>
            <?php endif; ?>
        </div>

        <a href="../DASHBOARD/dashboard.php" class="back-button">
            <i class="fas fa-home"></i> Kembali ke Beranda
        </a>
    </div>
</body>
</html>

<?php
} else {
    header('Location: checkout.php');
    exit();
}
?>