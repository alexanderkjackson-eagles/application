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
        <?php if ($this->notes) { ?>
            <table class="note-table">
                <thead>
                <tr>
                    <td>Recipient</td>
                    <td>Message</td>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($this->notes as $key => $value) { ?>
                        <tr>
                            <!-- <td><?= $value->note_id; ?></td> TODO: RESTORE ME FOR DEVELOPMENT -->
			    <td>User</td>
                            <td><?= htmlentities($value->note_text); ?></td>
<!--
                            <td><a href="<?= Config::get('URL') . 'note/edit/' . $value->note_id; ?>">Edit</a></td>
                            <td><a href="<?= Config::get('URL') . 'note/delete/' . $value->note_id; ?>">Delete</a></td>
-->
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } else { ?>
                <div>No messages yet. Bother someone!</div>
            <?php } ?>
    </div>
</div>
