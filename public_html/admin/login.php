<?php
include '../elems/init.php';
session_start();
$_SESSION['message'] = '';
if (!empty($_POST['login']) and !empty($_POST['password'])) {
    $_SESSION['message'] = null;
    $login = $_POST['login'];
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE login='$login'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $data = []; $row = mysqli_fetch_assoc($result);
    $_SESSION['message'] = '';
    if ($row != '') {
       if (password_verify($password, $row['password'])) {
           $_SESSION['id'] = $row['id'];
           $_SESSION['status'] = $row['status'];
           $_SESSION['auth'] = true;
           $_SESSION['login'] = $login;
           $_SESSION['ban'] = $row['ban'];
           $_SESSION['message'] = null;
           header('Location: /'); die();
       } else {
           $_SESSION['message'] = 'Вы не прошли авторизацию! Проверьте свой логин или пароль!';
       }
    }
    else $_SESSION['message'] = 'Вы не прошли авторизацию! Проверьте свой логин или пароль!';
    $_POST['login'] = '';
    $_POST['password'] = '';
} 
if (empty($_POST['login']) and empty($_POST['password']) or $_POST['login'] == '' or $_POST['password'] == '') { 
echo "<link rel=\"stylesheet\" href=\"style.css\">";
?>
<form action="" method="POST">
    <table align="center" border="0" width="400px" style="margin-top: 300px; border: 1px solid;box-shadow: 5px 5px 20px black; ">
        <tr><td><br></td></tr>
        <tr align="center"><td style="font:bold 16px Arial">Логин: <input type="text" name="login"><br><br></td></tr>
        <tr align="center"><td style="font:bold 16px Arial">Пароль: <input type="password" name="password"><br><br></td></tr>
        <tr align="center"><td><input type="submit" value="Войти"></td><td><td id="tab"><a href="/">Назад</a></td></tr>
    </table>
     <?php
        if (!empty($_SESSION['message'])) {
            echo "<p align=\"center\">{$_SESSION['message']}</p><br><br>"; $_SESSION['message'] = null;
        } else $_SESSION['message'] = null;
    ?>   
</form>   
<?php }