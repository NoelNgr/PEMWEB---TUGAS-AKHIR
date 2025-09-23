document.getElementById('loginForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const email = document.getElementById('email').value; 
  const password = document.getElementById('loginPassword').value; 

  if (email === 'user@gmail.com' && password === '111111') {
    alert('Selamat anda berhasil login');
    window.location.href = '/PEMWEB---TUGAS-AKHIR/DASHBOARD/dashboard.php';
  } else {
    alert('email atau password salah');
  }
});