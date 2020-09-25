<?php
include '../elems/init.php';
session_start();
if (!empty($_SESSION['auth']) and $_SESSION['ban'] == 0) {
    if (isset($_GET)) {
        $id = explode('_', $_GET['id']);
        $str = explode(',', $_SESSION['goods']);
        $len = count($str);
        for ($i = 0; $i < $len; $i++) {
            if ($str[$i] == $id[0]) { unset($str[$i]); break; }
        }
        $str = implode(',', $str);
        $_SESSION['goods'] = $str;
        $_SESSION['count']--;
        $_SESSION['sum_count'] -= $id[1];
        header("Location: /admin/profil.php");
    } 
} header("Location: /admin/profil.php");