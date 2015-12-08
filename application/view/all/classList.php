<div class="container">
	<h2>Classes</h2>
	<div class="box">
<?php $this->renderFeedbackMessages(); ?>

	<table class="overview-table">
	<thead>
	<tr>
		<td>Class ID</td>
		<td>Class Name</td>
		<td>Number of paragraphs</td>
		<td>Class key</td>
		<td>Instructor</td>
	</tr>
	</thead>
<form action="processClass" method="post" enctype="multipart/form-data">
 <?php foreach ($this->classList as $class) { ?>
	 <tr>
	 <td><?= $class->class_id ?></td>
	 <td><?= $class->class_name ?></td>
	 <td><?= $class->num_paragraphs ?></td>
	 <td><?= $class->class_key ?></td>
	 <td><?= UserModel::getPublicProfileOfUser($class->instructor_id)->user_name ?></td>
	 </tr>
 <?php } ?>
 </table>
  <input type="submit">
</form>
	</div>
</div>
