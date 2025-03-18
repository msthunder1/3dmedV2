<?php

function stranke_shortcode() {

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}

	// Get all stranke
	$items = get_posts([
		'post_type' => 'stranke',
		'post_status' => 'publish',
		'numberposts' => -1
	]);

	// If any, start render
	if($items) { ?>

		<div class="dataTable3dm">
			<table class="dataTable3dm__table js-dataTable__table">
				<thead class="dataTable3dm__head">
					<tr class="dataTable3dm__headerRow">
						<th class="dataTable3dm__header"></th>
						<th class="dataTable3dm__header">Ime podjetja</th>
						<th class="dataTable3dm__header">Davčna številka</th>
						<th class="dataTable3dm__header">Zavezanec za DDV</th>
						<th class="dataTable3dm__header">Naslov</th>
						<th class="dataTable3dm__header">Poštna številka</th>
						<th class="dataTable3dm__header">Kraj</th>
						<th class="dataTable3dm__header">Država</th>
						<th class="dataTable3dm__header">E-naslov</th>
						<th class="dataTable3dm__header">Telefon</th>
						<th class="dataTable3dm__header">Zastopnik</th>
					</tr>
				</thead>
				<tbody class="dataTable3dm__body">

					<?php
					foreach($items as $item){

						$item_id = $item->ID;
						$item_url = get_permalink($item_id);
						global $post; 
						$post = get_post( $item_id, OBJECT );
						setup_postdata( $post );
						$zastopnik_id = getField__value('zastopnik');
						?>

						<tr class="dataTable3dm__row">
							<td class="dataTable3dm__cell delete">
								<a class="js-list-delete-stranka" data-item-id="<?php echo $item_id ?>" data-zastopnik-id="<?php echo $zastopnik_id ?>" href="#">
									<i class="fas fa-trash-alt"></i>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo getField__value('ime_podjetja'); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo getField__value('davcna_stevilka'); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo getField__value('zavezanec_za_ddv'); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo getField__value('naslov'); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo getField__value('postna_stevilka'); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo getField__value('kraj'); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo getField__value('drzava'); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo getField__value('e-naslov_podjetja'); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo getField__value('telefon_podjetja'); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php
									$user = get_user_meta($zastopnik_id);
									$zastopnik = $user ? $user['first_name'][0].' '.$user['last_name'][0] : '';
									echo $zastopnik;
									?>
								</a>
							</td>
						</tr>

						<?php 
						wp_reset_postdata();
						} ?>

				</tbody>
			</table>
		</div>
		
	<?php }

}

?>