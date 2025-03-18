<?php

function image_content_block_shortcode($atts = [], $content = null) {

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}

	$title = isset($atts['title']) ? $atts['title'] : '';
	$image = isset($atts['image']) ? $atts['image'] : '';
	$class = isset($atts['class']) ? $atts['class'] : '';
	$icon = isset($atts['icon']) ? '<i class="'.$atts['icon'].'"></i>' : '';

	$content = do_shortcode($content);

	?>

	<div class="imageContentBlock <?php echo $class ?>">
		<div class="imageContentBlock__imageTitleContent">
			<div class="imageContentBlock__image"><?php echo $icon ?></div>
			<div class="imageContentBlock__titleContent">
				<div class="imageContentBlock__title"><?php echo $title ?></div>
				<div class="imageContentBlock__content"><?php echo $content ?></div>
			</div>
		</div>
	</div>

<?php } ?>