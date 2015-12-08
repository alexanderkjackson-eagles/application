<div class="container">
	<h1>Outbox</h1>
	<?php 
		$database = DatabaseFactory::getFactory()->getConnection();
		$sql = "SELECT * FROM notes WHERE sender_id = :user_id";
		$query = $database->prepare($sql);
		$query->execute(array(
			':user_id' => Session::get('user_id')
			));
		$res = $query->fetchAll();
		if ($res) {
	?>
            <table class="note-table">
                <thead>
                <tr>
                    <td>Note ID</td>
		    <td>Recipient</td>
                    <td>Message</td>
		    <td>Delete?</td>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($res as $note) { ?>
                        <tr>
                            <td><?= $note->note_id; ?></td> 
			    <td><a href="<?= Config::get('URL') . "profile/showProfile/" . $note->user_id ?>"><?= UserModel::getPublicProfileOfUser($note->user_id)->user_name ?></a></td>
			    <td><?= htmlentities($note->note_text); ?></td>
                            <td><a href="<?= Config::get('URL') . 'note/delete/' . $note->note_id; ?>">Delete</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } else { ?>
                <div>No messages.</div>
            <?php } ?>
</div>
