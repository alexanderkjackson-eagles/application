<div class="container">
    <h1>Admin/index</h1>

    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
	<!-- <?php AdminController::checkUpdate() ?> -->
	<ul>
	<li <?php if (View::checkForActiveControllerAndAction($filename, "admin/sessionCreator")) { echo ' class="active" '; } ?> >
	    <a href="<?php echo Config::get('URL'); ?>admin/sessionCreator">Create a research session.</a>
	</li>
	<li <?php if (View::checkForActiveControllerAndAction($filename, "admin/sessionEditor")) { echo ' class="active" '; } ?> >
	    <a href="<?php echo Config::get('URL'); ?>admin/sessionEditor">View or edit a research session.</a>
	</li>
	<li <?php if (View::checkForActiveControllerAndAction($filename, "admin/aggregateData")) { echo ' class="active" '; } ?> >
	    <a href="<?php echo Config::get('URL'); ?>admin/aggregateData">View aggregate research data.</a>
	</li>
	<li><a href="https://projectweb.site/phpmyadmin/">Manipulate Database</a>
	<li><a href="?page=../StudentForms/pupil.html">Be an imposter student</a>
	</ul>
	<!--
	<?php 
		if(isset($_GET['page'])){ // If ?page= exists
			$var = $_GET['page'];
			include '/var/www/html/our-html/Admin Forms/' . $var;
		}
		else
			include '/var/www/html/our-html/Admin Forms/admin.html';
	?>
	-->
    </div>
</div>
