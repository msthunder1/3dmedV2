<?php

function oddaj_narocilo_admin_shortcode() {

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}

	$status_query = get_post(187);

	$groupId = 272;

	$attachment__array = array();

	// POST request was send
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// Assign the existing attachments
		$attachment__array = isset($_POST['attachments']) ? $_POST['attachments'] : $attachment__array;

		$attachment__array = stripslashes($attachment__array);

		$attachment__array = unserialize($attachment__array);

		// Dodaj datoteko
		if(isset($_POST['submit__dodajDatoteko'])){

			// Assing the file value from the FILES to the POST, so we dont get a validation error
			$_POST['datoteka']['value'] = $_FILES['datoteka']['name']['value'];

			// Check for errors in the POST request
			$error = checkPostRequiredFields($_POST);
			if($error['count'] == 0){
				// If no errors are found, add the new file to our existing array
				$attachment__array = handlePostUpdate__dodajDatoteko($_FILES, $_POST, $attachment__array);
			} else {
				// Else show the errors
				echo handlePostNotificationError($error['messages']);
			}

			showNarociloAdminForm($groupId, $attachment__array);

		} else if (isset($_POST['submit__zakljuciNarocilo'])){

			// Empty form was submitted
			if(empty($attachment__array)){
				showNarociloAdminForm($groupId, $attachment__array);
			} else {
				// Check for errors
				$error = checkPostRequiredFields($_POST);
				if($error['count'] == 0){
					echo handlePostUpdate__zakljuciNarociloAdmin($attachment__array);
				} else {
					echo handlePostNotificationError($error['messages']);
					showNarociloAdminForm($groupId, $attachment__array);
				}
			}

		} else if (isset($_POST['submit__odstraniDatoteko'])){

			$id_to_remove = $_POST['submit__odstraniDatoteko'];

			$attachment__array = handlePostUpdate__odstraniDatoteko($id_to_remove, $attachment__array);

			showNarociloAdminForm($groupId, $attachment__array);

		} else {
			showNarociloAdminForm($groupId, $attachment__array);
		}

	} else {
		showNarociloAdminForm($groupId, $attachment__array);
	}
}

