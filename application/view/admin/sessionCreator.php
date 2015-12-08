<div class="container">
	<h1>Create a session</h1>
	<div class="box">
<?php $this->renderFeedbackMessages(); ?>
<body>
    <form action="processSession" method="post" enctype="multipart/form-data">
    <p><strong>Number of Paragraphs to be Generated: </strong><br>
    <input type='text' name='paragraphParameter' size='10' />
    <p><strong>Name of class: </strong><br>
    <input type='text' name='class_name' size='48' />
    </p>
			
    <div id="addSession">
    <?php $this->renderWithoutHeaderAndFooter("admin/instructorList"); ?>
    </div>

	<?php $this->renderWithoutHeaderAndFooter("admin/bookList") ?>
		 
		<br><br><input type="submit" />
    </form>
	</div>
</div>
</body>
