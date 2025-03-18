<?php

	$user = wp_get_current_user();

	$is_user = $user->exists();

	if(!$is_user){
		return;
	}


	$user_id = $user->ID;
	$user_name = $user->display_name;

	$podjetje_id = get_field('id_podjetja', "user_${user_id}");
	$podjetje_name = $podjetje_id ? ', '.get_the_title($podjetje_id) : '';

?>

<div class="loggedInAs">
	<div class="loggedInAs__icon"><i class="fas fa-user"></i></div>
	<div class="loggedInAs__label">V sistem ste prijavljeni kot</div>
	<div class="loggedInAs__data"><?php echo $user_name . $podjetje_name?></div>
</div>