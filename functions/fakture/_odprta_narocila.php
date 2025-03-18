<?php

ob_start();

$postFunctionCalled = false;

function odprta_narocila_shortcode($atts = []) {

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}

	$faktureStranka = [
		'ime' => '',
		'id' => 0
	];

	$currentPage = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	$url = '';

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$faktureStranka = faktureStrankaPostHandling();
		$currentPage = 1;
		$url = strtok(get_pagenum_link(), '?');
	}

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		$faktureStranka = faktureStrankaGetHandling();
	}

	// Get all stranke
	$stranke = $items = get_posts([
		'post_type' => 'stranke',
		'post_status' => 'publish',
		'numberposts' => -1,
		'orderby' => 'title',
    	'order' => 'ASC'
	]);

	// POST request was send
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// If we are adding new modul fields
		global $postFunctionCalled;
		if(isset($_POST['posljiFormo']) && $postFunctionCalled == false){
			echo createFaktura();
		}
	}

	?>
	<div class="fakture__stranka">
		<div class="fakture__strankaTitle">Izberi stranko:</div>
		<div class="fakture__strankaInputWrapper">
			<form method="post" action="<?php echo $url ?>">
				<input class="js_narocilaKupecIme fakture__strankaInput" name="narocilaKupecIme" list="stranke" value="<?php echo $faktureStranka["ime"] ?>">
				<input class="js_narocilaKupecid" type="hidden" name="narocilaKupecId">
				<datalist class="js_narocilaKupecList" id="stranke">
				<?php foreach($stranke as $stranka){

					$stranka_id = $stranka->ID;
					$stranka_name = get_field('ime_podjetja', $stranka_id);

					?>

					<option data-id="<?php echo $stranka_id ?>" value="<?php echo $stranka_name ?>">

				<?php } ?>
				</datalist>
				<input class="fakture__submit button" type="submit" value="Potrdi">
			</option>
		</div>
	</div>
	<?php

	$args = array();

	if(isset($faktureStranka['id']) && $faktureStranka['id'] != 0){
		$args = array(
			'post_type' => 'narocila',
			'post_status' => 'publish',
			'orderby' => 'ID',
			'posts_per_page' => 20,
			'paged' => $currentPage,
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => 'narocnik_id',
					'value' => $faktureStranka['id'],
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
			'numberposts' => -1,
		);
	}

	$the_query = new WP_Query($args);

	if ( $the_query->have_posts() ){ ?>

		<div class="pagination">
			<div class="pagination__inner">
				<?php displayPagination($the_query, $faktureStranka, $currentPage); ?>
			</div>
		</div>

		<div class="js-fakture-list-narocila-for-stranka">
			<div class="dataTable3dm">
				<form method='post' name='createFaktura' class='form' enctype='multipart/form-data'>
					<table class="dataTable3dm__table">
						<thead class="dataTable3dm__head">
							<tr class="dataTable3dm__row">
								<th class="dataTable3dm__header"><input type="checkbox" class="js-fakture-stranke-selectAll" name="allItems" value="allItems"></th>
								<th class="dataTable3dm__header">Kupec</th>
								<th class="dataTable3dm__header">Številka naročila</th>
								<th class="dataTable3dm__header">Datum</th>
								<th class="dataTable3dm__header">Status naročila</th>
								<th class="dataTable3dm__header">Cena</th>
							</tr>
						</thead>
						<tbody class="dataTable3dm__body">
						<?php while ( $the_query->have_posts() ) {
							$the_query->the_post();
							$item_id = get_the_ID();
							$item_url = isset($user_id) ? get_permalink($item_id).'?userid='.$user_id : get_permalink($item_id);
							global $post; 
							$post = get_post( $item_id, OBJECT );
							setup_postdata( $post );
							$item_st_elementov = getField__value('stevilo_elementov');
							$narocnik__id = getField__value('narocnik_id');
							$narocnik__ime = get_field('ime_podjetja', $narocnik__id);
							?>

							<tr class="dataTable3dm__row">
								<td class="dataTable3dm__cell">
									<input type="checkbox" class="js-fakture-stranka-check" name="narocilo[<?php echo $item_id ?>]" value="<?php echo $item_id ?>" data-st-elementov="<?php echo $item_st_elementov ?>">
								</td>
								<td class="dataTable3dm__cell">
									<a href="<?php echo $item_url ?>">
										<?php
											echo $narocnik__ime;
										?>
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

					<input type="hidden" name="stranka_id" value="<?php echo $narocnik__id ?>" />
					<input type="hidden" name="stranka_ime" value="<?php echo $narocnik__ime ?>" />

				</form>

			</div>
		</div>

		<div class="pagination">
			<div class="pagination__inner">
				<?php displayPagination($the_query, $faktureStranka, $currentPage); ?>
			</div>
		</div>

	<?php } else { ?>
			Stranka nima nobenih odprtih naročil.
	<?php }

}

