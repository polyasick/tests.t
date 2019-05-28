<?php
error_reporting(-1);
header('Content-Type: text/html; charset=utf-8');
  /*$username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
  $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));*/
  $uslogin = trim(filter_var($_POST['login'], FILTER_SANITIZE_STRING));
  $uspass = trim(filter_var($_POST['pass'], FILTER_SANITIZE_STRING));

  $error = '';
  if(strlen($uslogin) <= 3)
    $error = 'Введите логин';
  else if(strlen($uspass) <= 3)
    $error = 'Введите пароль';

  if($error != '') {
    echo $error;
    exit();
  }

  $hash = "dfghjsbhebjsd";
  $pass = md5($uspass . $hash);

  require_once '../mysqlconnect.php';

  $sql = 'INSERT INTO account (login, pass) VALUES(?, ?)';
  $query = $pdo->prepare($sql);
  $query->execute([$uslogin, $pass]);

  echo 'Готово';
?>
