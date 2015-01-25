<?php
session_start();
$_SESSION['co'] = 0;
unset($_SESSION['id']);
header('location: index.php');
?>