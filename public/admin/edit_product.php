<?php 
require_once "../../src/middleware_admin.php";
require_once "../../src/conn.php";

$id = $_GET['id'];

// Ambil data produk
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$produk = $result->fetch_assoc();

if (!$produk) {
    echo "Produk tidak ditemukan!";
    exit();
}

// Decode warna & ukuran dari JSON -> jadi string koma
$warnaText  = implode(", ", json_decode($produk['warna'], 1) ?? []);
$ukuranText = implode(", ", json_decode($produk['ukuran'], 1) ?? []);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
</head>
<body>

<h1>Edit Produk</h1>

<form action="../../src/actions/edit_product.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $produk['id']; ?>">

<label>Nama Produk</label><br>
<input type="text" name="name" value="<?= $produk['name']; ?>" required><br><br>

<label>Harga</label><br>
<input type="number" name="price" value="<?= $produk['price']; ?>" required><br><br>

<label>Brand</label><br>
<input type="text" name="brand" value="<?= $produk['brand']; ?>"><br><br>

<label>Stok</label><br>
<input type="number" name="stok" value="<?= $produk['stok']; ?>" required><br><br>

<label>Deskripsi</label><br>
<textarea name="deskripsi" rows="3"><?= $produk['deskripsi']; ?></textarea><br><br>

<label>Warna (pisahkan dengan koma)</label><br>
<input type="text" name="warna" value="<?= $warnaText; ?>" placeholder="Putih, Hitam"><br><br>

<label>Ukuran (pisahkan dengan koma)</label><br>
<input type="text" name="ukuran" value="<?= $ukuranText; ?>" placeholder="38, 39, 40"><br><br>

<label>Rating</label><br>
<input type="number" name="rating" step="0.1" value="<?= $produk['rating']; ?>"><br><br>

<label>Foto Produk Baru</label><br>
<input type="file" name="image"><br>
<small>Biarkan kosong jika tidak mengganti</small><br><br>

<!-- <img src="../uploads/<?= $produk['image']; ?>" width="120" style="border:1px solid #ccc;">
<br><br> -->

<button type="submit">Simpan Perubahan</button>

</form>

</body>
</html>
