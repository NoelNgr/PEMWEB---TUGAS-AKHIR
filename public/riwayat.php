<?php
include '../src/conn.php';
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

/* ============================
   AMBIL SEMUA ORDER MILIK USER
   ============================ */
$stmt = $conn->prepare("
    SELECT id_order, total, metode_pembayaran, tanggal, status
    FROM orders
    WHERE email = ?
    ORDER BY tanggal DESC
");
$stmt->bind_param("s", $email);
$stmt->execute();
$resOrders = $stmt->get_result();

$orders = [];
while ($row = $resOrders->fetch_assoc()) {
    $orders[] = $row;
}

/* =======================================
   AMBIL DETAIL PRODUK UNTUK SETIAP ORDER
   ======================================= */
$orderDetails = []; // id_order → list of products

if (!empty($orders)) {
    $orderIds = array_column($orders, 'id_order');
    $placeholders = implode(",", array_fill(0, count($orderIds), "?"));

    $types = str_repeat("i", count($orderIds));

    $sql = "
        SELECT id_order, id_produk, nama_produk, brand, warna, ukuran, qty, harga, subtotal
        FROM order_detail
        WHERE id_order IN ($placeholders)
    ";

    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param($types, ...$orderIds);
    $stmt2->execute();
    $resDetail = $stmt2->get_result();

    while ($row = $resDetail->fetch_assoc()) {
        $orderDetails[$row['id_order']][] = $row;
    }
}

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

            <?php if (empty($orders)): ?>
                <p>Belum ada pesanan yang diselesaikan.</p>
            <?php else: ?>

                <?php foreach ($orders as $order): ?>
                    <div class="order-card">

                        <div class="order-header">
                            <strong>ID Order:</strong> #<?= $order['id_order'] ?> <br>
                            <strong>Tanggal:</strong> <?= $order['tanggal'] ?> <br>
                            <strong>Metode:</strong> <?= strtoupper($order['metode_pembayaran']) ?> <br>
                            <strong>Status:</strong> <?= $order['status'] ?> <br>
                            <strong>Total:</strong> Rp <?= number_format($order['total'], 0, ',', '.') ?>
                        </div>

                        <div class="order-items">
                            <?php if (isset($orderDetails[$order['id_order']])): ?>
                                <?php foreach ($orderDetails[$order['id_order']] as $item): ?>
                                    <div class="item">
                                        <div>
                                            <strong><?= htmlspecialchars($item['nama_produk']) ?></strong><br>
                                            <small>Brand: <?= htmlspecialchars($item['brand']) ?></small><br>

                                            <?php if (!empty($item['warna'])): ?>
                                                <small>Warna: <?= htmlspecialchars($item['warna']) ?></small><br>
                                            <?php endif; ?>

                                            <?php if (!empty($item['ukuran'])): ?>
                                                <small>Ukuran: <?= htmlspecialchars($item['ukuran']) ?></small><br>
                                            <?php endif; ?>
                                        </div>

                                        <div class="price">
                                            <?= $item['qty'] ?>x - Rp <?= number_format($item['harga'], 0, ',', '.') ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Tidak ada detail produk.</p>
                            <?php endif; ?>
                        </div>

                        <div class="order-footer">
                            <?php
                            // Jika status order "Berhasil" atau "Selesai", tombol review aktif
                            if (strtolower($order['status']) === 'berhasil' || strtolower($order['status']) === 'selesai'):
                            ?>
                                <a href="rating.php?order_id=<?= $order['id_order'] ?>" class="btn-review">
                                    <i class="bi bi-star"></i> Beri Rating
                                </a>
                            <?php else: ?>
                                <button class="btn-review" disabled>
                                    <i class="bi bi-star"></i> Review belum tersedia
                                </button>
                            <?php endif; ?>
                        </div>


                    </div>
                <?php endforeach; ?>

            <?php endif; ?>
        </section>

        <script src="js/dashboard.js"></script>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>