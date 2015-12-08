<!doctype html>
<html>
<head>
    <title>Project</title>
    <!-- META -->
    <meta charset="utf-8">
    <!-- send empty favicon fallback to prevent user's browser hitting the server for lots of favicon requests resulting in 404s -->
    <link rel="icon" href="data:;base64,=">
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/style.css" />
</head>
<body>
    <!-- wrapper, to center website -->
    <div class="wrapper">

        <!-- logo
        <div class="logo"></div> -->

        <!-- navigation -->
        <ul class="navigation">
	<!--
	    <li <?php if (View::checkForActiveController($filename, "profile")) { echo ' class="active" '; } ?> >
                <a href="<?php echo Config::get('URL'); ?>profile/index">Profiles</a>
            </li>
        -->
            <?php if (Session::userIsLoggedIn()) { ?>
	    <!--
                <li <?php if (View::checkForActiveController($filename, "dashboard")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>dashboard/index">Dashboard</a>
                </li>
	    -->
                <li <?php if (View::checkForActiveController($filename, "note")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>note/index">Messaging</a>
		    <ul class="navigation-submenu">
		    <li>
		    	<a href="<?= Config::get('URL') . 'note/index'?>">Inbox</a>
		    </li>
		    <li>
		    	<a href="<?= Config::get('URL') . 'note/outbox'?>">Outbox</a>
		    </li>
		    <li>
		    	<a href="<?= Config::get('URL') . 'note/compose'?>">Compose</a>
		    </li>
		    </ul>
                </li>
            <?php } else { ?>
                <!-- for not logged in users -->
            <?php } ?>
        </ul>

        <!-- my account -->
        <ul class="navigation right">
        <?php if (Session::userIsLoggedIn()) : ?>
            <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                <a href="<?php echo Config::get('URL'); ?>login/showprofile">My Account</a>
                <ul class="navigation-submenu">
                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>all/elevate">Change account type</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>login/editAvatar">Edit your avatar</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>login/editusername">Edit my username</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>login/edituseremail">Edit my email</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>login/changePassword">Change Password</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>login/logout">Logout</a>
                    </li>
                </ul>
            </li>
            <?php if (Session::get("user_account_type") == 7) : ?>
                <li <?php if (View::checkForActiveController($filename, "admin")) {
                    echo ' class="active" ';
                } ?> >
                    <a href="<?php echo Config::get('URL'); ?>admin/">Admin</a>
                </li>
            <?php endif; ?>
	    
	    <?php if (Session::get("user_account_type") == 6) : ?>
	    	<li <?php if (View::checkForActiveController($filename, "instructor")) {
			echo ' class="active" ';
		} ?> >
			<a href="<?php echo Config::get('URL'); ?>instructor/">instructors</a>
		</li>
	    <?php endif; ?>
	    <?php if (Session::get("user_account_type") == 5) : ?>
	    	<li <?php if (View::checkForActiveController($filename, "student")) {
			echo ' class="active" ';
		} ?> >
			<a href="<?php echo Config::get('URL'); ?>student/">students</a>
		</li>
	    <?php endif; ?>
        <?php endif; ?>
        </ul>
