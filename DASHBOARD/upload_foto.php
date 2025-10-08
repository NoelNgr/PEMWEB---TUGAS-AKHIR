<?php
session_start();
$user = $_SESSION['user'] ?? '';

// cek apakah file diupload
if (isset($_FILES['foto_profil']) && $user) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir);
    $fileName = $user . "_" . basename($_FILES["foto_profil"]["name"]);
    $targetFile = $targetDir . $fileName;

    // menyimpan file
    if (move_uploaded_file($_FILES["foto_profil"]["tmp_name"], $targetFile)) {
        // menyimpan nama file
        $_SESSION['foto_profil'] = $fileName;
        header("Location: profile.php");
        exit();
    } else {
        echo "Gagal upload file.";
    }
}
?>