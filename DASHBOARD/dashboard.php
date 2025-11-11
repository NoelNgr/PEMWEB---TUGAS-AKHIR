<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../LOGIN/login.php");
} else {
    $fullname = $_SESSION['fullname'];
}

// 2. INISIALISASI CART
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 3. ARRAY PRODUK (TARO DI SINI ✅)
$produkTerlaris = [
    [
        'name' => 'Nike Air Force 1',
        'price' => 1729000,
        'brand' => 'Nike',
        'image' => 'https://placehold.co/400x300/EAF2F8/333?text=Nike+Air'
    ],
    [
        'name' => 'Adidas Ultraboost',
        'price' => 3300000,
        'brand' => 'Adidas',
        'image' => 'https://placehold.co/400x300/E8F6F3/333?text=Adidas+Runner'
    ],
    [
        'name' => 'Vans Old Skool',
        'price' => 1099000,
        'brand' => 'Vans',
        'image' => 'https://placehold.co/400x300/FEF9E7/333?text=Vans+Classic'
    ],
    [
        'name' => 'Puma Suede Classic',
        'price' => 899000,
        'brand' => 'Puma',
        'image' => 'https://placehold.co/400x300/FFF5E5/333?text=Puma+Suede'
    ],
    [
        'name' => 'Converse Chuck Taylor',
        'price' => 799000,
        'brand' => 'Converse',
        'image' => 'https://placehold.co/400x300/F0F0F0/333?text=Converse+All+Star'
    ],
    [
        'name' => 'Reebok Classic Leather',
        'price' => 1299000,
        'brand' => 'Reebok',
        'image' => 'https://placehold.co/400x300/EDEDED/333?text=Reebok+Classic'
    ],
    [
        'name' => 'Asics Gel-Kayano',
        'price' => 2499000,
        'brand' => 'Asics',
        'image' => 'https://placehold.co/400x300/DFF0D8/333?text=Asics+Gel-Kayano'
    ],
    [
        'name' => 'New Balance 550',
        'price' => 2099000,
        'brand' => 'New Balance',
        'image' => 'https://placehold.co/400x300/F5EEF8/333?text=New+Balance'
    ]
];

// 4. LOGIKA TAMBAH CART
if (isset($_POST['add_to_cart'])) {
    $product = [
        'name' => $_POST['product_name'],
        'price' => (int)$_POST['product_price'],
        'brand' => $_POST['product_brand'],
        'qty' => 1
    ];
    $_SESSION['cart'][] = $product;
    header("Location: dashboard.php"); 
    exit();
}

// 5. LOGIKA REMOVE CART
if (isset($_GET['remove'])) {
    $idx = (int)$_GET['remove'];
    if (isset($_SESSION['cart'][$idx])) {
        unset($_SESSION['cart'][$idx]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    header("Location: dashboard.php");
    exit();
}


if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
  $product = [
    'name' => $_POST['product_name'],
    'price' => (int)$_POST['product_price'],
    'brand' => $_POST['product_brand'],
    'qty' => 1
  ];
  $_SESSION['cart'][] = $product;
  header("Location: dashboard.php"); 
  exit();
}

if (isset($_GET['remove'])) {
  $idx = (int)$_GET['remove'];
  if (isset($_SESSION['cart'][$idx])) {
    unset($_SESSION['cart'][$idx]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); 
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
      <div class="cart">
        <button id="cartButton" class="btn btn-success">
          <i class="bi bi-cart"></i> Keranjang (<?php echo count($_SESSION['cart']); ?>)
        </button>
      </div>
      <div class="profile" style="display:flex;align-items:center;gap:8px;">
        <a href="profile.php" style="display:flex;align-items:center;gap:8px;text-decoration:none;color:inherit;">
          <img 
            src="uploads/<?php echo isset($_SESSION['foto_profil']) && $_SESSION['foto_profil'] !== '' 
              ? htmlspecialchars($_SESSION['foto_profil']) 
              : 'defaultpicture.jpg'; ?>" 
            alt="Foto Profil"
            style="width:30px;height:30px;border-radius:50%;object-fit:cover;border:2px solid #3aadeb;">
          <span><?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
        </a>
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

      <?php foreach ($produkTerlaris as $item): ?>
        <div class="product-card">
          <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
          <h3><?php echo $item['name']; ?></h3>
          <p class="price">Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></p>

          <form method="POST">
              <input type="hidden" name="product_name" value="<?php echo $item['name']; ?>">
              <input type="hidden" name="product_price" value="<?php echo $item['price']; ?>">
              <input type="hidden" name="product_brand" value="<?php echo $item['brand']; ?>">
              <button type="submit" name="add_to_cart" class="btn btn-primary">
                <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
              </button>
          </form>
        </div>
      <?php endforeach; ?>
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

  <div class="offcanvas" id="cartDrawer">
    <div class="offcanvas-header">
      <h5>Keranjang Saya</h5>
      <button type="button" class="btn-close" id="closeCartButton">&times;</button>
    </div>

    <div class="offcanvas-body">
      <?php if (!empty($_SESSION['cart'])): ?>
        <ul class="cart-item-list">
          <?php
          $total = 0;
          foreach ($_SESSION['cart'] as $index => $item):
            $subtotal = $item['price'] * $item['qty'];
            $total += $subtotal;
          ?>
            <li class="cart-item">
              <div class="item-info">
                <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
                <small><?php echo htmlspecialchars($item['brand']); ?></small><br>
                <span><?php echo $item['qty']; ?>x - Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></span>
              </div>
              <a href="?remove=<?php echo $index; ?>" class="btn-danger">
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
          <form action="/PEMWEB---TUGAS-AKHIR/CHECKOUT/checkout.php" method="POST">
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
        </div>
      <?php endif; ?>
    </div>
</body>
  <script src="dashboard.js"></script>
</html>

</html>