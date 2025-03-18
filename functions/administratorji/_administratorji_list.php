<?php

function administratorji_shortcode() {

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}

	// Get all the users in teh appropriet roles
	$users = get_users( array( 'role__in' => ['3dmed_admin', '3dmed_mini_admin']));

	// If any, start render
	if($users){ ?>

		<div class="dataTable3dm">
			<table class="dataTable3dm__table js-dataTable__table_administratorji">
				<thead class="dataTable3dm__head">
					<tr class="dataTable3dm__row">
						<th class="dataTable3dm__header"></th>
						<th class="dataTable3dm__header">Ime</th>
						<th class="dataTable3dm__header">Priimek</th>
						<th class="dataTable3dm__header">Podjetje</th>
						<th class="dataTable3dm__header">Vloga</th>
					</tr>
				</thead>
				<tbody class="dataTable3dm__body">

					<?php
					foreach($users as $user){

						$user_id = (int)$user->data->ID;
						$user_meta = get_user_meta($user_id);
						$user_data = get_userdata($user_id);
						$profilePage = get_page_link(402);

						?>

						<tr class="dataTable3dm__row">
							<td class="dataTable3dm__cell delete">
								<a class="js-list-delete-user" data-user-id="<?php echo $user_id ?>" href="#">
									<i class="fas fa-user-minus"></i>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $profilePage.'?userid='.$user_id; ?>">
									<?php echo $user_meta['first_name'][0]; ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $profilePage.'?userid='.$user_id; ?>">
									<?php echo $user_meta['last_name'][0]; ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $profilePage.'?userid='.$user_id; ?>">
									<?php echo get_field('podjetje', 'user_'.$user_id); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $profilePage.'?userid='.$user_id; ?>">
									<?php echo $user_data->roles[0]; ?>
								</a>
							</td>
						</tr>

					<?php } ?>

				</tbody>
			</table>
		</div>

	<?php }
}

?>