function showNarociloAdminForm($groupId, $attachment__array){

	// clear the zobotehnicni_status field for easier input
	$_POST['zobotehnicni_status']['value'] = '';

	?>

	<div class="oddajNarocilo">
		<div class="oddajNarocilo__wrapper">
			<div class="oddajNarocilo__novoNarocilo novoNarocilo">

				<form method='post' name='dodajDatoteko' class='form3dm' enctype='multipart/form-data'>

					<input type="hidden" name="attachments" value='<?php echo serialize($attachment__array); ?>' />

					<div class="novoNarocilo__titleWrapper">
						<h2 class="novoNarocilo__title oddajNarocilo__title">Oddaj novo naročilo</h2>
						<div class="oddajNarocilo__divider"></div>
					</div>

					<div class="novoNarocilo__form">
						<div class="form3dm__element">
							<div class="form3dm__row">
								<div class="form3dm__text">Izberite datoteke, ki jih želite izdelati s tehnologijo SLM (3D-tisk kovine)</div>
							</div>
							<div class="form3dm__row">
								<?php $datoteka = acf_get_field('datoteka', $groupId) ?>
								<div class="form3dm__col center">
									<div class="form3dm__label">Datoteka</div>
								</div>
								<div class="form3dm__col full">
									<div class="form3dm__value hasBorder"><?php echo getField__file($datoteka) ?></div>
								</div>
							</div>
						</div>

						<div class="form3dm__element">
							<div class="form3dm__row">
								<?php $material = acf_get_field('material', $groupId) ?>
								<div class="form3dm__col center">
									<div class="form3dm__label">Material</div>
								</div>
								<div class="form3dm__col full">
									<div class="form3dm__value"><?php echo getField__postObject($material) ?></div>
								</div>
							</div>
						</div>

						<div class="form3dm__element">
							<div class="form3dm__row">
								<?php $status = acf_get_field('zobotehnicni_status', $groupId) ?>
								<div class="form3dm__col center">
									<div class="form3dm__label small">
										<p>Št. delovnega naloga</p>
										<p>Zobozdravnik</p>
										<p>Pacient</p>
									</div>
								</div>
								<div class="form3dm__col full">
									<div class="form3dm__value"><?php echo getField__text($status) ?></div>
								</div>
							</div>
						</div>

						<div class="form3dm__row">
							<input class='form3dm__submit button buttonYellow' type='submit' name='submit__dodajDatoteko' value='Dodaj datoteko' >
						</div>

					</div>

				</form>

			</div>

			<div class="oddajNarocilo__oddaneDatoteke oddaneDatoteke">

				<form method='post' name='odstraniDatoteko' class='form3dm' enctype='multipart/form-data'>

					<input type="hidden" name="attachments" value='<?php echo serialize($attachment__array); ?>' />

					<div class="oddaneDatoteke__titleWrapper">
						<h2 class="oddaneDatoteke__title oddajNarocilo__title">Oddane datoteke</h2>
						<div class="oddajNarocilo__divider"></div>
					</div>
					<div class="oddaneDatoteke__form">
						<?php
						foreach ($attachment__array as $id => $attachment) {
							$size = size_format(filesize( get_attached_file($id)), 2);
							?>
							<div class="oddaneDatoteke__block">
								<div class="oddaneDatoteke__sizeName">
									<div class="oddaneDatoteke__name"><?php echo $attachment['file_name'] ?></div>
									<div class="oddaneDatoteke__size"><?php echo $size ?></div>
								</div>
								<div class="oddaneDatoteke__delete">
									<button class="form3dm__submit button delete" type="submit" name="submit__odstraniDatoteko" value="<?php echo $id ?>">
										<i class="far fa-times-circle"></i>
									</button>
								</div>
							</div>

						<?php } ?>
					</div>

				</form>

			</div>

			<div class="oddajNarocilo__divider"></div>

			<div class="oddajNarocilo__zakljuciNarocilo zakljuciNarocilo">

				<form method='post' name='zakljuciNarocilo' class='form3dm formZakljuciNarocilo' enctype='multipart/form-data'>

					<input type="hidden" name="attachments" value='<?php echo serialize($attachment__array); ?>' />

					<div class="zakljuciNarocilo__form">
						<div class="form3dm__element">
							<div class="form3dm__row">
								<div class="form3dm__col center">
									<div class="form3dm__label">Opcija <span class="uppercase bold">+1 dan</span></div>
								</div>
								<div class="form3dm__col full">
									<div class="form3dm__value"><?php echo createField__input('plus_en_dan', $groupId) ?></div>
								</div>
							</div>
						</div>

						<div class="form3dm__element">
							<div class="form3dm__row">
								<div class="form3dm__col">
									<div class="form3dm__label">Opombe stranke k celotnemu naročilu</div>
								</div>
								<div class="form3dm__col full">
									<div class="form3dm__value"><?php echo createField__input('opombe_stranke', $groupId) ?></div>
								</div>
							</div>
						</div>

						<?php

						$stranke_list = array(
							'label' => 'Seznam strank',
							'name' => 'seznam_strank',
							'type' => 'post_object',
							'post_type' => [
								0 => 'stranke'
							],
							'value' => '',
							'required' => 1
						);

						?>

						<div class="form3dm__element">
							<div class="form3dm__row">
								<div class="form3dm__col">
									<div class="form3dm__label">Oddaj naročilo za stranko</div>
								</div>
								<div class="form3dm__col full">
									<div class="form3dm__value"><?php echo getField__inputBasedOnType($stranke_list, $stranke_list['type']) ?></div>
								</div>
							</div>
						</div>

						<div class="form3dm__row">
							<input class='form3dm__submit button buttonYellow' type='submit' name='submit__zakljuciNarocilo' value='Zaključi naročilo' >
						</div>
					</div>

				</form>

			</div>

		</div>
	</div>

<?php }

