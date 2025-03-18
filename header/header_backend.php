<div class="header__wrapper">
	
	<?php include('_header__logo.php') ?>

	<div class="header__menu backendMenu">
		<div class="header__hamburger hamburgerIcon js-toggleMenu">
			<span class="hamburgerIcon__line hamburgerIcon__line1"></span>
			<span class="hamburgerIcon__line hamburgerIcon__line2"></span>
			<span class="hamburgerIcon__line hamburgerIcon__line3"></span>
		</div>
		<div class="backendMenu__wrapper js-menu">
			<?php
			$args = array(
				'menu'	=> 1,
				'menu_class' => 'backendMenu__menu'
			);
			wp_nav_menu($args);
			?>
		</div>
	</div>
</div>