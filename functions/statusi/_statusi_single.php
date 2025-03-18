<?php

function singleStatus() {

	// POST request was send
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// Submit button was clicked
		if (isset($_POST['posljiFormo'])) {
			$error = checkPostRequiredFields($_POST);
			if($error['count'] == 0){
				echo handlePostUpdate__status();
			} else {
				echo handlePostNotificationError($error['messages']);
			}
		}
	}

	$item_id = get_the_ID();

	?>
	<div class='form__wrapper materialEdit'>
		<form method='post' name='updateFields' class='form'>

			<div class='form__title'>
				<h2>Urejanje statusa: <?php echo get_the_title($item_id)?></h2>
			</div>

			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('barva') ?>:</div>
				<div class="form__value"><?php echo getField__input('barva') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('pozicija') ?>:</div>
				<div class="form__value"><?php echo getField__input('pozicija') ?></div>
			</div>

			<div class="form__row">
				<input class='form__submit button button-primary' type='submit' name='posljiFormo' value='Posodobi status' >
			</div>

			<input type='hidden' name='item_id' value='<?php echo $item_id?>' >

		</form>
	</div>
	<?php

}

function handlePostUpdate__status(){

	$item_id = $_POST["item_id"];
	$messages = array();

	if(isset($_POST["barva"]['value'])){
		$val = $_POST["barva"]['value'];
		update_field('barva', $val, $item_id);
		array_push($messages, "Barva uspešno posodobljena.");
	}

	if(isset($_POST["pozicija"])){
		$val = $_POST["pozicija"]['value'];
		update_field('pozicija', $val, $item_id);
		array_push($messages, "Pozicija uspešno posodobljena.");
	}

}

?>