<?php
// Start output buffering
ob_start();

session_start();
include_once("header.php");
?>
    <style>
    #loginHeaderDiv{
      width:100%;
      display:flex;
      justify-content:center;
    }
    </style>
<?php

if(isset($_POST['register'])){
  $username= protect($mysql,$_POST["username"]);
  $password= protect($mysql,$_POST["password"]);
  $email= protect($mysql,$_POST["email"]);
  if($username== "" || $password=="" || $email== ""){
    echo "Please supply all fields.";
  }
  elseif (strlen($username) > 20) {
    echo "Username must be less than 20 characters.";
  }
  //elseif(empty($password) || strlen($password) < 20) {}
  elseif(strlen($email) > 100) {
    echo "E-mail must be less than 100 characters";
  }
  else{
    $register1 = mysqli_query($mysql, "SELECT `id` FROM `user` WHERE `username`='$username'") or die(mysqli_error($mysql));
    $register2 = mysqli_query($mysql, "SELECT `id` FROM `user` WHERE `email`='$email'") or die(mysqli_error($mysql));

    if (mysqli_num_rows($register1) > 0) {
      echo "That username is already taken.";
    }
    elseif (mysqli_num_rows($register2) > 0) {
      echo "That e-mail address is already in use!";
    }
    else{
      /*
      $ins1=mysqli_query($mysql,"INSERT INTO `stats` (`points`,`attack`,`defense`,`food`,`farming`,`materials`,`mat_production`,`currency`,`income`) VALUES (100,10,10,50,0,10,0,0,0)") or die(mysqli_error($mysql));
      $ins2=mysqli_query($mysql,"INSERT INTO `units` (`worker`,`farmer`,`warrior`,`defender`) VALUES (5,5,0,0)") or die(mysqli_error($mysql));
      $ins3=mysqli_query($mysql,"INSERT INTO `user`  (`username`,`password`,`email`) VALUES ('$username','".md5($password)."','$email')") or die(mysqli_error($mysql));
      $ins4=mysqli_query($mysql,"INSERT INTO `ranking` (`attack`,`defense`,`overall`) VALUES(0,0,0)") or die(mysqli_error($mysql));
      $ins5=mysqli_query($mysql,"INSERT INTO `inventory` (`items`) VALUES ('[{}]')") or die(mysqli_error($mysql));
      echo "Thank you for registering with Tilde Asterisk ~*";
      */
      // Begin the transaction
      mysqli_begin_transaction($mysql);

      try {
          // Your SQL queries
          $ins1 = mysqli_query($mysql, "INSERT INTO `stats` (`points`,`attack`,`defense`,`food`,`farming`,`materials`,`mat_production`,`currency`,`income`) VALUES (100,10,10,50,0,10,0,0,0)");
          $ins2 = mysqli_query($mysql, "INSERT INTO `units` (`worker`,`farmer`,`warrior`,`defender`) VALUES (5,5,0,0)");
          $ins3 = mysqli_query($mysql, "INSERT INTO `user` (`username`,`password`,`email`) VALUES ('$username','" . md5($password) . "','$email')");
          $ins4 = mysqli_query($mysql, "INSERT INTO `ranking` (`attack`,`defense`,`overall`) VALUES(0,0,0)");
          
          $ins5 = mysqli_query($mysql, "INSERT INTO `inventory` (`capacity`) VALUES (5)");

          // Commit the transaction if all queries succeed
          mysqli_commit($mysql);
          echo "Thank you for registering with Tilde Asterisk ~*";
      } catch (Exception $e) {
          // Roll back the transaction if any query fails
          mysqli_rollback($mysql);
          echo "Registration failed. Please try again later.";
          echo $e;
      }

      UpdateGlobalRankingStats($mysql);
      //Causes errors: //include("update_stats.php");
    }
  }
}

?>
<hr>
<center><h1>Registration:</h1></center>
<pre id="loginHeaderDiv"> <!-- Formats all text to monosize -->
  
  <form action="register.php" method="POST">
    Username:  <input type="text" name="username"/><br />
    Password:  <input type="password" name="password"/><br />
    Email:     <input type="text" name="email"/><br />
    <input type="submit" name="register" value="Register"/>
  </form>

</pre>

<?php 
  include("footer.php");

  // End output buffering
  ob_end_flush();
?>