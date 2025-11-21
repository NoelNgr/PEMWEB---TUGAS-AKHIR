<?php
session_start();
include '../src/conn.php';

// Pastikan user login
if (!isset($_SESSION['email']) || !isset($_SESSION['id_pelanggan'])) {
    header("Location: login.php");
    exit();
}

$id_pelanggan = $_SESSION['id_pelanggan'];
$email = $_SESSION['email'];
$fullname = $_SESSION['fullname'] ?? 'User';
$cart = $_SESSION['cart'] ?? [];

$fotoProfil = $_SESSION['foto_profil'] ?? 'defaultpicture.jpg';
$path = "uploads/" . $fotoProfil;
$fotoProfilPath = file_exists($path) ? $path : "images/defaultpicture.jpg";

// =========================
// HANDLE POST REVIEW
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;

    // Ambil semua produk di order ini milik user
    $stmt = $conn->prepare("
        SELECT od.id_produk
        FROM order_detail od
        JOIN orders o ON od.id_order = o.id_order
        WHERE od.id_order = ? AND o.email = ?
    ");
    $stmt->bind_param("is", $order_id, $email);
    $stmt->execute();
    $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    foreach ($products as $prod) {
        $prod_id = $prod['id_produk'];
        $rating = (int)($_POST['rating_'.$prod_id] ?? 0);
        $comment = trim($_POST['comment_'.$prod_id] ?? '');

        if ($rating > 0) {
            // Insert atau update review
            $stmt_insert = $conn->prepare("
                INSERT INTO reviews (product_id, id_pelanggan, rating, comment)
                VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE rating=?, comment=?
            ");
            $stmt_insert->bind_param("iiisis", $prod_id, $id_pelanggan, $rating, $comment, $rating, $comment);
            $stmt_insert->execute();

            // Update rata-rata rating di tabel products
            $stmt_avg = $conn->prepare("SELECT AVG(rating) AS avg_rating FROM reviews WHERE product_id=?");
            $stmt_avg->bind_param("i", $prod_id);
            $stmt_avg->execute();
            $avg_row = $stmt_avg->get_result()->fetch_assoc();
            $avg_rating = round($avg_row['avg_rating'],1);

            $stmt_update = $conn->prepare("UPDATE products SET rating=? WHERE id=?");
            $stmt_update->bind_param("di", $avg_rating, $prod_id);
            $stmt_update->execute();
        }
    }

    // Setelah submit, redirect ke riwayat.php
    header("Location: riwayat.php");
    exit();
}

// =========================
// AMBIL DATA PRODUK UNTUK FORM
// =========================
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

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
                <form method="POST" action="">
                    <input type="hidden" name="order_id" value="<?= $order_id ?>">

                    <?php foreach ($products as $prod): ?>
                        <div class="order-card product-review">
                            <div class="order-header">
                                <strong><?= htmlspecialchars($prod['nama_produk']) ?></strong><br>
                                <?php if (!empty($prod['brand'])): ?>
                                    <small>Brand: <?= htmlspecialchars($prod['brand']) ?></small><br>
                                <?php endif; ?>
                                <?php if (!empty($prod['warna'])): ?>
                                    <small>Warna: <?= htmlspecialchars($prod['warna']) ?></small><br>
                                <?php endif; ?>
                                <?php if (!empty($prod['ukuran'])): ?>
                                    <small>Ukuran: <?= htmlspecialchars($prod['ukuran']) ?></small><br>
                                <?php endif; ?>
                            </div>

                            <div class="stars">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio"
                                        name="rating_<?= $prod['id_produk'] ?>"
                                        id="star<?= $i ?>_<?= $prod['id_produk'] ?>"
                                        value="<?= $i ?>">
                                    <label for="star<?= $i ?>_<?= $prod['id_produk'] ?>">★</label>
                                <?php endfor; ?>
                            </div>

                            <textarea name="comment_<?= $prod['id_produk'] ?>" placeholder="Tulis komentar..."></textarea>
                        </div>
                    <?php endforeach; ?>

                    <button type="submit" class="btn-review">Kirim Review</button>
                </form>
            <?php endif; ?>
        </section>
        
        <script src="js/dashboard.js"></script>
    </main>
    <?php include 'footer.php'; ?>
</body>

</html>
