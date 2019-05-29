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
	  $id_student = $row-> Id_student;
	 //echo $id_student;

// запрос на ввод данных в seans
   // $sql = "INSERT INTO seans(Id_cl, Id_stud, Id_tests) VALUES($row->Id_class, $row->Id_student,$row->Id_test)";
     // $query1 = $pdo->query($sql);

if ($_POST['butt']) {
//очищаем предыдущие результаты
$sql = "DELETE FROM `concrete_answer` WHERE id_student='". $id_student."' AND Id_test_new='".$Id."'";
$pdo->query($sql);

//заносим новые
	for ($i=0;$i<100;$i++) {
if 	($_POST['v'.$i]){
$pieces = explode("|", $_POST['v'.$i]);
echo $_POST['v'.$i]."<br/>";
$sql = "INSERT INTO concrete_answer (Id_note_answ, Id_test_new, Id_question_concr, amswer_stud, id_student) VALUES(NULL, '".$Id."', '".$pieces[0]."', '".$pieces[1]."', '".$id_student."')";
$query1 = $pdo->query($sql);
}
}


echo "Данные теста успешно занесены!";
}
else {
 ?>
 <div class= "jumbotron">
<form method="post" action="">
<?php
//номер вопроса


$quest = 'SELECT  question.Text_quest, question.Id_question
from `question`
join `test_list`
on question.Id_tests = test_list.Id_test
where `Id_test` = :Id_test ';

$query = $pdo->prepare($quest);
$query->execute(['Id_test' =>$Id]);


$chet=-1;
$question_mass_text = array();
$question_mass_id  = array();
while ($row = $query -> fetch(PDO::FETCH_OBJ) )
{
$chet++;
$question_mass_text[$chet] = $row->Text_quest;
$question_mass_id [$chet] =$row->Id_question;
}

for ($i=0; $i<=$chet;$i++) {
echo "Вопрос №".($i+1)." <br />".$question_mass_text[$i]."<br /><br />Ответы: <br />";

$Id_que = $question_mass_id [$i];

$answ = "SELECT * FROM `list_answer` where `Id_question_LAnsw` = '".$Id_que."'";
$query = $pdo->prepare($answ);
$query->execute(['Id_answer' =>$Id]);
while ($row = $query -> fetch(PDO::FETCH_OBJ) )
{
	echo "<input  class='form-check-input' type='radio' name='v ".$i."' value='".$row->Id_question_LAnsw."|".$row->answer."'>".$row->answer."<br />";
}

echo "<br />";
echo '<input type="hidden" value = "'.$Id.'" name="Id_test_new"/>';
}

        ?>
<input type="submit" value = "Я решил!" class="btn btn-secondary mt-3" name="butt"/>
</form>
      </div>

    </div>
<?php }?>
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
