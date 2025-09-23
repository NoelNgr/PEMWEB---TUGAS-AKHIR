<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="container">
    <div class="card">
      <h2>Login</h2>
      <form id="loginForm">
        <div class="input-group">
          <label>Email</label>
          <input type="email" id="email" placeholder="example@gmail.com" required>
        </div>
        <div class="input-group">
          <label>Password</label>
          <input type="password" id="loginPassword" placeholder="Password" required>
          <span class="password-toggle" onclick="togglePassword('loginPassword')"></span>
        </div>
        <div class="checkbox">
          <input type="checkbox" required>
          <label>Saya memahami dan menyetujui <a href="#">KALC3R Terms of Service</a></label>
        </div>
        <button type="submit" class="btn">Login</button>
      </form>
      <div class="social-login">
        <button class="social-btn">Masuk dengan Google</button>
        <button class="social-btn">Masuk dengan Facebook</button>
      </div>
      <p style="font-size:12px; color:#888;">Atau Buat Akun</p>
      <p>Belum memiliki akun? <a href="/PEMWEB---TUGAS-AKHIR/REGISTER/register.php" style="color:#3aadeb;">Daftar</a></p>
    </div>
    
  </div>

  <script src="script.js"></script>
</body>
</html>
