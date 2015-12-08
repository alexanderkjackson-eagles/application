<div class="container">
	<div class="box">
		<div>
            <table class="overview-table">
	    	<center><strong>Books</center></strong>
                <thead>
                <tr>
                    <td>Book ID</td>
                    <td>Title</td>
                    <td>Author</td>
                    <td>Paragraphs</td>
		    <td>Select</td>
                </tr>
                </thead>
                <?php foreach ($this->books as $book) { ?>
			<tr>
			<td><?= $book->book_id ?></td>
                        <td><?= $book->title ?></td>
                        <td><?= $book->author; ?></td>
                        <td><?= $book->sections; ?></td>
			<td><input type="checkbox" name="book_id_<?= $book->book_id ?>" value="<?= $book->book_id ?>" unchecked /></td>
                        </tr>
                <?php } ?>
            </table>
		</div>
	</div>
</div>
