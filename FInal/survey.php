<?php
require_once 'header.php';
$username = "";
//these variables will hold the answers to the survey the ones that already have an answer are boolean type so we need to assign to begin with, this can later be changed
$ans1 ="false";
$ans2 ="false";
$ans3 ="";
$ans4 ="";
$ans5 ="false";
$ans6 ="false";
$ans7 ="false";
$ans8 ="false";
$ans9 ="";
//these variables are for any validation errors
$username_error = "";
$ans3_error= "";
$ans4_error= "";
$ans9_error= "";
$username = $_SESSION['username'];

if (!isset($_SESSION['loggedInSkeleton']))
{
    echo "You are not logged in, please log in before completing this survey";
}
if(isset($_POST['ans1']))
{
    $ans1 = true;
}
else
{
    $ans1=false;
}
if(isset($_POST['ans1']))
{
   $ans2 = true;
}
else
{
    $ans2=false;
}
if(isset($_POST['ans5']))
{
    $ans5=true;
}
else
{
    $ans5=false;
}
if(isset($_POST['ans6']))
{
    $ans6=true;
}
else
{
    $ans6=false;
}
if(isset($_POST['ans7']))
{
    $ans7=true;
}
else
{
    $ans7=false;
}
if(isset($_POST['ans8']))
{
    $ans8=true;
}
else
{
    $ans8=false;
}
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


echo <<<_END
<!-- Displaying the survey for the end user to input their answers includes validation on all applicable fields -->
<form action="survey.php" method="post">
Student Feedback Survey:
<br>
Are you Male or Female?
<br> Male <input type = "radio" name = "ans1" value = "1">
Female <input type = "radio" name="ans2" value="1">
<br>
What degree/course are you doing?
<br>
<input type="text" name ="ans3" value="$ans3">$ans3_error
<br>
When did you start this uni course?
<br>
<input type=""date" name="ans4" value"$ans4">$ans4_error
<br>
Have you considered any of the following?
<br>
Masters <input type ="checkbox" name="ans5" value="1">
PhD  <input type ="checkbox" name="ans6" value="1">
Another Degree <input type ="checkbox" name="ans7" value="1">
Another Form of Further Education <input type ="checkbox" name="ans8" value="1">
<br>
Why did you choose this degree? (Max 500 Chars)
<br>
<input type="text" name="ans9" value="$ans9">$ans9_error
<input type="submit" name="Submit">
</form>
_END;

//validation of answers
$username_error = validateString($username,1,16);
$ans3_error = validateString($ans3, 1, 70);
$ans4_error = validateDate($ans4);
$ans_9error = validateString($ans9, 1, 500);

$ans3 = sanitise ($_POST['ans3'], $connection);
$ans4 = sanitise ($_POST['ans4'],$connection);
$ans9 = sanitise ($_POST['ans9'],$connection);

if(!$connection)
{
    die("Connection failed" . $mysqli_connect_error);
}

require_once "footer.php";
?>