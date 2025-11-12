<?php
session_start();
include '../conn.php';

if (!isset($_SESSION['email'])) {
    echo "Anda harus login untuk upload foto.";
    exit();
}

$userEmail = $_SESSION['email']; 

if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
    $targetDir = "../../public/uploads/"; 
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    
    $file = $_FILES["foto_profil"];
    $fileName = basename($file["name"]);
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
    
    // Buat nama file unik
    $newFileName = md5($userEmail . time()) . "." . $fileType;
    $targetFile = $targetDir . $newFileName;

    // Cek tipe file
    $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];
    if (in_array(strtolower($fileType), $allowTypes)) {
        
        // Coba pindahkan file
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            
            // SUKSES! Sekarang simpan nama file ini ke database (rentan SQL Injection)
            $query = "UPDATE user SET foto_profil = '$newFileName' WHERE email = '$userEmail'";
            
            if(mysqli_query($conn, $query)) {
                // Simpan juga ke session
                $_SESSION['foto_profil'] = $newFileName;
                header("Location: ../../public/profile.php");
                exit();
            } else {
                 echo "Gagal update database: " . mysqli_error($conn);
            }

        } else {
            echo "Gagal memindahkan file (cek izin folder 'uploads').";
        }
    } else {
        echo "Hanya file JPG, JPEG, PNG, & GIF yang diizinkan.";
    }
} else {
    echo "Tidak ada file yang diupload atau terjadi error: " . $_FILES['foto_profil']['error'];
}

mysqli_close($conn);
?>