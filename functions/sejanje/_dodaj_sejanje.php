<?php

function dodaj_sejanje_shortcode() {

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
				echo handlePostUpdate__newSejanje();
			} else {
				echo handlePostNotificationError($error['messages']);
				showNewSejanjeForm();
			}
		}
	} else {
		showNewSejanjeForm();
	}
}

function showNewSejanjeForm(){

	$groupId = 88;
	
	?>

	<div class='form__wrapper sejanjeEdit'>
		<form method='post' name='updateFields' class='form'>

			<div class="form__row">
				<div class="form__label"><?php echo createField__label('material', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('material', $groupId) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('vsebnik', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('vsebnik', $groupId) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('sito', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('sito', $groupId) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('datum_sejanja', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('datum_sejanja', $groupId) ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('sejalec', $groupId) ?>:</div>
				<div class="form__value">
					<?php

					$user_id = get_current_user_id();
					$user_meta = get_user_meta($user_id);
					$user_data = get_userdata($user_id);

					$user_ime = $user_meta['first_name'][0];
					$user_priimek = $user_meta['last_name'][0];

					echo $user_ime." ".$user_priimek;

					?>
					<input type="hidden" name='user_id' value='<?php echo $user_id ?>' >
				</div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo createField__label('sarza', $groupId) ?>:</div>
				<div class="form__value"><?php echo createField__input('sarza', $groupId) ?></div>
			</div>

			<div class="form__row">
				<input class='form__submit button' type='submit' name='posljiFormo' value='Dodaj novo sejanje' >
			</div>

		</form>
	</div>
	<?php

}

function handlePostUpdate__newSejanje(){

	$messages = array();

	$t=time();

	// Get the required fields for the title of sejanje
	if(isset($_POST["material"]['value'])){
		$material = $_POST["material"]['value'];
	} else {
		return "Napaka: Material ni nastavljen.";
	}

	if(isset($_POST["sarza"])){
		$sarza = $_POST["sarza"]['value'];
	} else {
		return "Napaka: Sarža ni nastavljena.";
	}

	// Build the title
	$title = "S-".$material."-".$sarza."-".$t;

	$newSejanjeData = array(
		'post_title' => $title,
		'post_type' => 'sejanja',
		'post_status' => 'publish'
	);

	// Insert the sejanje
	$item_id = wp_insert_post($newSejanjeData);

	// Update the fields
	if($material !== 'Material'){
		update_field('material', $material, $item_id);
	}

	if(isset($_POST["vsebnik"])){
		$val = $_POST["vsebnik"]['value'];
		update_field('vsebnik', $val, $item_id);
	}
	
	if(isset($_POST["sito"])){
		$val = $_POST["sito"]['value'];
		update_field('sito', $val, $item_id);
	}
	
	if(isset($_POST["datum_sejanja"])){
		$val = $_POST["datum_sejanja"]['value'];
		update_field('datum_sejanja', $val, $item_id);
	}
	
	if(isset($_POST["sejalec"])){
		$val = is_numeric($_POST["sejalec"]['value']) ? (int)$_POST["sejalec"]['value'] : 0;
		if($val > 0){
			update_field('sejalec', $val, $item_id);
		}
	}
	
	if(isset($_POST["sarza"])){
		$val = $_POST["sarza"]['value'];
		update_field('sarza', $val, $item_id);
	}

	array_push($messages, "Sejanje uspešno dodano.");

	return handlePostNotificationUpdate($messages);
}

?>