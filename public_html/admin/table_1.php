<?php
$table .= "<td>";
$query = "SELECT category.name as name, sub_category.name as sub, sub_category.id as id, category.id as d FROM category
           JOIN sub_category ON category.id=sub_category.category_id ORDER BY category.id";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
$table .= "<table border=\"1\" width=\"1000px\" border=\"0\" style=\"border: 1px solid;box-shadow: 5px 5px 20px black; \">";
$str = ''; $q = true; $i = 0; $w = true; $k = 0; $j = -1;
foreach ($data as $elem) {
    if ($elem['name'] != $str) {
        $a[$j] = $k;
        if ($w == false) { $table .= c($data[$j]['d']); }
        if ($q == false and $w == true) { $i = 0; $table .= c($data[$j]['d']); $w = false; } 
        if ($q == true) { $q = false; } 
        $str = $elem['name'];
        $table .= "<tr><td style=\"font:bold 18px Arial;padding: 20px;\">{$elem['name']}</td>";
        $table .= "<td id=\"sub\"><a href=\"/admin/goods.php?id={$elem['id']}\">{$elem['sub']}</a>";
    } else $table .= "<br><a href=\"/admin/goods.php?id={$elem['id']}\">{$elem['sub']}</a>";
    $j++;
}
$table .= c($data[$j]['d']);
$table .= "<tr><form action=\"\" method=\"POST\"><td style=\"text-align:center; padding:10px;\"><br>Категория: &nbsp &nbsp &nbsp&nbsp<input type=\"text\" name=\"cater\"><br><br>";
$table .= "Подкатегория: <input type=\"text\" name=\"category\"><br><br>";
$table .= "<input type=\"submit\" value=\"Добавить категорию\"></form><br>";

function c($i)
{
 $table = "<form action=\"\" method=\"POST\"><td style=\"text-align:center; padding:10px;\"><br><input type=\"text\" name=\"sub\" value=\"\"><br><br>";
$table .= "<input type=\"submit\" value=\"Добавить подкатегорию\" name=\"$i\"></form><br>";
    return $table;
}
