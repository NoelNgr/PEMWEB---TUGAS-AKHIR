<?php
session_start();
session_unset();
session_destroy();

// Hapus cookie dengan path '/'
setcookie('user', '', time() - 3600, '/');
setcookie('fullname', '', time() - 3600, '/');
setcookie('whatsapp', '', time() - 3600, '/');

// Redirect ke halaman login di folder public
header('Location: ../../public/login.php');
exit();
?>