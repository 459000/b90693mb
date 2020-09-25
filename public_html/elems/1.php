<?php
$a_uri = 'http://project-4/Обслуживание и эксплуатация';
echo preg_replace('#^(http://[A_Za-z-_0-9А-Яа-я]+)#','',$a_uri);echo preg_replace('#^(http://[A_Za-z-_0-9А-Яа-я]+)#','',$a_uri);
if (!empty($_SERVER['HTTP_REFERER'])) $a_uri = urldecode($_SERVER['HTTP_REFERER']);
$a_uri = trim(preg_replace('#^(http://[A_Za-z-_0-9А-Яа-я]+)#','',$a_uri),'/');