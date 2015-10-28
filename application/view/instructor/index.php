<div class="container">
    <h1>Instructor/index</h1>

    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>What happens here ?</h3>

        <div>
	This section will contain information and features only accessible to instructors. This should populate with pupils.
        </div>
	<?php 
		if(isset($_GET['page'])){
			$var = $_GET['page'];
			include '/var/www/html/our-html/Instructor Forms/' . $var;
			if ($var == 'studentData.html')
				include '/var/www/html/application/view/instructor/student_list.php';
		}
		else
			include '/var/www/html/our-html/Instructor Forms/instructor.html';
	?>
    </div>
</div>
