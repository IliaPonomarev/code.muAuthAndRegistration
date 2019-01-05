<?php
session_start();
$_SESSION['auth'] = null;

$_SESSION['logoutText'] = ['text' => 'your logout successfully'];
header('Location: /1/login.php'); die();
