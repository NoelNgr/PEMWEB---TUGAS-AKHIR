<?php
session_start();

if (isset($_SESSION['email']) && $_SESSION['status'] == 'login') {
    header('Location: dashboard.php');
    exit();
} else {
    header('Location: login.php');
    exit();
}
?>