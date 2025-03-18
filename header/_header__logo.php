<?php

$logo = srcset_image(876, '(max-width: 767px) 250px, (max-width: 1024px) 479px, 768px', 'header__image', false);

?>

<div class="header__logo">
	<a class="header__link" href="<?php echo site_url(); ?>">
		<?php echo $logo ?>
		<div class="header__label">Rezervacijska platforma</div>
	</a>
</div>