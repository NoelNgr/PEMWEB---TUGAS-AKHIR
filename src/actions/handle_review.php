<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $review = trim($_POST['review']);
    $rating = (int)$_POST['rating'];
    $user = $_SESSION['fullname'] ?? 'Guest';
    $date = date('Y-m-d H:i:s');

    // Path ke file JSON
    $filePath = __DIR__ . '/../data/reviews.json';
    $data = [];

    if (file_exists($filePath)) {
        $data = json_decode(file_get_contents($filePath), true);
    }

    // Simpan review baru
    $data[] = [
        'product_id' => $productId,
        'user' => $user,
        'review' => $review,
        'rating' => $rating,
        'date' => $date
    ];

    file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

    // Kembali ke halaman produk
    header("Location: ../../public/product_detail.php?id=$productId");
    exit;
}
?>
