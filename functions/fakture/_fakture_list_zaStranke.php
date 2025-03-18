<?php

function pregled_faktur_stranke_shortcode($atts = []) {

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}

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
			array(
				'key' => 'stranka',
				'value' => $podjetje_id,
			)
		),
		'numberposts' => -1,
	]);

	// If any, start render
	if($items) { ?>

		<div class="dataTable3dm">
			<table class="dataTable3dm__table js-dataTable__table_faktureForStranka">
				<thead class="dataTable3dm__head">
					<tr class="dataTable3dm__row">
						<th class="dataTable3dm__header">Številka fakture</th>
						<th class="dataTable3dm__header">Datum</th>
						<th class="dataTable3dm__header">Cena</th>
						<th class="dataTable3dm__header">Status fakture</th>
						<th class="dataTable3dm__header">Status plačila</th>
					</tr>
				</thead>
				<tbody class="dataTable3dm__body">

					<?php
					foreach($items as $item){

						$item_id = $item->ID;
						$item_url = isset($user_id) ? get_permalink($item_id).'?userid='.$user_id : get_permalink($item_id);
						global $post; 
						$post = get_post( $item_id, OBJECT );
						setup_postdata( $post );
						$test = get_fields();
						$status = getField__value('status_fakture');
						$status_placila_obj = get_field('status_placila');
						$status_placila_value = "";
						$status_placila_label = "";

						if($status_placila_obj) {
							$status_placila_value = $status_placila_obj["value"];
							$status_placila_label = $status_placila_obj["label"];
						}

						?>

						<tr class="dataTable3dm__row">
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo get_the_title($item_id); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo get_the_date('d.m.Y \ob H:i', $item_id); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo getField__value('cena'); ?> €
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo $status ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a class="dataTable3dm__statusPlacila <?php echo $status_placila_value ?>" href="<?php echo $item_url ?>">
									<?php echo $status_placila_label ?>
								</a>
							</td>
						</tr>

						<?php wp_reset_postdata(); } ?>

				</tbody>
			</table>
		</div>

	<?php }
	
}

function updateUserCompanyIdField($user_id){

	$podjetje_ime = get_field('podjetje', 'user_'.$user_id);

	$podjetje_obj = get_posts([
		'post_type' => 'stranke',
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => 'ime_podjetja',
				'value' => $podjetje_ime,
			)
		),
		'numberposts' => 1,
	]);

	if($podjetje_obj){
		$podjetje_id = $podjetje_obj[0]->ID;
		update_field('id_podjetja', $podjetje_id, 'user_'.$user_id);
		return $podjetje_id;
	}

	echo "Uporabnik ni pripisan nobenemu podjetju. Obrnite se na administratorja.";

}

 ?>