<?php
$this->renderFeedbackMessages(); 
$section_id = $_GET['section_id'];
?>

<div class="container">
	<center><strong>Section number <?= $section_id ?></center></strong>
	<p><?= AllModel::getSectionText($section_id) ?></p>
</div>
