<?php
if (isset($_POST)) {
    if (empty($_POST['sub'])) {
        //$_SESSION['message'] = 'Поле не должно быть пустым';
    } else {
        $sub = $_POST['sub'];
        $arr = array_keys($_POST);
        $p = $arr['1'];
        $query = "INSERT INTO sub_category SET name='$sub', category_id='$p'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        
    }
}