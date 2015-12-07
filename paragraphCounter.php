<!DOCTYPE HTML PUBLIC >

<html>
<head>
	<title>Paragraph Counter</title>
	
</head>

<body>

<h3>Paragraph Count:</h3>

<?php 

	$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
	
	$filename = $DOCUMENT_ROOT.'data/'.'countingRobinsonCrusoe.txt';
	
	$lines_in_file = count(file($filename));
	
	$fp = fopen($filename, 'r'); // opens Kipling.txt for reading
	
	$paragraph_count = 0;
	
	for ($i = 0; $i <= $lines_in_file; $i++)
	{
		$line = fgets($fp);
		$line = trim($line);
		
		if ($line == '')
		{
			$paragraph_count+=1;
		}
		
	}
	
	print $paragraph_count;

	fclose($fp);
?>
	
	