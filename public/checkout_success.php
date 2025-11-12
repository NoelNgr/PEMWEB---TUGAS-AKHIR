<?php
session_start();

$lastOrder = $_SESSION['last_order'] ?? null;

if (!$lastOrder) {
    header('Location: dashboard.php');
    exit();
}

$metode = $lastOrder['metode'];
$total = $lastOrder['total'];

unset($_SESSION['last_order']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout Berhasil - KALC3R</title>
    <link rel="stylesheet" href="css/checkout_success.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="success-container">
        <i class="fas fa-check-circle success-icon"></i>
        <h2>Checkout Berhasil!</h2>
        
        <div class="payment-info">
            <?php if ($metode === 'qris'): ?>
                <p>Silakan scan QRIS berikut untuk pembayaran:</p>
                <img src="images/qris-sample.png" alt="QRIS" style="max-width: 200px; margin: 15px 0;">
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

        <a href="dashboard.php" class="back-button">
            <i class="fas fa-home"></i> Kembali ke Beranda
        </a>
    </div>
</body>
</html>