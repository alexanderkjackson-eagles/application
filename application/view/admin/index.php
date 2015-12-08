<div class="container">
    <h1>Administrative controls</h1>

    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
	<!-- <?php AdminController::checkUpdate() ?> -->
	<ul>
	<li <?php if (View::checkForActiveControllerAndAction($filename, "admin/sessionCreator")) { echo ' class="active" '; } ?> >
	    <a href="<?php echo Config::get('URL'); ?>admin/sessionCreator">Create a research session.</a>
	</li>
	<li <?php if (View::checkForActiveControllerAndAction($filename, "admin/generateKey")) { echo ' class="active" '; } ?> >
	    <a href="<?php echo Config::get('URL'); ?>admin/generateKey">Generate/view keys.</a>
	</li>
	<li <?php if (View::checkForActiveControllerAndAction($filename, "admin/aggregateData")) { echo ' class="active" '; } ?> >
	    <a href="<?php echo Config::get('URL'); ?>admin/generateData">View data.</a>
	</li>
	<li <?php if (View::checkForActiveControllerAndAction($filename, "admin/uploadBook")) { echo ' class="active" '; } ?> >
	    <a href="<?php echo Config::get('URL'); ?>admin/uploadBook">Upload a book.</a>
	</li>
	<li <?php if (View::checkForActiveControllerAndAction($filename, "admin/bookList")) { echo ' class="active" '; } ?> >
	    <a href="<?php echo Config::get('URL'); ?>admin/bookList">View book list.</a>
	</li>
	<li <?php if (View::checkForActiveControllerAndAction($filename, "all/index")) { echo ' class="active" '; } ?> >
	    <a href="<?php echo Config::get('URL'); ?>all/index">Contribute data.</a>
	</li>
	<li <?php if (View::checkForActiveControllerAndAction($filename, "all/classList")) { echo ' class="active" '; } ?> >
	    <a href="<?php echo Config::get('URL'); ?>all/classList">View classes.</a>
	</li>
	<li><a href="https://projectweb.site/phpmyadmin/">Manipulate Database</a>
	</ul>
    </div>
</div>
