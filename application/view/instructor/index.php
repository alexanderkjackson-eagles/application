<!--
Author: Joseph Jones 
Working From Design Document: "System Architecture Document"
Section: Site Map

Purpose: This is the page showing the Instructor's site options


 -->


<div class="container">
    <h1>Instructor functionality</h1>

    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
	<ul>
	<li><a href="<?= Config::get('URL') . 'all/index' ?>">Contribute data</a></li>
	<li><a href="<?= Config::get('URL') . 'all/viewAnswers' ?>">View previous answers</a></li>
	<li><a href="<?= Config::get('URL') . 'all/studentList' ?>">View students registered to class</a></li>
	<li><a href="<?= Config::get('URL') . 'all/elevate' ?>">Become an administrator</a></li>
	</ul>
    </div>
</div>
