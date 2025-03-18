<?php

function sejanje_shortcode() {

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}

	// Get all sejanja
	$items = get_posts([
		'post_type' => 'sejanja',
		'post_status' => 'publish',
		'numberposts' => -1
	]);

	// If any, start render
	if($items) { ?>

		<div class="dataTable3dm">
			<table class="dataTable3dm__table js-dataTable__table">
				<thead class="dataTable3dm__head">
					<tr class="dataTable3dm__headerRow">
						<th class="dataTable3dm__header">ID</th>
						<th class="dataTable3dm__header">Naslov</th>
						<th class="dataTable3dm__header">Material</th>
						<th class="dataTable3dm__header">Vsebnik</th>
						<th class="dataTable3dm__header">Sito</th>
						<th class="dataTable3dm__header">Datum sejanja</th>
						<th class="dataTable3dm__header">Sejalec</th>
						<th class="dataTable3dm__header">Šarža</th>
						<th class="dataTable3dm__header">Datum urejanja</th>
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
						?>

						<tr class="dataTable3dm__row">
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo $item_id; ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo get_the_title($item_id); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php
									$material_id = getField__value('material');
									$material = get_the_title($material_id);
									echo $material;
									?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo getField__value('vsebnik'); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo getField__value('sito'); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo getField__value('datum_sejanja'); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php
									$sejalec_id = getField__value('sejalec');
									$user = get_user_meta($sejalec_id);
									$sejalec = $user ? $user['first_name'][0].' '.$user['last_name'][0] : '';
									echo $sejalec;
									?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo getField__value('sarza'); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo $item->post_modified; ?>
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