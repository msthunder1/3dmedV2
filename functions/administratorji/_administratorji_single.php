<?php

function administrator_shortcode() {

	if (isset($_GET['userid'])) {

		// POST request was send
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			// Submit button was clicked
			if (isset($_POST['posljiFormo'])) {
				$error = checkPostRequiredFields($_POST);
				if($error['count'] == 0){
					echo handlePostUpdate__administrator();
				} else {
					echo handlePostNotificationError($error['messages']);
				}
			}
		}

		$user_id = $_GET['userid'];
		$user_meta = get_user_meta($user_id);
		$user_info = get_userdata($user_id);

		?>

		<div class='form__wrapper administratorEdit'>
			<form method='post' name='updateFields' class='form'>

				<div class='form__title'>
					<h2><?php echo $user_meta["first_name"][0].' '.$user_meta["last_name"][0];?></h2>
				</div>

				<div class="form__row">
					<div class="form__label"><?php echo "Ime"; ?>:</div>
					<div class="form__value"><?php echo getCustom__user('ime', $user_id); ?></div>
				</div>
				<div class="form__row">
					<div class="form__label"><?php echo "Priimek"; ?>:</div>
					<div class="form__value"><?php echo getCustom__user('priimek', $user_id); ?></div>
				</div>
				<div class="form__row">
					<div class="form__label"><?php echo "E-pošta"; ?>:</div>
					<div class="form__value"><?php echo getCustom__user('email', $user_id); ?></div>
				</div>
				<div class="form__row">
					<div class="form__label"><?php echo getUserField__Label('podjetje', $user_id); ?>:</div>
					<div class="form__value"><?php echo getUserField__input('podjetje', $user_id); ?></div>
				</div>
				<div class="form__row">
					<div class="form__label">Vloga :</div>
					<div class="form__value"><?php echo getCustom__user('roles', $user_id);; ?></div>
				</div>
				<div class="form__row">
				<?php

	            $user_login = $user_info->user_login;
	            $key = get_password_reset_key( $user_info );
	            $resetLink = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');

				?>
					<div class="form__label">Ponastavljanje gesla:</div>
					<div class="form__value"><a href='<?php echo $resetLink; ?>' target='_blank'>Ponastavi geslo</a></div>
				</div>

				<div class="form__row">
					<input class='form__submit button button-primary' type='submit' name='posljiFormo' value='Posodobi Administratorja' >
				</div>

				<input type='hidden' name='user_id' value='<?php echo $user_id?>' >

			</form>
		</div>
		<?php
	}
}

function handlePostUpdate__administrator(){

	$user_id = $_POST["user_id"];
	$messages = array();

	$updateUserData = array('ID' => $user_id);

	if(isset($_POST["ime"]['value'])){
		$val = $_POST["ime"]['value'];
		$updateUserData['first_name'] = $val;
		array_push($messages, "Ime uspešno posodobljeno.");
	}

	if(isset($_POST["priimek"]['value'])){
		$val = $_POST["priimek"]['value'];
		$updateUserData['last_name'] = $val;
		array_push($messages, "Priimek uspešno posodobljen.");
	}

	if(isset($_POST["email"]['value'])){
		$val = $_POST["email"]['value'];
		$updateUserData['user_login'] = $val;
		$updateUserData['user_email'] = $val;
		array_push($messages, "E-pošta uspešno posodobljena.");
	}

	if(isset($_POST["roles"]['value'])){
		$user_newRole = $_POST["roles"]['value'];
		$user_meta=get_userdata($user_id);
		$user_exsistingRole=$user_meta->roles[0];

		if($user_newRole !== $user_exsistingRole){
			echo "<pre>";
			$u = new WP_User( $user_id );
			$u->remove_role( $user_exsistingRole );
			$u->add_role( $user_newRole );
			echo "</pre>";
			array_push($messages, "Vloga uspešno posodobljen.");
		}
	}

	$user_update = wp_update_user($updateUserData);

	if(is_object($user_update)){
		$messages[] = 'Napaka. Ta e-naslov zastopnika ime že obstaja.';
		return handlePostNotificationUpdate($messages);
	}

	if(isset($_POST["podjetje"]['value'])){
		$val = $_POST["podjetje"]['value'];
		update_field('podjetje', $val, "user_${user_id}");
		array_push($messages, "Podjetje uspešno posodobljeno.");
	}

	return handlePostNotificationUpdate($messages);

}

?>