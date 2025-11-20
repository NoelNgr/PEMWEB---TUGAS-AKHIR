<?php 
require_once "../../src/middleware_admin.php";
require_once "../../src/conn.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/index_admin.css" />
</head>
<body>

<h1>Dashboard Admin</h1>
<p>Halo, <?= $_SESSION['fullname']; ?> (Admin)</p>

<ul>
    <li><a href="products.php">Kelola Produk</a></li>
    <li><a href="orders.php">Kelola Pesanan</a></li>
    <li><a href="users.php">Kelola User</a></li>
    <li><a href="../../src/actions/logout.php">Logout</a></li>
</ul>

</body>
</html>
