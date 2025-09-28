<?php
session_start();

// Cek apakah keranjang kosong
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Keranjang belanja kosong!'); window.location.href='../DASHBOARD/dashboard.php';</script>";
    exit();
}

$cart = $_SESSION['cart'];
$total = 0;
foreach ($cart as $item) {
    // Ubah sesuai struktur dari cart.php
    $total += $item['price'] * ($item['qty'] ?? 1);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="checkout-container">
            <!-- Left Column -->
            <div class="checkout-left">
                <h2><i class="fas fa-shopping-cart"></i> Checkout</h2>
                
                <div class="checkout-section">
                    <h3><i class="fas fa-map-marker-alt"></i> Alamat Pengiriman</h3>
                    <form id="checkoutForm" action="proses_checkout.php" method="post">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>No. HP</label>
                            <input type="text" name="nohp" required>
                        </div>
                    
                        <div class="payment-section">
                            <h3><i class="fas fa-credit-card"></i> Metode Pembayaran</h3>
                            <div class="payment-options">
                                <div class="payment-option">
                                    <input type="radio" name="metode" value="qris" id="qris" required>
                                    <label for="qris">
                                        <img src="https://imgv2-1-f.scribdassets.com/img/document/631692560/original/fc380cd3ee/1693096410?v=1" alt="QRIS">
                                        <span>QRIS</span>
                                    </label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" name="metode" value="va" id="va" required>
                                    <label for="va">
                                        <img src="https://4.bp.blogspot.com/-ft6zklEvSuU/UN1whi41o2I/AAAAAAAAEiQ/5biCC0QgUKE/s1600/Logo+Bank+Mandiri.jpg" alt="Virtual Account">
                                        <span>Virtual Account</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column -->
            <div class="checkout-right">
                <div class="order-summary">
                    <h3>Ringkasan Pesanan</h3>
                    <div class="order-items">
                        <?php foreach ($cart as $item): ?>
                        <div class="order-item">
                            <div class="item-details">
                                <span class="item-name"><?= htmlspecialchars($item['name']) ?></span>
                                <span class="item-qty"><?= $item['qty'] ?? 1 ?> x</span>
                            </div>
                            <span class="item-price">Rp <?= number_format($item['price']) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="order-total">
                        <div class="total-row">
                            <span>Total Harga</span>
                            <span>Rp <?= number_format($total) ?></span>
                        </div>
                    </div>
                    
                    <button type="submit" form="checkoutForm" class="checkout-button">
                        Bayar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>