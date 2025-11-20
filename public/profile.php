<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'] ?? [
  'fullname' => $_SESSION['fullname'] ?? '',
  'email' => $_SESSION['email'] ?? '',
  'whatsapp' => ''
];

$fotoProfil = $_SESSION['foto_profil'] ?? 'defaultpicture.jpg';
$fotoProfilPath = 'uploads/' . $fotoProfil;

if (!file_exists($fotoProfilPath) || $fotoProfil == 'defaultpicture.jpg') {
    $fotoProfilPath = 'images/defaultpicture.jpg';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Saya</title>
  <link rel="stylesheet" href="css/profile.css"> </head>
<body>
  <div class="profile-container">
    <img src="<?php echo htmlspecialchars($fotoProfilPath); ?>" alt="Foto Profil" class="profile-avatar">
    <div class="profile-title">Profil Saya</div>

    <form class="profile-form" action="../src/actions/handle_photo_upload.php" method="POST" enctype="multipart/form-data">
      <label class="custom-file-label">
        Pilih Foto Profil
        <input type="file" name="foto_profil" accept="image/*" onchange="this.form.submit()">
      </label>
    </form>
    
    <form class="profile-form" action="../src/actions/handle_profile_update.php" method="POST" autocomplete="off">
      <label for="fullname">Nama Lengkap</label>
      <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

      <label for="whatsapp">WhatsApp</label>
      <input type="number" id="whatsapp" name="whatsapp" value="<?php echo htmlspecialchars($user['whatsapp']); ?>" placeholder="08xxxxxxxxxx">

      <label for="password">Ubah Password</label>
      <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">

      <button type="submit">Simpan Perubahan</button>
    </form>
    <br>
    <a href="dashboard.php" style="text-decoration:none; color:#3aadeb;">Kembali ke Dashboard</a>
  </div>
</body>
</html>