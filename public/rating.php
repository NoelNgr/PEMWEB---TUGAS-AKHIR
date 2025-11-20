<?php
session_start();
include '../src/conn.php';

// Pastikan login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

// Ambil semua produk di order ini
$stmt = $conn->prepare("
    SELECT od.id_produk, p.name AS nama_produk, od.brand, od.warna, od.ukuran
    FROM order_detail od
    JOIN products p ON od.id_produk = p.id
    JOIN orders o ON od.id_order = o.id_order
    WHERE od.id_order = ? AND o.email = ?
");
$stmt->bind_param("is", $order_id, $email);
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Berikan Review - KALC3R</title>
<link rel="stylesheet" href="css/rating.css">
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/footer.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php include 'header.php'; ?>

<main>
<section class="riwayat-section">
    <h2>Berikan Review untuk Pesanan #<?= htmlspecialchars($order_id) ?></h2>

    <?php if (empty($products)): ?>
        <p>Produk tidak ditemukan untuk order ini.</p>
    <?php else: ?>
    <form method="POST" action="handle_rating.php">
        <input type="hidden" name="order_id" value="<?= $order_id ?>">

        <?php foreach ($products as $prod): ?>
        <div class="order-card product-review">
            <div class="order-header">
                <strong><?= htmlspecialchars($prod['nama_produk']) ?></strong><br>
                <?php if(!empty($prod['brand'])): ?>
                    <small>Brand: <?= htmlspecialchars($prod['brand']) ?></small><br>
                <?php endif; ?>
                <?php if(!empty($prod['warna'])): ?>
                    <small>Warna: <?= htmlspecialchars($prod['warna']) ?></small><br>
                <?php endif; ?>
                <?php if(!empty($prod['ukuran'])): ?>
                    <small>Ukuran: <?= htmlspecialchars($prod['ukuran']) ?></small><br>
                <?php endif; ?>
            </div>

            <div class="stars">
                <?php for($i=5;$i>=1;$i--): ?>
                    <input type="radio" name="rating_<?= $prod['id_produk'] ?>" id="star<?= $i ?>_<?= $prod['id_produk'] ?>" value="<?= $i ?>">
                    <label for="star<?= $i ?>_<?= $prod['id_produk'] ?>">&#9733;</label>
                <?php endfor; ?>
            </div>

            <textarea name="comment_<?= $prod['id_produk'] ?>" placeholder="Tulis komentar..."></textarea>
        </div>
        <?php endforeach; ?>

        <button type="submit" class="btn-review">Kirim Review</button>
    </form>
    <?php endif; ?>
</section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
