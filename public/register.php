<?php
session_start();

if (isset($_SESSION['email'])) {
    // Jika sudah login, lempar kembali ke dashboard/home
    header("Location: dashboard.php"); 
    exit();
}
?>
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
          <input type="text" id="fullname" name="fullname" placeholder="Nama lengkap" required>
          <small id="name-error" style="color:red; display:none; margin-top:5px;">
            Nama hanya boleh berisi huruf dan spasi!
          </small>
        </div>
        <div class="input-group">
          <label>Email</label>
          <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
        </div>
        <div class="input-group">
            <label>No. Whatsapp</label>
            <input type="number" id="whatsapp" name="whatsapp" placeholder="08xxxxxxxxxx" inputmode="numeric" required>
          <small id="wa-error" style="color:red; display:none; margin-top:5px;">
            Nomor minimal 10 digit!
          </small>
        </div>
        <div class="input-group">
          <label>Password</label>
          <input type="password" id="registerPassword" name="password" placeholder="Password" required>
          <span class="password-toggle" onclick="togglePassword('registerPassword')">Tampilkan</span>

          <small id="pw-error" style="color:red; display:none; margin-top:5px;">
            Password minimal 8 karakter!
          </small>
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