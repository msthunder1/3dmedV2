<?php

function list_fakture_for_stranka($data) {

	$podjetje_ime = $_POST['podjetje_ime'];
	$podjetje_id = $_POST['podjetja_id'];

	if($podjetje_ime === ''){

		$items = get_posts([
			'post_type' => 'fakture',
			'post_status' => 'publish',
			'numberposts' => -1
		]);

	} else {

		$items = get_posts([
			'post_type' => 'fakture',
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => 'stranka',
					'value' => $podjetje_id,
				)
			),
			'numberposts' => -1
		]);

	}

	// If any, start render
	if($items) { ?>

		<div class="dataTable3dm">
			<table class="dataTable3dm__table js-dataTable__table">
				<thead class="dataTable3dm__head">
					<tr class="dataTable3dm__row">
						<th class="dataTable3dm__header"></th>
						<th class="dataTable3dm__header">ID</th>
						<th class="dataTable3dm__header">Številka fakture</th>
						<th class="dataTable3dm__header">Stranka</th>
						<th class="dataTable3dm__header">Datum</th>
						<th class="dataTable3dm__header">Račun pripravil</th>
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
						$status_placila = acf_get_field('status_placila', $item_id);
						$status_placila_value = get_field('status_placila', $item_id);
						$status_placila["value"] = $status_placila_value["value"];

						?>

						<tr class="dataTable3dm__row">
							<td class="dataTable3dm__cell delete">
								<?php
								if($status === 'Predračun'){?>
								<a class="js-storniraj-predracun" data-item-id="<?php echo $item_id ?>" href="#">
									<i class="fas fa-trash-alt"></i>
								</a>
								<?php } ?>
								
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo $item_id ?>
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
									$stranka = getField__value('stranka');
									echo $stranka -> post_title;
									?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo get_the_date('d.m.Y \ob H:i', $item_id); ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php 
									$pripravil = getField__value('pripravil');
									echo $pripravil->display_name  ? $pripravil->display_name : '--';
									?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php
									$cena = getField__value('cena') . ' €';
									$cena_s_popustom = getField__value('cena_s_popustom');
									if($cena_s_popustom){
										$cena = $cena . ' ('.$cena_s_popustom.' €)';
									}
									echo $cena;
									?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<a href="<?php echo $item_url ?>">
									<?php echo $status ?>
								</a>
							</td>
							<td class="dataTable3dm__cell">
								<form method='post' name='createFaktura' class='form faktureList__form' enctype='multipart/form-data'>
									<?php
										echo getField__select($status_placila, false);
									?>
									<div class="faktureList__buttonWrapper">
										<input class='faktureList__submit button button-primary <?php echo $status_placila_value["value"] ?>' type='submit' name='posljiFormo' value='Posodobi' >
										<input type='hidden' name='fakturaId' value='<?php echo $item_id ?>' >
									</div>
								</form>
							</td>
						</tr>

						<?php wp_reset_postdata(); } ?>

				</tbody>
			</table>
		</div>

	<?php } else {
		echo "Izbrana stranka nima nobenih odprtih faktur.";
	}

	die();

}

add_action( 'wp_ajax_nopriv_list_fakture_for_stranka', 'list_fakture_for_stranka' );
add_action( 'wp_ajax_list_fakture_for_stranka', 'list_fakture_for_stranka' );

?>