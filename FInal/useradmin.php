<?php
require_once "header.php";
require_once "credentials.php";
$displayUser = "username";
$username = "";
$password = "";
$email = "";
$firstname ="";
$surname = "";
$dob = "";
$telephone = "";
// strings to hold any validation error messages:
$username_val="";
$password_val="";
$email_val = "";
$firstname_val="";
$secondname_val="";
$dob_val="";
$telephone_val="";
$errors = "";
$message = "";
$displayUser ="username";
$displayUser= true;
//checking if the user is logged in there username is admin
if (isset($_SESSION['loggedInSkeleton']) && ($_SESSION['username']=='admin'))
    {   //checks if display user has a value, if it is it calls it
        if(isset($_GET['displayUser']))
		{
            $displayUser = $_GET['displayUser'];
		}
		
	if(isset($_GET['operation']) && (isset($_GET['id'])) && $_SESSION['username']=='admin')
        {
            if ($_GET['operation']=="delete")
            {
                //passes the id of the selected user to the delete function
                deleteUsers($dbhost, $dbuser, $dbpass, $dbname, $_GET['id']);
                $displayUser = true;
            }
            elseif ($_GET['operation']=="newUser"|| $_GET['operation']=="editUser")//awaits user input to to call functions that will either edit or create a new user
            {
                $displayUser = false; //hides the previous part of the page (table) after the user input

                if ($_GET['operation']=="newUser")//if the admin opts to create a new user, then the script follows this path
                {
					$operation="newUser";
                    $usernameOp ="";
                    $buttonname = "Add New"; //sets the text on the input button
                    $editRow['username'] ="";
                    $editRow['password'] ="";
                    $editRow['email'] ="";
                    $editRow['firstname'] ="";
                    $editRow['surname'] ="";
                    $editRow['dob'] ="";
                    $editRow['telephone'] ="";
                }
                else
                {
                    $operation="editUser";
                    $buttonname = "Change";
                    $editRow = editUser($dbhost, $dbuser, $dbpass, $dbname, $_GET['id']);
					$editRow['username'] ="";
                    $editRow['password'] ="";
                    $editRow['email'] ="";
                    $editRow['firstname'] ="";
                    $editRow['surname'] ="";
                    $editRow['dob'] ="";
                    $editRow['telephone'] ="";
                }
			}
   echo <<<_END
 <form action="useradmin.php" method="post">
      Update the user profile info:<br>
      Username: {$_GET['id']}
      <br>
	  Username: <input type:"string" name="username" value="$username" required>$username_val
	  <br>
      Password: <input type="string" name="password" value="$password" required> $password_val
	  <br>
      Email address: <input type="email" name="email" value="$email" minlength="1" maxlength="64" required> $email_val
      <br>
      First name: <input type="string" name="firstname" value="$firstname" minlength="1" maxlength="16"required> $firstname_val
      <br>
      Surname: <input type="string" name="surname" value="$surname" minlength="1" maxlength="16" required>  $secondname_val
      <br>
      DOB: <input type="date" name="dob" value="$dob" required> $dob_val
      <br>
      Telephone: <input type="number" name="telephone" minlength="1" maxlength="24" value="$telephone"> $telephone_val
      <input type="submit" name="$operation" value="$buttonname">
    </form>	
_END;
            }

        }
        elseif (isset($_POST['editUser']) || (isset($_POST['newUser'])))
        {
            //if the edit user or new user inputs are chosen then this script is ran
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['surname'];
            $dob = $_POST['dob'];
            $telephone = $_POST['telephone'];


            $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

            if (!$connection)
            {
                die("Connection failed: " . $mysqli_connect_error);
            }

            //sanitise variables
            $username = sanitise($username, $connection);
            $password = sanitise($password, $connection);
            $email = sanitise($email, $connection);
            $firstname = sanitise($firstname, $connection);
            $lastname = sanitise($lastname, $connection);
            $dob = sanitise($dob, $connection);
            $telephone = sanitise($telephone, $connection);

            //validate variables
			$username_val = validateString($username , 1, 16);
            $email_val = validateEmail($email, 1, 64);
            $firstname_val = validateString($firstname, 1, 16);
            $surname_val = validateString($lastname, 1, 16);
            $dob_val = validateDOB($dob);
            $telephone_val = validateTelephone($telephone, 1, 24);

            $errors = $firstname_val . $surname_val . $email_val . $dob_val . $telephone_val;
            echo "$errors";
            if ($errors == "") {
                if (isset($_POST['newUser'])) {
                    //if the new user input is selected run this sql statement which will insert the neww user to the database
                    $query = "INSERT INTO users (username, password, firstname, surname, email, telephone,dob)
                    VALUES ('$username', '$password', '$firstname', '$lastname', '$email', '$telephone', '$dob')";

                    if (mysqli_query($connection, $query)) {
                        //lets the admin know, the user has been added
                        echo "Database updated, $username added";
                        //display the users table again
                        $displayUser = true;
                    } else {
                        echo "Error, could not insert row";
                    }
                }
                else {
                    //
                    $query = "UPDATE users SET username='$username', password='$password', firstname='$firstname', surname='$lastname', DOB='$dob', email='$email', telephone='$telephone' WHERE username='$username'";

                    if (mysqli_query($connection, $query)) {
                        //if sql statement has ran correctly following will display:
                        echo "$username has been edited";
                        $displayUser = true;
                    }
                    else
                    {
                        die("Error updating row: " . mysqli_error($connection));
                    }
					
                }

            }
            else {
                echo "Validation Failed";
            }
            mysqli_close($connection);
        }
		
        if($displayUser)
        {
            //passing the variables back to display user
            displayUser($dbhost,$dbuser,$dbpass,$dbname,$displayUser);
        }
