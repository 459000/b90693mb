<?php    
session_start();
$_SESSION['status'] = null;
$_SESSION['auth'] = null;
$_SESSION['id'] = null;
$_SESSION['login'] = null;
$_SESSION['ban'] = null;
$_SESSION['goods'] = null;
$_SESSION['count'] = null;
$_SESSION['sum_count'] = null;
header('Location: /'); die();