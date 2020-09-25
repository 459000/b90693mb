<?php
include '../elems/init.php';
session_start();
if (!empty($_SESSION['auth']) and $_SESSION['ban'] == 0) {
    if (isset($_POST) and !empty($_POST)) {
        $id = $_SESSION['id'];
        buy($link, $_POST, $id);
    }
    $goods = '';
    if(!empty($_SESSION['goods'])) {
        $str = trim($_SESSION['goods'], ',');
        $array = explode(',', $str);
        $query = "SELECT * FROM goods WHERE id IN ($str)";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        $goods = ''; $summa = 0;
        foreach ($data as $elem) {
            $con = c($array, $elem['id']);
            $goods .= "<tr id=\"buy\" align=\"center\"><td>Кол-во: $con</td>";
            if ($con > 1) $text = $con.'__'.$elem['id'].'__'.$elem['price']; else $text = $elem['id'].'__'.$elem['price'];
            $goods .= "<td><input type=\"checkbox\" name=\"text[]\" value=\"$text\"></td>";
            $goods .= "<td><img width=\"100px\" src=\"/admin/image/{$elem['image']}\"></td>";
            $goods .= "<td>{$elem['name']}</td>";
            $sum = $elem['price'] * $con;
            $summa += $sum;
            $goods .= "<td>$sum</td>";
            $goods .= "<td id=\"tab\"><a href=\"/admin/del_goods.php?id={$elem['id']}_{$elem['price']}\">Удалить</a></td></tr>";
        }
    } else {
}
    echo "<link rel=\"stylesheet\" href=\"style.css\">";
    $table = "<form action=\"\" method=\"POST\"><table align=\"center\" border=\"1\" width=\"1400px\" border=\"0\" style=\"border: 1px solid;box-shadow: 5px 5px 20px black; \">";
    $table .= "<tr height=\"40px\" align=\"center\"><td colspan=\"6\" style=\"font:bold 20px Arial;\">Пользователи<span id=\"tab\"><a style=\"padding-left: 300px;\" href=\"/\">Вернуться</a></span></td></tr>";
    $table .= $goods;
    if (isset($summa)) $sum = $summa.' руб'; else $sum = '';
    $table .= "<tr><td colspan=\"6\" id=\"buy\" align=\"right\" height=\"60px\">Общая сумма: $sum</td></tr>";
    $table .= "<tr><td colspan=\"6\" id=\"buy\" align=\"right\" height=\"60px\">Отметьте нужные вам товары и нажмите купить<span style=\"padding-left: 60px;\"></span><input type=\"submit\" value=\"Купить\" style=\"width: 160px; height: 40px;\"></td></tr>";
    $table .= "</table><br><br></form>"; echo $table;
    $goods = '';
        $table = "<table align=\"center\" border=\"1\" width=\"1200px\" border=\"0\" style=\"border: 1px solid;box-shadow: 5px 5px 20px black; \">";
    $table .= "<tr height=\"40px\" align=\"center\"><td colspan=\"6\" style=\"font:bold 20px Arial;\">Список ваших покупок</td></tr>";
    $id = $_SESSION['id'];
        $query = "SELECT goods.name as name, goods.id as id, buy_goods.price as price, 
                   goods.image as image, buy_goods.date as date FROM goods
                  JOIN buy_goods ON goods.id=buy_goods.goods_id
                  JOIN users ON buy_goods.users_id=users.id WHERE users.id='$id' ORDER BY buy_goods.date DESC";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        foreach ($data as $elem) {
            $goods .= "<tr id=\"buy\" align=\"center\"><td>{$elem['date']}</td>";
            $goods .= "<td><img width=\"100px\" src=\"/admin/image/{$elem['image']}\"></td>";
            $goods .= "<td>{$elem['name']}</td>";
            $goods .= "<td>{$elem['price']}</td></tr>";
        }    
    $table .= $goods;
    $table .= "</table>";
    echo $table;
} else {
    header("Location: /");
}

function c($array, $elem)
{
    $i = 0;
       foreach ($array as $q) {
           if ($elem == $q) $i++;
       }
    return $i;    
}

function buy($link, $POST, $id)
{
    $value = '';
    foreach ($POST as $elem) {
        foreach ($elem as $q) {
        $con = substr_count($q, '__');
        if ($con == 2) {
            $str = explode('__', $q);
            for ($i = 1; $i <= $con; $i++) {
                $value .= ",($id, $str[1], $str[2], NOW())";
            }
        } else {
            $str = explode('__', $q);
            $value .= ",($id, $str[0], $str[1], NOW())";
        }
        }
    }
    $value = trim($value, ',');
    $query = "INSERT INTO buy_goods (users_id, goods_id, price, date) VALUES $value";
    mysqli_query($link, $query) or die(mysqli_error($link));
    $_SESSION['goods'] = null;
    $_SESSION['sum'] = null;
    $_SESSION['sum_count'] = null;
}
















