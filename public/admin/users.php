<?php
require_once "../../src/middleware_admin.php";
require_once "../../src/conn.php";

// Proses update role
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id_pelanggan'] ?? 0);
    $role = $_POST['role'] === 'admin' ? 'admin' : 'user';
    $stmt = $conn->prepare("UPDATE user SET role = ? WHERE id_pelanggan = ?");
    $stmt->bind_param("si", $role, $id);
    $stmt->execute();
    header("Location: users.php"); // reload halaman setelah submit
    exit();
}

$users = $conn->query("SELECT * FROM user ORDER BY id_pelanggan DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Kelola User</title>
<link rel="stylesheet" href="../css/users_admin.css" />
</head>
<body>

<h1>Daftar User</h1>
<a href="index.php" class="button back-btn">← Back</a>

<table>
<tr>
<th>Nama</th>
<th>Email</th>
<th>WA</th>
<th>Role</th>
<th>Aksi</th>
</tr>

<?php while($r = $users->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($r['fullname']) ?></td>
<td><?= htmlspecialchars($r['email']) ?></td>
<td><?= htmlspecialchars($r['whatsapp']) ?></td>
<td><?= htmlspecialchars($r['role']) ?></td>
<td>
    <a href="#" class="button" onclick="openModal(<?= $r['id_pelanggan'] ?>, '<?= $r['fullname'] ?>', '<?= $r['role'] ?>')">Ganti Role</a>
    <a href="delete_user.php?id=<?= $r['id_pelanggan'] ?>" class="button" onclick="return confirm('Hapus user ini?')">Hapus</a>
</td>
</tr>
<?php endwhile; ?>
</table>

<!-- Modal -->
<div id="roleModal" class="modal">
<div class="modal-content">
    <span class="close-btn" onclick="closeModal()">×</span>
    <h2 id="modalTitle">Ganti Role</h2>
    <form method="POST">
        <input type="hidden" name="id_pelanggan" id="modalUserId">
        <select name="role" id="modalRole">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit">Simpan</button>
    </form>
</div>
</div>

<script>
function openModal(id, name, role) {
    document.getElementById('modalUserId').value = id;
    document.getElementById('modalTitle').textContent = 'Ganti Role ' + name;
    document.getElementById('modalRole').value = role;
    document.getElementById('roleModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('roleModal').style.display = 'none';
}

// Tutup modal jika klik di luar konten
window.onclick = function(e) {
    if(e.target == document.getElementById('roleModal')) {
        closeModal();
    }
}
</script>

</body>
</html>
