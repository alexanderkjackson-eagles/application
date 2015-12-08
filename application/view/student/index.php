<div class="container">
    <h1>Student functionality</h1>

    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

		<ul>
		<li> 
			<a href="<?php echo Config::get('URL'); ?>all/index">Contribute data.</a>
		</li>
		<li> 
			<a href="<?php echo Config::get('URL'); ?>all/studentList">View students in class.</a>
		</li>
		<li>
			<a href="<?php echo Config::get('URL'); ?>all/joinClass">Join another class.</a>
		</li>
		<li>
			<a href="<?php echo Config::get('URL'); ?>all/viewAnswers">View answers.</a>
		</li>
		<li> 
			<a href="<?php echo Config::get('URL'); ?>all/elevate">Become instructor/administrator.</a>
		</li>
		</ul>
    </div>
</div>
