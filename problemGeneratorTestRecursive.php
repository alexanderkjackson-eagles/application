<html>
<head>
	<title>Problem Generator</title>
</head>

<body>

<h2> Question Generator </h2>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >

<?php
// connect to databases
$db_session = mysqli_connect('localhost', 'root','', 'session');

if(!$db_session)
{
	print "<h1>Unable to connect to session database.</h1>";
}

$db_book = mysqli_connect('localhost', 'root', '', 'book');

if(!$db_book)
{
	print "<h1>Unable to connect to book database</h1>";
}

$db_answer = mysqli_connect('localhost', 'root', '', 'session');

if(!$db_answer)
{
	print "<h1>Unable to connect to book database.</h1>";
}

$user_name = $_POST["user_name"];
$book_insert = $_POST['book'];
$author_insert = $_POST['author'];
$paragraph_insert = $_POST['paragraphs'];
$session_insert = $_POST['session'];
$flag_insert = $_POST["flag_type"];
$comments_insert = trim($_POST['comments']);



if (isset($flag_insert))
{
	$sql_statement = "INSERT INTO `session`.`answer` (`Book`, `Author`, `Paragraphs`, `Session`, `Tag`, `Username`, `Comments`) VALUES ('".$book_insert."', '".$author_insert."', '".$paragraph_insert."', '".$session_insert."', '".$flag_insert."', '".$user_name."' ,'".$comments_insert."'".")";
	//$sql_statement = "INSERT INTO `session`.`answer` (`Book`, `Author`, `Paragraphs`, `Session`, `Tag`, `Username`, `Comments`) VALUES ('Emma', 'Jane Austen', '543', '1', 'Weather', 'SheerOptimism', 'I hope this works')";
	$result = mysqli_query($db_session, $sql_statement);
	if ($result)
	{
		print $user_name;
	} else {
	    $errno = mysqli_errno($db_session);

	    if ($errno == '1062') {
			echo "<p style='color: red'>Misleading error message: ".$flag_insert. " is already in Table ";
		} else {
			echo("<h4>MySQL No: ".mysqli_errno($db_session)."</h4>");
			echo("<h4>MySQL Error: ".mysqli_error($db_session)."</h4>");
			echo("<h4>SQL: ".$sql_statement."</h4>");
			echo("<h4>MySQL Affected Rows: ".mysqli_affected_rows($db_session)."</h4>");
		}

		
	}
}
else
{
	print "<strong>Database entry error.  Please contact administrator.</strong><br><br>";
}

// collect user and session information
$user_name = 'WakaFlaka'; // we really need to grab this from the user
$session_number = 1; // grab from user


$books_array = array();

$sql_statement = "SELECT Book ";
$sql_statement .= "FROM session ";
$sql_statement .= "WHERE Number = 1 ";

$session_books =  mysqli_query($db_session, $sql_statement);
$outputDisplay = "";

if(!$session_books)
{
	$outputDisplay = "";
	$outputDisplay .= "<p style='color: red;'>MySQL No: ".mysqli_errno($db_session)."<br>";
	$outputDisplay .= "MySQL Error: ".mysqli_error($db_session)."<br>";
	$outputDisplay .= "<br>SQL: ".$sql_statement."<br>";
	$outputDisplay .= "<br>MySQL Affected Rows: ".mysqli_affected_rows($db_session)."</p>";
}


// Generate random paragraph section FUNCTION
// PRECONDITION: book has been selected and paragraph parameter is known
// POSTCONDITION: A random section of the book has been printed to the screen
// Here we need the parameter supplied by the administrator $paragraphs_generated
// Here we also need the name of the book chosen by the last function as $chosen_book
// for loop, containing a paragraph counter $paragraph
// loops through text until paragraph counter equals randomly generated paragraph number
// once it does, it appends the getlines to a variable until the paragraph counter equals 
// the number of paragraphs plus the administrators parameter
// prints the text
	
$numresults = mysqli_num_rows($session_books);

for ($ii = $numresults; $ii > 0; $ii--)
{
	$book_results = mysqli_fetch_array($session_books);
	$books_array[$ii-1] = $book_results['Book'];

}
$random_selection = mt_rand(0, ($numresults-1));
$pass_book = $books_array[$random_selection];

