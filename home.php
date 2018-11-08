<!--Connect to database-->
<?php
  session_start();
$mysqli = new mysqli("localhost", "zaman29", "pass1234", "StudentRegistrationAuthentication");

/*onClick submit button that INSERTS INTO the section in the database and checks for a match */
if (isset($_POST['submitSection'])) {
    $courseName = ($_POST['courseName']);
    $courseCode = ($_POST['courseCode']);
    $currentSection = ($_POST['currentSection']);
    $desiredSection = ($_POST['desiredSection']);

     $query  = "INSERT INTO availableSections(CourseName, CourseCode, sectionsList) VALUES('$courseName', '$courseCode', '$currentSection');";
   // $querytwo .= "SELECT * FROM availableSections WHERE sectionsList = '$desiredSection'";
     //find 
    $querytwo .= "SELECT * FROM availableSections WHERE CourseName = '$courseName' AND CourseCode = '$courseCode' AND sectionsList = '$desiredSection'";

    $result = mysqli_query($mysqli, $query);
    $newResult = mysqli_query($mysqli, $querytwo);

//return message
if (mysqli_num_rows($newResult) > 0) {
      $_SESSION['foundmessage'] = "Great News! That section is available.";
      /*insert swap here*/

      /*if (isset($_POST['yes'])) {
        $querythree = "DELETE FROM availableSections WHERE sectionsList = '$desiredSection'";
      
      if($querythree){
        echo "delete query ran";
      }else{
        echo "delete query didnt run";
      }
    }
    */
    }else if (mysqli_num_rows($newResult) == 0){
      $_SESSION['notfoundmessage'] = "Sorry ".$_SESSION['username'].", We'll email you if someone submits that section";
    }                            
  }
?>






<!--Tutor Feature Fuction-->
<?php
/*onClick submitTutor button that INSERTS INTO the tutor in the table */
if (isset($_POST['submitTutor'])) {
    $tutorName = ($_POST['tutorName']);
    $tutorEmail = ($_POST['tutorEmail']);
    $ExpertCourse = ($_POST['ExpertCourse']);
    $query  = "INSERT INTO Tutors(tutorName,tutorEmail,expertCourse) VALUES('$tutorName','$tutorEmail','$ExpertCourse');";
    $result = mysqli_query($mysqli, $query);
}
?>




<!--SEARCH TUTOR-->
<?php
if (isset($_POST['submitSearch'])) {
    $SubjectName = ($_POST['SubjectName']);
    $queryTutor = "SELECT * FROM Tutors WHERE expertCourse = '$SubjectName'";

    $tutorResult = mysqli_query($queryTutor);

    //return message
if (mysqli_num_rows($tutorResult) > 0) {
      echo "tutor if result ran!";
    }
else{
      echo "tutor else result ran";
}
}
?>




<!--HTML-->
<!DOCTYPE html>
<html>
  <head>
    <title>CUNYthird Party Application</title>
      <link rel="stylesheet" type="text/css" href="style.css">
      <link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet"> 
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--TIMER_____________________-->
    <script>
    function fade_out() {
      $("#fade-out").fadeOut().empty();
      alert("fadeout was called");
    }
    setTimeout(fade_out,1000);
    </script>
  </head>
  <body>
    <div class="header">
      <div><a href="home.php"><img class="logo" src="images/logo.png"></a></div>
  <!--style='float:left; margin-left:550px; color:#fff;'  <div id="logout_btn"></div>-->
    <div id="welcome-msg">
      <p>Welcome <?php echo $_SESSION['username']; ?></p>
    </div>
    <div id="logout_btn"><a href="logout.php">Sign out</a></div>

<?php
  if($query) {
    $_SESSION['querymsg'] = "Your Section was added to the Database";
    
    echo "<div id = 'query_msg'>".$_SESSION['querymsg']."</div>";
    echo "<div id = 'sql-image'><img src = 'images/left.jpg'></div></div>";
  }
 
?>
</div>

<!--Nav bar-->
<ul class="my-nav-bar">
  <li><a href="http://home.cunyfirst.cuny.edu" target="blank">CUNYfirst</a></li>
  <li><a href="https://baruch.cuny.edu" target="blank">Baruch</a></li>
  <li><a href="https://help.orgsync.com/hc/en-us" target="blank">Contact</a></li>
</ul>



<!--First Tool-->
<div id="fade-out">
<div class="block-one">
<?php
    if (isset($_SESSION['foundmessage'])) {
      echo "<div id = 'found_msg'>".$_SESSION['foundmessage']."</div>";
      unset($_SESSION['foundmessage']);
    }
    if (isset($_SESSION['notfoundmessage'])) {
      echo "<div id = 'error_msg'>".$_SESSION['notfoundmessage']."</div>";
      unset($_SESSION['notfoundmessage']);
    }
?>

<!--list the sections from the database-->
<div id="new-database-box">
<?php
/*Display database on webpage for user to see which sections are currently available*/
$sqlShowDatabase = "SELECT * FROM availableSections";
$resultShowDatabase = $mysqli->query($sqlShowDatabase);

