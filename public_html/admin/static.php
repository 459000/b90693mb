<?php
include '../elems/init.php';
session_start();
if (!empty($_SESSION['auth']) and !empty($_SESSION['status']) and $_SESSION['status'] == 2) {
    $query = "SELECT DATE_FORMAT(date, '%Y - %m') as date, SUM(price) as sum FROM buy_goods GROUP BY DATE_FORMAT(date, '%m'), 
      DATE_FORMAT(date, '%Y') ORDER BY date DESC";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    echo "<link rel=\"stylesheet\" href=\"style.css\">";
    $table = "<table align=\"center\" border=\"1\" width=\"1200px\" border=\"0\" style=\"border: 1px solid;box-shadow: 5px 5px 20px black; \">";
    $table .= "<tr height=\"40px\" align=\"center\"><td colspan=\"6\" style=\"font:bold 20px Arial;\">Статистика продаж<span id=\"tab\"><a style=\"padding-left: 200px;\" href=\"/admin/admin.php\">Вернуться</a></span></td></tr>";
    $table .= "<tr height=\"40px\" style=\"font:bold 16px Arial;\" align=\"center\"><td>Год - Месяц</td>";
    $table .= "<td>Сумма, руб</td></tr>";
    foreach ($data as $elem) {
        $table .= "<tr height=\"40px\" align=\"center\"><td>{$elem['date']}</td>";
        $table .= "<td>{$elem['sum']}</td></tr>";
    }
    $table .= "</table>";
    echo $table;
} else echo 'Доступ запрещен!';