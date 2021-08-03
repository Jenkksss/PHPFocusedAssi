<?php

// Things to notice:
// You need to add code to this script to implement the admin functions and features
// Notice that the code not only checks whether the user is logged in, but also whether they are the admin, before it displays the page content
// When an admin user is verified, you can implement all the admin tools functionality from this script, or distribute them over multiple pages - your choice

// execute the header script:
require_once "header.php";

// checks the session variable named 'loggedInSkeleton'
// take note that of the '!' (NOT operator) that precedes the 'isset' function
if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}

// the user must be signed-in, show them suitable page content
else
{
	// only display the page content if this is the admin account (all other users get a "you don't have permission..." message):
	if ($_SESSION['username'] == "admin")
	{
		echo "<h2>Administration Tools</h2><br>
                <h3><a href='useradmin.php'>Edit User Credentials</a></h3><br>
                <h3><a href='surveyadmin.php'>See/Edit Survey Response</a></h3>";


	}

	else
	{
		echo "You don't have permission to view this page, please log into an admin account<br>";
	}
}

// finish off the HTML for this page:
require_once "footer.php";
?>