<?php $this->renderFeedbackMessages(); 
$user_id = Session::get('user_id');
$sql = "SELECT * FROM `answers` WHERE `user_id` = :user_id;";
$database = DatabaseFactory::getFactory()->getConnection();
$query = $database->prepare($sql);
$query->execute(array(
	':user_id' => $user_id
	));

$answerList = array();
	while ($res = $query->fetch(PDO::FETCH_ASSOC))
		array_push($answerList, $res);
?>
<div class="container">
	<table class="overview-table">
	<center><strong>Previous answers</center></strong>
	<thead>
	<tr>
		<td>Section Text</td>
		<td>Book Title</td>
		<td>Class Name</td>
		<td>Answer</td>
	</tr>
	</thead>
 <?php foreach ($answerList as $answer) { ?>
	 <tr>
	 <td><?= AllModel::getTruncatedSectionText($answer['section_id']) ?></td>
	 <td><?= AllModel::getBookTitle($answer['book_id']) ?></td>
	 <td><?= AllModel::getClassName($answer['class_id']) ?></td>
	 <td><?= $answer['tag']?></td>
	 </tr>
 <?php } ?>
 </table>
</div>
