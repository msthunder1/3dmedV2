<?php

function backend_welcome_screen_shortcode() {

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}

	?>
	<div class="welcomebox">
		<?php welcome_box('Naročila', 114, 'orange');?>
		<?php welcome_box('Naročila', 116, 'lightorange');?>
		<?php welcome_box('Naročila', 119, 'lightorange');?>
	</div>
	<?php
}

function welcome_box($label = '', $id, $theme = ''){

	$page_title = get_the_title($id);
	$page_link = get_permalink($id);

	?>

	<div class="welcomebox__item <?php echo $theme ?>">
		<a class="welcomebox__link" href="<?php echo $page_link ?>">
			<div class="welcomebox__label"><?php echo $label ?></div>
			<div class="welcomebox__title"><?php echo $page_title ?></div>
		</a>
	</div>

	<?php

} ?>