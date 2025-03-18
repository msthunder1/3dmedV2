<?php

function dodaj_administratorja_shortcode(){

	// If we are in backend, dont render the code
	if(is_admin()) {
		return;
	}

	// POST request was send
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// Submit button was clicked
		if (isset($_POST['posljiFormo'])) {
			$error = checkPostRequiredFields($_POST);
			if($error['count'] == 0){
				$r = handlePostUpdate__newAdmin();
				if(is_array($r) && array_key_exists('showForm', $r)){
					echo $r['error'];
					showNewAdminForm();
				} else {
					echo $r;
				}
			} else {
				echo handlePostNotificationError($error['messages']);
				showNewAdminForm();
			}
		}
	} else {
		showNewAdminForm();
	}
}

function showNewAdminForm(){

	$groupId = 265;

	?>

	<div class='form__wrapper administratorAdd'>
		<form method='post' name='administratorAdd' class='form'>

			<div class="form__row">
				<?php
					$zastopnikIme = array(
						'label' => 'Ime administratorja',
						'name' => 'ime_administratorja',
						'type' => 'text',
						'value' => '',
						'required' => 1
					);
				?>
				<div class="form__label">Ime administratorja:</div>
				<div class="form__value"><?php echo getField__inputBasedOnType($zastopnikIme, $zastopnikIme['type']) ?></div>
			</div>
			<div class="form__row">
				<?php
					$zastopnikPriimek = array(
						'label' => 'Priimek administratorja',
						'name' => 'priimek_administratorja',
						'type' => 'text',
						'value' => '',
						'required' => 1
					);
				?>
				<div class="form__label">Priimek administratorja:</div>
				<div class="form__value"><?php echo getField__inputBasedOnType($zastopnikPriimek, $zastopnikPriimek['type']) ?></div>
			</div>
			<div class="form__row">
				<?php
					$zastopnikEmail = array(
						'label' => 'E-naslov administratorja',
						'name' => 'e-naslov_administratorja',
						'type' => 'email',
						'value' => '',
						'required' => 1
					);
				?>
				<div class="form__label">E-naslov administratorja:</div>
				<div class="form__value"><?php echo getField__inputBasedOnType($zastopnikEmail, $zastopnikEmail['type']) ?></div>
			</div>
			<div class="form__row">
				<?php
					$zastopnikTelefon = array(
						'label' => 'Telefon administratorja',
						'name' => 'telefon_administratorja',
						'type' => 'number',
						'value' => '',
						'required' => 1
					);
				?>
				<div class="form__label">Telefon administratorja:</div>
				<div class="form__value"><?php echo getField__inputBasedOnType($zastopnikTelefon, $zastopnikTelefon['type']) ?></div>
			</div>
			<div class="form__row">
				<?php
					$zastopnikGeslo = array(
						'label' => 'Geslo administratorja',
						'name' => 'geslo_administratorja',
						'type' => 'password',
						'value' => '',
						'required' => 1
					);
				?>
				<div class="form__label">Geslo administratorja:</div>
				<div class="form__value"><?php echo getField__inputBasedOnType($zastopnikGeslo, $zastopnikGeslo['type']) ?></div>
			</div>
			<div class="form__row">
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

			<div class="form__row">
				<input class='form__submit button button-primary' type='submit' name='posljiFormo' value='Dodaj administratorja' >
			</div>

		</form>
	</div>
	<?php

}

function handlePostUpdate__newAdmin(){

	$messages = array();

	$post_gesloAdministratorja = $_POST["geslo_administratorja"]['value'];
	$post_ponoviGeslo = $_POST["ponovi_geslo"]['value'];

	if($post_gesloAdministratorja !== $post_ponoviGeslo){
		array_push($messages, "Gesli se ne ujemata.");
		return array(
			'error' => handlePostNotificationError($messages),
			'showForm' => 1
		);
	}

	$post_imeAdministratorja = $_POST["ime_administratorja"]['value'];
	$post_priimekAdministratorja = $_POST["priimek_administratorja"]['value'];
	$post_emailAdministratorja = $_POST["e-naslov_administratorja"]['value'];
	$post_telefonAdministratorja = $_POST["telefon_administratorja"]['value'];

	// Create new user
	$newUserData = array(
		'first_name' => $post_imeAdministratorja,
		'last_name' => $post_priimekAdministratorja,
		'user_login' => $post_emailAdministratorja,
		'user_email' => $post_emailAdministratorja,
		'user_pass' => $post_gesloAdministratorja,
		'role' => '3dmed_admin'
	);

	$newUserId = wp_insert_user($newUserData);

	if(is_object($newUserId)){
		array_push($messages, "Napaka. Ta e-naslov administratorja že obstaja. Registracija ni uspela. Prosimo vnesite drug e-naslov administratorja.");
		return array(
			'error' => handlePostNotificationError($messages),
			'showForm' => 1
		);
	}

	array_push($messages, "Administrator uspešno dodan.");

	if(isset($_POST["telefon_zastopnika"]['value'])){
		$val = $_POST["telefon_zastopnika"]['value'];
		update_field('telefon', $val, "user_${newUserId}");
	}

	return handlePostNotificationUpdate($messages, 'thankyou');

}

?>