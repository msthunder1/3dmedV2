<?php

function checkPostRequiredFields($postData){

	$error = array(
		'count' => 0,
		'messages' => array()
	);

	foreach($postData as $key => $data){
		if(is_array($data)){

			// If the value isnt required, we skip the further error check
			$required = array_key_exists('required', $data) ? $data['required'] : '';
			if(empty($required)){
				continue;
			}

			$value = '';

			if(isset($data['value'])){
				if($data['value'] !== ''){
					$value = $data['value'];
				}
			}

			// If the field was required, but the value was empty string, we have an error
			if($required !== 0 && $value === ''){
				$error['count']++;
			}
		}
	}

	if($error['count'] > 0){
		$error['messages']['main'] = 'Pri vnosu so bile napake. Prosimo popravite vnose.';
	}

	return $error;

}

?>