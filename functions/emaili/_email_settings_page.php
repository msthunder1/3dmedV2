<?php

function email_settings_shortcode(){

	// POST request was send
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// Submit button was clicked
		if (isset($_POST['posljiFormo'])) {
			$error = checkPostRequiredFields($_POST);
			if($error['count'] == 0){
				echo handlePostUpdate__email_options();
			} else {
				echo handlePostNotificationError($error['messages']);
			}
		}
	}

	?>

	<div class='form__wrapper sejanjeEdit'>
		<form method='post' name='updateFields' class='form'>

			<div class='form__title'>
				<h2>Urejanje e-poštnih nastavitev</h2>
			</div>

			<div class="form__row">
				<div class="form__label"><?php echo getOption__Label('email_podjetja') ?>:</div>
				<div class="form__value"><?php echo getOption__input('email_podjetja') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getOption__Label('posiljatelj') ?>:</div>
				<div class="form__value"><?php echo getOption__input('posiljatelj') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getOption__Label('skrita_kopija') ?>:</div>
				<div class="form__value"><?php echo getOption__input('skrita_kopija') ?></div>
			</div>

			<div class="form__row">
				<input class='form__submit button' type='submit' name='posljiFormo' value='Posodobi sejanje' >
			</div>

		</form>
	</div>

	<?php

}

function handlePostUpdate__email_options(){

	$messages = array();

	if(isset($_POST["email_podjetja"]['value'])){
		$val = $_POST["email_podjetja"]['value'];
		update_field('email_podjetja', $val, 'option');
		array_push($messages, "E-pošta podjetja uspešno posodobljena.");
	}

	if(isset($_POST["posiljatelj"]['value'])){
		$val = $_POST["posiljatelj"]['value'];
		update_field('posiljatelj', $val, 'option');
		array_push($messages, "Pošiljatelj podjetja uspešno posodobljen.");
	}

	if(isset($_POST["skrita_kopija"]['value'])){
		$val = $_POST["skrita_kopija"]['value'];
		update_field('skrita_kopija', $val, 'option');
		array_push($messages, "Skrita kopija uspešno posodobljena.");
	}

	return handlePostNotificationUpdate($messages);

}

?>