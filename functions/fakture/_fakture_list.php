<?php

function pregled_faktur_shortcode($atts = []) {

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}

	// Get all stranke
	$items = get_posts([
		'post_type' => 'stranke',
		'post_status' => 'publish',
		'numberposts' => -1,
		'orderby' => 'title',
		'order' => 'ASC'
	]);

	$fakture = get_posts([
		'post_type' => 'fakture',
		'post_status' => 'publish',
		'numberposts' => -1,
		'orderby' => 'ID',
		'order' => 'DESC'
	]);

	// POST request was send
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if (isset($_POST['status_placila'])){

			$status = $_POST['status_placila']['value'];
			$fakturaId = $_POST['fakturaId'];

			handlePostUpdate__posodobiPlacilo($fakturaId, $status);
		}
	}

	// If any, start render
	if($items) { ?>

		<div class="fakture__stranka">
			<div class="fakture__strankaTitle">Izberi stranko</div>
			<div class="fakture__strankaInputWrapper">
				<input class="fakture__strankaInput js-fakture-stranka-input" list="stranke">
				<datalist class="js-fakture-stranka-datalist" id="stranke">

					<?php foreach($items as $item){

						$item_id = $item->ID;
						$item_name = get_field('ime_podjetja', $item_id);

						?>

						<option data-id="<?php echo $item_id ?>" value="<?php echo $item_name ?>">

					<?php } ?>

				</datalist>
			</div>
		</div>
		<div class="fakture__response js-fakture-list-fakture-for-stranka-response">
			
			<?php if($fakture) { ?>

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
								<th class="dataTable3dm__header">Cena (€)</th>
								<th class="dataTable3dm__header">Status fakture</th>
								<th class="dataTable3dm__header">Status plačila</th>
							</tr>
						</thead>
						<tbody class="dataTable3dm__body">

							<?php
							foreach($fakture as $item){

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
											$pripravil = is_object($pripravil) ? $pripravil->display_name : '--';
											echo $pripravil;
											?>
										</a>
									</td>
									<td class="dataTable3dm__cell">
										<a href="<?php echo $item_url ?>">
											<?php
											$cena = getField__value('cena');
											$cena_s_popustom = getField__value('cena_s_popustom');
											if($cena_s_popustom){
												$cena = $cena_s_popustom;
											}
											$cena = str_replace('.',',',$cena);
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

			<?php } ?>

		</div>

	<?php }
	
} 

function handlePostUpdate__posodobiPlacilo($fakturaId, $status){

	update_field('status_placila', $status, $fakturaId);

}

?>