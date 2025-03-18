<?php

function singleNarocila() {

	// POST request was send
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// Adding new file / module
		if(isset($_POST['dodaj_datoteko'])){
			echo dodajModul();
		}
		// Deleting a file / module
		if(isset($_POST['izbrisiModul'])){
			izbrisiModul($_POST['izbrisiModul'], $_POST["item_id"]);
		}
		// Submit button was clicked
		if (isset($_POST['posljiFormo'])) {
			$error = checkPostRequiredFields($_POST);
			if($error['count'] == 0){
				echo handlePostUpdate__narocilo();
			} else {
				echo handlePostNotificationError($error['messages']);
			}
		}
	}

	$item_id = get_the_ID();

	showNarociloforRole($item_id);

}

function showNarociloforRole($item_id){

	// User handling
	// Get logged in user
	// Also get the _GET parameter user
	// If the user is stranka, and its id is the same as the URL parameter, then display the form for the user
	// If the user is stranka, but no parameter is in URL, show nothing
	global $current_user;
	$user = wp_get_current_user();
	$user_id = (int)$user->ID;
	$user_meta = get_userdata($user_id);
	$user_role = $user_meta->roles[0];

	$user_getid = isset($_GET['userid']) ? (int)$_GET['userid'] : '';

	if($user_role === '3dmed_stranka'){
		if($user_id === $user_getid){
			// Show the Naročilo for the customer
			showNarociloforStranka($item_id);
		}
		// dont show the naročilo at all
	} else {
		// Show the Naročilo for Admin
		showNarociloforAdmin($item_id);
	}
}

function showNarociloforStranka($item_id){ ?>
	<div class='form__wrapper narocilaEdit'>
		<form method='post' name='updateFields' class='form'>
			<div class='form__title'>
				<h2>Pregled naročila: <?php echo get_the_title($item_id)?></h2>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('datum_narocila_in_ura') ?>:</div>
				<div class="form__value"><?php echo get_the_date('d.m.Y \ob H:i', $item_id) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('rok_izdelave') ?></div>
				<div class="form__value">
					<?php
						echo getField__value('rok_izdelave');
						if(getField__value('plus_en_dan')){
							echo "<b>+1 DAN</b>";
						}
					?>
				</div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('narocnik') ?>:</div>
				<div class="form__value"><?php echo getField__value('narocnik') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('naslov_za_dostavo') ?>:</div>
				<div class="form__value"><?php echo getField__value('naslov_za_dostavo') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('narocilo_oddal') ?>:</div>
				<div class="form__value"><?php echo getField__value('narocilo_oddal') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('status_narocila') ?>:</div>
				<div class="form__value"><?php echo getField__value('status_narocila') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('opombe_stranke') ?>:</div>
				<div class="form__value"><?php echo getField__value('opombe_stranke') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('opombe_administratorja') ?>:</div>
				<div class="form__value"><?php echo getField__value('opombe_administratorja') ?></div>
			</div>

			<div class="form__row secondary">
				<div class="form__label"><?php echo getField__Label('datum_dobave') ?>:</div>
				<div class="form__value"><?php echo getField__value('datum_dobave') ?></div>
			</div>
			<div class="form__row secondary">
				<div class="form__label"><?php echo getField__Label('datum_storitve') ?>:</div>
				<div class="form__value"><?php echo getField__value('datum_storitve') ?></div>
			</div>
			<div class="form__row secondary" style="display:none;">
				<div class="form__label"><?php echo getField__Label('pripravil') ?>:</div>
				<div class="form__value">
					<?php

					$user__id = get_field('pripravil');

					if (is_object($user__id)) {
						$user__id = $user__id->ID;
					}

					if($user__id){
						echo getCustom__usernameFromId($user__id);
					}

					?>
				</div>
			</div>
		</form>
	</div>
<?php }

