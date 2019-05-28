<!DOCTYPE html>
<html lang="ru">
<head>
<?php
$website_title = 'Tests';

require 'blocks/head.php'; ?>
</head>
<body>
  <?php

  require 'blocks/header.php';
  ?>

<main class="container mt-5">
  <div class="row">
    <div class= "jumbotron col-md-8 mb-2 ">
      <h3><b>КАКИЕ ВОЗМОЖНОСТИ?</b></h3>
      <h6 class = "dline">Для учеников:
        <ul>
          <li>выбор дисциплины;</li>
          <li>выбор теста;</li>
          <li>прохождение тестов (есть 3 попытки);</li>
        </ul>

        Для учителей:
          <ul>
            <li>просмотр результатов;</li>
            <li>внесение новых тестов в систему;</li>

          </ul>
      </h6>

<div class="jumbotron">
<h3 align="center">ДЛЯ ПРОХОЖДЕНИЯ ТЕСТОВ И ПРОСМОТРА РЕЗУЛЬТАТОВ НЕОБХОДИМО АВТОРИЗОВАТЬСЯ В СИСТЕМЕ!</h3>
<h3 align="center">В шапке сайта нажмите на кнопку "Войти"</h3>
</div>


    </div>

    <aside class="col-md-4">
      <div class = "p-3 mb-3" style="background-color: #98A4B3">
        <h4><b>Что это за сайт?</b></h4>
        <p>Данный сайт предназначен для учеников школы,
          которые могут пройти тесты по учебным дисциплинам и
          закрепить знания.
          Учителя имеют возможность проверить знани учеников.
      </p>
       </div> <!--отступы примерно 30 пк-->

       <div class= "p-3 mb-3">
         <img class="img-thumbnail" src = "http://risovach.ru/upload/2017/02/mem/kot-kotoryy-videl-uzhasnye-vecshi_138726242_orig_.jpg">
       </div>
     </aside>

   </div>
 </main>

<?php require 'blocks/footer.php'; ?>

</body>
</html>
