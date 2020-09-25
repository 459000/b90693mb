<?php
include '../elems/init.php';
session_start();
if (isset($_POST)) {
    if (empty($_POST['sub'])) {
        //$_SESSION['message'] = 'Поле не должно быть пустым';
    } else {
        $sub = $_POST['sub'];
        $arr = array_keys($_POST);
        $p = $arr['1'];
        $query = "INSERT INTO sub_category SET name='$sub', category_id='$p'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['array'] = null;
        $_SESSION['submenu'] = null;
        header("Location: /admin/admin.php");
    }
    if (!empty($_POST['cater']) and !empty($_POST['category'])) {
        $cater = $_POST['cater'];
        $category = $_POST['category'];
        $query = "INSERT INTO category SET name='$cater'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $query = "INSERT INTO sub_category SET name='$category', category_id=
        (SELECT DISTINCT id FROM category WHERE name='$cater')";
        mysqli_query($link, $query) or die(mysqli_error($link));        
        $_SESSION['array'] = null;
        $_SESSION['submenu'] = null;       
        header("Location: /admin/admin.php");
    }
}

if (!empty($_SESSION['auth']) and !empty($_SESSION['status']) and $_SESSION['status'] == 2) {
    table($link);
} else {
    echo 'Доступ запрещен!';
}

function table($link)
{
    echo "<link rel=\"stylesheet\" href=\"style.css\">";
    $table = "<form action=\"\" method=\"POST\"><table border=\"0\" width=\"1000px\" align=\"center\" id=\"table\">";
    $table .= "<tr><td colspan=\"2\" id=\"title\">Управление сайтом</td>";
    $table .= "<td colspan=\"3\" id=\"tab\"><a href=\"/\">Вернуться</a></tr>";
    $table .= "<tr><td id=\"goods\">Товары</td>";
    include 'table_1.php';
    $table .= "<td colspan=\"2\" align=\"center\" id=\"buy_user\"><a href=\"/admin/users.php\">Покупатели</a>";
    $table .= "<a id=\"static\" href=\"/admin/static.php\">Статистика покупок</a></td></tr>";
    $table .= '</table>';
    $table .= "</table></form>";
    echo $table;
}