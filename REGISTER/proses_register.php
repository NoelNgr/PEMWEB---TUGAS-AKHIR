<?php
session_start();

$fullname = $_POST['fullname'] ?? '';
$email = $_POST['email'] ?? '';
$whatsapp = $_POST['whatsapp'] ?? '';
$password = $_POST['password'] ?? '';

if ($fullname && $email && $whatsapp && $password) {
    $_SESSION['user'] = [
        'fullname' => $fullname,
        'email' => $email,
        'whatsapp' => $whatsapp
    ];

    setcookie('user', $email, time() + 3600, '/');
    setcookie('fullname', $fullname, time() + 3600, '/');
    setcookie('whatsapp', $whatsapp, time() + 3600, '/');

    $filepath = __DIR__ . '/dataregis.txt';
    $myFile = fopen($filepath, 'a');
    fwrite($myFile, "Fullname: $fullname | Email: $email | WhatsApp: $whatsapp | Password: $password\n");
    fclose($myFile);

    echo "<script>alert('Registrasi berhasil, silakan login.'); window.location.href='../LOGIN/login.php';</script>";
    exit();
} else {
    echo "<script>alert('Registrasi gagal, silakan coba lagi.'); window.location.href='register.php';</script>";
}
