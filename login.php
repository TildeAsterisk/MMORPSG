<?php
// Start output buffering
ob_start();

session_start();
include_once("header.php");
?>
    <style>#loginHeaderDiv{display:none;}</style>
    <div id="loginHomepage">
    <center><h1>~* MMO RPG</h1></center>
    <form action="login.php" method="post" style="width:100%;">
    <center>
        Username:<input type="text" name="username"/><br>
        Password:<input type="password" name="password"/><br>
        <input style="margin:10px;" type="submit" name="login" value="Log-in"/>
        <button onclick="window.location.href = 'register.php';" type="button">Register</button>
    </center>
    </form>
    </div>
<?php

if (isset($_POST['login'])){
  if(isset($_SESSION['uid'])){
    echo "You are already logged in.";
  }
  else{
    $username = protect($mysql,$_POST["username"]);
    $password = protect($mysql,$_POST["password"]);

    $login_check=mysqli_query($mysql,"SELECT `id` FROM `user` WHERE `username`='$username' AND `password`='".md5($password)."'") or die(mysqli_error($mysql));
    if(mysqli_num_rows($login_check) == 0){
      echo "<center style='color:red;font-weight:bold;'>Invalid username/Password combination.</center>";
    }
    else{
      $get_id=mysqli_fetch_assoc($login_check);
      $_SESSION['uid'] = $get_id['id'];
      header("Location: main.php");
    }
  }
}
else{
  echo "You have visited this page incorrectly!";
}

// End output buffering
ob_end_flush();
?>