<div class="header__wrapper">
	
	<?php include('_header__logo.php') ?>

	<div class="header__menu frontendMenu">
		<div class="header__hamburger hamburgerIcon js-toggleMenu">
			<span class="hamburgerIcon__line hamburgerIcon__line1"></span>
			<span class="hamburgerIcon__line hamburgerIcon__line2"></span>
			<span class="hamburgerIcon__line hamburgerIcon__line3"></span>
		</div>
		<div class="frontendMenu__wrapper js-menu">
			<?php

			global $current_user;
			$user = wp_get_current_user();
			$user_id = $user->ID;

			$podjetje_id = get_field('id_podjetja', 'user_'.$user_id);

			if(!$podjetje_id){
				$podjetje_id = updateUserCompanyIdField($user_id);
			}

			$items = get_posts([
				'post_type' => 'fakture',
				'post_status' => 'publish',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'stranka',
						'value' => $podjetje_id,
					),
					array(
						'key'		=> 'status_placila',
						'value'		=> 'neplacano',
						'compare'	=> '='
					),
				),
				'numberposts' => -1,
			]);

			$menuClass = 'frontendMenu__menu';

			if (sizeof($items) > 0) {
				$menuClass = 'frontendMenu__menu neplacano';
			}

			$args = array(
				'menu'	=> 4,
				'menu_class' => $menuClass
			);
			wp_nav_menu($args);
			?>
		</div>
	</div>
</div>