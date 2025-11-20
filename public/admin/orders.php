<?php 
require_once "../../src/middleware_admin.php";
require_once "../../src/conn.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kelola Pesanan</title>
    <link rel="stylesheet" href="../css/orders_admin.css" />
</head>
<body>

<h1>Daftar Pesanan</h1>
    <a href="index.php" class="button back-btn">← Back</a>
<br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID Pesanan</th>
        <th>Pelanggan</th>
        <th>Total</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM orders");
    while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id_order']; ?></td>
            <td><?= $row['nama_pelanggan']; ?></td>
            <td>Rp <?= number_format($row['total'], 0, ',', '.'); ?></td>
            <td><?= $row['status']; ?></td>
            <td><a href="#">Detail</a></td>
        </tr>
    <?php } ?>

</table>

</body>
</html>
