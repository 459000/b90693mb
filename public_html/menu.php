<?php
include 'elems/init.php';
$query = "SELECT category.name as cat, GROUP_CONCAT(sub_category.name SEPARATOR ',')  as name FROM sub_category
JOIN category ON category.id=sub_category.category_id GROUP BY category.id";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
for ($dan = []; $row = mysqli_fetch_assoc($result); $dan[] = $row);
for ($i = 0; $i < count($dan); $i++) {
    $dan[$i]['name'] = $dan[$i]['name'].',00';
}
$_SESSION['array'] = $dan;