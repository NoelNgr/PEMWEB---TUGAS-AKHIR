<?php
session_start();
session_unset();
session_destroy();
setcookie('user', '', time() - 3600, '/');
setcookie('fullname', '', time() - 3600, '/');
setcookie('whatsapp', '', time() - 3600, '/');
<<<<<<< HEAD
header('Location:../LOGIN/login.php');
=======
header('Location: /PEMWEB---TUGAS-AKHIR/LOGIN/login.php');
>>>>>>> 3002a57dfa0314eed99dbfdb793fbbabd27792a0
exit();