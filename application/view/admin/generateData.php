<div class="container">
	<h1>Display data</h1>
	<div class="box">
<?php $this->renderFeedbackMessages(); ?>
<body>
    <form action="processData" method="post" enctype="multipart/form-data">
    <?php $this->renderWithoutHeaderAndFooter("admin/bookList") ?>
    </p>
    <input type="submit" />
    </form>
	</div>
</div>
</body>
