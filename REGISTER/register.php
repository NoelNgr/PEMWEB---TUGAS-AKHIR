<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KALC3R - Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="container">
    <div class="card">
      <h2>Buat Akun Baru</h2>

      <form id="registerForm" action="proses_register.php" method="POST">
        <div class="input-group">
          <label>Nama Lengkap</label>
          <input type="text" name="fullname" placeholder="Nama lengkap" required>
        </div>
        <div class="input-group">
          <label>Email</label>
          <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
        </div>
        <div class="input-group">
          <label>No. Whatsapp</label>
          <input type="text" name="whatsapp" placeholder="No. whatsapp" required>
        </div>
        <div class="input-group">
          <label>Password</label>
          <input type="password" id="registerPassword" name="password" placeholder="Password" required>
          <span class="password-toggle" onclick="togglePassword('registerPassword')"></span>
        </div>
        <div class="checkbox">
          <input type="checkbox" required>
          <label>Saya memahami dan menyetujui <a href="#">KALC3R Terms of Service</a></label>
        </div>
        <button type="submit" class="btn">Daftar Sekarang</button>
      </form>
      <p>Sudah punya akun? <a href="/PEMWEB---TUGAS-AKHIR/LOGIN/login.php" style="color:#3aadeb;">Login</a></p>
    </div>
  </div>

  <!-- <script src="script.js"></script> -->
</body>
</html>
