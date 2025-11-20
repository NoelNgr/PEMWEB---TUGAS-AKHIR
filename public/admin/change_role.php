<?php
require_once "../../src/middleware_admin.php";
require_once "../../src/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id_pelanggan'] ?? 0);
    $role = $_POST['role'] === 'admin' ? 'admin' : 'user';
    $stmt = $conn->prepare("UPDATE user SET role = ? WHERE id_pelanggan = ?");
    $stmt->bind_param("si", $role, $id);
    $stmt->execute();
    header("Location: ../../public/admin/users.php");
    exit();
}

$id = (int)($_GET['id'] ?? 0);
$user = $conn->query("SELECT * FROM user WHERE id_pelanggan = $id")->fetch_assoc();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ganti Role</title>
</head>

<body>
    <h1>Ganti Role <?= htmlspecialchars($user['fullname']) ?></h1>
    <form method="POST">
        <input type="hidden" name="id_pelanggan" value="<?= $id ?>">
        <select name="role">
            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
        <button type="submit">Simpan</button>
    </form>
    <p><a href="users.php">Kembali</a></p>
</body>

</html>