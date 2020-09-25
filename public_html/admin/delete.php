<?php
include '../elems/init.php';
session_start();
if (isset($_GET['id']) and $_GET['id'] != '' and !empty($_SESSION['auth']) and !empty($_SESSION['status']) and $_SESSION['status'] == 2) {
    $id = $_GET['id'];
    $str = explode('_', $id);
    $id = $str['0'];
    $query = "SELECT image FROM goods WHERE id='$id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $image = mysqli_fetch_assoc($result)['image'];    
    $query = "DELETE FROM goods WHERE id='$id'";
    mysqli_query($link, $query) or die(mysqli_error($link));
    unlink("image/$image");
    header("Location: /admin/goods.php?id={$str['1']}"); die();
} else echo 'Доступ запрещен!';