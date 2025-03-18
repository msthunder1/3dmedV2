<?php

function singleStranke() {

	// POST request was send
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// Submit button was clicked
		if (isset($_POST['posljiFormo'])) {
			$error = checkPostRequiredFields($_POST);
			if($error['count'] == 0){
				echo handlePostUpdate__stranka();
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
				<h2>Urejanje stranke: <?php echo get_the_title($item_id)?></h2>
			</div>

			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('ime_podjetja') ?>:</div>
				<div class="form__value"><?php echo getField__input('ime_podjetja') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('davcna_stevilka') ?>:</div>
				<div class="form__value"><?php echo getField__input('davcna_stevilka') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('zavezanec_za_ddv') ?>:</div>
				<div class="form__value"><?php echo getField__input('zavezanec_za_ddv') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('naslov') ?>:</div>
				<div class="form__value"><?php echo getField__input('naslov') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('postna_stevilka') ?>:</div>
				<div class="form__value"><?php echo getField__input('postna_stevilka') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('kraj') ?>:</div>
				<div class="form__value"><?php echo getField__input('kraj') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('drzava') ?>:</div>
				<div class="form__value"><?php echo getField__input('drzava') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('e-naslov_podjetja') ?>:</div>
				<div class="form__value"><?php echo getField__input('e-naslov_podjetja') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('telefon_podjetja') ?>:</div>
				<div class="form__value"><?php echo getField__input('telefon_podjetja') ?></div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('zastopnik') ?>:</div>
				<div class="form__value">
					<?php
					
					$user__id = getField__value('zastopnik');

					if($user__id){
						echo getCustom__usernameFromId($user__id);
					}
					
					?>	
				</div>
			</div>
			<div class="form__row">
				<div class="form__label"><?php echo getField__Label('kratko_ime') ?>:</div>
				<div class="form__value"><?php echo getField__input('kratko_ime') ?></div>
			</div>

			<div class="form__row">
				<input class='form__submit button' type='submit' name='posljiFormo' value='Posodobi stranko' >
			</div>

			<input type='hidden' name='item_id' value='<?php echo $item_id?>' >

		</form>
	</div>
	<?php

}

function handlePostUpdate__stranka(){

	// Check if we have any post data to update 
	$item_id = $_POST["item_id"];
	$messages = array();

	
	if(isset($_POST["ime_podjetja"]['value'])){
		$val = $_POST["ime_podjetja"]['value'];
		update_field('ime_podjetja', $val, $item_id);
		array_push($messages, "Ime podjetja uspešno posodobljeno.");
		$updatePostTitle = array(
			'ID' => $item_id,
			'post_title' => $val
		);
		wp_update_post($updatePostTitle);
	}

	if(isset($_POST["davcna_stevilka"]['value'])){
		$val = $_POST["davcna_stevilka"]['value'];
		update_field('davcna_stevilka', $val, $item_id);
		array_push($messages, "Davčna številka uspešno posodobljena.");
	}
	
	if(isset($_POST["zavezanec_za_ddv"]['value'])){
		$val = $_POST["zavezanec_za_ddv"]['value'];
		update_field('zavezanec_za_ddv', $val, $item_id);
		array_push($messages, "Podjetje je sedaj davčni zavezanec.");
	} else {
		update_field('zavezanec_za_ddv', '', $item_id);
		array_push($messages, "Podjetje ni davčni zavezanec.");
	}
	
	if(isset($_POST["naslov"]['value'])){
		$val = $_POST["naslov"]['value'];
		update_field('naslov', $val, $item_id);
		array_push($messages, "Naslov podjetja uspešno posodobljen.");
	}
	
	if(isset($_POST["postna_stevilka"]['value'])){
		$val = $_POST["postna_stevilka"]['value'];
		update_field('postna_stevilka', $val, $item_id);
		array_push($messages, "Poštna številka podjetja uspešno posodobljena.");
	}
	
	if(isset($_POST["kraj"]['value'])){
		$val = $_POST["kraj"]['value'];
		update_field('kraj', $val, $item_id);
		array_push($messages, "Kraj podjetja uspešno posodobljena.");
	}
	
	if(isset($_POST["drzava"]['value'])){
		$val = $_POST["drzava"]['value'];
		update_field('kdrzavaraj', $val, $item_id);
		array_push($messages, "Država podjetja uspešno posodobljena.");
	}
	
	if(isset($_POST["e-naslov_podjetja"]['value'])){
		$val = $_POST["e-naslov_podjetja"]['value'];
		update_field('e-naslov_podjetja', $val, $item_id);
		array_push($messages, "E-pošta podjetja uspešno posodobljena.");
	}
	
	if(isset($_POST["telefon_podjetja"]['value'])){
		$val = $_POST["telefon_podjetja"]['value'];
		update_field('telefon_podjetja', $val, $item_id);
		array_push($messages, "Telefon podjetja uspešno posodobljen.");
	}
	
	if(isset($_POST["kratko_ime"]['value'])){
		$val = $_POST["kratko_ime"]['value'];
		update_field('kratko_ime', $val, $item_id);
		array_push($messages, "Kratko ime podjetja uspešno posodobljeno.");
	}

	return handlePostNotificationUpdate($messages);
}

?>