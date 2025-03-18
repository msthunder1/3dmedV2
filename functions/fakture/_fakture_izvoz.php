<?php

function izvoz_faktur_shortcode() {

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}

	$min = "2020-01-01";
	$max = "2030-01-01";
	$datumOd = isset($_POST['izvozOd']) ? $_POST['izvozOd'] : date('Y-m-d');
	$datumDo = isset($_POST['izvozDo']) ? $_POST['izvozDo'] : Date('Y-m-d', strtotime('+3 days'));

	// Get all stranke
	$stranke = get_posts([
		'post_type' => 'stranke',
		'post_status' => 'publish',
		'numberposts' => -1,
		'orderby' => 'title',
		'order' => 'ASC'
	]);

	$faktureZaStranko = [
		'strankaId' => 'vse',
		'strankaIme' => 'Vse stranke',
		'fakture' => []
	];

	// POST request was send
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$faktureZaStranko = handleIzberiStrankoInDatum();
	}

	?>

	<div class="faktureIzvoz">
		<form method='post' name='strankaInDatum' class='form faktureList__form' enctype='multipart/form-data'>
			<div class="faktureIzvoz__wrapper">
				<div class="faktureIzvoz__datum faktureIzvoz__datum--od">
					<label for="izvozOd" class="faktureIzvoz__datum--label">Datum od:</label>
					<input class="faktureIzvoz__datum--input" type="date" id="izvozOd" name="izvozOd" value="<?php echo $today ?>" min="<?php echo $min ?>" max="<?php echo $max ?>">
				</div>
				<div class="faktureIzvoz__datum faktureIzvoz__datum--do">
					<label for="izvozDo" class="faktureIzvoz__datum--label">Datum do:</label>
					<input class="faktureIzvoz__datum--input" type="date" id="izvozDo" name="izvozDo" value="<?php echo $today3 ?>" min="<?php echo $min ?>" max="<?php echo $max ?>">
				</div>
			</div>
			<?php

			if($stranke) { ?>
				<div class="faktureIzvoz__stranka">
					<div class="fakture__stranka">
						<div class="fakture__strankaTitle">Izberi stranko</div>
						<div class="fakture__strankaInputWrapper">
							<input class="js_narocilaKupecIme pregledNarocil__kupecInput" name="narocilaKupecIme" list="stranke" value="<?php echo $faktureZaStranko["strankaIme"] ?>">
							<input class="js_narocilaKupecid" type="hidden" name="narocilaKupecId" value="<?php echo $faktureZaStranko["strankaId"] ?>">
							<datalist class="js_narocilaKupecList" id="stranke">
								<option data-id="vse" value="Vse stranke">
								<?php foreach($stranke as $stranka){

									$stranka_id = $stranka->ID;
									$stranka_name = get_field('ime_podjetja', $stranka_id);

									?>

									<option data-id="<?php echo $stranka_id ?>" value="<?php echo $stranka_name ?>">

								<?php } ?>
							</datalist>
						</div>
					</div>
				</div>
			<?php } ?>
			
			<div class="faktureIzvoz__potrdi">
				<input class='faktureList__submit button button-primary' type='submit' name='izberiStrankoInDatum' value='Potrdi izbiro' >
			</div>
		</form>
	</div>

	<?php

	if(!empty($faktureZaStranko["fakture"])) { ?>
		<form method='post' name='izvozFakturZaStranko' class='form faktureIzvoz__form' enctype='multipart/form-data'>
			<div class="fakture__strankaTitle">Izbrane fakture:</div>
			<div class="faktureIzvoz__list">
				<?php
					foreach($faktureZaStranko["fakture"] as $faktura){ ?>
						<div class="faktureIzvoz__item"><?php echo $faktura->ID ?></div>
					<?php }
				?>
			</div>
			<div class="faktureIzvoz__potrdi">
				<input type='hidden' name='strankaId' value='<?php echo $faktureZaStranko["strankaId"] ?>' >
				<input type='hidden' name='faktureZaStranko' value='<?php echo serialize($faktureZaStranko["fakture"]) ?>' >
				<input class='faktureList__submit button button-primary' type='submit' name='izvoziFaktureZaStranko' value='Stisni in prenesi' >
			</div>
		</form>
	<?php }

}

function handleIzberiStrankoInDatum() {
	$izvozOd = $_POST["izvozOd"];
	$izvozDo = $_POST["izvozDo"];
	$strankaId = $_POST["narocilaKupecId"];
	$vseStranke = $strankaId == "vse" ? true : false;

	$r = [
		"strankaId" => "vse",
		"strankaIme" => "Vse stranke",
		"fakture" => []
	];

	if($vseStranke) {
		$strankaName = "Vse stranke";
		$fakture = get_posts([
			'post_type' => 'fakture',
			'post_status' => 'publish',
			'date_query' => array(
				array(
		            'after'     => $izvozOd,
		            'before'    => $izvozDo,
		            'inclusive' => true,
		        ),
			),
			'numberposts' => -1,
		]);
	} else {
		$strankaName = get_the_title($strankaId);
		$fakture = get_posts([
			'post_type' => 'fakture',
			'post_status' => 'publish',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => 'stranka',
					'value' => $strankaId,
				)
			),
			'date_query' => array(
				array(
		            'after'     => $izvozOd,
		            'before'    => $izvozDo,
		            'inclusive' => true,
		        ),
			),
			'numberposts' => -1,
		]);
	}

	$r = [
		"strankaId" => $strankaId,
		"strankaIme" => $strankaName,
		"fakture" => $fakture
	];

	return $r;
}

?>