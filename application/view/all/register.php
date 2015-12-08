<?php
	$database = DatabaseFactory::getFactory()->getConnection();
	$sql = "SELECT * FROM `class` WHERE `class_key` = :class_key;";
	$query = $database->prepare($sql);
	$query->execute(array(
		":class_key" => $_POST['classKey']
		));
	$class_id = $query->fetch()->class_id;
	$sql = "UPDATE `users` SET `class_id` = :class_id WHERE `user_id` = :user_id;";
	$query = $database->prepare($sql);
	$user_id = Session::get('user_id');
	$query->execute(array(
		':class_id' => $class_id,
		':user_id' => $user_id
		));
	Redirect::to('student/');
?>
