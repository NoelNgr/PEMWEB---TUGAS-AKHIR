<?php 
include "../src/conn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="dashboard.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <header>
        <div class="header-container">
            <!-- Logo -->
            <div class="logo">KALC3R</div>

            <!-- Hamburger Menu (Mobile) -->
            <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Navigation & Actions -->
            <div class="header-content" id="headerContent">
                <!-- Navigation Links -->
                <nav class="nav-links">
                    <a href="dashboard.php">Beranda</a>
                    <a href="produk.php">Produk</a>
                    <a href="riwayat.php">Riwayat Pesanan</a>
                </nav>

                <!-- Search Form -->
                <form class="search-form" role="search" method="GET" action="dashboard.php">
                    <input 
                        class="form-control" 
                        type="search" 
                        placeholder="Cari sepatu impianmu..." 
                        aria-label="Search"
                        name="query" 
                        value="<?php echo htmlspecialchars($search_query ?? ''); ?>"
                    />
                    <i class="bi bi-search"></i>
                </form>

                <!-- Action Buttons -->
                <div class="header-actions">
                    <!-- Favorit -->
                    <div class="wishlist">
                        <a href="favorit.php" class="btn btn-outline-secondary">
                            <i class="bi bi-heart" style="color: red"></i> 
                            <span class="btn-text">Favorit</span>
                        </a>
                    </div>

                    <!-- Keranjang -->
                    <div class="cart">
                        <button id="cartButton" class="btn btn-success">
                            <i class="bi bi-cart"></i> 
                            <span class="btn-text">Keranjang (<?php echo count($cart); ?>)</span>
                            <span class="cart-badge"><?php echo count($cart); ?></span>
                        </button>
                    </div>

                    <!-- Profile -->
                    <div class="profile">
                        <a href="profile.php" class="profile-link">
                            <img 
                                src="<?php echo htmlspecialchars($fotoProfilPath); ?>" 
                                alt="Foto Profil"
                                class="profile-img">
                            <span class="profile-name"><?php echo htmlspecialchars($fullname); ?></span>
                        </a>
                    </div>

                    <!-- Logout -->
                    <form action="../src/actions/logout.php" method="POST">
                        <button type="submit" class="btn-logout" title="Logout">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
<script src="js/dashboard.js"></script>
</body>
</html>