function handlePostUpdate__zakljuciNarociloAdmin($attachment__array){

	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	$t=time();
	$date = date("d.m.Y",$t);
	$dateForTitle = date("Y",$t);
	$timestamp = date("d.m.Y \ob h:i",$t);
	$messages = array();
	$serial = get_field("stevilo_narocila", "option");
	$serial__padded = sprintf("%04d", $serial);
	update_field( 'stevilo_narocila', $serial+1, 'option' );

	if(isset($_POST["seznam_strank"]['value'])){
		$company_id = $_POST["seznam_strank"]['value'];
		$user_id = get_field('zastopnik', $company_id);
	}

	// First, get all the neccesary user data
	$user_meta = get_user_meta($user_id);
	$user_data = get_userdata($user_id);

	$user_ime = $user_meta['first_name'][0];
	$user_priimek = $user_meta['last_name'][0];
	$user_email = $user_data->data->user_email;
	$user_telefon = $user_meta['telefon'][0];

	// Secondly, get user company information
	$company_ime = get_field('ime_podjetja', $company_id);
	$company_naslov = get_field('naslov', $company_id);
	$company_postnaSt = get_field('postna_stevilka', $company_id);
	$company_kraj = get_field('kraj', $company_id);

	// Ready the data for saving
	$title = $dateForTitle."-N-".$serial__padded;

	$newNarociloData = array(
		'post_title' => $title,
		'post_type' => 'narocila',
		'post_status' => 'publish',
		'post_author' => $user_id
	);

	$newNarociloId = wp_insert_post($newNarociloData);

	if(is_object($newNarociloId)){
		$messages[] = 'Napaka. Naročilo ni bilo ustvarjeno. Prosimo obrnite se na administratorja.';
		return handlePostNotificationError($messages);
	}

	$company_polniNaslov = $company_naslov.", ".$company_postnaSt." ".$company_kraj;
	$company_oddal = $user_ime." ".$user_priimek." (".$user_email.")"."\n".$user_telefon;

	// Lastly, update the fields that should be automatically updated
	update_field('datum_narocila_in_ura', $timestamp, $newNarociloId);
	update_field('rok_izdelave', $date, $newNarociloId);
	update_field('narocnik', $company_ime, $newNarociloId);
	update_field('narocnik_id', $company_id, $newNarociloId);
	update_field('naslov_za_dostavo', $company_polniNaslov, $newNarociloId);
	update_field('narocilo_oddal', $company_oddal, $newNarociloId);
	update_field('narocilo_oddal_id', $user_id, $newNarociloId);

	if(isset($_POST["opombe_stranke"]['value'])){
		$val = $_POST["opombe_stranke"]['value'];
		update_field('opombe_stranke', $val, $newNarociloId);
	}

	if(isset($_POST["plus_en_dan"]['value'])){
		$val = $_POST["plus_en_dan"]['value'];
		update_field('plus_en_dan', $val, $newNarociloId);
	}

	// Status: Povpraševanje
	$status_query = get_post(187);
	$status_title = $status_query->post_title;

	update_field('status_narocila', $status_title, $newNarociloId);
	update_field('faze_narocila', $status_title, $newNarociloId);
	update_field('postavi_status', 187, $newNarociloId);
	update_field('status_fakture', 'Odprto', $newNarociloId);

	$empty_fields = array('datum_dobave', 'datum_storitve', 'opombe_administratorja', 'pripravil');
	foreach($empty_fields as $field){
		update_field($field, '', $newNarociloId);
	}

	// Dodaj nove module
	foreach ($attachment__array as $file_id => $attachment) {

		$file_name = $attachment['file_name'];
		$material = $attachment['material'];
		$zobotehnicni_status = $attachment['zobotehnicni_status'];

		$sejanja_query = get_posts(array(
			'numberposts'	=> 1,
			'post_type'		=> 'sejanja',
			'meta_key'		=> 'material',
			'meta_value'	=> $material,
			'orderby'		=> 'publish_date',
			'order' 		=> 'DESC',
		));

		$sejanje_id = $sejanja_query[0]->ID;

		$modul = array(
			'datoteka' => $file_id,
			'material' => $material,
			'sarza__lot' => $sejanje_id,
			'status_datoteke' => 'ok',
			'zobotehnicni_status' => $zobotehnicni_status
		);

		add_row('modul', $modul, $newNarociloId);

	}

	array_push($messages, "Naročilo uspešno oddano.");

	// Reset the post data
	$_POST = array();

	return handlePostNotificationUpdate($messages, 'thankyou');

}

?>
