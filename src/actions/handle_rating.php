<?php
session_start();
include '../src/conn.php';

if (!isset($_SESSION['id_pelanggan'])) {
    header("Location: login.php");
    exit();
}

$id_pelanggan = $_SESSION['id_pelanggan'];
$order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;

// Ambil semua produk di order ini
$stmt = $conn->prepare("
    SELECT od.id_produk
    FROM order_detail od
    JOIN orders o ON od.id_order = o.id_order
    WHERE od.id_order = ? AND o.email = ?
");
$stmt->bind_param("is", $order_id, $_SESSION['email']);
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

foreach ($products as $prod) {
    $prod_id = $prod['id_produk'];
    $rating = (int)($_POST['rating_'.$prod_id] ?? 0);
    $comment = $_POST['comment_'.$prod_id] ?? '';

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

header("Location: riwayat.php");
exit();
