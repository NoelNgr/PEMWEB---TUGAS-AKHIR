<?php 
require_once "../../src/middleware_admin.php";
require_once "../../src/conn.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Produk</title>
    <link rel="stylesheet" href="../css/products_admin.css" />
</head>
<body>

<h1>Daftar Produk</h1>
    <a href="index.php" class="button back-btn">← Back</a>
    <a href="add_product.php">+ Tambah Produk</a>
<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM products");

    while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['name']; ?></td>
            <td>Rp <?= number_format($row['price'], 0, ',', '.'); ?></td>
            <td><?= $row['stok']; ?></td>
            <td>
                <a href="edit_product.php?id=<?= $row['id']; ?>">Edit</a> |
                <a href="../../src/actions/delete_product.php?id=<?= $row['id']; ?>" onclick="return confirm('Hapus produk ini?')">Hapus</a>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
