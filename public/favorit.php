<?php
session_start();
include '../src/conn.php'; 

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$fullname = $_SESSION['fullname'] ?? 'User';
$id_pelanggan = $_SESSION['id_pelanggan'] ?? null; 
$fotoProfil = $_SESSION['foto_profil'] ?? 'defaultpicture.jpg';
$fotoProfilPath = 'uploads/' . $fotoProfil;

if (!file_exists($fotoProfilPath) || $fotoProfil == 'defaultpicture.jpg') {
    $fotoProfilPath = 'images/defaultpicture.jpg';
}

// Mengambil Data Favorit
$favorite_products = [];
if ($id_pelanggan && $conn) {
    
    $safe_id_pelanggan = (int)$id_pelanggan; 

    $query = "
        SELECT 
            p.id AS product_id,
            p.name AS nama_produk, 
            p.price, 
            p.brand, 
            p.warna, 
            p.ukuran, 
            p.image,
            p.rating,
            f.id AS id_favorit
        FROM favorit f
        JOIN products p ON f.products_id = p.id
        WHERE f.id_pelanggan = $safe_id_pelanggan
        ORDER BY f.id DESC
    ";
    
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $warna_array = json_decode($row['warna'], true);
            $ukuran_array = json_decode($row['ukuran'], true);
            $row['warna'] = is_array($warna_array) ? implode(', ', $warna_array) : 'N/A';
            $row['ukuran'] = is_array($ukuran_array) ? implode(', ', $ukuran_array) : 'N/A';
            $favorite_products[] = $row;
        }
    } else {
        // Debugging jika query gagal
        error_log("Error query favorit: " . mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/favorit.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Produk Favorit - KALC3R</title>
</head>
<body>
    <header>
        <div class="header-left">
            <div class="logo">KALC3R</div>
            <nav>
                <a href="dashboard.php">Beranda</a>
                <a href="#">Produk</a>
                <a href="#">Pre-order</a>
                <a href="riwayat.php">Riwayat Pesanan</a>
            </nav>
        </div>
        <div class="header-right">
            <div class="wishlist">
                <a href="favorit.php" class="btn btn-secondary active"> 
                    <i class="bi bi-heart" style="color: red"></i> Favorit
                </a>
            </div>
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

    <main class="favorit-content">
        <h1>Favorit Anda</h1>
        
        <?php if ($id_pelanggan): ?>
            <p style="color: #666; font-size: 14px;">
                Total favorit: <?php echo count($favorite_products); ?> produk
            </p>
        <?php endif; ?>
        
        <div class="product-list">
            <?php if (empty($favorite_products)): ?>
                <p class="empty-message">Anda belum menambahkan produk ke daftar favorit.</p>
            <?php else: ?>
                <?php foreach ($favorite_products as $product): ?>
                    <div class="product-card">
                        <img 
                            src="<?php echo htmlspecialchars('uploads/' . $product['image']); ?>" 
                            alt="<?php echo htmlspecialchars($product['nama_produk']); ?>" 
                            class="product-image"
                            onerror="this.src='images/defaultpicture.jpg'"
                        >
                        <div class="product-info">
                            <h3 class="product-name"><?php echo htmlspecialchars($product['nama_produk']); ?></h3>
                            <p class="product-price">
                                Harga: <strong>Rp<?php echo number_format($product['price'], 0, ',', '.'); ?></strong>
                            </p>
                            <p class="product-detail">Warna: <span><?php echo htmlspecialchars($product['warna']); ?></span></p>
                            <p class="product-detail">Ukuran: <span><?php echo htmlspecialchars($product['ukuran']); ?></span></p>
                            
                            <form action="../src/actions/handler_favorit.php" method="POST" class="remove-form">
                                <input type="hidden" name="action" value="remove"> 
                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                <button type="submit" class="btn-remove" title="Hapus dari Favorit">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <script>
        document.querySelectorAll('.remove-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Anda yakin ingin menghapus produk ini dari favorit?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>