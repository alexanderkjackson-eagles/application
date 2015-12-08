<div class="container">
	<h1>Answer a question</h1>
	<div class="box">
<?php $this->renderFeedbackMessages(); ?>
<body>
<center><p>Select the tag that <strong>best</strong> describes the subject of the excerpt. If the excerpt transitions to other subjects, select the subject of the later paragraphs.</p></center>
	<p><strong>Excerpt</p></strong>
	<p><?= $this->question["text"] ?></p>

<form action="processAnswer" method="post" enctype="multipart/form-data">
  <input list="tags" name="tag">
  <datalist id="tags">
 <?php foreach ($this->question["tags"] as $tag) { ?>
    <option value="<?= $tag; ?>">
 <?php } ?>
  </datalist>
  <input type="submit">
</form>
	</div>
</div>
