<?php

function narocila_stranke_shortcode($atts = []) {

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}
		
	global $current_user;
	$user = wp_get_current_user();
	$user_id = $user->ID;

	$items = get_posts([
		'author' => $user_id,
		'post_type' => 'narocila',
		'post_status' => 'publish',
		'orderby' => 'ID',
		'numberposts' => -1
	]);

	// If any, start render
	if($items) { ?>

		<div class="js-pregled-narocil-response">
			<div class="dataTable3dm">
				<table class="dataTable3dm__table js-dataTable__table_stranka">
					<thead class="dataTable3dm__head">
						<tr class="dataTable3dm__row">
							<th class="dataTable3dm__header">Status naročila</th>
							<th class="dataTable3dm__header">Št. naročila</th>
							<th class="dataTable3dm__header">Datum oddaje</th>
							<th class="dataTable3dm__header">Predviden rok dostave</th>
							<th class="dataTable3dm__header">Cena</th>
							<th class="dataTable3dm__header">+1 dan</th>
							<th class="dataTable3dm__header">Spremni list</th>
							<th class="dataTable3dm__header">Datoteke</th>
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
							?>

							<tr class="dataTable3dm__row">
								<?php

								$status = get_field('postavi_status');

								$status__title = '';
								$status__color = '';
								$status__class = '';

								if($status){
									$status__title = get_the_title($status);
									$status__color = get_field('barva', $status);
								}

								?>
								<td class="dataTable3dm__cell">
									<a class="statusMark" href="<?php echo $item_url ?>">
										<div class="statusMark__icon" style="background: <?php echo $status__color ?>;"></div>
										<div class="statusMark__text"><?php echo $status__title; ?></div>
									</a>
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
										<?php
											$datum_dobave = getField__value('datum_dobave');
											echo $datum_dobave;
										?>
									</a>
								</td>
								<td class="dataTable3dm__cell">
									<a href="<?php echo $item_url ?>">
										<?php 
										$znesek = get_field('znesek') ? get_field('znesek') . ' €' : '/';
										echo $znesek;
										?>
									</a>
								</td>
								<td class="dataTable3dm__cell">
									<a href="<?php echo $item_url ?>">
										<?php 
										$plus_en_dan = get_field('plus_en_dan') ? get_field('plus_en_dan')[0]['value'] : 'ne';
										echo $plus_en_dan;
										?>
									</a>
								</td>
								<td class="dataTable3dm__cell">
									<?php
									if($status == 193){ ?>
										<div class="icon3dm icon3dm__pdf js-pdf-print-narocilo" data-narocilo-id="<?php echo $item_id ?>">PDF</div>
									<?php } ?>
								</td>
								<td class="dataTable3dm__cell">
									<?php echo getCustom__datoteke($item_id); ?>
								</td>
							</tr>

							<?php 
							wp_reset_postdata();
							} ?>

					</tbody>
				</table>
			</div>
		</div>

		<div class="popup js-popup">
			<div class="popup__container">
				<div class="popup__stl js-popup__stl" id="stl_cont"></div> 
			</div>
		</div>

	<?php } else {

		$page_link = get_permalink(288);

		?>

		Zaenkrat nimate oddanih naročil. Svoje naročilo lahko oddate <a href="<?php echo $page_link ?>">tukaj</a>.

	<?php }
} ?>