<?php
session_start();
require_once '../src/conn.php';

if (!isset($_GET['id'])) {
    echo "Produk tidak ditemukan.";
    exit;
}

$id = $_GET['id'];
$selected = null;

$sql = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    $selected = [
        'id' => $row['id'],
        'name' => $row['name'],
        'price' => $row['price'],
        'brand' => $row['brand'],
        'image' => $row['image'],
        'stok' => $row['stok'],
        'detail' => [
            'deskripsi' => $row['deskripsi'],
            'rating' => $row['rating'],
            'warna' => json_decode($row['warna'], true),
            'ukuran' => json_decode($row['ukuran'], true)
        ]
    ];
} else {
    echo "Produk tidak ada.";
    exit;
}

$product_id = $_GET['id'] ?? 0;
$id_pelanggan = $_SESSION['id_pelanggan'] ?? 0;

$check_fav = mysqli_query($conn, "SELECT id FROM favorit WHERE id_pelanggan = '$id_pelanggan' AND products_id = '$product_id'");
$is_favorited = mysqli_num_rows($check_fav) > 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?php echo $selected['name']; ?></title>
    <link rel="stylesheet" href="../public/css/detailproducts.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <div class="product-container">
        <a href="dashboard.php">
            <i class="bx bx-x"></i>
        </a>

        <div class="product-image-section">
            <img src="<?php echo $selected['image']; ?>" alt="<?php echo $selected['name']; ?>" class="product-image">
        </div>

        <div class="product-info-section">
            <h1 class="product-title"><?php echo $selected['name']; ?></h1>
            <p class="product-price">Rp <?php echo number_format($selected['price'], 0, ',', '.'); ?></p>
            <p class="product-brand">Brand: <span><?php echo $selected['brand']; ?></span></p>

            <div class="product-description">
                <h3>Deskripsi</h3>
                <p><?php echo $selected['detail']['deskripsi']; ?></p>
            </div>

            <div class="product-rating">
                <h3>Rating Produk: <span><?php echo $selected['detail']['rating']; ?>/5</span></h3>
            </div>

            <div class="action-buttons">
                <form action="../src/actions/handler_favorit.php" method="POST" style="display: inline;">
                    <input type="hidden" name="product_id" value="<?php echo $selected['id']; ?>">
                    <input type="hidden" name="action" value="<?php echo $is_favorited ? 'remove' : 'add'; ?>">
                    <input type="hidden" name="from_favorit" value="0">

                    <button type="submit" class="btn-favorit <?php echo $is_favorited ? 'favorited' : ''; ?>">
                        <?php if ($is_favorited): ?>
                            <i class="bi bi-heart-fill"></i>
                        <?php else: ?>
                            <i class="bi bi-heart"></i>
                        <?php endif; ?>
                    </button>
                </form>
            </div>

            <form id="product-selection-form" action="../src/actions/handle_cart.php" method="POST" onsubmit="return validateSelection()">
                <input type="hidden" name="product_id" value="<?php echo $selected['id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $selected['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $selected['price']; ?>">
                <input type="hidden" name="product_brand" value="<?php echo $selected['brand']; ?>">
                <input type="hidden" name="warna" id="selectedColor">
                <input type="hidden" name="ukuran" id="selectedSize">

                <div class="option-group">
                    <h3>Pilih Warna:</h3>
                    <div class="color-options">
                        <?php foreach ($selected['detail']['warna'] as $w): ?>
                            <button type="button" class="option-btn color-btn" onclick="selectColor(this, '<?php echo $w; ?>')">
                                <?php echo $w; ?>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <h3>Pilih Ukuran:</h3>
                    <div class="size-options">
                        <?php foreach ($selected['detail']['ukuran'] as $u): ?>
                            <button type="button" class="option-btn size-btn" onclick="selectSize(this, '<?php echo $u; ?>')">
                                <?php echo $u; ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>


                <button type="submit" name="add_to_cart" class="add-cart-btn">
                    🛒 Tambah ke Keranjang
                </button>

            </form>

            <hr>
            <hr>
            
            <h3>Ulasan Produk</h3>

            <?php
            $canReview = false;

            if (isset($_SESSION['fullname'])) {
                // Cek apakah user sudah pernah review produk ini
                $check_already_reviewed = mysqli_query($conn, "
                    SELECT 1 FROM reviews 
                    WHERE id_pelanggan = '{$_SESSION['id_pelanggan']}'
                    AND product_id = '{$selected['id']}'
                    LIMIT 1
                ");
                
                if (mysqli_num_rows($check_already_reviewed) == 0) {
                    // Cek apakah user pernah beli produk SPESIFIK ini dengan JOIN ke order_detail
                    $check_purchase = mysqli_query($conn, "
                        SELECT 1 
                        FROM orders o
                        INNER JOIN order_detail od ON o.id_order = od.id_order
                        WHERE o.nama_pelanggan = '{$_SESSION['fullname']}'
                        AND o.status = 'Berhasil'
                        AND od.id_produk = '{$selected['id']}'
                        LIMIT 1
                    ");
                    
                    if (mysqli_num_rows($check_purchase) > 0) {
                        $canReview = true;
                    }
                }
            }

            if ($canReview):
            ?>
                <form action="../src/actions/handle_review.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $selected['id']; ?>">

                    <label for="review">Tulis ulasan:</label><br>
                    <textarea name="review" rows="3" required></textarea><br>

                    <label for="rating">Rating:</label>
                    <select name="rating" required>
                        <option value="">Pilih rating</option>
                        <option value="5">⭐️⭐️⭐️⭐️⭐️</option>
                        <option value="4">⭐️⭐️⭐️⭐️</option>
                        <option value="3">⭐️⭐️⭐️</option>
                        <option value="2">⭐️⭐️</option>
                        <option value="1">⭐️</option>
                    </select><br><br>

                    <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                </form>
            <?php else: ?>
                <p class="text-muted">
                    Anda harus membeli produk ini sebelum menulis ulasan.
                </p>
            <?php endif; ?>

            <script>
                let selectedColor = null;
                let selectedSize = null;

                function selectColor(button, value) {
                    document.querySelectorAll('.color-btn').forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    selectedColor = value;
                    document.getElementById('selectedColor').value = value;
                }

                function selectSize(button, value) {
                    document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    selectedSize = value;
                    document.getElementById('selectedSize').value = value;
                }

                function validateSelection() {
                    if (!selectedColor || !selectedSize) {
                        alert("Silakan pilih warna dan ukuran terlebih dahulu!");
                        return false;
                    }
                    return true;
                }
            </script>

        </div>
    </div>

    <div class="review-section">
        <h2>Review Pembeli</h2>

        <?php
        // JOIN reviews dengan user untuk ambil nama_pelanggan (fullname)
        $stmt_reviews = $conn->prepare("
            SELECT r.comment, r.rating, r.id_pelanggan, u.fullname
            FROM reviews r
            LEFT JOIN user u ON r.id_pelanggan = u.id_pelanggan
            WHERE r.product_id = ?
            ORDER BY r.created_at DESC
        ");
        $stmt_reviews->bind_param("i", $selected['id']);
        $stmt_reviews->execute();
        $result_reviews = $stmt_reviews->get_result();
        $productReviews = $result_reviews->fetch_all(MYSQLI_ASSOC);

        if (empty($productReviews)): ?>
            <p class="no-review">Belum ada ulasan untuk produk ini.</p>

        <?php else: ?>
            <?php foreach ($productReviews as $r): ?>
                <div class="review-card">
                    <p><strong><?php echo htmlspecialchars($r['fullname'] ?? 'User #' . $r['id_pelanggan']); ?></strong> — ⭐<?php echo (int)$r['rating']; ?>/5</p>
                    <p><?php echo htmlspecialchars($r['comment']); ?></p>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    </div>

</body>

</html>