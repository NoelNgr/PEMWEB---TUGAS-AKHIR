<?php 
session_start();

$fullname = $_POST['fullname'] ?? '';
$email = $_POST['email'] ?? '';
$whatsapp = $_POST['whatsapp'] ?? '';
$password = $_POST['password'] ?? '';

if($fullname && $email && $whatsapp && $password){
    $_SESSION['user'] = [
        'fullname' => $fullname,
        'email' => $email,
        'whatsapp' => $whatsapp
    ];

    setcookie('user', $email, time() + 3600, '/');
    setcookie('fullname', $fullname, time() + 3600, '/');
    setcookie('whatsapp', $whatsapp, time() + 3600, '/');
    header('Location:../LOGIN/login.php');
    exit();
} else {
    echo "<script>alert('Registrasi gagal, silakan coba lagi.'); window.location.href='register.php';</script>";
}
?>