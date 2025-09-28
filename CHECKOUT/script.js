document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const nama = this.nama.value.trim();
    const alamat = this.alamat.value.trim();
    const nohp = this.nohp.value.trim();
    if (nama.length < 3) {
        alert('Nama minimal 3 karakter');
        this.nama.focus();
        e.preventDefault();
        return false;
    }
    if (alamat.length < 5) {
        alert('Alamat minimal 5 karakter');
        this.alamat.focus();
        e.preventDefault();
        return false;
    }
    if (!/^[0-9]{10,15}$/.test(nohp)) {
        alert('No HP harus angka 10-15 digit');
        this.nohp.focus();
        e.preventDefault();
        return false;
    }
});