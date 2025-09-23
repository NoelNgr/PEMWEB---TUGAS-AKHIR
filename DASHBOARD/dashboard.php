<?php
session_start();

if (!isset($_SESSION['user'])) {
  if (isset($_COOKIE['user']) && isset($_COOKIE['fullname'])) {
    $_SESSION['user'] = [
      'fullname' => $_COOKIE['fullname'],
      'email' => $_COOKIE['user'],
      'whatsapp' => $_COOKIE['whatsapp'] ?? ''
    ];
  } else {
    header('Location: /PEMWEB---TUGAS-AKHIR/LOGIN/login.php');
    exit();
  }
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beranda - KALC3R</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
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
      <div class="profile">
        <i class="bi bi-person-circle"></i>
        <span><?php echo htmlspecialchars($user); ?></span>
      </div>
      <form action="/PEMWEB---TUGAS-AKHIR/logout.php" method="POST">
        <button type="submit" class="btn-logout">
          <i class="bi bi-box-arrow-right"></i>
        </button>
      </form>
    </div>
  </header>

  <main>
    <section class="hero">
      <div class="hero-content">
        <h1>Koleksi Sepatu Terbaru</h1>
        <p>Temukan gaya terbaikmu dengan koleksi eksklusif yang baru tiba. Kualitas dan kenyamanan dalam setiap langkah.</p>
        <button class="cta-button">Belanja Sekarang</button>
      </div>
    </section>

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

    <section class="page-section">
      <h2 class="section-title">Produk Terlaris</h2>
      <div class="product-grid">
        <div class="product-card">
          <img src="https://placehold.co/400x300/EAF2F8/333?text=Nike+Air" alt="Sepatu">
          <h3>Nike Air Force 1</h3>
          <p class="price">Rp 1.729.000</p>
        </div>
        <div class="product-card">
          <img src="https://placehold.co/400x300/E8F6F3/333?text=Adidas+Runner" alt="Sepatu">
          <h3>Adidas Ultraboost</h3>
          <p class="price">Rp 3.300.000</p>
        </div>
        <div class="product-card">
          <img src="https://placehold.co/400x300/FEF9E7/333?text=Vans+Classic" alt="Sepatu">
          <h3>Vans Old Skool</h3>
          <p class="price">Rp 1.099.000</p>
        </div>
        <div class="product-card">
          <img src="https://placehold.co/400x300/F5EEF8/333?text=New+Balance" alt="Sepatu">
          <h3>New Balance 550</h3>
          <p class="price">Rp 2.099.000</p>
        </div>
      </div>
    </section>

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

  <footer>
    <div class="footer-content">
      <div class="logo">KALC3R</div>
      <p>&copy; 2025 KALC3R. Semua Hak Dilindungi Undang-Undang.</p>
    </div>
  </footer>

</body>
</html>