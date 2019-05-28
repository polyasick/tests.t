<!DOCTYPE html>
<html lang="ru">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <?php
  $website_title = 'Просмотр списка тестов';
  require 'blocks/head.php';
  ?>
</head>
<body>
  <?php require 'blocks/header.php'; ?>

<main class="container mt-5">
  <div class="row">
    <div class= "col-md-8 mb-3">
      <h4>Все тесты, которые указаны в учебном плане.</h4>

      <?php
     require_once 'mysqlconnect.php';
     ini_set('display_errors','Off');
     $username = $_COOKIE['login'];
     $sql = 'SELECT subjects.Name_subj, test_list.Name_test, theme_list.Name_theme, test_list.Id_test
      FROM `account`
      JOIN `student_list`
      ON account.Id_account = student_list.st_Id_User
      JOIN `class_list`
      ON student_list.Id_class = class_list.Id_class
      JOIN `class_theme`
      ON class_list.Id_class = class_theme.Id_class_1
      JOIN `theme_list`
      ON class_theme.Id_theme = theme_list.Id_themes
      JOIN `test_list`
      ON test_list.Id_themes = theme_list.Id_themes
      JOIN `subject_tests`
      ON subject_tests.id_test_SubTest = test_list.Id_test
      JOIN `subjects`
      ON subject_tests.id_subj_SubTest = subjects.Id_subject
      WHERE  `login` = :login'  ;


      $query = $pdo->prepare($sql);
      $query->execute(['login' => $username]);

      ?>
<!-- запрос на вывод предметов, тестов  -->

      <table class="table table-striped">
        <thead>
          <tr>
            <th>Номер</th>
            <th>Предмет</th>
              <th>Название темы</th>
            <th>Название теста</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $k=1;
          while($row = $query -> fetch(PDO::FETCH_OBJ))
            {

              echo "<tr>
              <th scope = 'row'>$k</th>
              <td> <a  class = 'text-dark'> $row->Name_subj </a></td>
              <td> <a  class = 'text-dark'> $row->Name_theme </a></td>
              <td> <a href='/test.php?Id_t=$row->Id_test' class = 'text-dark'> $row->Name_test </a></td>
              </tr>";
              $k++;
            }
          ?>
        </tbody>
      </table>


  </div>

    <?php# require 'blocks/aside.php'; ?>

  </div>
 </main>

<?php require 'blocks/footer.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>




</body>
</html>
