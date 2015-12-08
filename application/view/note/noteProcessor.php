<?php
echo "<br>";
$text = $this->data['text'];
$user_ids = array();
foreach ($_POST as $key => $value)
	if (substr($key, 0, 8) == "user_id_")
		array_push($user_ids, $value);

$sql = "INSERT INTO `notes` (`note_id`, `note_text`, `user_id`, `sender_id`) VALUES (NULL, :note_text, :user_id, :sender_id);";
$database = DatabaseFactory::getFactory()->getConnection();
$query = $database->prepare($sql);
foreach ($user_ids as $user_id){
	$query->execute(array(
		':note_text' => $text,
		':user_id' => $user_id,
		':sender_id' => Session::get('user_id')
		));
}
Redirect::to("note/index");
?>
