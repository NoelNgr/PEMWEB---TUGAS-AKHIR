<?php
session_start();
include '../conn.php';
$fullname = $_POST['fullname'] ;
$email = $_POST['email'];
$whatsapp = $_POST['whatsapp'];
$password = $_POST['password'];

$query = "INSERT INTO user (fullname, email, whatsapp, password) VALUES ('$fullname', '$email', '$whatsapp', '$password')";

if ($fullname == "" || $email == "" || $whatsapp == "" || $password == "") {
       echo "Form tidak boleh kosong!";
       exit();
   } else {
       $cekDuplikat = "SELECT * FROM user WHERE email='$email'";
       $result = mysqli_query($conn, $cekDuplikat);
       if (mysqli_num_rows($result) > 0) {
           echo "<script>alert('email sudah ada, gunakan email lainnya'); window.location='../register/register.php';</script>";
           exit();
       }
   }

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Registrasi berhasil, silakan login.'); window.location.href='../LOGIN/login.php';</script>";
    $_SESSION['user'] = [
        'fullname' => $fullname,
        'email' => $email,
        'whatsapp' => $whatsapp
    ];

    setcookie('user', $email, time() + 3600, '/');
    setcookie('fullname', $fullname, time() + 3600, '/');
    setcookie('whatsapp', $whatsapp, time() + 3600, '/');
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}


mysqli_close($conn);
?>