function showNarociloforAdmin($item_id){ ?>

	<div class='form__wrapper narocilaEdit' id="natisniNarocilnico">
		<form method='post' name='updateFields' class='form' enctype='multipart/form-data'>
			<div class='form__title'>
				<h2>Urejanje naročila: <?php echo get_the_title($item_id)?></h2>
			</div>
			<div class="narocilaEdit__partCustomer">
				<div class="narocilaEdit__partLeft">
					<div class="form__row">
						<div class="form__label"><?php echo getField__Label('datum_narocila_in_ura') ?>:</div>
						<div class="form__value"><?php echo get_the_date('d.m.Y \ob H:i', $item_id) ?></div>
					</div>
					<div class="form__row">
						<div class="form__label"><?php echo getField__Label('rok_izdelave') ?></div>
						<div class="form__value">
							<?php
								echo getField__value('rok_izdelave');
								if(getField__value('plus_en_dan')){
									echo "<b>+1 DAN</b>";
								}
							?>
						</div>
					</div>
					<div class="form__row">
						<div class="form__label"><?php echo getField__Label('narocnik') ?>:</div>
						<div class="form__value"><?php echo getField__value('narocnik') ?></div>
					</div>
					<div class="form__row">
						<div class="form__label"><?php echo getField__Label('naslov_za_dostavo') ?>:</div>
						<div class="form__value"><?php echo getField__value('naslov_za_dostavo') ?></div>
					</div>
					<div class="form__row">
						<div class="form__label"><?php echo getField__Label('narocilo_oddal') ?>:</div>
						<div class="form__value"><?php echo getField__value('narocilo_oddal') ?></div>
					</div>
					<div class="form__row">
						<div class="form__label"><?php echo getField__Label('status_narocila') ?>:</div>
						<div class="form__value"><?php echo getField__value('status_narocila') ?></div>
					</div>
					<div class="form__row">
						<div class="form__label"><?php echo getField__Label('opombe_stranke') ?>:</div>
						<div class="form__value"><?php echo getField__value('opombe_stranke') ?></div>
					</div>
					<div class="form__row secondary">
						<div class="form__label"><?php echo getField__Label('opombe_administratorja') ?>:</div>
						<div class="form__value"><?php echo getField__input('opombe_administratorja') ?></div>
					</div>

					<div class="form__row secondary">
						<div class="form__label"><?php echo getField__Label('datum_dobave') ?>:</div>
						<div class="form__value"><?php echo getField__input('datum_dobave') ?></div>
					</div>
					<div class="form__row secondary">
						<div class="form__label"><?php echo getField__Label('datum_storitve') ?>:</div>
						<div class="form__value"><?php echo getField__input('datum_storitve') ?></div>
					</div>
					<div class="form__row secondary">
						<div class="form__label"><?php echo getField__Label('pripravil') ?>:</div>
						<div class="form__value">
						<?php

						$user__id = get_field('pripravil') ? get_field('pripravil') : get_current_user_id();

						if (is_object($user__id)) {
							$user__id = $user__id->ID;
						}

						if($user__id){
							echo getCustom__usernameFromId($user__id);
						}

						?>
						</div>
					</div>
					<div class="form__row secondary">
						<div class="form__label"><?php echo getField__Label('postavi_status') ?>:</div>
						<div class="form__value"><?php echo getField__input('postavi_status') ?></div>
					</div>
					<div class="form__row secondary">
						<input class='form__submit button button-primary' type='submit' name='posljiFormo' value='Posodobi naročilo' >
					</div>
				</div>
				<div class="narocilaEdit__partRight">

					<div class="form__column">

						<div class="narocilaEdit__natisni js-pdf-print-narocilo" data-narocilo-id="<?php echo $item_id ?>">
							<div class="narocilaEdit__natisniIcon form__icon"><i class="far fa-file-pdf"></i></div>
							<div class="narocilaEdit__natisniText form__iconText">Natisni spremni list</div>
						</div>
						<div class="narocilaEdit__prenesi js-prenesi" data-id-paketa="<?php echo $item_id ?>">
							<div class="narocilaEdit__prenesiIcon form__icon"><i class="fas fa-download"></i></div>
							<div class="narocilaEdit__prenesiText form__iconText">Stisni in prenesi datoteke</div>
						</div>
						<div class="narocilaEdit__izpisek">
							<div class="narocilaEdit__izpisekTitle">Izpis aktualnega cenika</div>
							<div class="narocilaEdit__izpisekSeznam seznam">
								<?php echo getCustom__seznamCen(); ?>
							</div>
						</div>

					</div>

				</div>
			</div>

			<div class="narocilaEdit__partBottom">
			<?php
			$count = 0;
			$groupId = 272;

			$repeater = get_field('modul');

			if ( have_rows( 'modul' ) ) {
	    		while( have_rows( 'modul' ) ) {
	    			the_row(); ?>
    				<div class="narocilaEdit__repeater">
	    				<div class="narocilaEdit__repeaterTop">

	    					<div class="form__row">
								<div class="form__column">
									<div class="form__label secondary">Zap. št.:</div>
									<div class="form__value form__value--center isBig"><?php echo $count+1 ?></div>
								</div>
								<div class="form__column">
									<div class="form__label secondary"><?php echo getField__Label('material', 'modul') ?></div>
									<div class="form__value"><?php echo getField__input('material', 'modul') ?></div>
								</div>

								<?php
									$object = get_sub_field_object('datoteka');
									$object_id = $object['value'];

									if($object_id){
										$object_link = wp_get_attachment_url($object_id);
										$attachment_dir = get_attached_file($object_id);
										$object_size_bytes = filesize($attachment_dir);
										$object_size = formatBytes($object_size_bytes);
										$object_name = basename ($attachment_dir);
										$object_extenstion = pathinfo($object_link, PATHINFO_EXTENSION);

									} else {
										$object = "Datoteka ne obstaja";
									}
								?>

								<div class="form__column">
									<div class="form__label secondary"><?php echo getField__Label('datoteka', 'modul') ?></div>
									<div class="form__value--box">
										<div class="form__value form__value--center">
											<?php if($object_id) {
												$file__count = $count + 1;
												$stranka__id = get_field('narocnik_id', $item_id);
												$stranka__kratkoIme = get_field('kratko_ime', $stranka__id);
												$file__downloadName = get_the_title($item_id) . '-' . $file__count . '-' . $stranka__kratkoIme . '.' . $object_extenstion;

												?>
												<a class="js-image-download"
												   href="<?php echo $object_link ?>"
												   download="<?php echo $file__downloadName ?>"><i class="fas fa-download"></i></a>
												<span><?php echo $object_size ?></span>
											<?php } else {
												echo $object;
											} ?>
										</div>
										<div class="form__value form__value--center">
											<a class="js-image-view" href="#" data-object="<?php echo $object_link ?>" >
												<i class="fas fa-redo"></i>
											</a>
										</div>
									</div>
								</div>
								<div class="form__column">
									<div class="form__label secondary">Originalna datoteka</div>
									<div class="form__value form__value--center">
										<?php if($object_id) {
											echo $object_name;
										} else {
											echo $object;
										} ?>
									</div>
								</div>
								<div class="form__column">
									<div class="form__label secondary"><?php echo getField__Label('status_datoteke', 'modul') ?></div>
									<div class="form__value"><?php echo getField__input('status_datoteke', 'modul') ?></div>
								</div>
								<div class="form__column">
									<div class="form__label secondary">Izbriši</div>
									<div class="form__value form__value--center">
										<button class='form__submit button button--full button--secondary' type='submit' name='izbrisiModul' value='<?php echo $count+1 ?>' formnovalidate>Izbriši [<?php echo $count+1 ?>]</button>
									</div>
								</div>
							</div>

							<div class="form__row">
								<div class="form__row--box">
									<div class="form__label secondary"><?php echo getField__Label('zobotehnicni_status', 'modul') ?></div>
									<div class="form__value"><?php echo getField__input('zobotehnicni_status', 'modul') ?></div>
								</div>
							</div>

						</div>

						<div class="form__row narocilaEdit__repeaterBottom">
							<div class="form__column narocilaEdit__repeaterBottomLeft">
								<div class="form__row secondary">
									<div class="form__label"><?php echo getField__Label('slika_izdelka', 'modul') ?></div>
									<div class="form__value"><?php echo getField__input('slika_izdelka', 'modul') ?></div>
								</div>

								<?php
								$image__exists = get_sub_field('slika_izdelka');

								if($image__exists){

									$image__url = wp_get_attachment_url($image__exists);

									?>

									<div class="form__row secondary">
										<div class="form__image">
											<img class="priloga" src="<?php echo $image__url ?>" />
										</div>
									</div>

								<?php } ?>

								<div class="form__row secondary narocilaEdit__ceniki">
									<div class="form__column">
										<div class="narocilaEdit__cenikiLabel">Člen</div>
										<div class="narocilaEdit__cenikiValue form__value">
							    			<div class="narocilaEdit__cenikiBox"><?php echo getField__input('komadi_za_clen', 'modul') ?></div>
							    			<div class="narocilaEdit__cenikiBox multiplier">x</div>
							    			<div class="narocilaEdit__cenikiBox"><?php echo getField__input('cena_za_clen', 'modul') ?><span class="sign-eur">€</span></div>
										</div>
									</div>
									<div class="form__column">
										<div class="narocilaEdit__cenikiLabel">Sidro</div>
										<div class="narocilaEdit__cenikiValue form__value">
											<div class="narocilaEdit__cenikiBox"><?php echo getField__input('komadi_za_sidro', 'modul') ?></div>
							    			<div class="narocilaEdit__cenikiBox multiplier">x</div>
							    			<div class="narocilaEdit__cenikiBox cena">
						    					<?php
									    			$cenik__sidro = getCustom__cenik('Sidro');
									    			echo $cenik__sidro;
								    			?><span class="sign-eur">€</span>
								    			<input type="hidden" name="modul_<?php echo $count ?>_cena_za_sidro[value]" value="<?php echo $cenik__sidro; ?>" />
							    			</div>
										</div>
									</div>
									<div class="form__column">
										<div class="narocilaEdit__cenikiLabel">Izdelava EM</div>
										<div class="narocilaEdit__cenikiValue form__value">
							    			<div class="narocilaEdit__cenikiBox"><?php echo getField__input('komadi_za_em', 'modul') ?></div>
							    			<div class="narocilaEdit__cenikiBox multiplier">x</div>
							    			<div class="narocilaEdit__cenikiBox cena">
							    				<?php
													$cenik__em = getCustom__cenik('Izdelava EM');
													echo $cenik__em;
								    			?><span class="sign-eur">€</span>
								    			<input type="hidden" name="modul_<?php echo $count ?>_cena_za_em[value]" value="<?php echo $cenik__em; ?>" />
								    		</div>
										</div>
									</div>
									<div class="form__column">
										<div class="narocilaEdit__cenikiLabel">Scan</div>
										<div class="narocilaEdit__cenikiValue form__value">
							    			<div class="narocilaEdit__cenikiBox"><?php echo getField__input('komadi_za_scan', 'modul') ?></div>
							    			<div class="narocilaEdit__cenikiBox multiplier">x</div>
							    			<div class="narocilaEdit__cenikiBox cena">
							    				<?php
													$cenik__scan = getField__value('cena_za_scan', 'modul');
													echo getCustom__createCenikSelect('Scan', 'cena_za_scan', $count, $cenik__scan);
								    			?><span class="sign-eur">€</span>
								    		</div>
										</div>
									</div>
									<div class="form__column">
										<div class="narocilaEdit__cenikiLabel">Modelacija</div>
										<div class="narocilaEdit__cenikiValue form__value">
						    				<div class="narocilaEdit__cenikiBox"><?php echo getField__input('komadi_za_modelacijo', 'modul') ?></div>
							    			<div class="narocilaEdit__cenikiBox multiplier">x</div>
							    			<div class="narocilaEdit__cenikiBox cena">
							    				<?php
													$cenik__modelacija = getCustom__cenik('Modelacija');
													echo $cenik__modelacija;
								    			?><span class="sign-eur">€</span>
								    			<input type="hidden" name="modul_<?php echo $count ?>_cena_za_modelacijo[value]" value="<?php echo $cenik__modelacija; ?>" />
								    		</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form__column narocilaEdit__repeaterBottomRight">
								<div class="form__row secondary">
									<div class="form__label"><?php echo getField__Label('sarza__lot', 'modul') ?></div>
									<div class="form__value form__value--border">
										<?php
										$sejanje_id = get_sub_field('sarza__lot');
										$sarza = get_field('sarza', $sejanje_id);
										echo $sarza;
										?>
									</div>
								</div>
								<div class="form__row secondary">
									<div class="form__value form__value--full"><?php echo getField__input('interne_opombe', 'modul') ?></div>
								</div>
							</div>
						</div>
						<div class="form__row secondary narocilaEdit__ceniki2">
							<div class="form__row--box">
								<div class="form__label"><?php echo getField__Label('vizilke', 'modul') ?></div>
								<div class="form__value">
									<?php
									$currentValue = getField__value('vizilke', 'modul');
									echo getCustom__createCenikSelect('Vizilke', 'vizilke', $count, $currentValue);
									?>
								</div>
							</div>
							<div class="form__row--box">
								<div class="form__label"><?php echo getField__Label('modeliranje', 'modul') ?></div>
								<div class="form__value">
									<?php
									$currentValue = getField__value('modeliranje', 'modul');
									echo getCustom__createCenikSelect('Modeliranje', 'modeliranje', $count, $currentValue);
									?>
								</div>
							</div>
							<div class="form__row--box">
								<div class="form__label"><?php echo getField__Label('scan2', 'modul') ?></div>
								<div class="form__value">
									<?php
									$currentValue = getField__value('scan2', 'modul');
									echo getCustom__createCenikSelect('Scan 2', 'scan2', $count, $currentValue)
									?>
								</div>
							</div>
						</div>
					</div>
	    		<?php $count++; }
	    	} ?>
	    	</div>

	    	<div class="form__row">
				<input class='form__submit button button-primary' type='submit' name='posljiFormo' value='Posodobi naročilo' >
			</div>

		</form>

		<form method='post' name='updateFields__addNewFile' class='form' enctype='multipart/form-data'>

	    	<div class="narocilaEdit__partAddNewModule">

	    		<div class="form__message">Dodaj novo datoteko</div>

				<div class="form__row">
					<div class="form__label"><?php echo createField__label('datoteka', $groupId) ?></div>
					<div class="form__value">
						<?php
						$datoteka = acf_get_field('datoteka', $groupId);
						$datoteka['name'] = 'novmodul__datoteka';
						$datoteka['required'] = '0';
						echo getField__file($datoteka);
						?>
					</div>
				</div>
				<div class="form__row">
					<div class="form__label"><?php echo createField__label('material', $groupId) ?></div>
					<div class="form__value">
						<?php
						$material = acf_get_field('material', $groupId);
						$material['name'] = 'novmodul__material';
						$material['required'] = '0';
						echo getField__postObject($material);
						?>
					</div>
				</div>
				<div class="form__row">
					<div class="form__label"><?php echo createField__label('zobotehnicni_status', $groupId) ?></div>
					<div class="form__value">
						<?php
						$zobostatus = acf_get_field('zobotehnicni_status', $groupId);
						$zobostatus['name'] = 'novmodul__zobotehnicni_status';
						$zobostatus['required'] = '0';
						echo getField__text($zobostatus);
						?>
					</div>
				</div>
			</div>

			<div class="form__row">
				<input class='form__submit button button-primary' type='submit' name='dodaj_datoteko' value='Dodaj novo datoteko' formnovalidate>
			</div>

			<input type='hidden' name='stevilo_modulov' value='<?php echo $count?>' >
			<input type='hidden' name='item_id' value='<?php echo $item_id?>' >

		</form>
	</div>

	<div class="popup js-popup">
		<div class="popup__container">
			<div class="popup__stl js-popup__stl" id="stl_cont"></div>
		</div>
	</div>

<?php }

