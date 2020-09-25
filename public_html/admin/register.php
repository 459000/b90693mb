<?php
include '../elems/init.php';
session_start();
$_SESSION['message'] = '';
function do_regis($link) 
{
if (isset($_POST['login']) and isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $p_pass = $_POST['p_pass'];
    $_SESSION['message'] = ''; $regis = true; 
    if ($login == '') {
        $_SESSION['message'] = 'Поле логин пустое'; $regis = false;
    }   
    if ($password == '') {
        $_SESSION['message'] = 'Поле пароль пустое'; $regis = false;
    }     
    if ($p_pass == '') {
        $_SESSION['message'] = 'Поле пароль пустое'; $regis = false;
    } 
    if ($password != $p_pass) {
        $_SESSION['message'] = 'Поле не совпадает с паролем'; $regis = false;
    }
    $query = "SELECT id FROM users WHERE login='$login'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $data = []; $row = mysqli_fetch_assoc($result)['id'];
    if ($row != '') {
        $regis = false;
        $_SESSION['message'] = 'Такой логин уже занят';
    }
    if ($regis) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (login, password, status, ban) VALUES ('$login', '$password', 1, 0)";
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['id'] = mysqli_insert_id($link);
        $_SESSION['status'] = 1;
        $_SESSION['auth'] = true;
        $_SESSION['login'] = $login;
        $_SESSION['ban'] = 0;
        $_SESSION['message'] = null;
        header('Location: /'); die();
    }
    if (!$regis) {
        form_regis();
    }
}
}
function input($type, $name, $place)
{
    if (!empty($_POST[$name]) and $type != 'password') $value = $_POST[$name]; else $value = '';   
    return "<input type=\"$type\" name=\"$name\" placeholder=\"$place\" value=\"$value\"><br><br>";
}
function form_regis()
{ 
    echo "<link rel=\"stylesheet\" href=\"style.css\">";
    if (!isset($_SESSION['message'])) $_SESSION['message'] = '';
?>
<form action="" method="POST" style="margin: 200px auto; text-align: center;">
    <table align="center" border="0" width="500px" style="margin-top: 300px; border: 1px solid;box-shadow: 5px 5px 20px black; ">
        <tr><td align="center"><br></td></tr>
        <tr align="center"><td style="font:bold 16px Arial"><?php  echo "Логин:  </td><td colspan=\"2\"><br>".input('text', 'login', 'login'); ?></td></tr>
        <tr align="center"><td style="font:bold 16px Arial"><?php  echo "Пароль: </td><td colspan=\"2\"><br>".input('password', 'password', ''); ?></td></tr>
        <tr align="center"><td style="font:bold 16px Arial"><?php  echo "Повторите пароль: </td><td colspan=\"2\"><br>".input('password', 'p_pass', ''); ?></td></tr>
        <tr align="center"><td><br><input type="submit" value="Зарегистрироваться"><br><br></td><td><td id="tab"><a href="/">Назад</a><br></td></tr>
    </table>
    <p align="center"><?php if (!empty($_SESSION['message'])) { echo $_SESSION['message']; $_SESSION['message'] == null; } ?></p>
</form>
<?php 
}
if (!isset($_POST['login'])) form_regis();
do_regis($link);