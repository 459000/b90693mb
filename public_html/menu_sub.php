<?php
$data = $_SESSION['array'];
$menu = open_close($data, $uri);
$_SESSION['menu'] = $menu;
function open_close($data, $uri)
{
    $str = '';
    $menu = "<table cellpadding=\"10\" id=\"table\"><tr><td id=\"tovar\">Каталог товаров</td></tr>";
    $len =  count($data);
    if ($uri != '') {
    for ($i = 0; $i < $len; $i++) {
        if ($data[$i]['cat'] == $uri and substr_count($data[$i]['name'], ',00')) {
            $data[$i]['name'] = str_replace(',00', ',11', $data[$i]['name']);
            $str = 'open';
            for ($j = 0; $j < $len; $j++) {
                if ($data[$i]['name'] != $data[$j]['name']) {
                    $data[$j]['name'] = str_replace(',11', ',00', $data[$j]['name']);
                }
            }
        } elseif ($data[$i]['cat'] == $uri and substr_count($data[$i]['name'], ',11')) {
            $data[$i]['name'] = str_replace(',11', ',00', $data[$i]['name']);
            $str = 'close';
        } elseif (substr_count($data[$i]['name'], $uri) or !empty($_GET['page'])) {
            if (!empty($_SESSION['submenu'])) return $_SESSION['submenu'];
        }        
    }
    }
    if ($str == 'open') {
        $sub_menu = '';
        foreach ($data as $elem) {
            if ($uri != $elem['cat']) $menu .= "<tr><td id=\"catalog\"><a href=\"{$elem['cat']}\">{$elem['cat']}</a>";
            if ($uri == $elem['cat']) { 
                $menu .= "<tr><td id=\"catalog\"><a href=\"{$elem['cat']}\">{$elem['cat']}</a>";
                $sub_menu = "<table cellpadding=\"10\" id=\"sub\">";
                $array = explode(',', $elem['name']);
                foreach ($array as $a) {
                    if ($a != '11' and $a != '00') $sub_menu .= "<tr><td id=\"sub_cat\"><a href=\"$a\">$a</a></td></tr>";
                }   
                $sub_menu .= "</table>";
                $menu .= $sub_menu;
            } 
            $menu .= "</td></tr>";
        }
        $menu .= "</table>";
        $_SESSION['submenu'] = $menu;
    }
    if ($str == '' or $str == 'close') {
        foreach ($data as $elem) {
            $menu .= "<tr><td id=\"catalog\"><a href=\"{$elem['cat']}\">{$elem['cat']}</a>";
            $menu .= "</td></tr>";
        }
        $menu .= "</table>";
    }
    $_SESSION['array'] = $data;
    return $menu;
}


















