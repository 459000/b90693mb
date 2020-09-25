<?php
include '../elems/init.php';
session_start();
if (!empty($_SESSION['auth']) and !empty($_SESSION['status']) and $_SESSION['status'] == 2) {
    $query = "SELECT users.login as login, users.id as id, users.ban as ban, statuses.status as status FROM users
             JOIN statuses ON users.status=statuses.id WHERE users.login!='admin'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    echo "<link rel=\"stylesheet\" href=\"style.css\">";
    $table = "<table align=\"center\" border=\"1\" width=\"1200px\" border=\"0\" style=\"border: 1px solid;box-shadow: 5px 5px 20px black; \">";
    $table .= "<tr height=\"40px\" align=\"center\"><td colspan=\"6\" style=\"font:bold 20px Arial;\">Пользователи<span id=\"tab\"><a style=\"padding-left: 300px;\" href=\"/admin/admin.php\">Вернуться</a></span></td></tr>";
    $table .= "<tr height=\"40px\" style=\"font:bold 16px Arial;\" align=\"center\"><td>Логин</td>";
    $table .= "<td>Статус</td>";
    $table .= "<td>Изменить статус</td>";
    $table .= "<td>Состояние</td>";
    $table .= "<td>Изменить</td>";
    $table .= "<td>Удалить</td>";
    foreach ($data as $elem) {
        $table .= "<tr height=\"40px\" align=\"center\"><td>{$elem['login']}</td>";
        $table .= "<td>{$elem['status']}</td>";
        if ($elem['status'] == 'admin') $text = 'Изменить на user'; else $text = 'Изменить на admin';
        $table .= "<td id=\"tab\"><a href=\"/admin/status.php?id={$elem['id']}\">$text</a></td>";
        if ($elem['ban'] == 0) $text = 'Не забанен'; else $text = 'Забанен';
        $table .= "<td>$text</td>";
        if ($text == 'Не забанен') $text = 'Забанить'; else $text = 'Разбанить';
        $table .= "<td id=\"tab\"><a href=\"/admin/ban.php?id={$elem['id']}\">$text</a></td>";
        $table .= "<td id=\"tab\"><a href=\"/admin/del_user.php?id={$elem['id']}\">Удалить</a></td>";
    }
    $table .= "</table>";
    echo $table;
} else {
    echo 'Доступ запрещен!';
}