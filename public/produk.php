<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit(); 
}

$fullname = $_SESSION['fullname'] ?? 'User';
$cart = $_SESSION['cart'] ?? [];

// --- PERUBAHAN DIMULAI (Koneksi & Logika Pencarian) ---
include '../src/conn.php'; 

// 1. Ambil kueri pencarian dari URL (jika ada)
$search_query = $_GET['query'] ?? null;

// 2. Siapkan kueri SQL
$sql = "SELECT id, name, price, brand, image FROM products";
$params = [];
$types = "";

// 3. Jika ada kueri pencarian, ubah SQL
if ($search_query) {
    // Menambahkan WHERE clause untuk mencari nama ATAU brand
    $sql .= " WHERE name LIKE ? OR brand LIKE ?";
    
    // Siapkan parameter untuk prepared statement (mencegah SQL Injection)
    $search_term = "%" . $search_query . "%";
    $params[] = &$search_term; // Parameter untuk 'name'
    $params[] = &$search_term; // Parameter untuk 'brand'
    $types = "ss"; // s = string, jadi "ss" untuk dua string
}

// 4. Eksekusi Kueri
$produkTerlaris = [];
$stmt = $conn->prepare($sql);

// 5. Bind parameter jika ada pencarian
if ($search_query && $stmt) {
    // Gunakan ...$params untuk 'splat' array ke dalam argumen bind_param
    $stmt->bind_param($types, ...$params);
}

// 6. Eksekusi dan ambil hasil
if ($stmt && $stmt->execute()) {
    $result = $stmt->get_result();
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $produkTerlaris[] = $row;
        }
    }
    $stmt->close();
} else {
    // Handle error jika kueri gagal
    echo "Error: " . $conn->error;
}

// 7. Tentukan judul bagian produk
if ($search_query) {
    $section_title = 'Hasil Pencarian untuk "' . htmlspecialchars($search_query) . '"';
} else {
    $section_title = 'Katalog Produk Kami';
}
// --- PERUBAHAN SELESAI ---

$fotoProfil = $_SESSION['foto_profil'] ?? 'defaultpicture.jpg';
$fotoProfilPath = 'uploads/' . $fotoProfil;

if (!file_exists($fotoProfilPath) || $fotoProfil == 'defaultpicture.jpg') {
    $fotoProfilPath = 'images/defaultpicture.jpg';
}

include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beranda - KALC3R</title>
  <link rel="stylesheet" href="css/dashboard.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
  <main>
    <section class="page-section">
    
    <h2 class="section-title"><?php echo $section_title; ?></h2>
    <div class="product-grid">

      <?php if (empty($produkTerlaris) && $search_query): ?>
        
        <p style="text-align: center; grid-column: 1 / -1; color: #555;">
            Tidak ada produk yang ditemukan untuk "<?php echo htmlspecialchars($search_query); ?>".
        </p>

      <?php else: ?>
        
        <?php foreach ($produkTerlaris as $item): ?>
          <div class="product-card">

              <a href="product_detail.php?id=<?php echo $item['id']; ?>">
                  <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
              </a>

              <h3>
                  <a href="product_detail.php?id=<?php echo $item['id']; ?>">
                      <?php echo $item['name']; ?>
                  </a>
              </h3>

              <p class="price">
                  Rp <?php echo number_format($item['price'], 0, ',', '.'); ?>
              </p>

              <a href="product_detail.php?id=<?php echo $item['id']; ?>" class="btn btn-secondary">
                  Lihat Detail
              </a>
          </div>
        <?php endforeach; ?>
      
      <?php endif; ?>
      </div>
</section>

    
    <section class="page-section brand-section">
      <h2 class="section-title">Brand Teratas</h2>
      <div class="brand-logos">
        <img src="https://placehold.co/150x60/f0f0f0/999?text=NIKE" alt="Nike">
        <img src="https://placehold.co/150x60/f0f0f0/999?text=ADIDAS" alt="Adidas">
        <img src="https://placehold.co/150x60/f0f0f0/999?text=PUMA" alt="Puma">
        <img src="https://placehold.co/150x60/f0f0f0/999?text=VANS" alt="Vans">
      </div>
    </section>
  </main>

  <?php include 'footer.php'; ?>

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
                <small>Brand : <?php echo htmlspecialchars($item['brand'] ?? 'Brand'); ?></small><br>

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
        <p>Pilih barang untuk ditambahkan ke keranjang !</p>
        <div class="cart-actions">
          <button class="btn-empty" disabled>
            <i class="bi bi-bag-x"></i> Checkout
          </button>
        </div>
      <?php endif; ?>
    </div>
  </div>
  
  <script src="js/dashboard.js"></script>
</body>
</html>
