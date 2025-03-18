<?php

function list_narocila_for_stranka($data) {

	$podjetje_ime = $_POST['podjetje_ime'];
	$podjetje_id = $_POST['podjetja_id'];

	if($podjetje_ime === ''){
		die();
	}

	// Get all naročila from stranka
	$items = get_posts([
		'post_type' => 'narocila',
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => 'narocnik_id',
				'value' => $podjetje_id,
			),
			array(
				'key' => 'postavi_status',
				'value' => 193,
				'compare' => '=',
			),
			array(
				'key' => 'status_fakture',
				'value' => 'Odprto',
			)
		),
		'numberposts' => -1
	]);

	if(!empty($items)){ ?>

		<div class="dataTable3dm faktureResponseData">
			<form method='post' name='createFaktura' class='form' enctype='multipart/form-data'>
				<table class="dataTable3dm__table js-dataTable__table">
					<thead class="dataTable3dm__head">
						<tr class="dataTable3dm__row">
							<th class="dataTable3dm__header"><input type="checkbox" class="js-fakture-stranke-selectAll" name="allItems" value="allItems"></th>
							<th class="dataTable3dm__header">Številka naročila</th>
							<th class="dataTable3dm__header">Datum</th>
							<th class="dataTable3dm__header">Status naročila</th>
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
							$item_st_elementov = getField__value('stevilo_elementov');
							?>

							<tr class="dataTable3dm__row">
								<td class="dataTable3dm__cell">
									<input type="checkbox" class="js-fakture-stranka-check" name="narocilo[<?php echo $item_id ?>]" value="<?php echo $item_id ?>" data-st-elementov="<?php echo $item_st_elementov ?>">
								</td>
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
										<?php echo getField__value('status_narocila'); ?>
									</a>
								</td>
								<td class="dataTable3dm__cell">
									<?php $cena = getField__value('znesek'); ?>
									<a href="<?php echo $item_url ?>"><?php echo $cena; ?></a>
									<input type="hidden" name="cena[<?php echo $item_id ?>]" value="<?php echo $cena ?>" />
								</td>
							</tr>

							<?php wp_reset_postdata(); } ?>

					</tbody>
				</table>

				<div class="faktureResponseData__popustStElementov">
					<div class="faktureResponseData__stElementovWrapper">
						<div class="faktureResponseData__stElementovLabel">Število elementov:</div>
						<div class="faktureResponseData__stElementovInput js-stElementov"></div>
					</div>
					<div class="faktureResponseData__popustWrapper">
						<div class="faktureResponseData__popustLabel">Popust (%)</div>
						<div class="faktureResponseData__popustInput">
							<input type="number" name="popust" step="0.1" min="0" max="30" value="0" />
						</div>
					</div>
				</div>

				<div class="faktureResponseData__buttonWrapper">
					<input class='faktureResponseData__submit button button-primary' type='submit' name='posljiFormo' value='Ustvari fakturo' >
				</div>

				<input type="hidden" name="stranka_id" value="<?php echo $podjetje_id ?>" />
				<input type="hidden" name="stranka_ime" value="<?php echo $podjetje_ime ?>" />

			</form>

		</div>

	<?php } else {
		echo "Izbrana stranka nima nobenih odprtih naročil.";
	}

	die();

}

add_action( 'wp_ajax_nopriv_list_narocila_for_stranka', 'list_narocila_for_stranka' );
add_action( 'wp_ajax_list_narocila_for_stranka', 'list_narocila_for_stranka' );

?>