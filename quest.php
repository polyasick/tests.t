<!DOCTYPE html>
<html lang="ru">
<head>
<?php

require_once 'mysqlconnect.php';
$sql = 'SELECT * FROM `test_list` WHERE `Id_test` = :Id_test';
$Id = $_GET['Id_test_q'];
$query = $pdo->prepare($sql);
$query->execute(['Id_test' => $Id]);

$article = $query->fetch(PDO::FETCH_OBJ);
$website_title = $article->Name_test;

require 'blocks/head.php'; ?>
</head>
<body>
  <?php
  require 'blocks/header.php';
  ?>

<main class="container mt-5 ">
  <div class="row">
    <div class= "col-md-8 mb-2 ">
      <?php
// запрос на получение данных и запись данных в бд (кто и когда какой тест)
      ini_set('display_errors','Off');
      $username = $_COOKIE['login'];
      $sql_1 = 'SELECT  student_list.Id_student, class_list.Id_class, test_list.Id_test
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
       WHERE  `login` = :login && `Id_test` = :Id_test';
       $query = $pdo->prepare($sql_1);
       $query->execute(['login' => $username, 'Id_test' =>$Id]);
       $row = $query -> fetch(PDO::FETCH_OBJ);

//  пока не будут готовы вопросы
      // $sql = "INSERT INTO seans(Id_cl, Id_stud, Id_tests) VALUES($row->Id_class, $row->Id_student,$row->Id_test)";
      // $query1 = $pdo->query($sql);
       ?>
    <div class= "jumbotron">

       <?php
        // $vopros = 'SELECT question.Text_quest, question.Id_question
        // FROM `test_list`
        // JOIN `question`
        // ON test_list.Id_test = question.Id_tests
        // WHERE  `Id_test` = :Id_test ORDER BY RAND() LIMIT 5';
        //
        // $query = $pdo->prepare($vopros);
        // $query->execute(['Id_test' =>$Id]);

        $quest = 'SELECT  question.Text_quest, question.Id_question
        from `question`
        join `test_list`
        on question.Id_tests = test_list.Id_test
        where `Id_test` = :Id_test ';

        $query = $pdo->prepare($quest);
        $query->execute(['Id_test' =>$Id]);


        $answ = "SELECT list_answer.answer, list_answer.Id_question_LAnsw
        FROM `list_answer`
        JOIN `question`
        ON list_answer.Id_question_LAnsw = question.Id_question
        JOIN `test_list`
        ON test_list.Id_test = question.Id_tests
        where `Id_test` = :Id_test  ";
        $query1 = $pdo->prepare($answ);
        $query1->execute(['Id_test' => $Id]);

        //
        // echo $row1->Id_question_LAnsw,'<br>';
        // echo $row1->answer, '<br>';
        // echo  '<br>';
        // костыли
        $mass = array();
        $answ = array();
        while ($row1 = $query1 -> fetch(PDO::FETCH_OBJ) )
        {
          $mass[] = $row1->Id_question_LAnsw;
          $answ[] = $row1->answer;
        }

        //
        // foreach ($mass as $value) {
        //     echo $value, " ";
        //   }

          // foreach ($answ as $vale) {
          //     echo $vale, "<br>";
          //   }

        //  echo '<br>', $mass[0], $mass[1],$mass[2],$mass[3], '<br>';

        $k = 0;
        $i = 0;
        while ($row = $query -> fetch(PDO::FETCH_OBJ) )
        {
          echo $row->Text_quest, '<br>';
          // echo $row->Id_question,'айди вопроса вопроc<br>';
          // echo $mass[$k],'айди вопроса ответ <br>';

          // $answ1 = "SELECT list_answer.answer, list_answer.Id_question_LAnsw
          // FROM `list_answer`
          // JOIN `question`
          // ON list_answer.Id_question_LAnsw = question.Id_question
          // JOIN `test_list`
          // ON test_list.Id_test = question.Id_tests
          // where `Id_test` = :Id_test  ";
          // $query2 = $pdo->prepare($answ1);
          // $query2->execute(['Id_test' => $Id]);
          // $row2 = $query2 -> fetch(PDO::FETCH_OBJ);

          // все это костыли
          // if($row->Id_question == $mass[$k])
          // {
          //
          //
          //   echo $answ[$i],' ответ <br>';
          //   echo $answ[$i+1],' ответ <br>';
          //   echo $answ[$i+2],' ответ <br>';
          //   echo $answ[$i+3],' ответ <br>';
          //  $k = $k+5;
          //   $i = $i +5;
          //
          // echo "<br>";
          // }
          // else {
          //   echo '<br>ошибка <br>';
          // }


        }
        ?>

      <!-- запрос на вывод вопросов -->


      </div>







    </div>

<!--
    <aside class="col-md-4">
      <div class = "p-3 mb-4" style="background-color: #98A4B3">
        <h4><b>Что это?</b></h4>
        <p>На этой странице показаны тесты, которые необходимо
          пройти по выбранной дисциплине.
          Нажмите на тест, тогда увидите свои оценки.
      </p>
       </div>

     </aside>-->

   </div>
 </main>

<?php require 'blocks/footer.php'; ?>

</body>
</html>
