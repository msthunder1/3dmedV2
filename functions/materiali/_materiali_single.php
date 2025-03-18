<?php

function singleMaterial() {

	// POST request was send
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// Submit button was clicked
		if (isset($_POST['posljiFormo'])) {
			$error = checkPostRequiredFields($_POST);
			if($error['count'] == 0){
				echo handlePostUpdate__material();
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
				<h2>Urejanje materiala: <?php echo get_the_title($item_id)?></h2>
			</div>

			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('gostota') ?>:</div>
				<div class="form__value"><?php echo getField__input('gostota') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('pozicija') ?>:</div>
				<div class="form__value"><?php echo getField__input('pozicija') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('privzeto') ?>:</div>
				<div class="form__value"><?php echo getField__input('privzeto') ?></div>
			</div>

			<div class="form__row">
				<input class='form__submit button button-primary' type='submit' name='posljiFormo' value='Posodobi material' >
			</div>

			<input type='hidden' name='item_id' value='<?php echo $item_id?>' >

		</form>
	</div>
	<?php

}

function handlePostUpdate__material(){

	$item_id = $_POST["item_id"];
	$messages = array();

	if(isset($_POST["gostota"]['value'])){
		$val = $_POST["gostota"]['value'];
		update_field('gostota', $val, $item_id);
		array_push($messages, "Gostota uspešno posodobljena.");
	}

	if(isset($_POST["privzeto"]['value'])){
		$val = $_POST["privzeto"]['value'];
		update_field('privzeto', $val, $item_id);
		array_push($messages, "Material je sedaj privzet.");
	} else {
		update_field('privzeto', '', $item_id);
		array_push($messages, "Material več ni privzet.");
	}

	if(isset($_POST["pozicija"]['value'])){
		$val = $_POST["pozicija"]['value'];
		update_field('pozicija', $val, $item_id);
		array_push($messages, "Pozicija uspešno posodobljena.");
	}

	return handlePostNotificationUpdate($messages);
}

?>