function faktureStrankaPostHandling(){

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

function faktureStrankaGetHandling(){

	$r = [
		'ime' => '',
		'id' => 0
	];

	$r['ime'] = $_GET['paginationStrankaIme'];
	$r['id'] = $_GET['paginationStrankaId'];

	return $r;
}

function createFaktura(){

	$postFunctionCalled = true;

	$messages = array();
	$narocila = array();

	$stranka_id = $_POST['stranka_id'];
	$stranka_ime = $_POST['stranka_ime'];
	$popust = $_POST['popust'];

	$znesek = 0;

	foreach($_POST['narocilo'] as $narociloId){
		$znesek = $znesek + $_POST['cena'][$narociloId];
		array_push($narocila, $narociloId);
	}

	// Ustvari se nova faktura z določenim imenon P-Y-Zap.št.predračuna
	$serial = get_field("stevilo_predracuna", "option");
	update_field( 'stevilo_predracuna', $serial+1, 'option' );

	$t=time();
	$dateForTitle = date("Y",$t);
	$title = 'P-'.$dateForTitle."-".$serial;
	$referenca = 'SI00 ' . $dateForTitle."-".$serial;

	$newFakturaData = array(
		'post_title' => $title,
		'post_type' => 'fakture',
		'post_status' => 'publish'
	);

	$newFakturaId = wp_insert_post($newFakturaData);

	if(is_object($newFakturaId)){
		$messages[] = 'Napaka. Faktura ni bilo ustvarjena. Prosimo obrnite se na administratorja.';
		return handlePostNotificationError($messages);
	}

	// Datum valute je nastavljen na danes +3 dni
	$datum__valute = date('d.m.Y', strtotime(' + 3 days'));

	// Postavi se status fakture na predračun
	update_field('status_fakture', 'Predračun', $newFakturaId);
	update_field('stranka', $stranka_id, $newFakturaId);
	update_field('narocila', $_POST['narocilo'], $newFakturaId);
	update_field('pripravil', get_current_user_id(), $newFakturaId);
	update_field('cena', $znesek, $newFakturaId);
	update_field('datum_valute', $datum__valute, $newFakturaId);
	update_field('referenca', $referenca, $newFakturaId);
	update_field('popust', $popust, $newFakturaId);

	if($popust > 0){
		$cena_popust = (100 - $popust) / 100 * $znesek;
		$cena_popust = number_format((float)$cena_popust, 2, '.', '');
		update_field('cena_s_popustom', $cena_popust, $newFakturaId);
	}

	// Postavi se status vseh naročil na predračun
	foreach($_POST['narocilo'] as $narociloId){
		update_field('status_fakture', 'Predračun', $narociloId);
	}

	array_push($messages, "Faktura uspešno ustvarjena.");

	$podjetje__arr = array(
		'naslov' => get_field('naslov_podjetja', 'option'),
		'email' => get_field('email_podjetja', 'option'),
		'maticna' => get_field_object("maticna_stevilka", "option")['value'],
		'davcna' => get_field_object("davcna_stevilka", "option")['value'],
		'trr_nlb' => get_field_object("stevilka_trr_pri_nlb_dd", "option")['value'],
		'trr_sparkasse' => get_field_object("stevilka_trr_pri_sparkasse_dd", "option")['value'],
		'logotip' => get_field('logotip_podjetja', 'option'),
		'podpis' => get_field('podpis_podjetja', 'option'),
		'zig' => get_field('zig_podjetja', 'option'),
	);

	$stranka__arr = array(
		'ime' => get_field("ime_podjetja", $stranka_id),
		'naslov' => get_field("naslov", $stranka_id),
		'posta' => get_field("postna_stevilka", $stranka_id),
		'kraj' => get_field("kraj", $stranka_id),
		'drzava' => get_field("drzava", $stranka_id),
		'ddv' => get_field("davcna_stevilka", $stranka_id),
	);

	$pripravil = '';
	$pripravil__obj = get_field("pripravil", $newFakturaId);

	if (is_object($pripravil__obj)) {
		$pripravil__id = $pripravil__obj->ID;
	}

	if($pripravil__id){
		$pripravil = getCustom__usernameFromId($pripravil__id);
	}

	$faktura__arr = array(
		'narocila' => $narocila,
		'title' => get_the_title($newFakturaId),
		'link' => get_permalink($newFakturaId),
		'cena' => $znesek,
		'datum' => get_the_date('', $newFakturaId),
		'datumValute' => get_field("datum_valute", $newFakturaId),
		'status' => get_field("status_fakture", $newFakturaId),
		'referenca' => get_field("referenca", $newFakturaId),
		'pripravil' => $pripravil,
		'popust' => get_field('popust', $newFakturaId),
		'cena_s_popustom' => get_field('cena_s_popustom', $newFakturaId),
	);

	$pdf = pdfPrintTemplate($podjetje__arr, $stranka__arr, $faktura__arr);
	$pdf_file_url = wp_upload_dir()['path'].'/predracun.pdf';

	$mpdf = new \Mpdf\Mpdf();
	$mpdf->WriteHTML($pdf);
	$mpdf->Output($pdf_file_url, 'F');

	$email_data = array(
		'faktura_title' => $faktura__arr['title'],
		'faktura_link' => $faktura__arr['link'],
		'faktura_cena' => $faktura__arr['cena'],
		'stranka_id' => $stranka_id,
		'pdf' => $pdf_file_url
	);

	send_email('predracun', $stranka_id, $email_data);

	unlink($pdf_file_url);

	return handlePostNotificationUpdate($messages);

}

?>