function dodajModul(){

	$messages = array();

	if(!isset($_FILES['novmodul__datoteka']["name"])){
		$messages[] = 'Napaka. Datoteka ni bila izbrana.';
		return handlePostNotificationError($messages);
	}

	$file = $_FILES['novmodul__datoteka'];
	$file_name = $file['name']['value'];
	$file_type = wp_check_filetype( basename($file_name), null );

	$upload_dir = wp_upload_dir()['path'];
	$upload_filename = $upload_dir . '/' . basename($file_name);
	$upload_file = move_uploaded_file($file["tmp_name"]["value"], $upload_filename);

	$attachment = array(
		'guid' => $upload_filename,
		'post_mime_type' => $file_type['type'],
		'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
		'post_content' => '',
		'post_status' => 'inherit'
	);

	$file_path = wp_upload_dir()['path']  . '/' . $file_name;

	$attachment_id = wp_insert_attachment( $attachment, $file_path, $itemId );
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	$attach_data = wp_generate_attachment_metadata( $attachment_id, $file_path );
	wp_update_attachment_metadata( $attachment_id, $attach_data );

	if(!$attachment_id){
		$messages[] = 'Napaka. Slika ni bila naložena. Brišem naročilo. Prosimo obrnite se na administratorja.';
		return handlePostNotificationError($messages);
	}

	$material = $_POST['novmodul__material']['value'];
	$zob__status = $_POST['novmodul__zobotehnicni_status']['value'];

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
		'datoteka' => $attachment_id,
		'material' => $material,
		'sarza__lot' => $sejanje_id,
		'status_datoteke' => 'ok',
		'zobotehnicni_status' => $zob__status
	);

	add_row('modul', $modul, $itemId);

	array_push($messages, "Datoteka je bila uspešno dodana.");

	return handlePostNotificationUpdate($messages);

}

