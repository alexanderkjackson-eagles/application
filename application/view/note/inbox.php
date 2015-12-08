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
