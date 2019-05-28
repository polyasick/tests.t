<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 border-bottom shadow-sm" style="background-color: #FFDED4">
  <h5 class="my-0 mr-md-auto font-weight-normal"> <a class="p-2 text-dark " href="/index.php"> <b>Система тестов</b></a> </h5>
  <nav class="my-2 my-md-0 mr-md-3">
   <a class="p-2 text-dark" href="/">Главная</a>
  </nav>

  <?php
    ini_set('display_errors','Off');
    if($_COOKIE['login'] == ''):
         ?>
        <a class="btn btn-outline-secondary mr-2 mb-2" href="/auth.php" >Войти</a>
        <a class="btn btn-outline-secondary mr-2 mb-2" href="/reg.php">Регистрация</a>

  <?php
    else:
  ?>
         <?php
         require_once 'mysqlconnect.php';
           ini_set('display_errors','Off');
         $username = $_COOKIE['login'];
         $sql = 'SELECT access.access FROM `access` JOIN `account`
        ON access.Id_user = account.Id_account WHERE `login` = :login';
         $query = $pdo->prepare($sql);
         $query->execute(['login'=> $username]);
         $row = $query -> fetch(PDO::FETCH_OBJ);
         if($row->access == "2"):
          ?>
           <nav class="my-2 my-md-0 mr-md-3">
             <a class="p-2 text-dark " href="/watch_tests.php"> Просмотр тестов </a>
           </nav>
         <?php
           endif;
          ?>

         <a class="btn btn-outline-secondary mr-2 mb-2" href="/users.php">Кабинет пользователя</a>
         <button class="btn btn-danger mr-2 mb-2" id="exit_btn" >Выйти</button>

         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

         <script>
           $('#exit_btn').click(function() {

             $.ajax({
               url: 'ajax/exit.php',
               type: 'POST',
               cache: false,
               data: {},
               dataType: 'html',
               success: function(data) {
                 document.location.href = "index.php";
               }
             });
           });
         </script>
   <?php
      endif;
    ?>
</div>
