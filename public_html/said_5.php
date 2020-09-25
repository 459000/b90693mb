<?php

if (!isset($_GET['page'])) {
    $page = 1; $k = 1;
}  else {   
    if (substr_count($_GET['page'], 'go')) { 
        $str = explode('_', $_GET['page']);
        $page = $str[1]; 
        $k = $page; 
    } else { 
        $k = 1;
        $page = $_GET['page']; 
        if ($page > 10) {
            $k = $page[0] * 10 + 1;
            if ($page == ($k - 1)) $k = $page - 9;
        }
    }
}
        $p = 4;  //кол-во записей на странице
        $q = $p * ($page - 1);

$count = 0;
$query = "SELECT goods.name as name, goods.id as id, 
           goods.price as price, goods.image as image FROM goods
          JOIN sub_category ON goods.category_id=sub_category.id WHERE sub_category.name='$uri'
           ORDER BY goods.price LIMIT $q,$p";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row); $count = 1;
if (empty($data)) {
    $query = "SELECT goods.name as name, goods.id as id, 
           goods.price as price, goods.image as image FROM goods
          JOIN sub_category ON goods.category_id=sub_category.id 
          JOIN category ON sub_category.category_id=category.id 
          WHERE category.name='$uri' ORDER BY RAND() LIMIT $q,$p";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row); $count = 2;
}
if (empty($data)) {
    $query = "SELECT goods.name as name, goods.id as id, 
           goods.price as price, goods.image as image FROM goods
          JOIN sub_category ON goods.category_id=sub_category.id 
          JOIN category ON sub_category.category_id=category.id WHERE goods.hit=1 LIMIT $q,$p";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row); $count = 3;
}


if ($count == 1) {
   $query = "SELECT COUNT(goods.id) as count FROM goods
          JOIN sub_category ON goods.category_id=sub_category.id WHERE sub_category.name='$uri'"; 
} elseif ($count == 3) {
      $query = "SELECT COUNT(goods.id) as count FROM goods
          JOIN sub_category ON goods.category_id=sub_category.id 
          JOIN category ON sub_category.category_id=category.id WHERE goods.hit=1";  
} elseif ($count == 2) {
        $query = "SELECT COUNT(goods.id) as count FROM goods
          JOIN sub_category ON goods.category_id=sub_category.id 
          JOIN category ON sub_category.category_id=category.id 
          WHERE category.name='$uri'";
} 
        $result = mysqli_query($link, $query) or die(mysqli_error($link)); 
        $count = mysqli_fetch_assoc($result)['count'];  //кол-во записей

        $ss = ceil($count / $p);   //кол-во ссылок
        $pagin = "";

        $j = $k - 10;
if ($k > 10) $pagin .= "<td><a href=\"?page=go_$j\"> < < < </a></td>"; 
$j = 0;
        for ($i = $k; $i <= $ss; $i ++) {
            if ($j == 10) { 
                $pagin .= "<td><a href=\"?page=go_$i\"> > > > </a></td>"; 
                break;
            }         
            $pagin .= "<td><a href=\"?page=$i\"> $i </a></td>";
            $j++;
        }
include 'footer.php';












