<?php

function narocila_shortcode($atts = []) {

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}

	$narocilaKupec = [
		'ime' => '',
		'id' => 0
	];

	$currentPage = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	$url = '';

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$narocilaKupec = narocilaKupecPostHandling();
		$currentPage = 1;
		$url = strtok(get_pagenum_link(), '?');
	}

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		$narocilaKupec = narocilaKupecGetHandling();
	}

	// Get all stranke
	$stranke = get_posts([
		'post_type' => 'stranke',
		'post_status' => 'publish',
		'numberposts' => -1,
		'orderby' => 'title',
		'order' => 'ASC'
	]);

	?>
	<div class="pregledNarocil__kupec">
		<div class="pregledNarocil__kupecTitle">Kupec:</div>
		<div class="pregledNarocil__kupecInputWrapper">
			<form method="post" action="<?php echo $url ?>">
				<input class="js_narocilaKupecIme pregledNarocil__kupecInput" name="narocilaKupecIme" list="stranke" value="<?php echo $narocilaKupec["ime"] ?>">
				<input class="js_narocilaKupecid" type="hidden" name="narocilaKupecId">
				<datalist class="js_narocilaKupecList" id="stranke">
				<?php foreach($stranke as $stranka){

					$stranka_id = $stranka->ID;
					$stranka_name = get_field('ime_podjetja', $stranka_id);

					?>

					<option data-id="<?php echo $stranka_id ?>" value="<?php echo $stranka_name ?>">

				<?php } ?>
				</datalist>
				<input class="pregledNarocil__submit button" type="submit" value="Potrdi">
			</option>
		</div>
	</div>
	<?php

	if(isset($narocilaKupec['id']) && $narocilaKupec['id'] != 0){
		$args = array(
			'post_type' => 'narocila',
			'post_status' => 'publish',
			'orderby' => 'ID',
			'posts_per_page' => 20,
			'paged' => $currentPage,
			'meta_query' => array(
				array(
					'key' => 'narocnik_id',
					'value' => $narocilaKupec['id'],
				)
			),
		);
	} else {
		$args = array(
			'post_type' => 'narocila',
			'post_status' => 'publish',
			'orderby' => 'ID',
			'posts_per_page' => 20,
			'paged' => $currentPage,
		);
	}

	
	$the_query = new WP_Query($args);

	if ( $the_query->have_posts() ){ ?>

		<div class="pagination">
			<div class="pagination__inner">
				<?php displayPagination($the_query, $narocilaKupec, $currentPage); ?>
			</div>
		</div>

		<div class="dataTable3dm">
			<table class="dataTable3dm__table">
				<thead class="dataTable3dm__head">
					<tr class="dataTable3dm__row">
						<th class="dataTable3dm__header">Status naročila</th>
						<th class="dataTable3dm__header">Št. naročila</th>
						<th class="dataTable3dm__header">Datum oddaje</th>
						<th class="dataTable3dm__header">Kupec</th>
						<th class="dataTable3dm__header">Cena</th>
						<th class="dataTable3dm__header">+1 dan</th>
						<th class="dataTable3dm__header">Spremni list</th>
						<th class="dataTable3dm__header">Datoteke</th>
					</tr>
				</thead>
				<tbody class="dataTable3dm__body">
				<?php
					while ( $the_query->have_posts() ){
						$the_query->the_post();
						$item_id = get_the_ID();
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
										$narocnik__id = getField__value('narocnik_id');
										$narocnik__ime = get_field('ime_podjetja', $narocnik__id);
										echo $narocnik__ime;
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

		<div class="popup js-popup">
			<div class="popup__container">
				<div class="popup__stl js-popup__stl" id="stl_cont"></div> 
			</div>
		</div>

		<div class="pagination">
			<div class="pagination__inner">
				<?php displayPagination($the_query, $narocilaKupec, $currentPage); ?>
			</div>
		</div>

		<?php } else {
			$page_link = get_permalink(288); ?>
			Zaenkrat nimate oddanih naročil. Svoje naročilo lahko oddate <a href="<?php echo $page_link ?>">tukaj</a>.
	<?php }

}

function narocilaKupecPostHandling(){

	$r = [
		'ime' => '',
		'id' => 0
	];

	if(isset($_POST['narocilaKupecIme'])){
		$r['ime'] = $_POST['narocilaKupecIme'];
	}

	if(isset($_POST['narocilaKupecId'])){
		$r['id'] = $_POST['narocilaKupecId'];
	}

	return $r;
}

function narocilaKupecGetHandling(){

	$r = [
		'ime' => '',
		'id' => 0
	];

	$r['ime'] = $_GET['paginationStrankaIme'];
	$r['id'] = $_GET['paginationStrankaId'];

	return $r;
}

?>