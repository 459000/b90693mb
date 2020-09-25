<?php
session_start();
include '../elems/init.php';
if (!empty($_GET['id']) and !empty($_SESSION['auth']) and !empty($_SESSION['status']) and $_SESSION['status'] == 2) {
    $id = $_GET['id'];
    $query = "DELETE FROM users WHERE id='$id'";
    mysqli_query($link, $query) or die(mysqli_error($link));
    header("Location: /admin/users.php");
} else echo 'Доступ запрещен!';