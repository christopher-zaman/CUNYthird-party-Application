<?php

  session_start();

  //connect to database

  $db = mysqli_connect("localhost", "zaman29", "pass1234", "StudentRegistrationAuthentication");

//sign up button

  if (isset($_POST['register_btn'])) {

    $username = ($_POST['username']);

    $email = ($_POST['email']);

    $password = ($_POST['password']);

    $password2 = ($_POST['password2']);


    if ($password == $password2) {

      // create user account

      $password = md5($password); //hash password before storing for security
      // SQL Query to enter user sign up data into database 
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





//login button routes to home

if (isset($_POST['login_btn'])) {

    $username = ($_POST['username']);

    $password = ($_POST['password']);



    $password = md5($password); // remember we hash pw b4 storing last 

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

    $result = mysqli_query($db, $sql);



    if (mysqli_num_rows($result) == 1) {

      $_SESSION['message'] = "You are logged in";

      $_SESSION['username'] = $username;

      header("location: home.php"); // redirect to home page

    }else{

      $_SESSION['message'] = "Username/Password not found";

    }

  }











?>

<!--HTML-->

<!DOCTYPE html>

<html>

<head>

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

  <title>CUNYthird Party Application</title>

  <link rel="stylesheet" type="text/css" href="style.css">

  <link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet"> 

  <meta name="viewport" content="width=device-width, initial-scale=1">

</head>



<body>

<!--header-->

<div class="header">

  <div><a href="index.php"><img class="logo" src="images/logo.png"></a></div>

    <div class="login-page-form">

      <form method="post" action="index.php">

        <p class="login-p-tag">Log in</p>

          <table>

            <tr>

              <td class="user"><input type="text" name="username"  placeholder="Username" class="textInput"></td>

              <td class="pass"><input type="password" name="password"  placeholder="Password" class="textInput"></td>

              <td class="button"><input type="submit" name="login_btn"   value="Login" class="textInput"></td>

            </tr>

          </table>

      </form>

    </div> 

</div>



<div class="main">

<div class="main-content">



<?php

      if (isset($_SESSION['message'])){

        echo "<div class='login_error_msg'>".$_SESSION['message']."</div>";

        unset($_SESSION['message']);

      }

?>



<!--Sign in form-->

<form id ="main-form" method="post" action="index.php">

<p id="or">Or</p>

<p>Sign up with email </p>

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

      <td><input type="password" name="password2" placeholder="Confirm Password" class="textInput"></td>

    </tr>



    <tr>

      <td><input type="submit" name="register_btn" value="Sign Up" class="textInput"></td>

    </tr>

    

  </table>

</form>



<!--left side box-->

  <div class="left-content">

    <h1>Welcome to a multipurpose web application!</h1>  

      <div class="first-feature">

        <img class="first-feautre-icon" src="images/swap-people.png" />

        <h2>Swap Sections</h2>

        <p>Stuck in a section you wish to swap out of? Submit your section and maybe someone  else will swap with you!</p>

      </div>

      <div class="second-feautre">

        <img class="second-feautre-icon" src="images/find-tutor.png" />

        <h2>Find a Tutor</h2>

        <p>Need some expert level help to Ace a class? Search for a tutor or submit a request!  </p>

      </div>

      <div class="third-feautre">

        <img class="third-feautre-icon" src="images/submit-tutor.png" />

        <h2>Become a Tutor</h2>

        <p>Are you an expert willing to earn extra cash teaching? Submit yourself to be a   tutor (must have an A)</p>

      </div>

  </div>

</div>



</body>



<!--<footer class="my-footer"><p>CUNYthird Party Application</p></footer>-->

</html>

