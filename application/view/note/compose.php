<div class="container">
    <h1>NoteController/index</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
	
        <h3>Messages.</h3>
        <p>
		Here you may send messages to users by selecting them and submitting a text form.
        </p>
	<form method="post" enctype="multipart/form-data" action="<?= Config::get("URL") . "note/create" ?>">
	<?php $this->renderWithoutHeaderAndFooter("all/userList", array(
		"userList" => UserModel::getPublicProfilesOfAllUsers()
		)); ?><br>

	<?php include '/var/www/html/application/view/note/contactForm.html' ?>
	<input type="submit">
    </div>
</div>
