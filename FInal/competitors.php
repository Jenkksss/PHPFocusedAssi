<?php

// Things to notice:
// You need to add your Analysis and Design element of the coursework to this script
// There are lots of web-based survey tools out there already.
// It’s a great idea to create trial accounts so that you can research these systems. 
// This will help you to shape your own designs and functionality. 
// Your analysis of competitor sites should follow an approach that you can decide for yourself. 
// Examining each site and evaluating it against a common set of criteria will make it easier for you to draw comparisons between them. 
// You should use client-side code (i.e., HTML5/JavaScript/jQuery) to help you organise and present your information and analysis 
// For example, using tables, bullet point lists, images, hyperlinking to relevant materials, etc.

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
	echo "<ul><h2>Website 1:Survey Monkey</h2></b><br>
           <li>Layout/presentation of surveys:Very easy to maneuver in terms of both set up and filling the surveys out, looks professional and very neat, </li>
           <br>
           <li>Ease of use: Very easy to set up, limited to only ten questions without a subscription, so in terms of this google docs is a lot better </li>
           <br>
           <li>User account set-up/login process:Very easy to set up as it allows the person setting up the survey to use either a pre-made Office 365, Google, Facebook or LinkedIn or create a fresh account, <br>
            the user does not need to make an account in order to fill out the survey.</li>
           <br>
           <li>Question types: various question types, some that allow the user to type and radio buttons very useful tools to limit respondent answers, of the 3 seems to have the most options,<br>
			other options include: checkbox, drop down, star rating, file upload, slider, </li>
           <br>
           <li>Analysis tools:very limited, unless the user pays a subscription, and looking through various online reviews, 
           <br> these subscription seem difficult to get out of, and the accounts are limited to two devices so for bigger companies, this may be an issue</li> 
           <br></ul>
           <ul><h2>Website 2:Google Forms</h2><br>
           <li>Layout/presentation of surveys:ver simple and easy to use/read, and creation is very simple, </li><br>
           <li>Ease of use:Very easy to use, similar to SurveyMonkey in this respect, difficult to embed in your own website, has to be shared via e-mail which given the Gmail link is very easy, also allows the user to set their own custom URL, allowing for ease of sharing</li><br>
           <li>User account set-up/login process:Google forms comes free with a Google account, making  it the cheapest option of the 3 sites that have been analysed, users do not need an account in order to fill out the survey</li><br>
           <li>Question types:Plenty of question types, fewer than SurveyMonkey, and a lot a less than Lime Survey, 9 in total, text, paragraph, multiple choice, checkbox, list, slider, grid and date, lots of templates more for design than function </li><br>
           <li>Analysis tools:less than survey monkey but for the price, better value for money, depending on what you want out of the survey, would depend of the two you would use </li> <br></ul>
           <ul><h2>Website 3:Lime Survey</h2><br>
           <li>Layout/presentation of surveys:this site edges the other two in this department as it supports the use of audio/video/images</li><br>
           <li>Ease of use:like SurveyMonkey limits the amount of responses one can receive, however does have live support and training, both online and in person, allows the user to set custom urls for their surveys, <br> which would make them easier to share also offer email marketing and mobile surveys</li><br>
           <li>User account set-up/login process:</li><br>
           <li>Question types:very similar to the other two, but supported audio/video and images which could be a massive advantage in particular fields/area </li><br>
           <li>Analysis tools:lots of in depth analysis tools, on a par with SurveyMonkey, lots of different ways to anaylsis results, some of which can be daunting, ut given the support available, should be easy enough to master </li><br></ul>
		   <ul><h2>Conclusion</h2></ul><br>
		   <li>From my research, I've concluded that the best survey website is depenedent on a number of factors, these include but are not limited to, the budegt available to the client/user, the users needs in regards to the questions they wish to ask <br>
		   and wether or not they need to use things such as imaes or audio, the other factor that needs to be considered is how they would want to view/analyse the results of their surveys. My reccomendations <br>
		   in terms of value for money would be google forms, as it is free and offers a lot of options for absoultey no cost, if the user has a little bit more money to spend I'd reccomend using SurveyMonkey, <br>
		   as it doesn't cost a great deal more, and offers more in terms fo questions and analysis, and thirdly if budget is no issue, I'd reccomend using Lime Survey, as it offers the widest array of options in terms <br>
		   of questions and anaylsis.</li>
          ";
}

// finish off the HTML for this page:
require_once "footer.php";
?>