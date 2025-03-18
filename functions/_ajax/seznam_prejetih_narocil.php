<?php

function ajax__seznam_narocil($data) {

	$seznam__od = $_POST['seznam__od'];
	$seznam__do = $_POST['seznam__do'];

	$args = array(
		'post_type' => 'narocila',
		'posts_per_page' => -1,
		'date_query' => array(
			array(
				'after' => $seznam__od,
				'before' => $seznam__do,
				'inclusive' => true,
			),
		),
	);

	$query = new WP_Query( $args );

	if ($query->have_posts()){

		$items = $query->posts;

		?>

		<div class="dataTable3dm faktureResponseData">
			<form method='post' name='createFaktura' class='form' enctype='multipart/form-data'>
				<table class="dataTable3dm__table js-dataTable__table">
					<thead class="dataTable3dm__head">
						<tr class="dataTable3dm__row">
							<th class="dataTable3dm__header"></th>
							<th class="dataTable3dm__header">Številka naročila</th>
							<th class="dataTable3dm__header">Naročnik</th>
							<th class="dataTable3dm__header">Datum</th>
							<th class="dataTable3dm__header">Status naročila</th>
							<th class="dataTable3dm__header">Cena</th>
							<th class="dataTable3dm__header">Št. datotek</th>
							<th class="dataTable3dm__header dataTable3dm__header--hidden">Št. členov</th>
							<th class="dataTable3dm__header dataTable3dm__header--hidden">Modelacija</th>
							<th class="dataTable3dm__header dataTable3dm__header--hidden">Izdelava EM</th>
							<th class="dataTable3dm__header dataTable3dm__header--hidden">Sidro</th>
							<th class="dataTable3dm__header dataTable3dm__header--hidden">Št. wizilk</th>
							<th class="dataTable3dm__header dataTable3dm__header--hidden">Št mode. Wizilk</th>
						</tr>
					</thead>
					<tbody class="dataTable3dm__body">

						<?php

						$count = 0;

						foreach($items as $item){

							$count++;
							$item_id = $item->ID;
							$item_url = get_permalink($item_id);
							$item_narocnik = get_field('narocnik', $item_id);
							global $post; 
							$post = get_post( $item_id, OBJECT );
							setup_postdata( $post );

							$st__clenov = '';
							$komadi_za_modelacijo = '';
							$komadi_za_em = '';
							$komadi_za_sidro = '';
							$vizilke = '';
							$modeliranje = '';

							while( have_rows( 'modul', $narocilo__id ) ) {
								the_row();
								$st__clenov = get_sub_field('komadi_za_clen');
								$st__clenov = !$st__clenov ? '' : $st__clenov;

								$komadi_za_modelacijo = get_sub_field('komadi_za_modelacijo');
								$komadi_za_modelacijo = !$komadi_za_modelacijo ? '' : $komadi_za_modelacijo;

								$komadi_za_em = get_sub_field('komadi_za_em');
								$komadi_za_em = !$komadi_za_em ? '' : $komadi_za_em;

								$komadi_za_sidro = get_sub_field('komadi_za_sidro');
								$komadi_za_sidro = !$komadi_za_sidro ? '' : $komadi_za_sidro;

								$vizilke = get_sub_field('vizilke');
								$vizilke = $vizilke == 'zero' ? '' : $vizilke;

								$modeliranje = get_sub_field('modeliranje');
								$modeliranje = $modeliranje == 'zero' ? '' : $modeliranje;
							}

							?>

							<tr class="dataTable3dm__row">
								<td class="dataTable3dm__cell">
									<a href="<?php echo $item_url ?>">
										<?php echo $count ?>
									</a>
								</td>
								<td class="dataTable3dm__cell">
									<a href="<?php echo $item_url ?>">
										<?php echo get_the_title($item_id) ?>
									</a>
								</td>
								<td class="dataTable3dm__cell">
									<a href="<?php echo $item_url ?>">
										<?php echo $item_narocnik ?>
									</a>
								</td>
								<td class="dataTable3dm__cell">
									<a href="<?php echo $item_url ?>">
										<?php echo get_the_date('d.m.Y \ob H:i', $item_id) ?>
									</a>
								</td>
								<td class="dataTable3dm__cell">
									<a href="<?php echo $item_url ?>">
										<?php echo getField__value('status_narocila') ?>
									</a>
								</td>
								<td class="dataTable3dm__cell">
									<a href="<?php echo $item_url ?>">
										<?php 
										$cena = getField__value('znesek');
										$cena = str_replace('.',',',$cena);
										echo $cena;
										?>
									</a>
								</td>
								<td class="dataTable3dm__cell">
									<a href="<?php echo $item_url ?>">
										<?php
										$modules = get_field_object('modul');
										$num__modules = count($modules['value']);
										echo $num__modules;
										?>
									</a>
								</td>
								<td class="dataTable3dm__cell dataTable3dm__cell--hidden">
									<?php echo $st__clenov; ?>
								</td>
								<td class="dataTable3dm__cell dataTable3dm__cell--hidden">
									<?php echo $modeliranje; ?>
								</td>
								<td class="dataTable3dm__cell dataTable3dm__cell--hidden">
									<?php echo $komadi_za_em; ?>
								</td>
								<td class="dataTable3dm__cell dataTable3dm__cell--hidden">
									<?php echo $komadi_za_sidro; ?>
								</td>
								<td class="dataTable3dm__cell dataTable3dm__cell--hidden">
									<?php echo $vizilke; ?>
								</td>
								<td class="dataTable3dm__cell dataTable3dm__cell--hidden">
									<?php echo $komadi_za_modelacijo; ?>
								</td>
							</tr>

						<?php wp_reset_postdata(); } ?>

					</tbody>
				</table>

			</form>

		</div>

	<?php 

	} else {
		echo "V izbranem časovnem obdobju ni naročil.";
	}

	die();

}

add_action( 'wp_ajax_nopriv_ajax__seznam_narocil', 'ajax__seznam_narocil' );
add_action( 'wp_ajax_ajax__seznam_narocil', 'ajax__seznam_narocil' );

?>