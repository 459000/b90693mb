<?php
$header = "<table border=\"0\"><tr>";
$header .= "<td width=\"1000px\"><a id=\"title\"  href=\"/\">Интернет - магазин электроники</a></td>";
if (empty($_SESSION['status'])) $a = ''; else {
    if ($_SESSION['status'] == 2) $a = "href=\"/admin/admin.php\"";
    if ($_SESSION['status'] == 1) $a = "href=\"/admin/profil.php\"";
}
$header .= "<td width=\"80px\"><a $a><img title=\"Оформить заказ\" width=\"60px\" src=\"/elems/picture/buy.gif\"></a></td>";
if (!isset($_SESSION['count'])) $count = 0; else $count = $_SESSION['count'];
if ($count == 1) $text = 'В корзине 1 товар';
if ($count >=2 and $count <=4) $text = 'В корзине '.$count.' товара';
if ($count > 4) $text = 'В корзине '.$count.' товаров';
if ($count == 0) $text = 'В корзине нет товаров'; else $text .= ' на сумму '.$_SESSION['sum_count'].' руб';
$header .= "<td id=\"goods\">$text</td></tr>";
$a = '';
if (!empty($_SESSION['auth'])) {
    $login = $_SESSION['login'];
    if ($_SESSION['ban'] == 1) {
        $text = "Извините, но вы $login забанены";
    } else { 
        $text = "Добро пожаловать, $login"; $a = "href=\"/admin/profil.php\"";
        if ($_SESSION['status'] == 2) $a = "href=\"/admin/admin.php\"";
    }
} else $text = '';
$header .="<tr><td rowspan=\"3\" align=\"center\" id=\"catalog\"><a $a>$text</a></td></tr>";
if ($text == '') {
    $header .= "<tr><td id=\"catalog\"><a href=\"/admin/login.php\" >Войти</a></td><td id=\"catalog\"><a href=\"/admin/register.php\">Регистрация</a></td></tr>";
} else {
    $header .= "<tr><td id=\"catalog\"></td><td id=\"catalog\"><a href=\"/admin/logout.php\">Выйти</a></td></tr>";   
}
$header .= "</table>";