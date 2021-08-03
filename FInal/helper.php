<?php

// Things to notice:
// This script holds the sanitisation function that we pass all our user data to
// This script holds the validation functions that double-check our user data is valid
// You can add new PHP functions to validate different kinds of user data (e.g., emails, dates) by following the same convention:
// if the data is valid return an empty string, if the data is invalid return a help message
// You are encouraged to create/add your own PHP functions here to make frequently used code easier to handle



// function to sanitise (clean) user data:
function sanitise($str, $connection)
{
	if (get_magic_quotes_gpc())
	{
		// just in case server is running an old version of PHP with "magic quotes" running:
		$str = stripslashes($str);
	}

	// escape any dangerous characters, e.g. quotes:
	$str = mysqli_real_escape_string($connection, $str);
	// ensure any html code is safe by converting reserved characters to entities:
	$str = htmlentities($str);
	// return the cleaned string:
	return $str;
}

//validates that any strings are the correct length returns an error message if not
function validateString($field, $minlength, $maxlength)
{
    if (strlen($field) < $minlength) {
        // wasn't a valid length, return a help message:
        return "Minimum length: " . $minlength;
    } elseif (strlen($field) > $maxlength) {
        // wasn't a valid length, return a help message:
        return "Maximum length: " . $maxlength;
    }

    // data was valid, return an empty string:
    return "";
}

function validateEmail($field, $minlength, $maxlength)
{
    if (strlen($field) < $minlength) {
        // wasn't a valid length, return a help message:
        return "Minimum length: " . $minlength;
    }
    //validates whether it's an actual email address
    if (!filter_var($field, FILTER_VALIDATE_EMAIL)) {
        return "$field is not a valid email address";
    } elseif (strlen($field) > $maxlength) {
        // wasn't a valid length, return a help message:
        return "Maximum length: " . $maxlength;
    }
    // data was valid, return an empty string:
    return "";
}

function validateDOB($field)
{
    //Putting the parsed date into a array, so we can retrieve the individual fields
    $dob = date_parse($field);

    //using PHP's checkdate() function to make sure the date is valid,
    if (checkdate($dob['month'], $dob['day'], $dob['year'])) {
        //return nothing if date is valid
        return "";
    } else {
        return "Date is not valid";
    }

}


function validateDate($field)
{
    //Putting the parsed date into a array, so we can retrieve the individual fields
    $date = date_parse($field);

    //using PHP's checkdate() function to make sure the date is valid,
    if (checkdate($date['month'], $date['day'], $date['year'])) {
        //return nothing if date is valid
        return "";
    } else {
        return "Date is not valid";
    }

}



function validateTelephone($field, $minlength, $maxlength)
{
    if (strlen($field) < $minlength) {
        // wasn't a valid length, return a help message:
        return "Minimum length: " . $minlength;
    }
    //checks if field is a telephone number if not returns an error message
    if (filter_var($field, FILTER_VALIDATE_INT)) {
        return "$field isn't a telephone number, please enter a telephone number";

    } elseif (strlen($field) > $maxlength) {
        // wasn't a valid length, return a help message:
        return "Maximum length: " . $maxlength;
    }

    // data was valid, return an empty string:
    return "";
}

?>