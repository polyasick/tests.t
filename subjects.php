<!DOCTYPE html>
<html lang="ru">
<head>
<?php

require_once 'mysqlconnect.php';
$sql = 'SELECT * FROM `subjects` WHERE `Id_subject` = :Id_subject';
$id = $_GET['Id'];
$query = $pdo->prepare($sql);
$query->execute(['Id_subject' => $id]);

$article = $query->fetch(PDO::FETCH_OBJ);
$website_title = $article->Name_subj;


require 'blocks/head.php'; ?>
</head>
<body>
  <?php

  require 'blocks/header.php';
  ?>

<main class="container mt-5">
  <div class="row">
    <div class= "col-md-8 mb-2 ">
      <!-- вывод данных из запроса -->
       <!-- запрос на вывод предмета, теста и оценки по нему
       если оценки нет, то вывести "еще не пройден, необходимо пройти - ссылка" -->

      <?php
     require_once 'mysqlconnect.php';
     ini_set('display_errors','Off');
     $username = $_COOKIE['login'];
     $sql = 'SELECT account.login,  test_list.Name_test, test_list.Id_test, theme_list.Name_theme
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
      WHERE  `login` = :login && `Id_subject` = :Id_subject'  ;


      $query = $pdo->prepare($sql);
      $query->execute(['login' => $username, 'Id_subject' => $id]);

      ?>


      <table class="table table-striped">
        <thead>
          <tr>
            <th>Номер</th>
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
              <td> <a  class = 'text-dark'> $row->Name_theme </a></td>
              <td> <a href='/test.php?Id_t=$row->Id_test' class = 'text-dark'> $row->Name_test </a></td>
              </tr>";
              $k++;
            }
          ?>
        </tbody>
      </table>

      <button type="button" onclick="history.back();" class="btn btn-secondary mt-3">
       Назад
      </button>

    </div>

    <aside class="col-md-4">
      <div class = "p-3 mb-4" style="background-color: #98A4B3">
        <h4><b>Что это?</b></h4>
        <p>На этой странице показаны тесты, которые необходимо
          пройти по выбранной дисциплине.
          Нажмите на тест, тогда увидите свои оценки.
      </p>
       </div> <!--отступы примерно 30 пк-->

     </aside>

   </div>
 </main>

<?php require 'blocks/footer.php'; ?>

</body>
</html>
