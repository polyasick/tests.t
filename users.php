<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <?php

   $website_title = 'Кабинет пользователя';
   require 'blocks/head.php'; ?>
</head>
<body>
<?php
 require_once 'mysqlconnect.php';
   ini_set('display_errors','Off');
 $username = $_COOKIE['login'];
 $sql = 'SELECT access.access FROM `access` JOIN `account`
ON access.Id_user = account.Id_account WHERE `login` = :login';
 $query = $pdo->prepare($sql);
 $query->execute(['login'=> $username]);
 $row = $query -> fetch(PDO::FETCH_OBJ);
?>

<?php require 'blocks/header.php'; ?>

<?php
if ($row->access=="2"):
{ require_once 'mysqlconnect.php';
  $sql = 'SELECT account.login, student_list.FIO_stud, class_list.Number
  FROM `account`
  JOIN `student_list`
  ON account.Id_account = student_list.st_Id_User
  JOIN `class_list`
  ON class_list.Id_class = student_list.Id_class


  WHERE `login` = :login';

$query = $pdo->prepare($sql);
$query->execute(['login'=> $username]);
$row = $query -> fetch(PDO::FETCH_OBJ);

}
?>

 <main class="container mt-5">
  <div class="row">
    <div class= "col-md-6 mb-3">
    <h4>Личная информация</h4>
      <form>

      <label for="username"> Ваш Ник: </label>
      <input type="text" value="<?=$row->login?>"  name="username" id="username" class="form-control"  style="color:black;" >
      <br>
      <label for="FIO_stud"> ФИО: </label>
      <input type="text" value="<?=$row->FIO_stud?>"  name="FIO_stud" id="FIO_stud" class="form-control"  style="color:black;"><br>

      <label for="Number"> Класс: </label>
      <input type="text" value="<?=$row->Number?>" name="Number" id="Number" class="form-control"  style="color:black;"><br>


      <nav class="menu">
        <ul>
          <li><label for="subj"> Предметы: </label>

            <ul>
                <?php
                  require_once 'mysqlconnect.php';
                  $sql = 'SELECT account.login, student_list.FIO_stud, class_list.Number, subjects.Name_subj, subjects.Id_subject
                  FROM `account`
                  JOIN `student_list`
                  ON account.Id_account = student_list.st_Id_User
                  JOIN `class_list`
                  ON class_list.Id_class = student_list.Id_class
                  JOIN `teacher_class`
                 ON teacher_class.Id_cl = class_list.Id_class
                 JOIN `subjects`
                 ON subjects.Id_subject = teacher_class.Id_subj
                 JOIN `subject_tests`
                 ON subject_tests.id_sub_test = subjects.Id_subject

                  WHERE `login` = :login';

                $query = $pdo->prepare($sql);
                $query->execute(['login'=> $username]);
                while($row = $query -> fetch(PDO::FETCH_OBJ))
                {
                  echo "<li><a href='/subjects.php?Id=$row->Id_subject'>$row->Name_subj</a></li>";
                }

                ?>

            </ul>

          </li>

        </ul>
      </nav>


    </div>
    </form>

<aside class="col-md-5 mb-3">
  <div class = "p-3 mb-4" style = "background-color:#98A4B3">
    <h4><b>Подсказка!</b></h4>
    <p>Кабинет пользователя. Здесь указана информация о пользователе: данные об ученике и дисциплины, которые изучаются.
  </p>
   </div> <!--отступы примерно 30 пк-->

 </aside>
</div>

<?php
else:
{
  echo "учитель";
}
 ?>
 <?php
   endif;
  ?>
</main>

<?php require 'blocks/footer.php'; ?>
</body>
</html>
