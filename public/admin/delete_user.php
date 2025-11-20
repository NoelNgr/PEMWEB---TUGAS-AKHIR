<?php
require_once "../../src/middleware_admin.php";
require_once "../../src/conn.php";

$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM user WHERE id_pelanggan = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: ../../public/admin/users.php");
exit();
