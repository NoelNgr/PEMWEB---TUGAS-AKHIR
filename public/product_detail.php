<?php
session_start();
// --- PERUBAHAN DIMULAI DI SINI ---
require_once '../src/conn.php'; // Pakai koneksi DB

if (!isset($_GET['id'])) {
    echo "Produk tidak ditemukan.";
    exit;
}

$id = $_GET['id']; // Ambil ID dari URL
$selected = null;

// Ambil 1 produk dari DB berdasarkan ID
// (Mengikuti style kode Anda yang rentan SQL Injection, sesuai file login/register)
$sql = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    // REKONSTRUKSI ARRAY $selected agar sama persis seperti struktur lama
    // Ini adalah kunci agar sisa file HTML tidak perlu diubah
    $selected = [
        'id' => $row['id'],
        'name' => $row['name'],
        'price' => $row['price'],
        'brand' => $row['brand'],
        'image' => $row['image'],
        'detail' => [
            'deskripsi' => $row['deskripsi'],
            'rating' => $row['rating'],
            // Ubah string JSON dari DB kembali menjadi array PHP
            'warna' => json_decode($row['warna'], true),
            'ukuran' => json_decode($row['ukuran'], true)
        ]
    ];
    
} else {
    echo "Produk tidak ada.";
    exit;
}
// --- PERUBAHAN SELESAI DI SINI ---
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $selected['name']; ?></title>
    <link rel="stylesheet" href="../public/css/detailproducts.css">
</head>
<body>

<div class="product-container">

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

        <form action="../src/actions/handle_cart.php" method="POST" onsubmit="return validateSelection()">
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
    $ordersFile = __DIR__ . '/../src/data/orders.json';
    if (file_exists($ordersFile)) {
        $orders = json_decode(file_get_contents($ordersFile), true);
        foreach ($orders as $order) {
            if ($order['nama'] == $_SESSION['fullname']) {
                foreach ($order['cart'] as $c) {
                    if ($c['name'] == $selected['name']) {
                        $canReview = true;
                        break 2;
                    }
                }
            }
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
    // Path ke file JSON
    $reviewsFile = __DIR__ . '/../src/data/reviews.json';
    $productReviews = [];

    // Cek apakah file review ada dan bisa dibaca
    if (file_exists($reviewsFile)) {
        $allReviews = json_decode(file_get_contents($reviewsFile), true);

        // Filter review berdasarkan product_id
        $productReviews = array_filter($allReviews, function ($r) use ($selected) {
            return isset($r['product_id']) && $r['product_id'] == $selected['id'];
        });
    }

    // Jika belum ada review sama sekali
    if (empty($productReviews)): ?>
        <p class="no-review">Belum ada ulasan untuk produk ini.</p>

    <?php else: ?>
        <?php foreach ($productReviews as $r): ?>
            <div class="review-card">
                <p><strong><?php echo htmlspecialchars($r['user']); ?></strong> — ⭐<?php echo (int)$r['rating']; ?>/5</p>
                <p><?php echo htmlspecialchars($r['review']); ?></p>
                <small><?php echo htmlspecialchars($r['date']); ?></small>
                <hr>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</div>

</body>
</html>