<div class="container">
    <h1>NoteController/index</h1>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
	
        <h3>What happens here ?</h3>
        <p>
		A simple message sending example.
        </p>
	<!--< ?php include(Config::get('URL') . 'profile/index.php') ?> TODO: FIXME -->
	<div> <!-- TODO: Fix me. This is copy-pasted code! -->
            <table class="overview-table">
                <thead>
                <tr>
		    <td>Select</td>
                    <td>Avatar</td>
                    <td>Username</td>
                </tr>
                </thead>
		<td><input type="checkbox" name="Select"/></td>	
                        <td class="avatar">
                                                            <img src="https://projectweb.site/avatars/default.jpg" />
                                                    </td>
                        <td><a href="https://projectweb.site/profile/showProfile/1">administrator</a></td>
                    </tr>
		    <td><input type="checkbox" name="Select"/></td>	
                        <td class="avatar">
                                                            <img src="https://projectweb.site/avatars/default.jpg" />
                                                    </td>
                        <td><a href="https://projectweb.site/profile/showProfile/2">Instructor</a></td>
                    </tr>
                            </table>
        </div>
	<!--
        <p>
            <form method="post" action="<?php echo Config::get('URL');?>note/create">
                <label>Text of new note: </label><input type="text" name="note_text" />
                <input type="submit" value='Create this note' autocomplete="off" />
            </form>
        </p>
	-->
	<?php include '/var/www/html/application/view/note/contactForm.html' ?>
        <?php if ($this->notes) { ?>
            <table class="note-table">
                <thead>
                <tr>
                    <td>Recipient</td>
                    <td>Message</td>
                    <!-- <td>EDIT</td>
                    <td>DELETE</td>
		    -->
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
