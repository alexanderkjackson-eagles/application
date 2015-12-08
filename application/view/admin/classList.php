        
	<div>
            <table class="overview-table">
	    	<center><strong>Select instructor</strong></center>
                <thead>
                <tr>
                    <td>Id</td>
                    <td>Avatar</td>
                    <td>Username</td>
                    <td>User's email</td>
                    <td>Link to user's profile</td>
                    <td>Select</td>
                </tr>
                </thead>
                <?php foreach ($this->instructors as $user) { ?>
                    <tr class="<?= ($user->user_active == 0 ? 'inactive' : 'active'); ?>">
                        <td><?= $user->user_id; ?></td>
                        <td class="avatar">
                            <?php if (isset($user->user_avatar_link)) { ?>
                                <img src="<?= $user->user_avatar_link; ?>"/>
                            <?php } ?>
                        </td>
                        <td><?= $user->user_name; ?></td>
                        <td><?= $user->user_email; ?></td>
                        <td>
                            <a href="<?= Config::get('URL') . 'profile/showProfile/' . $user->user_id; ?>">Profile</a>
                        </td>
                            <td><input type="radio" name="select_instructor"  value="<?= $user->user_id ?>" /></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
