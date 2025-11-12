<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KALC3R - Register</title>
  <link rel="stylesheet" href="css/auth.css">
</head>
<body>

  <div class="container">
    <div class="card">
      <h2>Buat Akun Baru</h2>

      <form id="registerForm" action="../src/actions/handle_register.php" method="POST">
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
          <input type="text" name="whatsapp" placeholder="08xxxxxxxxxx" required>
        </div>
        <div class="input-group">
          <label>Password</label>
          <input type="password" id="registerPassword" name="password" placeholder="Password" required>
          <span class="password-toggle" onclick="togglePassword('registerPassword')">Tampilkan</span>
        </div>
        <div class="checkbox">
          <input type="checkbox" id="terms" required>
          <label for="terms">Saya memahami dan menyetujui <a href="#">KALC3R Terms of Service</a></label>
        </div>
        <button type="submit" class="btn">Daftar Sekarang</button>
      </form>
      <p>Sudah punya akun? <a href="login.php" style="color:#3aadeb;">Login</a></p>
    </div>
  </div>

  <script src="js/auth.js"></script>
</body>
</html>