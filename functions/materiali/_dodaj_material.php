<?php

function dodaj_material_shortcode() {

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
				echo handlePostUpdate__newMaterial();
			} else {
				echo handlePostNotificationError($error['messages']);
				showMaterialForm();
			}
		}
	} else {
		showMaterialForm();
	}
}

function showMaterialForm(){

	$groupId = 197;

	?>

	<div class='form__wrapper sejanjeEdit'>
		<form method='post' name='updateFields' class='form'>

			<div class="form__row">
				<?php
					$materialIme = array(
						'label' => 'Ime materiala',
						'name' => 'ime_materiala',
						'type' => 'text',
						'value' => '',
						'required' => 1
					);
				?>
				<div class="form__label">Ime materiala:</div>
				<div class="form__value"><?php echo getField__inputBasedOnType($materialIme, $materialIme['type']) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('gostota', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('gostota', $groupId) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('privzeto', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('privzeto', $groupId) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('pozicija', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('pozicija', $groupId) ?></div>
			</div>

			<div class="form__row">
				<input class='form__submit button' type='submit' name='posljiFormo' value='Dodaj nov material' >
			</div>

		</form>
	</div>
	<?php

}

function handlePostUpdate__newMaterial(){

	$messages = array();

	// Get the required fields for the title of material
	if(isset($_POST["ime_materiala"]['value'])){
		$material = $_POST["ime_materiala"]['value'];
	} else {
		array_push($messages, "Napaka: Ime materiala ni nastavljeno.");
		return handlePostNotificationUpdate($messages);
	}

	$newMaterial = array(
		'post_title' => $material,
		'post_type' => 'materiali',
		'post_status' => 'publish'
	);

	// Insert the material
	$item_id = wp_insert_post($newMaterial);

	// Update the fields
	$valGostota = isset($_POST["gostota"]['value']) ? $_POST["gostota"]['value'] : '';
	$valPrivzeto = isset($_POST["privzeto"]['value']) ? $_POST["privzeto"]['value'] : '';
	$valPozicija = isset($_POST["pozicija"]['value']) ? $_POST["pozicija"]['value'] : '';

	update_field('gostota', $valGostota, $item_id);
	update_field('privzeto', $valPrivzeto, $item_id);
	update_field('pozicija', $valPozicija, $item_id);

	array_push($messages, "Material uspešno dodan.");
	return handlePostNotificationUpdate($messages);
}

?>