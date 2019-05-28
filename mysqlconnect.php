<?php

$user = 'root';
$password = '';
$db = 'tests';
$host = 'localhost';
#$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dsn = 'mysql:host='.$host.';dbname='.$db;
#$dsn_Option = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
$pdo = new PDO($dsn,$user,$password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));


?>
