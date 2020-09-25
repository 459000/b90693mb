<?php
include '../elems/init.php';
session_start();
        $_SESSION['message'] = null;  
        $_SESSION['text'] = null;  
        $_SESSION['message'] = null;  
if (!empty($_SESSION['auth']) and !empty($_SESSION['status']) and $_SESSION['status'] == 2) {
function tovar($link)
{
    if (isset($_GET['id']) and $_GET['id'] != '') {
        $id = $_GET['id'];
        echo "<link rel=\"stylesheet\" href=\"style.css\">";
        $query = "SELECT goods.name as name, goods.id as id, goods.image as image,
                   goods.price as price, goods.hit as hit FROM goods
              JOIN sub_category ON goods.category_id=sub_category.id WHERE sub_category.id='$id'
              UNION SELECT sub_category.name as name, 0, 0, 0, 0 FROM sub_category WHERE sub_category.id='$id'
              UNION SELECT category.name as name, 0, 0, 0, 0 FROM category 
              JOIN sub_category ON category.id=sub_category.category_id WHERE sub_category.id='$id'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
        $count = count($data);
        $table = "<table width=\"1300px\" border=\"1\" align=\"center\" style=\"border: 1px solid; box-shadow: 5px 5px 20px black;\">";
        $table .= "<tr><td colspan=\"5\" id=\"t_cat\">Категория: {$data[$count-1]['name']}</td>";
        $table .= "<td id=\"tab\" align=\"right\"><a href=\"/admin/del_cat.php?name={$data[$count-1]['name']}\">!!! Удалить категорию !!!</a></td></tr>";
        $table .= "<tr><td colspan=\"5\" id=\"t_subcat\">Подкатегория: {$data[$count-2]['name']}</td>";
        $table .= "<td id=\"tab\" align=\"right\"><a href=\"/admin/del_sub.php?name={$data[$count-2]['name']}\">!!! Удалить подкатегорию !!!</a></td></tr>";
        $table .= "<tr><td colspan=\"6\" id=\"tab\" height=\"40px\" align=\"center\"><a href=\"/admin/update.php?id=res\">Добавить</a><a style=\"padding-left: 200px;\" href=\"/admin/admin.php\">Вернуться</a></td></tr>";
        $table .= "<tr align=\"center\" style=\"font:bold 16px Arial;\"><td>Товар</td><td>Описание</td><td>Цена</td><td>Редактировать</td><td>Удалить</td><td>Популярность</td></tr>";
        foreach ($data as $elem) {
            if ($elem['name'] != $data[$count-1]['name'] and $elem['name'] != $data[$count-2]['name']) {
                $table .= "<tr align=\"center\"><td><img width=\"100px\" src=\"/admin/image/{$elem['image']}\"></td><td>{$elem['name']}</td><td>{$elem['price']} руб</td><td id=\"tab\"><a href=\"/admin/update.php?id={$elem['id']}_{$data[$count-2]['name']}\">Изменить</a></td><td id=\"tab\"><a href=\"/admin/delete.php?id={$elem['id']}_$id\">Удалить</a></td>";
                if ($elem['hit'] == 0) $text = 'Добавить в  популрное'; else $text = 'Удалить из популярного';
                $table .= "<td id=\"tab\"><a href=\"/admin/hit.php?id={$elem['id']}_$id\">$text</a></td></tr>";
            }
        }
        $table .= "</table>";
        echo $table;
    } else {
        
    }
}

tovar($link);
} else echo 'Доступ запрещен!';