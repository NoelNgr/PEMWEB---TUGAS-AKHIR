<?php
session_start();

// Jika belum login, arahkan ke login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$fullname = $_SESSION['fullname'] ?? 'User';
$email = $_SESSION['email'];
$cart = $_SESSION['cart'] ?? [];
$fotoProfil = $_SESSION['foto_profil'] ?? 'defaultpicture.jpg';
$fotoProfilPath = 'uploads/' . $fotoProfil;

if (!file_exists($fotoProfilPath) || $fotoProfil == 'defaultpicture.jpg') {
    $fotoProfilPath = 'images/defaultpicture.jpg';
}

// Ambil data pesanan dari JSON
$filePath = __DIR__ . '/../src/data/orders.json';
$orders = [];

if (file_exists($filePath)) {
    $orders = json_decode(file_get_contents($filePath), true) ?? [];
}

// Filter pesanan hanya milik user login
$userOrders = array_filter($orders, fn($order) => $order['nama'] === $fullname);

$search_query = $_GET['query'] ?? '';

// Include database connection jika diperlukan
include '../src/conn.php';


?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan - KALC3R</title>
    <link rel="stylesheet" href="css/riwayat.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <section class="riwayat-section">
            <h2>Riwayat Pesanan Anda</h2>

            <?php if (empty($userOrders)): ?>
                <p>Belum ada pesanan yang diselesaikan.</p>
            <?php else: ?>
                <?php foreach ($userOrders as $order): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <strong>Tanggal:</strong> <?php echo $order['tanggal']; ?> <br>
                            <strong>Metode Pembayaran:</strong> <?php echo strtoupper($order['metode']); ?>
                        </div>

                        <div class="order-items">
                            <?php foreach ($order['cart'] as $item): ?>
                                <div class="item">
                                    <div>
                                        <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
                                        <small><?php echo htmlspecialchars($item['brand']); ?></small><br>
                                        <?php if (isset($item['warna'])): ?>
                                            <small>Warna: <?php echo htmlspecialchars($item['warna']); ?></small><br>
                                        <?php endif; ?>
                                        <?php if (isset($item['ukuran'])): ?>
                                            <small>Ukuran: <?php echo htmlspecialchars($item['ukuran']); ?></small><br>
                                        <?php endif; ?>
                                    </div>
                                    <div class="price">
                                        <?php echo $item['qty']; ?>x - Rp <?php echo number_format($item['price'], 0, ',', '.'); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="order-footer">
                            <form action="product_detail.php" method="GET">
                                <input type="hidden" name="id" value="<?php echo $order['cart'][0]['id'] ?? ''; ?>">
                                <button type="submit" class="btn-review">
                                    <i class="bi bi-star"></i> Beri Review
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </section>
        <div class="offcanvas" id="cartDrawer">
        <div class="offcanvas-header">
            <h5>Keranjang Saya</h5>
            <button type="button" class="btn-close" id="closeCartButton">×</button>
        </div>

        <div class="offcanvas-body">
            <?php if (!empty($cart)): ?>
                <ul class="cart-item-list">
                    <?php
                    $total = 0;
                    foreach ($cart as $index => $item):
                        $subtotal = (int)($item['price'] ?? 0) * (int)($item['qty'] ?? 1);
                        $total += $subtotal;
                    ?>
                        <li class="cart-item">
                            <div class="item-info">
                                <strong><?php echo htmlspecialchars($item['name'] ?? 'Nama Produk'); ?></strong><br>
                                <small>Brand: <?php echo htmlspecialchars($item['brand'] ?? 'Brand'); ?></small><br>

                                <?php if (!empty($item['warna'])): ?>
                                    <small>Warna: <?php echo htmlspecialchars($item['warna']); ?></small><br>
                                <?php endif; ?>

                                <?php if (!empty($item['ukuran'])): ?>
                                    <small>Ukuran: <?php echo htmlspecialchars($item['ukuran']); ?></small><br>
                                <?php endif; ?>

                                <span><?php echo (int)($item['qty'] ?? 1); ?>x - Rp <?php echo number_format((int)($item['price'] ?? 0), 0, ',', '.'); ?></span>
                            </div>

                            <a href="../src/actions/handle_cart.php?remove=<?php echo $index; ?>" class="btn-danger">
                                <i class="bi bi-trash"></i>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="cart-total">
                    <strong>Total</strong>
                    <span>Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                </div>

                <div class="cart-actions">
                    <form action="checkout.php" method="POST">
                        <button type="submit" class="btn-checkout">
                            <i class="bi bi-bag-check"></i> Checkout
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <p>Pilih barang untuk ditambahkan ke keranjang!</p>
                <div class="cart-actions">
                    <button class="btn-empty" disabled>
                        <i class="bi bi-bag-x"></i> Checkout
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="js/dashboard.js"></script>
    </main>
    <?php include 'footer.php'; ?>
</body>

</html>