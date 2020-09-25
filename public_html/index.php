<?php
include 'elems/init.php';
session_start();
if (empty($_SESSION['sum'])) $_SESSION['sum'] = 0;
if (empty($_SESSION['goods'])) $_SESSION['goods'] = '';
if (empty($_SESSION['array'])) include 'menu.php';

$uri = urldecode(trim(preg_replace('#(\?.*)?#', '', $_SERVER['REQUEST_URI']), '/'));


if ($uri == '') {
    $title = 'Главная';
} else {
    $title = $uri;
}


include 'menu_sub.php';
include 'header.php';



include 'content.php';
include 'layout.php';










