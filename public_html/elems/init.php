<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
$host = 'localhost';
$user = 'b90693mb_test';
$password = 'LMjH9ktu';
$dbName= 'b90693mb_test';
$link = mysqli_connect($host, $user, $password, $dbName)
    or die(mysqli_error($link));
mysqli_query($link, "SET NAMES 'uf8'");