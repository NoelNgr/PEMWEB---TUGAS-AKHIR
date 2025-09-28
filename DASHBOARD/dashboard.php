<?php
session_start();

<<<<<<< HEAD
// Cek login
=======
// cek login
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
if (
  !isset($_SESSION['user']) ||
  !is_array($_SESSION['user']) ||
  !isset($_SESSION['user']['fullname'])
<<<<<<< HEAD
) {
=======
  ) {
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
  if (isset($_COOKIE['user']) && isset($_COOKIE['fullname'])) {
    $_SESSION['user'] = [
      'fullname' => $_COOKIE['fullname'],
      'email' => $_COOKIE['user'],
      'whatsapp' => $_COOKIE['whatsapp'] ?? ''
    ];
  } else {
<<<<<<< HEAD
    // Arahkan ke halaman login jika tidak ada sesi atau cookie
    header('Location: /C:/xampp/htdocs/PEMWEB---TUGAS-AKHIR/LOGIN/login.php');
=======
    header('Location: /PEMWEB---TUGAS-AKHIR/LOGIN/login.php');
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
    exit();
  }
}

$user = $_SESSION['user'];

<<<<<<< HEAD
// Inisialisasi keranjang jika belum ada
=======
// inisialisasi keranjang
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

<<<<<<< HEAD
// Logika untuk menambah item ke keranjang
=======
// tambah item
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
if (isset($_POST['add_to_cart'])) {
  $product = [
    'name' => $_POST['product_name'],
    'price' => (int)$_POST['product_price'],
    'brand' => $_POST['product_brand'],
    'qty' => 1
  ];
  $_SESSION['cart'][] = $product;
<<<<<<< HEAD
  header("Location: dashboard.php"); // Redirect untuk mencegah duplikasi saat refresh
  exit();
}

// Logika untuk menghapus item dari keranjang
=======
  header("Location: dashboard.php"); // biar nggak double submit
  exit();
}

