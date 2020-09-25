<?php
session_start();
if (!empty($_GET['id'])) {
    $qw = $_GET['id'];
    $buy = explode('__', $qw);
    if ($_SESSION['count'] == null) $_SESSION['count'] = 0;
    if ($_SESSION['sum_count'] == null) $_SESSION['sum_count'] = 0;
    $_SESSION['goods'] .= ',';
    $_SESSION['goods'] .= $buy['0'];
    $_SESSION['sum_count'] += $buy['1'];
    $_SESSION['count']++;
    if (!empty($_SERVER['HTTP_REFERER'])) $a_uri = $_SERVER['HTTP_REFERER'];
    $a_uri = trim(preg_replace('#^(http://[A_Za-z-_0-9А-Яа-я\.]+)#','',$a_uri),'/');
    header("Location: /$a_uri");
}