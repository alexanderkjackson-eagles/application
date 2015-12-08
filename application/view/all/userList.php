<?php $this->renderFeedbackMessages(); ?>

	<table class="overview-table">
	<center><strong>Users</center></strong>
	<thead>
	<tr>
		<td>User Name</td>
		<td>Avatar</td>
		<td>Select</td>
	</tr>
	</thead>
 <?php foreach ($this->userList as $user) { ?>
	 <tr>
	 <td><a href="<?= Config::get('URL') . 'profile/showProfile/' . $user->user_id ?>"><?= $user->user_name?></a></td>
	 <td class="avatar"><img src="<?= $user->user_avatar_link ?>"/></td>
	 <td><input type="checkbox" name="user_id_<?=$user->user_id?>" value="<?=$user->user_id?>">
	 </tr>
 <?php } ?>
 </table>
</div>
