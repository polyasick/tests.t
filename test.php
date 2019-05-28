<!DOCTYPE html>
<html lang="ru">
<head>
<?php

require_once 'mysqlconnect.php';
$sql = 'SELECT * FROM `test_list` WHERE `Id_test` = :Id_test';
$id = $_GET['Id_t'];
$query = $pdo->prepare($sql);
$query->execute(['Id_test' => $id]);

$article = $query->fetch(PDO::FETCH_OBJ);
$website_title = $article->Name_test;


require 'blocks/head.php'; ?>

<style>
.jumbotron
{
background-color:  #b5bec9;
width: 70%;
}

.center{
 display: block;
 margin: 0 auto;
}
</style>
</head>
<body>
  <?php

  require 'blocks/header.php';
  ?>

<main class="container mt-5">
  <div class="row">
    <div class= "col-md-8 mb-2 ">
      <div>
        <?php
        require_once 'mysqlconnect.php';
        ini_set('display_errors','Off');
        $username = $_COOKIE['login'];
        $sql = 'SELECT  theme_list.Name_theme, theme_list.Text_theme, student_list.st_Id_User, class_list.Id_class, test_list.Id_test
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
         WHERE  `login` = :login && `Id_test` = :Id_test'  ;


         $query = $pdo->prepare($sql);
         $query->execute(['login' => $username, 'Id_test' =>$id]);
         $row = $query -> fetch(PDO::FETCH_OBJ);
         echo "<h4>$row->Name_theme</h4> <br> <p>$row->Text_theme</p>";
         ?>
      </div>
        <?php

          require_once 'mysqlconnect.php';
          $sql = 'SELECT COUNT(*) FROM `seans` LIMIT 1';
          $query = $pdo->prepare($sql);
          $result = $query->fetch(PDO::FETCH_OBJ);
          if ( $result == NULL):
            echo '<h4 align="center" class="alert alert-secondary">Тест еще не пройден!</h4>';

// если таблица заполнена, то проверка на ученика (запрос) и количество его прохождений теста
         ?>

      <!-- вывод данных из запроса -->
       <!-- запрос на вывод предмета, теста и оценки по нему
       если оценки нет, то вывести "еще не пройден, необходимо пройти - ссылка" -->
    <button type="button" class="btn btn-secondary mt-2 btn-lg center" onClick="return confirm('Вы уверены, что хотите начать попытку?');">
      <?php echo "<a href =' /quest.php?Id_test_q=$id' style = ' color: white'> Пройти тест </a>";?>
    </button>


    <?php
      endif;
     ?>
       <br>
      <button type="button" onclick="history.back();" class="btn btn-secondary mt-3">Назад</button>


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