// hapus item
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
if (isset($_GET['remove'])) {
  $idx = (int)$_GET['remove'];
  if (isset($_SESSION['cart'][$idx])) {
    unset($_SESSION['cart'][$idx]);
<<<<<<< HEAD
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Atur ulang indeks array
=======
    $_SESSION['cart'] = array_values($_SESSION['cart']); // reset index
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
  }
  header("Location: dashboard.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beranda - KALC3R</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<<<<<<< HEAD
</head>
<body>
=======
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- HEADER -->
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
  <header>
    <div class="header-left">
      <div class="logo">KALC3R</div>
      <nav>
        <a href="#" class="active">Beranda</a>
        <a href="#">Produk</a>
        <a href="#">Pre-order</a>
        <a href="#">Pesanan</a>
      </nav>
    </div>
    <div class="header-right">
      <form class="search-form" role="search">
        <input class="form-control" type="search" placeholder="Cari sepatu impianmu..." aria-label="Search" />
        <i class="bi bi-search"></i>
      </form>
<<<<<<< HEAD
      <div class="cart">
        <button id="cartButton" class="btn btn-success">
          <i class="bi bi-cart"></i> Keranjang (<?php echo count($_SESSION['cart']); ?>)
        </button>
      </div>
=======
      <!-- tombol keranjang -->
      <div class="cart">
        <button class="btn btn-success" data-bs-toggle="offcanvas" data-bs-target="#cartDrawer">
          <i class="bi bi-cart"></i> Keranjang (<?php echo count($_SESSION['cart']); ?>)
        </button>
      </div>
      <!-- profil -->
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
      <div class="profile">
        <i class="bi bi-person-circle"></i>
        <span><?php echo htmlspecialchars($user['fullname']); ?></span>
      </div>
<<<<<<< HEAD
=======
      <!-- logout -->
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
      <form action="/PEMWEB---TUGAS-AKHIR/logout.php" method="POST">
        <button type="submit" class="btn-logout">
          <i class="bi bi-box-arrow-right"></i>
        </button>
      </form>
    </div>
  </header>

<<<<<<< HEAD
  <main>
=======
  <!-- MAIN -->
  <main>
    <!-- Hero Section -->
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
    <section class="hero">
      <div class="hero-content">
        <h1>Koleksi Sepatu Terbaru</h1>
        <p>Temukan gaya terbaikmu dengan koleksi eksklusif yang baru tiba. Kualitas dan kenyamanan dalam setiap langkah.</p>
        <button class="cta-button">Belanja Sekarang</button>
      </div>
    </section>

<<<<<<< HEAD
=======
    <!-- Kategori -->
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
    <section class="page-section">
      <h2 class="section-title">Jelajahi Berdasarkan Kategori</h2>
      <div class="category-grid">
        <div class="category-card">
          <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=2070&auto=format&fit=crop" alt="Sepatu Pria">
          <div class="category-name">Pria</div>
        </div>
        <div class="category-card">
          <img src="https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?q=80&w=1898&auto=format&fit=crop" alt="Sepatu Wanita">
          <div class="category-name">Wanita</div>
        </div>
        <div class="category-card">
          <img src="https://images.unsplash.com/photo-1560769629-975ec94e6a86?q=80&w=1964&auto=format&fit=crop" alt="Sepatu Anak">
          <div class="category-name">Anak</div>
        </div>
      </div>
    </section>

<<<<<<< HEAD
    <section class="page-section">
      <h2 class="section-title">Produk Terlaris</h2>
      <div class="product-grid">
        <div class="product-card">
          <img src="https://placehold.co/400x300/EAF2F8/333?text=Nike+Air" alt="Sepatu Nike Air">
=======
    <!-- Produk Terlaris -->
    <section class="page-section">
      <h2 class="section-title">Produk Terlaris</h2>
      <div class="product-grid">
        <!-- produk 1 -->
        <div class="product-card">
          <img src="https://placehold.co/400x300/EAF2F8/333?text=Nike+Air" alt="Sepatu">
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
          <h3>Nike Air Force 1</h3>
          <p class="price">Rp 1.729.000</p>
          <form method="POST">
            <input type="hidden" name="product_name" value="Nike Air Force 1">
            <input type="hidden" name="product_price" value="1729000">
            <input type="hidden" name="product_brand" value="Nike">
            <button type="submit" name="add_to_cart" class="btn btn-primary">
              <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
            </button>
          </form>
        </div>
<<<<<<< HEAD
        <div class="product-card">
          <img src="https://placehold.co/400x300/E8F6F3/333?text=Adidas+Runner" alt="Sepatu Adidas Runner">
=======
        <!-- produk 2 -->
        <div class="product-card">
          <img src="https://placehold.co/400x300/E8F6F3/333?text=Adidas+Runner" alt="Sepatu">
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
          <h3>Adidas Ultraboost</h3>
          <p class="price">Rp 3.300.000</p>
          <form method="POST">
            <input type="hidden" name="product_name" value="Adidas Ultraboost">
            <input type="hidden" name="product_price" value="3300000">
            <input type="hidden" name="product_brand" value="Adidas">
            <button type="submit" name="add_to_cart" class="btn btn-primary">
              <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
            </button>
          </form>
        </div>
<<<<<<< HEAD
        <div class="product-card">
          <img src="https://placehold.co/400x300/FEF9E7/333?text=Vans+Classic" alt="Sepatu Vans Classic">
=======
        <!-- produk 3 -->
        <div class="product-card">
          <img src="https://placehold.co/400x300/FEF9E7/333?text=Vans+Classic" alt="Sepatu">
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
          <h3>Vans Old Skool</h3>
          <p class="price">Rp 1.099.000</p>
          <form method="POST">
            <input type="hidden" name="product_name" value="Vans Old Skool">
            <input type="hidden" name="product_price" value="1099000">
            <input type="hidden" name="product_brand" value="Vans">
            <button type="submit" name="add_to_cart" class="btn btn-primary">
              <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
            </button>
          </form>
        </div>
<<<<<<< HEAD
        <div class="product-card">
          <img src="https://placehold.co/400x300/F5EEF8/333?text=New+Balance" alt="Sepatu New Balance">
=======
        <!-- produk 4 -->
        <div class="product-card">
          <img src="https://placehold.co/400x300/F5EEF8/333?text=New+Balance" alt="Sepatu">
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
          <h3>New Balance 550</h3>
          <p class="price">Rp 2.099.000</p>
          <form method="POST">
            <input type="hidden" name="product_name" value="New Balance 550">
            <input type="hidden" name="product_price" value="2099000">
            <input type="hidden" name="product_brand" value="New Balance">
            <button type="submit" name="add_to_cart" class="btn btn-primary">
              <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
            </button>
          </form>
        </div>
      </div>
    </section>

<<<<<<< HEAD
=======
    <!-- Brand -->
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
    <section class="page-section brand-section">
      <h2 class="section-title">Brand Teratas</h2>
      <div class="brand-logos">
        <img src="https://placehold.co/150x60/f0f0f0/999?text=NIKE" alt="Nike">
        <img src="https://placehold.co/150x60/f0f0f0/999?text=ADIDAS" alt="Adidas">
        <img src="https://placehold.co/150x60/f0f0f0/999?text=PUMA" alt="Puma">
        <img src="https://placehold.co/150x60/f0f0f0/999?text=VANS" alt="Vans">
        <img src="https://placehold.co/150x60/f0f0f0/999?text=CONVERSE" alt="Converse">
      </div>
    </section>
  </main>

<<<<<<< HEAD
=======
  <!-- FOOTER -->
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
  <footer>
    <div class="footer-content">
      <div class="logo">KALC3R</div>
      <p>&copy; 2025 KALC3R. Semua Hak Dilindungi Undang-Undang.</p>
    </div>
  </footer>

<<<<<<< HEAD
  <div class="offcanvas" id="cartDrawer">
    <div class="offcanvas-header">
      <h5>Keranjang Saya</h5>
      <button type="button" class="btn-close" id="closeCartButton">&times;</button>
    </div>
    <div class="offcanvas-body">
      <?php if (!empty($_SESSION['cart'])): ?>
        <ul class="cart-item-list">
          <?php foreach ($_SESSION['cart'] as $index => $item): ?>
            <li class="cart-item">
              <div>
                <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                <span><?php echo $item['qty']; ?>x - Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></span>
              </div>
              <a href="?remove=<?php echo $index; ?>" class="btn-danger">
=======
  <!-- OFFCANVAS Keranjang -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="cartDrawer">
    <div class="offcanvas-header">
      <h5>Keranjang Saya</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <?php if (!empty($_SESSION['cart'])): ?>
        <ul class="list-group">
          <?php foreach ($_SESSION['cart'] as $index => $item): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <strong><?php echo $item['name']; ?></strong><br>
                <?php echo $item['qty']; ?>x - Rp <?php echo number_format($item['price'],0,',','.'); ?>
              </div>
              <a href="?remove=<?php echo $index; ?>" class="btn btn-sm btn-danger">
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
                <i class="bi bi-trash"></i>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p>Keranjang kosong</p>
      <?php endif; ?>
    </div>
  </div>

<<<<<<< HEAD
  <script src="dashboard.js"></script>
</body>
</html>
=======
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
