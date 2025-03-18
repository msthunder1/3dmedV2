<?php

function registracija_shortcode() {

	if(is_user_logged_in()){
		echo "Že ste prijavljeni v sistem";
		return;
	}

	$groupId = 211;

	// POST request was send
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Submit button was clicked
		if (isset($_POST['posljiFormo'])) {
			$error = checkPostRequiredFields($_POST);
			if($error['count'] == 0){
				$r = handlePostUpdate__newStranka();
				if(is_array($r) && array_key_exists('showForm', $r)){
					echo $r['error'];
					showRegistracijaForm($groupId);
				} else {
					echo $r;
				}
			} else {
				echo handlePostNotificationError($error['messages']);
				showRegistracijaForm($groupId);
			}
		}
	} else {
		showRegistracijaForm($groupId);
	}

}

function showRegistracijaForm($groupId){ ?>
	<div class='form__wrapper register__wrapper container--small'>
		<form method='post' name='registracija' class='form'>

			<div class="form__title"><h2>Registracija novega uporabnika</h2></div>

			<div class="form__message">Podatki podjetja</div>

			<div class="form__row">
				<div class="form__label"><?php echo createField__label('ime_podjetja', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('ime_podjetja', $groupId) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('davcna_stevilka', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('davcna_stevilka', $groupId) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('zavezanec_za_ddv', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('zavezanec_za_ddv', $groupId) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('naslov', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('naslov', $groupId) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('postna_stevilka', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('postna_stevilka', $groupId) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('kraj', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('kraj', $groupId) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('drzava', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('drzava', $groupId) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('e-naslov_podjetja', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('e-naslov_podjetja', $groupId) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('telefon_podjetja', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('telefon_podjetja', $groupId) ?></div>
			</div>

			<div class="form__message">Podatki zastopnika</div>

			<div class="form__row secondary">
				<?php
					$zastopnikIme = array(
						'label' => 'Ime zastopnika',
						'name' => 'ime_zastopnika',
						'type' => 'text',
						'value' => '',
						'required' => 1
					);
				?>
				<div class="form__label">Ime zastopnika:</div>
				<div class="form__value"><?php echo getField__inputBasedOnType($zastopnikIme, $zastopnikIme['type']) ?></div>
			</div>
			<div class="form__row secondary">
				<?php
					$zastopnikPriimek = array(
						'label' => 'Priimek zastopnika',
						'name' => 'priimek_zastopnika',
						'type' => 'text',
						'value' => '',
						'required' => 1
					);
				?>
				<div class="form__label">Priimek zastopnika:</div>
				<div class="form__value"><?php echo getField__inputBasedOnType($zastopnikPriimek, $zastopnikPriimek['type']) ?></div>
			</div>
			<div class="form__row secondary">
				<?php
					$zastopnikEmail = array(
						'label' => 'E-naslov zastopnika',
						'name' => 'e-naslov_zastopnika',
						'type' => 'email',
						'value' => '',
						'required' => 1
					);
				?>
				<div class="form__label">E-naslov zastopnika:</div>
				<div class="form__value"><?php echo getField__inputBasedOnType($zastopnikEmail, $zastopnikEmail['type']) ?></div>
			</div>
			<div class="form__row secondary">
				<?php
					$zastopnikTelefon = array(
						'label' => 'Telefon zastopnika',
						'name' => 'telefon_zastopnika',
						'type' => 'number',
						'value' => '',
						'required' => 1
					);
				?>
				<div class="form__label">Telefon zastopnika:</div>
				<div class="form__value"><?php echo getField__inputBasedOnType($zastopnikTelefon, $zastopnikTelefon['type']) ?></div>
			</div>
			<div class="form__row secondary">
				<?php
					$zastopnikGeslo = array(
						'label' => 'Geslo zastopnika',
						'name' => 'geslo_zastopnika',
						'type' => 'password',
						'value' => '',
						'required' => 1
					);
				?>
				<div class="form__label">Geslo zastopnika:</div>
				<div class="form__value"><?php echo getField__inputBasedOnType($zastopnikGeslo, $zastopnikGeslo['type']) ?></div>
			</div>
			<div class="form__row secondary">
				<?php
					$ponoviGeslo = array(
						'label' => 'Ponovi geslo',
						'name' => 'ponovi_geslo',
						'type' => 'password',
						'value' => '',
						'required' => 1
					);
				?>
				<div class="form__label">Ponovi geslo:</div>
				<div class="form__value"><?php echo getField__inputBasedOnType($ponoviGeslo, $zastopnikGeslo['type']) ?></div>
			</div>
			<div class="form__row secondary">
				<?php
					$page_url = get_permalink(461);
				?>
				<div class="form__label">Strinjam se s&nbsp;<a href="<?php echo $page_url ?>" target="_blank">splošnimi pogoji</a>:</div>
				<div class="form__value"><?php echo createField__input('pogoji_uporabe', $groupId) ?></div>
			</div>

			<div class="form__row">
				<?php do_action( 'anr_captcha_form_field' ); ?>
			</div>

			<div class="form__row">
				<input class='form__submit button button-primary' type='submit' name='posljiFormo' value='Registracija' >
			</div>

			<input type='hidden' name='item_id' value='<?php echo $item_id?>' >

		</form>
	</div>
<?php }

function handlePostUpdate__newStranka(){

	$messages = array();

	if(!anr_verify_captcha()){
		array_push($messages, "Nepravilna Captcha. Prosimo poiskusite ponovno.");
		return array(
			'error' => handlePostNotificationError($messages),
			'showForm' => 1
		);
	}

	$post_gesloZastopnika = $_POST["geslo_zastopnika"]['value'];
	$post_ponoviGeslo = $_POST["ponovi_geslo"]['value'];

	if($post_gesloZastopnika !== $post_ponoviGeslo){
		array_push($messages, "Gesli se ne ujemata.");
		return array(
			'error' => handlePostNotificationError($messages),
			'showForm' => 1
		);
	}

	$t=time();

	$post_title = $_POST["ime_podjetja"]['value'];
	$post_davcna = $_POST["davcna_stevilka"]['value'];
	$post_zavezanec = isset($_POST["zavezanec_za_ddv"]['value']) ? $_POST["zavezanec_za_ddv"]['value'] : 'Ne';
	$post_naslov = $_POST["naslov"]['value'];
	$post_postnaSt = $_POST["postna_stevilka"]['value'];
	$post_kraj = $_POST["kraj"]['value'];
	$post_drzava = $_POST["drzava"]['value'];
	$post_email = $_POST["e-naslov_podjetja"]['value'];
	$post_telefon = $_POST["telefon_podjetja"]['value'];

	$post_imeZastopnika = $_POST["ime_zastopnika"]['value'];
	$post_priimekZastopnika = $_POST["priimek_zastopnika"]['value'];
	$post_emailZastopnika = $_POST["e-naslov_zastopnika"]['value'];
	$post_telefonZastopnika = $_POST["telefon_zastopnika"]['value'];

	// Create new user
	$newUserData = array(
		'first_name' => $post_imeZastopnika,
		'last_name' => $post_priimekZastopnika,
		'user_login' => $post_emailZastopnika,
		'user_email' => $post_emailZastopnika,
		'user_pass' => $post_gesloZastopnika,
		'role' => '3dmed_stranka'
	);

	$newUserId = wp_insert_user($newUserData);

	if(is_object($newUserId)){
		array_push($messages, "Napaka. Ta e-naslov zastopnika že obstaja. Registracija ni uspela. Prosimo vnesite drug e-naslov zastopnika.");
		return;
	}

	array_push($messages, "Uporabnik uspešno dodan.");

	// Update user data
	if(isset($_POST["ime_podjetja"]['value'])){
		$val = $_POST["ime_podjetja"]['value'];
		update_field('podjetje', $val, "user_${newUserId}");
	}
	if(isset($_POST["telefon_zastopnika"]['value'])){
		$val = $_POST["telefon_zastopnika"]['value'];
		update_field('telefon', $val, "user_${newUserId}");
	}

	$newStrankaData = array(
		'post_title' => $post_title,
		'post_type' => 'stranke',
		'post_status' => 'publish'
	);

	$newStrankaId = wp_insert_post($newStrankaData);

	if(is_object($newUserId)){
		array_push($messages, "Napaka pri dodajanje nove stranke.");
		return;
	}

	array_push($messages, "Stranka uspešno dodana.");

	update_field('ime_podjetja', $post_title, $newStrankaId);
	update_field('davcna_stevilka', $post_davcna, $newStrankaId);
	update_field('zavezanec_za_ddv', $post_zavezanec, $newStrankaId);
	update_field('naslov', $post_naslov, $newStrankaId);
	update_field('postna_stevilka', $post_postnaSt, $newStrankaId);
	update_field('kraj', $post_kraj, $newStrankaId);
	update_field('drzava', $post_drzava, $newStrankaId);
	update_field('e-naslov_podjetja', $post_email, $newStrankaId);
	update_field('telefon_podjetja', $post_telefon, $newStrankaId);
	update_field('zastopnik', $newUserId, $newStrankaId);
	update_field('kratko_ime', '', $newStrankaId);

	// Update the users company relation field
	update_field('id_podjetja', $newStrankaId, "user_${newUserId}");

	$registerLink = get_page_link(9);

	array_push($messages, "Registracija uspešna. <a href='".$registerLink."'>Kliknite tukaj za prijavo.</a>");

	send_email('registracija', $newUserId);

	return handlePostNotificationUpdate($messages, 'thankyou');

}

?>