<?php

function singleSejanje() {

	// POST request was send
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// Submit button was clicked
		if (isset($_POST['posljiFormo'])) {
			$error = checkPostRequiredFields($_POST);
			if($error['count'] == 0){
				echo handlePostUpdate__sejanje();
			} else {
				echo handlePostNotificationError($error['messages']);
			}
		}
	}

	$item_id = get_the_ID();

	?>
	<div class='form__wrapper sejanjeEdit'>
		<form method='post' name='updateFields' class='form'>

			<div class='form__title'>
				<h2>Urejanje sejanja: <?php echo get_the_title($item_id)?></h2>
			</div>

			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('material') ?>:</div>
				<div class="form__value"><?php echo getField__input('material') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('vsebnik') ?>:</div>
				<div class="form__value"><?php echo getField__input('vsebnik') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('sito') ?>:</div>
				<div class="form__value"><?php echo getField__input('sito') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('datum_sejanja') ?>:</div>
				<div class="form__value"><?php echo getField__input('datum_sejanja') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('sejalec') ?>:</div>
				<div class="form__value"><?php echo getField__input('sejalec') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('sarza') ?>:</div>
				<div class="form__value"><?php echo getField__input('sarza') ?></div>
			</div>

			<div class="form__row">
				<input class='form__submit button' type='submit' name='posljiFormo' value='Posodobi sejanje' >
			</div>

			<input type='hidden' name='item_id' value='<?php echo $item_id?>' >

		</form>
	</div>
	<?php

}

function handlePostUpdate__sejanje(){

	$item_id = $_POST["item_id"];
	$messages = array();

	if(isset($_POST["material"]['value'])){
		$val = $_POST["material"]['value'];
		update_field('material', $val, $item_id);
		array_push($messages, "Material uspešno posodobljen.");
	}

	if(isset($_POST["vsebnik"]['value'])){
		$val = $_POST["vsebnik"]['value'];
		update_field('vsebnik', $val, $item_id);
		array_push($messages, "Vsebnik uspešno posodobljen.");
	}
	
	if(isset($_POST["sito"]['value'])){
		$val = $_POST["sito"]['value'];
		update_field('sito', $val, $item_id);
		array_push($messages, "Sito uspešno posodobljeno.");
	}
	
	if(isset($_POST["datum_sejanja"]['value'])){
		$val = $_POST["datum_sejanja"]['value'];
		update_field('datum_sejanja', $val, $item_id);
		array_push($messages, "Datum sejanja uspešno posodobljen.");
	}
	
	if(isset($_POST["sejalec"]['value'])){
		$val = is_numeric($_POST["sejalec"]['value']) ? (int)$_POST["sejalec"]['value'] : 0;
		if($val > 0){
			update_field('sejalec', $val, $item_id);
			array_push($messages, "Sejalec uspešno posodobljen.");
		}
	}
	
	if(isset($_POST["sarza"]['value'])){
		$val = $_POST["sarza"]['value'];
		update_field('sarza', $val, $item_id);
		array_push($messages, "Šarža uspešno posodobljena.");
	}

	return handlePostNotificationUpdate($messages);
}

?>