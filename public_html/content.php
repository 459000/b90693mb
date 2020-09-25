<?php
$content = '<br>';
$content .= "<table border=\"0\" style=\"margin-left: 10px;\" cellpadding=\"10px\">";
include 'said_5.php';
if ($uri == '') $text = 'Популярные товары'; else $text = $uri;
$content .= "<tr><td colspan=\"4\" id=\"zag\">$text<p></p></td></tr>";
$i = 1;
foreach ($data as $elem) {
    if ($i == 1) $contet = '<tr align=\"center\">';
    $content .= "<td width=\"250px\"><table cellpadding=\"10px\" border=\"0\"><tr align=\"center\"><td colspan=\"2\"><img width=\"120px\" src=\"/admin/image/{$elem['image']}\"></td></tr>";
    $content .= "<tr align=\"center\"><td colspan=\"2\" style=\"font:16px Arial;\" height=\"50px\">{$elem['name']}</td></tr>";
    $content .= "<tr align=\"center\" id=\"text\"><td>{$elem['price']}, руб</td>";
    $content .= "<td id=\"buy\"><a href=\"/elems/buy.php?id={$elem['id']}__{$elem['price']}\">Купить</a></td></tr></table>";
    $i++;
    if ($i == 4) { $content .= "</tr><tr><td></td></tr>"; $i = 1; }
}
$content .= "</table>";