// This statement grabs the filename of the randomly selected book
$sql_statement = "SELECT Filename FROM book WHERE Title = "."'".$books_array[$random_selection]."'";
$find_file = mysqli_query($db_book, $sql_statement);
$filename = mysqli_fetch_array($find_file);
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

$file_stream = $DOCUMENT_ROOT.'data/'.$filename['Filename'];
// this will open the randomly selected book for reading
$fp = fopen($file_stream, 'r');

$paragraph_counter= 0;
$line = "";

// fetches number of paragraphs in book
$sql_statement = "SELECT `Paragraphs` FROM `book` WHERE `Title` LIKE "."'".$books_array[$random_selection]."'";
$find_paragraphs = mysqli_query($db_book, $sql_statement);
$paragraph_parameter_fetch = mysqli_fetch_array($find_paragraphs);
$paragraph_parameter = $paragraph_parameter_fetch['Paragraphs'];


// generates random paragraph number
$random_paragraph = mt_rand(0, $paragraph_parameter); 

// This parameter will limit the amount of paragraphs printed
$sql_stament = "SELECT `Paragraphs` FROM `session` WHERE `Number` = 1"; // number should not be hardcoded
$find_administrator_parameter = mysqli_query($db_session, $sql_stament);
$fetch_administrator_parameter = mysqli_fetch_array($find_administrator_parameter);
$administrator_parameter = $fetch_administrator_parameter['Paragraphs'];

	while($paragraph_counter != ($random_paragraph+$administrator_parameter))
	{
		if($paragraph_counter < $random_paragraph)
		{
			$line = trim(fgets($fp));
			if ($line == '')
			{
				$paragraph_counter+=1;
			}
		}
		else
		{
			$line = trim(fgets($fp));
			print $line."<br>";
			if ($line == '')
			{
				$paragraph_counter+=1;
			}
		}
	}
	
fclose($fp);


// Once submit button is hit:
// username, book, author, paragraph number, session number and chosen tag added to tag database

$sql_statement = "SELECT Flag FROM flag WHERE session = 1 AND Book LIKE"."'".$books_array[$random_selection]."'";
$find_flags = mysqli_query($db_session, $sql_statement);
$print_buttons = "";
$flag_var = "";

for ($ii = 0; $ii < mysqli_num_rows($find_flags); $ii++)
{
	$flag_fetch = mysqli_fetch_array($find_flags);
	$flag_var .= '<p><input type="radio" name="flag_type" value='.'"'.$flag_fetch['Flag'].'"'.'checked="checked">'.'"'.$flag_fetch['Flag'].'"'.'</p>';
	
}
$flag_var .= "<br /><input type='submit' name='mysubmit' value='Submit'>";
print $flag_var;

$comment_box = "
	<br />
	<textarea name='comments' rows='7' cols='50'>
	</textarea>";
print "<br><br>Enter your comments here (Please keep comments to a length of 300 characters): ".$comment_box;

print "<br><br><strong>Your question details: </strong>";

$sql_statement = "SELECT `Author` FROM `book` WHERE `Title` LIKE "."'".$books_array[$random_selection]."'";
$find_author = mysqli_query($db_book, $sql_statement);
$author = mysqli_fetch_array($find_author);
$author_display = $author['Author'];

$question_info ="<br><br><strong>Username:  </strong><input type='text' name='user_name' value='".$user_name."' readonly>\n";
$question_info .="<br><br><strong>Title:  </strong><input type='text' name='book' value='".$books_array[$random_selection]."' readonly>\n";
$question_info .="<br><br><strong>Author:  </strong><input type='text' name='author' value='".$author_display."' readonly>\n";
$question_info .= "<br><br><strong>Starting Paragraph:  </strong><input type='text' name='paragraphs' value='".$random_paragraph."' readonly>\n";
$question_info .= "<br><br><strong>Session number:  </strong><input type='text' name='session' value='".$session_number."' readonly>\n";
print $question_info;

// Nagging questions:
// How are we going to check if the user has answered this question before?
// Check answers database for username, session number, book, author, and paragraph numbers



// perhaps a seperate version of this program for updating answers?
// If they came from the clicked link, submit book information from table 
// to functions in order to generate same problem
// push update to table instead of adding to table

?>

</form>

</body>
<html>