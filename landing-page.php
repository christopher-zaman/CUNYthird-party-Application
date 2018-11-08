<?php
  session_start();
  //connect to database
  $db = mysqli_connect("localhost", "zaman29", "pass1234", "StudentRegistrationAuthentication");

  if (isset($_POST['register_btn'])) {
    $username = ($_POST['username']);
    $email = ($_POST['email']);
    $password = ($_POST['password']);
    $password2 = ($_POST['password2']);

    if ($password == $password2) {
      // create user
      $password = md5($password); //hash pw b4 storing for security
      $sql = "INSERT INTO users(username, email, password) VALUES('$username', '$email', '$password')";
      mysqli_query($db, $sql);
      $_SESSION['message'] = "you logged in";
      $_SESSION['username'] = $username;
      header ("location: home.php"); //redirect to home page
    }else{
      // failed
      $_SESSION['message'] = "the 2 pw dont match";
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Section swapping database</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
  <div class="header">

  <div><a href="index.php"><img class="cuny-third-logo" src="images/cuny-third-logo.png"></a></div>
   
  </div>

<div id="main">

<?php
      if (isset($_SESSION['message'])){
        echo "<div id='error_msg'>".$_SESSION['message']."</div>";
        unset($_SESSION['message']);
      }
?>
<div id="the-form">
<p>Log in or sign up with email </p>
<form method="post" action="index.php">
  <table>
    <tr>
      
      <td><input type="text" name="username" placeholder="Username" class="textInput"></td>
    </tr>
    <tr>

      <td><input type="email" name="email" placeholder="Email" class="textInput"></td>
    </tr>
    <tr>

      <td><input type="password" name="password" placeholder="Password" class="textInput"></td>
    </tr>
    <tr>

      <td><input type="password" name="password2" placeholder="Password" class="textInput"></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" name="register_btn" value="Register"></td>
    </tr>
  </table>
</form>
</div>
</div>
</body>

<footer class="my-footer"><p>Section Swapper</p></footer>
</html>
