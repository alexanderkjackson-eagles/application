<?php
$db = mysqli_connect('localhost', 'root', 'aoP2d9br31zmeC3aEm3lx5Ni7zsVSsPeM8pWzRL8', 'huge');

if(!$db)
{
	print "Unable to connect to database.";
}


$classID = $_POST['classID'];
$paragraphParameter = $_POST['paragraphParameter'];
$className = $_POST['className'];
$classKey = $_POST['classKey'];
$instructorID = $_POST['instructorID'];
$sectionBooks = $_POST["myInputs"];

$sql_statement = "DELETE FROM `class` WHERE class_id = '".$classID."'"; 

$deletion = mysqli_query($db, $sql_statement);

if(!$deletion)
	{
		$errno = mysqli_errno($db);
			
		echo("<h4>MySQL No: ".mysqli_errno($db)."</h4>");
		echo("<h4>MySQL Error: ".mysqli_error($db)."</h4>");
		echo("<h4>SQL: ".$sql_query."</h4>");
		echo("<h4>MySQL Affected Rows: ".mysqli_affected_rows($db)."</h4>");
		
	}
	else
	{
		mysqli_query($db, $sql_statement);
	}

foreach($sectionBooks as $eachInput)
{
	$sql_query = "INSERT INTO class(class_id, num_paragraphs, class_name, class_key, instructor_id)";
	$sql_query .= "VALUES (";
	$sql_query .= "'".$classID."', '".$paragraphParameter."', '".$className."', '".$classKey."', '".$instructorID."', '".$eachInput."'";
	$sql_query .= ")";
	
	
	
	$update = mysqli_query($db, $sql_query);
	
	if(!$update)
	{
		$errno = mysqli_errno($db);
			
		echo("<h4>MySQL No: ".mysqli_errno($db)."</h4>");
		echo("<h4>MySQL Error: ".mysqli_error($db)."</h4>");
		echo("<h4>SQL: ".$sql_query."</h4>");
		echo("<h4>MySQL Affected Rows: ".mysqli_affected_rows($db)."</h4>");
		
	}
	else
	{
		mysqli_query($db, $sql_query);
	}
}

?>

<h3> Session updated! </h3>