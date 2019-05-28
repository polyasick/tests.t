<?php
error_reporting(-1);
header('Content-Type: text/html; charset=utf-8');
  $login = trim(filter_var($_POST['login'], FILTER_SANITIZE_STRING));
  $pass = trim(filter_var($_POST['pass'], FILTER_SANITIZE_STRING));

  $error = '';
  if(strlen($login) <= 3)
    $error = 'Введите логин';
  else if(strlen($pass) <= 3)
    $error = 'Введите пароль';

  if($error != '') {
    echo $error;
    exit();
  }

  $hash = "dfghjsbhebjsd";
  $pass = md5($pass . $hash);

  require_once '../mysqlconnect.php';

  $sql = 'SELECT `id_account` FROM `account` WHERE `login` = :login && `pass` = :pass';
  $query = $pdo->prepare($sql);
  $query->execute(['login' => $login, 'pass' => $pass]);

  $user = $query->fetch(PDO::FETCH_OBJ);
  if($user == NULL)
    echo 'Такого пользователя не существует';
  else {
    setcookie('login', $login, time()+3600*24*30, "/");
    echo 'Готово';
}


?>
