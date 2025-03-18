<?php

function profil_shortcode() {
	
	// If paremeter exsists
	if (isset($_GET['userid'])) {

		$formUserData = array();

	    $user_id = $_GET['userid'];
	    $user_meta = get_user_meta($user_id);

	    $formUserData["id"] = $user_id;
	    $formUserData["podjetje"] = $user_meta["podjetje"][0];

	    echo createInputForm($formUserData, 'updateProfil', true);

	}

}

function updateProfil() {

	// Check if we have any post data to update 
	if (!empty($_POST)){

		$item_id = $_POST["item_id"];

		if(isset($_POST["ime"])){
			$userData = wp_update_user(array(
			    'ID' => $item_id,
			    'first_name' => $_POST[ 'ime' ]
			));

			if(is_object($userData)){
				echo 'Napaka.';
			} else {
				echo "Ime uspešno posodobljeno.";
			}
		}

		if(isset($_POST["priimek"])){
			$userData = wp_update_user(array(
			    'ID' => $item_id,
			    'last_name' => $_POST[ 'priimek' ]
			)); 

			if(is_object($userData)){
				echo 'Napaka.';
			} else {
				echo "Ime uspešno posodobljeno.";
			}
		}

		if(isset($_POST["email"])){

			$userData = wp_update_user(array(
			    'ID' => $item_id,
			    'user_email' => $_POST[ 'email' ]
			));

			if(is_object($userData)){
				echo 'Ta e-naslov zastopnika ime že obstaja.';
			} else {
				echo "E-naslov uspešno posodobljen.";
			}
		}

		if(isset($_POST["podjetje"])){
			update_field('podjetje', $_POST["podjetje"], 'user_'.$item_id);
			echo "Podjetje uspešno posodobljeno.";
		}

	}

}

?>