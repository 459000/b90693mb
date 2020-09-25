<?php
include '../elems/init.php';
session_start();
if (!empty($_SESSION['auth']) and !empty($_SESSION['status']) and $_SESSION['status'] == 2) {
    $id = $_GET['id'];
    $str = explode('_', $id);
    $id = $str['0'];
    $query = "SELECT hit FROM goods WHERE id='$id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $data = []; $row = mysqli_fetch_assoc($result)['hit'];
    if ($row == 0) $row = 1; else $row = 0;
    $query = "UPDATE goods SET hit='$row' WHERE id='$id'";
    mysqli_query($link, $query) or die(mysqli_error($link));
    header("Location: /admin/goods.php?id={$str['1']}"); die();
} else echo 'Доступ запрещен!';