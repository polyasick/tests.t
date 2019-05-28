<!DOCTYPE html>
<html lang="ru">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <?php
  $website_title = 'Авторизации';
  require 'blocks/head.php';
  ?>
</head>
<body>
  <?php require 'blocks/header.php'; ?>

<main class="container mt-5">
  <div class="row">
    <div class= "col-md-8 mb-3">
      <?php
        ini_set('display_errors','Off');
        if($_COOKIE['login'] == ''):
       ?>
      <h4>Форма авторизации</h4>
      <form action="" method="post">

        <label for="login">Логин</label>
        <input type="login" name="login" id="login" class="form-control">

        <label for="pass">Пароль</label>
        <input type="password" name="pass" id="pass" class="form-control">

        <div class="alert alert-danger mt-2" id="errorBlock2" ></div>

        <button type="button" id="auth_user" class="btn btn-secondary mt-3">
          Войти
        </button>
      </form>
      <?php
        else:
       ?>

       <?php
         endif;
        ?>
  </div>

    <?php# require 'blocks/aside.php'; ?>

  </div>
 </main>

<?php require 'blocks/footer.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<script>
  $('#auth_user').click(function() {
    var login = $('#login').val();
    var pass = $('#pass').val();

    $.ajax({
      url: 'ajax/auth.php',
      type: 'POST',
      cache: false,
      data: {'login' : login, 'pass' : pass},
      dataType: 'html',
      success: function(data) {
        if(data == 'Готово') {
          $('#auth_user').text('Готово');
          $('#errorBlock2').hide();
          document.location.href = "../users.php";
        }
        else {
          $('#errorBlock2').show();
          $('#errorBlock2').text(data);
        }
      }
    });
  });
</script>

</body>
</html>
