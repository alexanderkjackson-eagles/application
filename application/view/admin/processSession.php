<?php
	$target_dir = "data/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

	echo $target_dir;
	echo $target_file;
?>