if ($resultShowDatabase->num_rows > 0) {
     echo "<table><tr>Available Sections</tr>";
     // output data of each row
     while($row = $resultShowDatabase->fetch_assoc()) {
         echo "<tr><td>" . $row["CourseName"]. "</td><td>" . $row["CourseCode"]. "</td><td>" . $row["sectionsList"]. "</td></tr>";
     }
     echo "</table>";
} else {
     echo "Sorry, no sections are in the database";
}
?>
</div>


<!--block-one-CONTENT-->
<div class="block-one-content">
<div id="main-feature"><h1>Swap Closed Sections!</h1></div>
  <p class="page-message">Stuck in an inconvenient section?<br />Check to see if someone else is wiling to swap sections with you.</p><br />

<!--Section Swapper Form-->
  <div id="the-form">
    <form method="post" action="home.php">
      <table>
        <tr>

        <tr>
          <td>Course Name:</td>
          <td><input type="text" name="courseName" class="textInput" placeholder="Course Name ex:BPL"></td>
        </tr>

        <tr>
          <td>Course Code:</td>
          <td><input type="text" name="courseCode" class="textInput" placeholder="Course Code ex:5100"></td>
        </tr>


          <td>Add Current Section to the list:</td>
          <td><input type="text" name="currentSection" class="textInput" placeholder="Current Section ex:RTRA"></td>
        </tr>
          <tr>
          <td>Enter The Section You Want:</td>
          <td><input type="text" name="desiredSection" class="textInput" placeholder="Preferred Section"></td>
        </tr>
        <tr>
        <td></td>
          <td><input type="submit" name="submitSection" value="Submit" class="textInput"></td>
        </tr>
      </table>
    </form>
  </div>

</div>

</div>
</div>

<!--Second-Tool-->
<div class="block-two">
<div class="block-two-content">
  <h1>Become a Tutor!</h1>
    
      <p class="page-message">Do you have an A in a subject and willing to tutor ? <br />Submit yourself and students may reach out to you for tutoring</p><br />
        <div id="the-form">
        
          <form method="post" action="home.php">
            <table>
              <tr>
                <td>Name:</td>
                <td><input type="text" name="tutorName" class="textInput"></td>
              </tr>
              <tr>
                <td>Email:</td>
                <td><input type="email" name="tutorEmail" class="textInput"></td>
              </tr>
              <tr>
                <td>Enter Expert Course:</td>
                <td><input type="text" name="ExpertCourse" class="textInput"></td>
              </tr>
              
              <tr>
                <td></td>
                <td><input type="submit" name="submitTutor" value="Apply" class="textInput"></td>
              </tr>
            </table>
          </form>
        </div>
  
  <!--<div class="banner"><p>GPA Calculator <br /> You're busy, let us assist you with college</p></div>-->
  <div id="tutor-box">
<?php
/*New Feature - Display database on webpage for user to see which tutors are currently available*/
$sqlShowtutors = "SELECT * FROM Tutors";
$resultShowtutors = $mysqli->query($sqlShowtutors);

if ($resultShowtutors->num_rows > 0) {
     echo "<table><tr><th>Available Tutors</th></tr>";
     // output data of each row
     while($row = $resultShowtutors->fetch_assoc()) {
         echo "<tr><td>" . $row["tutorName"]. "</td><td>" . $row["tutorEmail"]. "</td></tr>";
     }
     echo "</table>";
} else {
     echo "Sorry, no tutors are in the database";
}
?>
</div>
</div>
</div>

<!--shown new tutor table-->




<!--Third-Tool-->
<div class="block-three">
<div class="block-three-content">
  <div id="third-image">
    <h1>Search for a tutor for any subject!</h1>
      <p class="page-message">We provide the tools you need to succeed</p><br />
        <div id="the-form">
          <form method="post" action="home.php">
            <table>
              <tr>
                <td>Enter Subject Name:</td>
                <td><input type="text" name="SubjectName" class="textInput"></td>
              </tr>
             <!-- <tr>
                <td>Enter Course Code:</td>
                <td><input type="text" name="courseCode" class="textInput"></td>
              </tr>
              -->

              <tr>
                <td></td>
                <td><input type="submit" name="submitSearch" value="Search" class="textInput"></td>
              </tr>
            </table>
          </form>
        </div>
  </div>
  <!--<div class="banner"><p>Find a Tutor<br />Get ahead, Get high Scores</p></div>-->
</div>
</div>



</body>
<!--<footer class="my-footer"><p>Section Swapper</p></footer>-->
</html>
<!--
/* mysql_query("
    INSERT INTO availableSections (sectionsList) VALUES('$currentSection');
    SELECT * FROM availableSections WHERE sectionsList = '$desiredSection';");
    $sql = "INSERT INTO availableSections(sectionsList) VALUES('$currentSection')";
    $sql = "SELECT * FROM availableSections WHERE sectionsList = '$desiredSection'";
    */
-->








