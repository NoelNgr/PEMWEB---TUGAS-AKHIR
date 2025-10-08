<?php
session_start();
$user = $_SESSION['user'] ?? [
  'fullname' => '',
  'email' => '',
  'whatsapp' => ''
];
$foto = $_SESSION['foto_profil'] ?? 'default.png';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Saya</title>
  <style>
    body {
      background: #f5f7fa;
      font-family: 'Segoe UI', Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    .profile-container {
      max-width: 400px;
      margin: 40px auto;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0,0,0,0.08);
      padding: 32px 24px;
      text-align: center;
    }
    .profile-avatar {
      width: 110px;
      height: 110px;
      border-radius: 10%;
      object-fit: cover;
      border: 3px solid #3aadeb;
      margin-bottom: 18px;
      background: #e9ecef;
    }
    .profile-title {
      font-size: 1.4rem;
      font-weight: 600;
      margin-bottom: 8px;
      color: #222;
    }
    .profile-form input[type="file"] {
      display: none;
    }
    .custom-file-label {
      display: inline-block;
      padding: 8px 18px;
      background: #eaf6fb;
      color: #3aadeb;
      border-radius: 6px;
      cursor: pointer;
      margin-bottom: 18px;
      font-size: 1rem;
      border: 1px solid #3aadeb;
      transition: background 0.2s;
    }
    .custom-file-label:hover {
      background: #d0eaf7;
    }
    .profile-form {
      text-align: left;
      margin-top: 18px;
    }
    .profile-form label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
      color: #333;
    }
    .profile-form input[type="text"],
    .profile-form input[type="email"],
    .profile-form input[type="password"] {
      width: 100%;
      padding: 8px 10px;
      margin-bottom: 14px;
      border: 1px solid #cce6f6;
      border-radius: 6px;
      font-size: 1rem;
      background: #f8fbfd;
    }
    .profile-form button {
      background: #3aadeb;
      color: #fff;
      border: none;
      padding: 10px 28px;
      border-radius: 6px;
      font-size: 1rem;
      cursor: pointer;
      margin-top: 10px;
      transition: background 0.2s;
      width: 100%;
    }
    .profile-form button:hover {
      background: #2699d6;
    }
    .profile-form .custom-file-label {
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="profile-container">
    <img src="uploads/<?php echo htmlspecialchars($foto); ?>" alt="Foto Profil" class="profile-avatar">
    <div class="profile-title">Profil Saya</div>
   <form class="profile-form" action="upload_foto.php" method="POST" enctype="multipart/form-data">
  <label class="custom-file-label">
    Pilih Foto Profil
    <input type="file" name="foto_profil" accept="image/*" onchange="this.form.submit()">
  </label>
</form>

<?php if ($foto !== 'default.png'): ?>
  <form action="upload_foto.php" method="post" onsubmit="return confirm('Yakin ingin hapus foto profil?');">
    <button type="submit" name="hapus_foto"
      style="background:#f44336;color:white;border:none;padding:8px 12px;border-radius:6px;cursor:pointer;margin-bottom:18px;">
      Hapus Foto Profil
    </button>
  </form>
<?php endif; ?>

    <form class="profile-form" action="update_profile.php" method="POST" autocomplete="off">
      <label for="fullname">Nama Lengkap</label>
      <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

      <label for="whatsapp">WhatsApp</label>
      <input type="text" id="whatsapp" name="whatsapp" value="<?php echo htmlspecialchars($user['whatsapp']); ?>" placeholder="08xxxxxxxxxx">

      <label for="password">Ubah Password</label>
      <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">

      <button type="submit">Simpan Perubahan</button>
    </form>
  </div>
</body>
</html>