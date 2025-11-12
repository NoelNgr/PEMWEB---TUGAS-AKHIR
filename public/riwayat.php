<?php
session_start();

// Jika belum login, arahkan ke login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$fullname = $_SESSION['fullname'] ?? 'User';
$email = $_SESSION['email'];
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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan - KALC3R</title>
    <link rel="stylesheet" href="css/riwayat.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<header>
    <div class="header-left">
      <div class="logo">KALC3R</div>
      <nav>
        <a href="dashboard.php">Beranda</a>
        <a href="#">Produk</a>
        <a href="#">Pre-order</a>
        <a href="" class="active">Riwayat Pesanan</a>
      </nav>
    </div>
    <div class="header-right">
      
      <div class="profile">
        <a href="profile.php" style="display:flex;align-items:center;gap:8px;text-decoration:none;color:inherit;">
          <img 
            src="<?php echo htmlspecialchars($fotoProfilPath); ?>" 
            alt="Foto Profil"
            style="width:30px;height:30px;border-radius:50%;object-fit:cover;border:2px solid #3aadeb;">
          <span><?php echo htmlspecialchars($fullname); ?></span>
        </a>
      </div>
      <form action="../src/actions/logout.php" method="POST">
        <button type="submit" class="btn-logout">
          <i class="bi bi-box-arrow-right"></i>
        </button>
      </form>
    </div>
  </header>

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
</main>

</body>
</html>
