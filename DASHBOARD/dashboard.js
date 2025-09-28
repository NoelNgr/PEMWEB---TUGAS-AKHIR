// Menunggu hingga seluruh konten halaman (DOM) selesai dimuat
document.addEventListener('DOMContentLoaded', function () {
  
  // Mendapatkan elemen-elemen yang diperlukan dari DOM
  const cartButton = document.getElementById('cartButton');
  const closeCartButton = document.getElementById('closeCartButton');
  const cartDrawer = document.getElementById('cartDrawer');

  // Pastikan elemen-elemen tersebut ada sebelum menambahkan event listener
  if (cartButton && closeCartButton && cartDrawer) {
    
    // Event listener untuk tombol keranjang utama
    // Saat diklik, tambahkan kelas 'show' untuk menampilkan side drawer
    cartButton.addEventListener('click', function () {
      cartDrawer.classList.add('show');
    });

    // Event listener untuk tombol 'close' di dalam side drawer
    // Saat diklik, hapus kelas 'show' untuk menyembunyikan side drawer
    closeCartButton.addEventListener('click', function () {
      cartDrawer.classList.remove('show');
    });

    // Event listener pada seluruh dokumen untuk menutup drawer
    // jika pengguna mengklik di luar area drawer
    document.addEventListener('click', function (event) {
      // Cek apakah klik terjadi di luar drawer DAN bukan pada tombol keranjang
      if (!cartDrawer.contains(event.target) && !cartButton.contains(event.target)) {
        cartDrawer.classList.remove('show');
      }
    });
  }
});