<?php
include '../elems/init.php';
session_start();
if (!empty($_GET['name']) and !empty($_SESSION['auth']) and !empty($_SESSION['status']) and $_SESSION['status'] == 2) {
    $name = $_GET['name'];
    $query = "SELECT COUNT(sub_category.category_id) as count FROM sub_category 
                  JOIN category ON sub_category.category_id=category.id WHERE sub_category.category_id=
                  (SELECT category_id FROM sub_category WHERE name='$name')";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $count = mysqli_fetch_assoc($result)['count'];
    if ($count == 1) {
        $query = "DELETE FROM category WHERE id=(SELECT category_id FROM sub_category WHERE name='$name')";
        mysqli_query($link, $query) or die(mysqli_error($link)); 
    }
    $query = "SELECT goods.image as image FROM goods 
              JOIN sub_category ON goods.category_id=sub_category.id WHERE sub_category.name='$name'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    foreach ($data as $elem) {
        unlink("image/{$elem['image']}");
    }
    $query = "DELETE FROM goods WHERE category_id=(SELECT DISTINCT id FROM sub_category WHERE name='$name')";
    mysqli_query($link, $query) or die(mysqli_error($link));   
    $query = "DELETE FROM sub_category WHERE name='$name'";
    mysqli_query($link, $query) or die(mysqli_error($link));  
    $_SESSION['array'] = null;
    $_SESSION['submenu'] = null;
    header("Location: /admin/admin.php"); die();
} else {
    echo 'Доступ запрещен!';
}