<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - KALC3R</title>
  <link rel="stylesheet" href="css/auth.css">
</head>
<body>
  
  <div class="container">
    <div class="card">
      <h2>Login</h2>
      <form id="loginForm" action="../src/actions/handle_login.php" method="POST" enctype="multipart/form-data">
        <div class="input-group">
          <label>Email</label>
          <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
        </div>
        <div class="input-group">
          <label>Password</label>
          <input type="password" id="loginPassword" name="password" placeholder="Password" required>
          <span class="password-toggle" onclick="togglePassword('loginPassword')">Tampilkan</span>
        </div>
        <button type="submit" class="btn">Login</button>
      </form>
      <p style="font-size:12px; color:#888;">Atau Buat Akun</p>
      <p>Belum memiliki akun? <a href="register.php" style="color:#3aadeb;">Daftar</a></p>
    </div>
  </div>
  
  <script src="js/auth.js"></script>
</body>
</html> 