//function that displays user table
function displayUser($dbhost, $dbuser, $dbpass, $dbname, $userField)
{
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }
	$query = "SELECT * FROM users ORDER BY $userField";
    mysqli_select_db($connection, $query);
    //querying the database for the users
    $result = mysqli_query($connection,$query);
    $n = mysqli_num_rows($result);
	

    echo "<h3>User Account Management</h3>";
    //the function is in the href so it can be used throughout this script running
    echo "<table>
            <tr><th><a href='useradmin.php?displayUser=username'>Username</a></th>
            <th><a href='useradmin.php?displayUser=firstname'>First Name </a></th>
            <th><a href='useradmin.php?displayUser=surname'>Last Name</a></th>
			<th>DELETE</th></tr>";
    if ($n>0)
    {
        //use a loop to assemble rows
        for ($i = 0; $i < $n; $i++)
        {
            //assigning the results of the query a row
            $row=mysqli_fetch_assoc($result);
            //putting names into table, the link to the operation and id allows that action to be performed on that particular user
            echo <<<_END
            <tr>
				<td><a href="useradmin.php?operation=editUser&id={$row['username']}">{$row['username']}</a></td>
				<td>{$row['firstname']}</td>
				<td>{$row['surname']}</td>
				<td><a href="useradmin.php?operation=delete&id={$row['username']}">Delete User</a></td>
            </tr>
			
			
_END;
        }

        
		echo "<tr><td><a href='useradmin.php?operation=newUser&id=newUser'>New User</a></td></tr></table>";
 }
    else
    {
        echo "No users found in database";
    }
        //close the database connection
        mysqli_close($connection);

}
//editUsers function
function editUser($dbhost, $dbuser, $dbpass, $dbname, $userField)
{
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    mysqli_select_db($connection, $dbname);
    //select user details
    $query = "UPDATE * FROM users WHERE username='$userField'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($connection);
    return $row;
}
function deleteUsers ($dbhost, $dbuser, $dbpass, $dbname, $userField)
{

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    mysqli_select_db($connection, $dbname);
    //deletes users with a name that is the same as the one inputted
    $query = "DELETE FROM users WHERE username='$userField'";
    $result = mysqli_query($connection, $query);
    if ($result)
    {
        echo "User Deleted Successfully";
    }
    mysqli_close($connection);
}
require_once "footer.php";
?>