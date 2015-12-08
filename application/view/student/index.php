<div class="container">
    <h1>Student/index</h1>

    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>What happens here ?</h3>
	<div>
		This section populates with student stuff.
	</div>
	<?php 
		if(isset($_GET['page'])){
			$var = $_GET['page'];
			if ($var == 'students.html')
				include '/var/www/html/application/view/student/student_list.php';
			
			else
				include '/var/www/html/our-html/StudentForms/' . $var;
		}
		else
			include '/var/www/html/our-html/StudentForms/pupil.html';
	?>
    </div>
</div>
