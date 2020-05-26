<?php
session_start();
$_SESSION = array();
session_destroy();
setcookie('connected', 'FALSE', strtotime('+ 3 days'), '/');

header('location:../index.php?p=acceuil');
?>