function izbrisiModul($row, $itemId){
	$messages = array();
	array_push($messages, "Datoteka je bila uspešno izbrisana.");
	delete_row('modul', $row, $itemId);
}

function handlePostUpdate__narocilo(){

	$item_id = $_POST["item_id"];
	$messages = array();

	$stevilo__elementov = 0;

	$cena_komadi_na_modul = array();

	$pripravil_id = get_current_user_id();
	update_field('pripravil', $pripravil_id, $item_id);

	foreach($_POST as $key => $value){

		if($key === 'postavi_status'){

			$status__current = (int)get_field($key, $item_id);
			$status__new = (int)$value['value'];

			if($status__current !== $status__new){

				$status_query = get_posts(array(
					'numberposts'	=> 1,
					'post_type'		=> 'statusi',
					'p'				=> $status__new
				));

				$status_title = $status_query[0]->post_title;
				update_field($key, $status__new, $item_id);
				update_field('status_narocila', $status_title, $item_id);

				$faze = get_field('faze_narocila', $item_id);
				$faze = $faze.'<br />'.$status_title;
				update_field('faze_narocila', $faze, $item_id);
			}
		} else if (strpos($key, 'slika_izdelka') !== false){

			// continue
			// handles with $_FILES

		} else if (strpos($key, 'material') !== false){

			$material_exsisting = get_field($key, $item_id);
			$material_new = $value['value'];

			// material je spremenjen, posodobimo ga in šaržo
			if($material_exsisting != $material_new){

				// dobi novo šaržo
				$sejanja_query = get_posts(array(
					'numberposts'	=> 1,
					'post_type'		=> 'sejanja',
					'meta_key'		=> 'material',
					'meta_value'	=> $material_new,
					'orderby'		=> 'publish_date',
					'order' 		=> 'DESC',
				));

				if(empty($sejanja_query)){
					array_push($messages, "Napaka: Sejanje ni nastavljeno.");
				} else {

					preg_match_all('!\d+!', $key, $matches);
					$modul = implode(' ', $matches[0]);

					$sejanje_id = $sejanja_query[0]->ID;
					update_field($key, $material_new, $item_id);
					update_field('modul_'.$modul.'_sarza__lot', $sejanje_id, $item_id);

				}
			}

		} else {

			// Nastavimo število vseh elementov v naročilu
			if(strpos($key, 'komadi_za_clen') !== false){
				preg_match_all('!\d+!', $key, $matches);
				$modul = implode(' ', $matches[0]);
				$stevilo__elementov = $stevilo__elementov + (int)$value['value'];
				$cena_komadi_na_modul[$modul]['clen']['komadi'] = (float)$value['value'];
			}
			if(strpos($key, 'komadi_za_sidro') !== false){
				preg_match_all('!\d+!', $key, $matches);
				$modul = implode(' ', $matches[0]);
				$cena_komadi_na_modul[$modul]['sidro']['komadi'] = (float)$value['value'];
			}
			if(strpos($key, 'komadi_za_em') !== false){
				preg_match_all('!\d+!', $key, $matches);
				$modul = implode(' ', $matches[0]);
				$stevilo__elementov = $stevilo__elementov + (int)$value['value'];
				$cena_komadi_na_modul[$modul]['em']['komadi'] = (float)$value['value'];
			}
			if(strpos($key, 'komadi_za_scan') !== false){
				preg_match_all('!\d+!', $key, $matches);
				$modul = implode(' ', $matches[0]);
				$cena_komadi_na_modul[$modul]['scan']['komadi'] = (float)$value['value'];
			}
			if(strpos($key, 'komadi_za_modelacijo') !== false){
				preg_match_all('!\d+!', $key, $matches);
				$modul = implode(' ', $matches[0]);
				$cena_komadi_na_modul[$modul]['modelacija']['komadi'] = (float)$value['value'];
			}

			// Nastavimo ceno vseh elementov v naročilu
			if(strpos($key, 'cena_za_clen') !== false){
				preg_match_all('!\d+!', $key, $matches);
				$modul = implode(' ', $matches[0]);
				$cena_komadi_na_modul[$modul]['clen']['cena'] = (float)$value['value'];
			}
			if(strpos($key, 'cena_za_sidro') !== false){
				preg_match_all('!\d+!', $key, $matches);
				$modul = implode(' ', $matches[0]);
				$cena_komadi_na_modul[$modul]['sidro']['cena'] = (float)$value['value'];
			}
			if(strpos($key, 'cena_za_em') !== false){
				preg_match_all('!\d+!', $key, $matches);
				$modul = implode(' ', $matches[0]);
				$cena_komadi_na_modul[$modul]['em']['cena'] = (float)$value['value'];
			}
			if(strpos($key, 'cena_za_scan') !== false){
				preg_match_all('!\d+!', $key, $matches);
				$modul = implode(' ', $matches[0]);
				$cena_komadi_na_modul[$modul]['scan']['cena'] = (float)$value['value'];
			}
			if(strpos($key, 'cena_za_modelacijo') !== false){
				preg_match_all('!\d+!', $key, $matches);
				$modul = implode(' ', $matches[0]);
				$cena_komadi_na_modul[$modul]['modelacija']['cena'] = (float)$value['value'];
			}

			// Dodamo še Vizilke, modeliranje in scan2
			if(strpos($key, 'vizilke') !== false){
				preg_match_all('!\d+!', $key, $matches);
				$modul = implode(' ', $matches[0]);

				// Če imamo izbrano nekaj pri vezilkah, dodamo še 1 element
				if($value['value'] !== 'zero'){
					$stevilo__elementov = $stevilo__elementov + 1;
				}

				$cena_komadi_na_modul[$modul]['vizilke']['komadi'] = 1;
				$cena_komadi_na_modul[$modul]['vizilke']['cena'] = (float)$value['value'];
			}
			if(strpos($key, 'modeliranje') !== false){
				preg_match_all('!\d+!', $key, $matches);
				$modul = implode(' ', $matches[0]);
				$cena_komadi_na_modul[$modul]['modeliranje']['komadi'] = 1;
				$cena_komadi_na_modul[$modul]['modeliranje']['cena'] = (float)$value['value'];
			}
			if(strpos($key, 'scan2') !== false){
				preg_match_all('!\d+!', $key, $matches);
				$modul = $matches[0][0];
				$cena_komadi_na_modul[$modul]['scan2']['komadi'] = 1;
				$cena_komadi_na_modul[$modul]['scan2']['cena'] = (float)$value['value'];
			}

			if(is_array($value)){
				update_field($key, $value['value'], $item_id);
			}
		}
	}

	array_push($messages, "Naročilo uspešno posodobljeno.");

	update_field('stevilo_elementov', $stevilo__elementov, $item_id);

	$znesek = 0;

	foreach($cena_komadi_na_modul as $modul){
		foreach($modul as $element){
			$komadi = $element['komadi'];
			$cena = $element['cena'];
			$skupna__cena = $komadi * $cena;
			$znesek = $znesek + (float)$skupna__cena;
		}
	}

	update_field('znesek', $znesek, $item_id);

	foreach($_FILES as $key => $file){

		$file__exists = $file['name']['value'];

		if($file__exists !== ''){

			$attachment__id = handleFileUpload($file);
			update_field($key, $attachment__id, $item_id);

		}
	}

	return handlePostNotificationUpdate($messages);

}

?>
