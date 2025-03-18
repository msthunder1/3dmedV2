<?php

function checkUser() {
	
	// We have different user roles :
	// - administrator
	// - 3dmed_admin
	// - 3dmed_mini_admin
	// - 3dmed_stranka
	$user = wp_get_current_user();
	$userRole = $user->roles[0];

	// Load login possibilities according to user role
	userRoleLoginWindow($userRole);
}

function userRoleLoginWindow($userRole) {

	switch ($userRole) {
	    case "administrator":
	        $boxWidth = "box__tripple";
	        break;
	    case "3dmed_admin":
	        $boxWidth = "box__double";
	        break;
	    case "3dmed_mini_admin":
	        $boxWidth = "box__double";
	        break;
	    case "3dmed_stranka":
	        $page = get_permalink(29);
			wp_redirect($page);
			exit();
	        break;
	    default:
	        $boxWidth = "box__single";
	} 

	?>
	<div class="loginWindow">
		<div class="loginWindow__wrapper">
			<?php if($userRole === "administrator") { ?>
				<div class="loginWindow__box <?php echo $boxWidth ?> box__administrator">
					<a class="loginWindow__link" href="/wp-admin/">
						<div class="loginWindow__title">Comma</div>
					</a>
				</div>
			<?php } if($userRole !== "3dmed_stranka") {
				$page_url = get_permalink(27);
				$page_title = get_the_title(27);
				?>
				<div class="loginWindow__box <?php echo $boxWidth ?> box__3dmed_admin">
					<a class="loginWindow__link" href="<?php echo $page_url ?>">
						<div class="loginWindow__title"><?php echo $page_title ?></div>
					</a>
				</div>
			<?php }
			$page_url = get_permalink(29);
			$page_title = get_the_title(29);
			?>
			<div class="loginWindow__box <?php echo $boxWidth ?> box__3dmed_stranka">
				<a class="loginWindow__link" href="<?php echo $page_url ?>">
					<div class="loginWindow__title"><?php echo $page_title ?></div>
				</a>
			</div>
		</div>
	</div>
	<?php
}

?>