<div class="container">
    <h1>Admin/index</h1>

    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>What happens here ?</h3>
	ELECTRIC BOOGALOO
        <div>
            This controller/action/view checks for an update and automatically installs it if found. Additionally, it provides the basic admin page to demonstrate use cases for administrators (researchers).
        </div>
	<a href="<?php echo Config::get('URL'); ?>index/index">Index</a>
	<div class="box">
	<?php AdminController::checkUpdate() ?>
	<?php 
		if(isset($_GET['page'])){ // If ?page= exists
			$var = $_GET['page'];
			include '/var/www/html/our-html/Admin Forms/' . $var;
		}
		else
			include '/var/www/html/our-html/Admin Forms/admin.html';
	?>
	</div>
<!--        <div>
//            <table class="overview-table">
//                <thead>
//                <tr>
//                    <td>Id</td>
//                    <td>Avatar</td>
//                    <td>Username</td>
//                    <td>User's email</td>
//                    <td>Activated ?</td>
//                    <td>Link to user's profile</td>
//                    <td>suspension Time in days</td>
//                    <td>Soft delete</td>
//                    <td>Submit</td>
//                </tr>
//                </thead>
//                <?php foreach ($this->users as $user) { ?>
//                    <tr class="<?= ($user->user_active == 0 ? 'inactive' : 'active'); ?>">
//                        <td><?= $user->user_id; ?></td>
//                        <td class="avatar">
//                            <?php if (isset($user->user_avatar_link)) { ?>
//                                <img src="<?= $user->user_avatar_link; ?>"/>
//                            <?php } ?>
//                        </td>
//                        <td><?= $user->user_name; ?></td>
//                        <td><?= $user->user_email; ?></td>
//                        <td><?= ($user->user_active == 0 ? 'No' : 'Yes'); ?></td>
//                        <td>
//                            <a href="<?= Config::get('URL') . 'profile/showProfile/' . $user->user_id; ?>">Profile</a>
//                        </td>
//                        <form action="<?= config::get("URL"); ?>admin/actionAccountSettings" method="post">
//                            <td><input type="number" name="suspension" /></td>
//                            <td><input type="checkbox" name="softDelete" <?php if ($user->user_deleted) { ?> checked <?php } ?> /></td>
//                            <td>
//                                <input type="hidden" name="user_id" value="<?= $user->user_id; ?>" />
//                                <input type="submit" />
//                            </td>
//                        </form>
//                    </tr>
//                <?php } ?>
//            </table>
//        </div>
-->
    </div>
</div>
