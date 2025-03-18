<?php


function cenik_shortcode() {

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}

	// Get all sejanja
	$items = get_posts([
		'post_type' => 'ceniki',
		'post_status' => 'publish',
		'numberposts' => -1
	]);

	// If any, start render
	if($items) { ?>

		<div class="dataTable3dm">
			<table class="dataTable3dm__table js-dataTable__table">
				<thead class="dataTable3dm__head">
					<tr class="dataTable3dm__row">
						<th class="dataTable3dm__header">Vrsta cenika</th>
						<th class="dataTable3dm__header">Cena</th>
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
									<?php echo get_the_title($item_id); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php 
										$vrsta = getField__value('vrsta_cenika');
										if($vrsta === 'cenik_abc'){
											echo getCustom__cenikAbc('cenik_abc');
										} else if ($vrsta === 'spisek_cen'){
											echo getCustom__spisekCen('spisek_cen');
										} else {
											echo getField__value('cena') . '<span class="sign-eur">€</span>';
										}
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