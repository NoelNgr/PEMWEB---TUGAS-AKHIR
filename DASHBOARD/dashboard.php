<?php
session_start();

if (!isset($_SESSION['user'])) {
  setcookie('user', '', time() - 3600, '/');
  header('Location: /PEMWEB---TUGAS-AKHIR/LOGIN/login.php');
  exit();
}
// Cek cookie
$user = is_array($_SESSION['user']) ? $_SESSION['user'] : [
  'fullname' => $_COOKIE['fullname'] ?? '',
  'email' => $_COOKIE['user'] ?? '',
  'whatsapp' => $_COOKIE['whatsapp'] ?? ''
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>

<body>
  <header>
    <div class="logo">KALC3R</div>
    <nav>
      <a href="#" class="active">Beranda</a>
      <a href="#">Dashboard</a>
      <a href="#">Produk</a>
      <a href="#">Pre-order</a>
      <a href="#">Pesanan</a>
    </nav>
    <form class="d-flex" role="search" id="searchForm">
      <input
        class="form-control me-2 bi bi-search"
        type="search"
        placeholder="Search"
        aria-label="Search" />
      <!-- <button class="btn btn-outline-dark" type="submit">Search</button> -->
    </form>
    <div class="profile" style="padding-left: 250px;">
      Profil Saya - <?php echo htmlspecialchars($user['fullname']); ?>
    </div>
    <form action="/PEMWEB---TUGAS-AKHIR/logout.php" method="POST" style="display:inline;">
      <button type="submit" class="btn btn-danger">Logout</button>
    </form>
  </header>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>