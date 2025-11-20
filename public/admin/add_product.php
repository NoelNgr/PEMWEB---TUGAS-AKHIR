<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../unauthorized.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<h2>Tambah Produk Baru</h2>

<form action="../../src/actions/add_product.php" method="POST" enctype="multipart/form-data">

    <label>Nama Produk</label>
    <input type="text" name="name" required><br>

    <label>Harga</label>
    <input type="number" name="price" required><br>

    <label>Brand</label>
    <input type="text" name="brand"><br>

    <label>Deskripsi</label>
    <textarea name="deskripsi" rows="3"></textarea><br>

    <label>Stok</label>
    <input type="number" name="stok" required><br>

    <label>Warna (pisahkan dengan koma)</label>
    <input type="text" name="warna" placeholder="Putih, Hitam, Maroon"><br>

    <label>Ukuran (pisahkan dengan koma)</label>
    <input type="text" name="ukuran" placeholder="38, 39, 40, 41"><br>

    <label>Rating (opsional)</label>
    <input type="number" name="rating" step="0.1" placeholder="4.5"><br>

    <label>Gambar Produk</label>
    <input type="file" name="gambar" accept="image/*" ><br>

    <button type="submit">Tambah Produk</button>

</form>

</body>
</html>
