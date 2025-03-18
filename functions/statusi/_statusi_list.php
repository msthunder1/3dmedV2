<?php

function statusi_shortcode() {

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}

	// Get all sejanja
	$items = get_posts([
		'post_type' => 'statusi',
		'post_status' => 'publish',
		'numberposts' => -1
	]);

	// If any, start render
	if($items) { ?>

		<div class="dataTable3dm">
			<table class="dataTable3dm__table js-dataTable__table">
				<thead class="dataTable3dm__head">
					<tr class="dataTable3dm__row">
						<th class="dataTable3dm__header">Naslov</th>
						<th class="dataTable3dm__header">Barva</th>
						<th class="dataTable3dm__header">Pozicija</th>
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

						// Get Color first for coloring the texts
						$barva = getField__value('barva');
						?>

						<tr class="dataTable3dm__row">
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo get_the_title($item_id); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<div style="color:<?php echo $barva ?>;"><?php echo $barva ?></div>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo getField__value('pozicija'); ?>
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