<?php
/* Basically defines a paragraph as a string containing 100 or more words. Paragraphs in Gutenberg books are separated by \n\n, but, unfortunately, so is other information.
*/
	$database = DatabaseFactory::getFactory()->getBooksConnection();
	$sql = "INSERT INTO :bookname ";
	$input = file_get_contents("Emma.txt");
	$paragraphs = explode("\n\n", $input);
	for ($i = 0; $i < sizeof($paragraphs); $i++){
	  $output = $paragraphs[$i];
	  while ( str_word_count($output) < 100 ){
	  	$output = $output . $paragraphs[++$i];
	  }
	}
?>
