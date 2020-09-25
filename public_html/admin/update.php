<?php
include '../elems/init.php';
session_start();
if (!empty($_SESSION['auth']) and !empty($_SESSION['status']) and $_SESSION['status'] == 2) {
if (isset($_POST) and !empty($_POST)) {
    if (empty($_POST['file']) or empty($_POST['text']) or empty($_POST['price']) or empty($_POST['cater'])) {
        $_SESSION['file'] = $_POST['file'];
        $_SESSION['text'] = $_POST['text'];
        $_SESSION['price'] = $_POST['price'];
        $_SESSION['cater'] = $_POST['cater'];
        $_SESSION['message'] = 'Пожалуйста заполните все поля!';
        echo "<meta http-equiv=\"refresh\">";
    } else {
        $file = $_POST['file']; 
        $text = $_POST['text'];
        $price = $_POST['price'];
        $cater = $_POST['cater'];
        if (!empty($_SESSION['id']) and $_SESSION['id'] != 0) {
            $id = $_SESSION['id'];
            $query = "UPDATE goods SET name='$text', image='$file', price='$price', 
            category_id=(SELECT id FROM sub_category WHERE name='$cater'), hit=0 WHERE id='$id'";
            mysqli_query($link, $query) or die(mysqli_error($link));
            $_SESSION['cater'] = $cater;
            $_SESSION['message'] = 'Данные были изменены';
        } else {
            $query = "INSERT INTO goods (name, image, price, category_id, hit) VALUES 
            ('$text', '$file', '$price', (SELECT id FROM sub_category WHERE name='$cater'), 0)";
            mysqli_query($link, $query) or die(mysqli_error($link));
            $_SESSION['cater'] = $cater;
            $_SESSION['message'] = 'Товар добавлен!'; 
        }
    }
} else {
    
}
if (isset($_GET['id']) and $_GET['id'] != '') {
    $id = $_GET['id'];
    if ($id != 'res') {
        $id = $_GET['id'];
        $str = explode('_', $id);
        $id = $str['0'];
        $razdel = $str['1'];
        $query = "SELECT * FROM goods WHERE id='$id'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        $pos1 = "<img width=\"100px\" src=\"/admin/image/{$data['0']['image']}\"><br>";
        $pos2 = "<input style=\"width:400px;\" type=\"text\" value=\"";
        if (!empty($_SESSION['text'])) $pos2 .= $_SESSION['text']; else $pos2 .= $data['0']['name'];
        $pos2 .= "\" name=\"text\">";
        $pos3 = "<input type=\"text\" value=\"";
        if (!empty($_SESSION['price'])) $pos3 .= $_SESSION['price']; else $pos3 .= $data['0']['price'];
        $pos3 .= "\" name=\"price\"";
        $pos4 = 'Применить изменения';
    } else {
        $id = 0;
        $razdel = '';
        $pos1 = '';
        $pos2 = "<input style=\"width:200px;\" type=\"text\" name=\"text\" value=\"";
        if (!empty($_SESSION['text'])) $pos2 .= $_SESSION['text']; else $pos2 .= '';
        $pos2 .= "\">";
        $pos3 = "<input type=\"text\" name=\"price\" value=\"";
        if (!empty($_SESSION['price'])) $pos3 .= $_SESSION['price']; else $pos3 .= '';
        $pos3 .= "\">";
        $pos4 = 'Добавить товар';
    }
    $_SESSION['id'] = $id;
    $pos1 .= "<input type=\"file\" name=\"file\">";
    echo "<link rel=\"stylesheet\" href=\"style.css\">";
    $table = "<form action=\"\" method=\"POST\"><table width=\"1300px\" border=\"1\" align=\"center\" style=\"border: 1px solid; box-shadow: 5px 5px 20px black;\">";
    if (!empty($_SESSION['cater'])) {
        $query = "SELECT id FROM sub_category WHERE name='{$_SESSION['cater']}'";
        
    } elseif ($razdel != '') $query = "SELECT id FROM sub_category WHERE name='$razdel'";
        else {
        $query = "SELECT id FROM sub_category WHERE id=1";     
    }
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        $row = mysqli_fetch_assoc($result)['id'];    
    $table .= "<tr><td colspan=\"3\" id=\"tab\" height=\"40px\" align=\"right\"><a style=\"padding-right: 200px;\" href=\"/admin/goods.php?id=$row\">Вернуться</a></td></tr>";
    $table .= "<tr align=\"center\" style=\"font:bold 16px Arial;\"><td>Товар</td><td>Описание</td><td>Цена</td></tr>";
    $table .= "<tr align=\"center\" height=\"50px\"><td>$pos1</td><td>$pos2</td><td>$pos3</td></tr>";
    $table .= "</table>";
    echo $table.'<br><br>';
    $table = "<table width=\"1300px\" border=\"1\" align=\"center\" style=\"border: 1px solid; box-shadow: 5px 5px 20px black;\">";
    $query = "SELECT name, 0 FROM sub_category";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    $table .= "<tr><td><select style=\"font: 16px Arial;\" value=\"Смартфоны\" name=\"cater\">";
    if (!empty($_SESSION['cater'])) $razdel = $_SESSION['cater'];
    foreach ($data as $elem) {
            if ($elem['name'] == $razdel) $text = "selected"; else $text = ""; 
            $table .= "<option $text>{$elem['name']}</option>";
    }
    $table .= "</select></td><td><input type=\"submit\" value=\"$pos4\"></td></tr>";
    if (!empty($_SESSION['message'])) {
        $table .= "<tr><td colspan=\"2\" style=\"font: bold 16px Arial;\">{$_SESSION['message']}</td></tr>";
        $_SESSION['message'] = null;
    }
    $table .= "</table></form>";
    echo $table;
}
} else echo 'Доступ запрещен!';
