<div class="container">
	<h1>Answer questions</h1>
	<div class="box">
<?php $this->renderFeedbackMessages(); ?>
<body>
	<form action="processAnswer" method="post" enctype="multipart/form-data">
	</form>
	<?php $this->renderWithoutHeaderAndFooter("all/questionGenerator") ?>
	</div>
</div>
</body>
