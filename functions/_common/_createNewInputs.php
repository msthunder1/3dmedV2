<?php

$error = 0;

function createNewInputForm($data, $callbackFn){

	$r = "<form method='post' name='createNewFields' class='createInputs__form'>";

	foreach($data as $field){

		$r .= createNewField($field);

	}

	$r .= "<p class='createInputs__submit submitButton'><input type='submit' name='SubmitButton' class='button button-primary'></p>";
	$r .= "</form>";

	global $error;

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if($error == 0){
			$callbackFn();
		} else {
			echo '<div class="napaka">Napaka. Prosimo popravite vnose.</div>';
		}
	}

	return $r;

}

function createNewField($fieldInfo){

	$item_name = !empty($fieldInfo['_name']) ? $fieldInfo['_name'] : $fieldInfo['name'];
	$item_label = !empty($fieldInfo['label']) ? $fieldInfo['label'] : '';
	$item_value = !empty($fieldInfo['value']) ? $fieldInfo['value'] : '';
	$item_required = $fieldInfo['required'];
	$item_type = $fieldInfo["type"];
	$validated = '';

	if($item_required){
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$postData = isset($_POST[$item_name]) ? $_POST[$item_name] : '';
			$validated = validateData($postData, $fieldInfo["type"]);
		}
	} else {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$item_value = isset($_POST[$item_name]) ? $_POST[$item_name] : $item_value;
		}
	}

	$r = "<p class='editInputs__paragraph ".$item_name.($item_required ? ' required' : '')." ".$item_type."'>";
	$r .= "<label class='editInputs__label ".$fieldInfo["type"]."'>".$item_label."</label>";

	switch ($item_type) {
		case 'text':
			$r .= createNewField_text($item_name, $item_value, $validated);
			break;

		case 'textarea':
			$r .= createNewField_textarea($item_name, $item_value, $validated);
			break;

		case 'number':
			$r .= createNewField_number($item_name, $item_value, $validated);
			break;

		case 'file':
			$r .= createNewField_file($item_name, $item_value, $validated);
			break;

		case 'email':
			$r .= createNewField_email($item_name, $item_value, $validated);
			break;

		case 'date_picker':
			$r .= createNewField_datePicker($item_name, $item_value, $validated);
			break;

		case 'date_time_picker':
			$r .= createNewField_dateTimePicker($item_name, $item_value, $validated);
			break;

		case 'checkbox':
			$r .= createNewField_checkbox($fieldInfo["choices"], $item_name, $item_value, $validated);
			break;

		case 'select':
			$r .= createNewField_select($fieldInfo["choices"], $item_name, $item_value, $validated);
			break;

		case 'radio':
			$r .= createNewField_radio($fieldInfo, $item_name, $item_label, $validated);
			break;

		case 'group':
			$r .= createNewField_group($fieldInfo["sub_fields"], $item_name);
			break;

		case 'repeater':
			$r .= createNewField_repeater($fieldInfo["sub_fields"], $item_name);
			break;

		case 'post_object':
			$r .= createNewField_postObject($fieldInfo, $item_name, $item_value, $validated);
			break;

		case 'user':
			$r .= createNewField_user($fieldInfo, $item_name, $item_value, $validated);
			break;

		case 'password':
			$r .= createNewField_password($item_name, $item_value, $validated);
			break;

		case 'addFile':
			$r .= createNewField_addFile($fieldInfo["targets"], $item_name, $item_label);
			break;
		
		default:
			break;
	}

	$r .= "</p>";

	return $r;

}

function createNewField_text($item_name, $item_value, $validated){

	$r = "<input ".((!empty($validated)) ? $validated['class'] : '')."
				type='text' 
				name='".$item_name."'
				".((!empty($validated)) ? "value='".$validated['value']."'" : "value='".$item_value."'")."
				".((!empty($validated)) ? $validated['message'] : '')." />";

	return $r;
}

function createNewField_textarea($item_name, $item_value, $validated){

	$r = "<textarea ".((!empty($validated)) ? $validated['class'] : '')."
				rows='4'
				name='".$item_name."'
				".((!empty($validated)) ? "value='".$validated['value']."'" : "value='".$item_value."'")."
				".((!empty($validated)) ? $validated['message'] : '').">";
	$r .= '</textarea>';

	return $r;
}

function createNewField_number($item_name, $item_value, $validated){

	$r = "<input ".((!empty($validated)) ? $validated['class'] : '')."
				type='number' 
				name='".$item_name."'
				".((!empty($validated)) ? "value='".$validated['value']."'" : "value='".$item_value."'")."
				".((!empty($validated)) ? $validated['message'] : '')." />";

	return $r;
}

function createNewField_file($item_name, $item_value, $validated){

	$r = "<input ".((!empty($validated)) ? $validated['class'] : '')."
				type='file' 
				name='".$item_name."'
				".((!empty($validated)) ? "value='".$validated['value']."'" : "value='".$item_value."'")."
				".((!empty($validated)) ? $validated['message'] : '')." />";

	return $r;
}

function createNewField_email($item_name, $item_value, $validated){

	$r = "<input ".((!empty($validated)) ? $validated['class'] : '')."
				type='email' 
				name='".$item_name."'
				".((!empty($validated)) ? "value='".$validated['value']."'" : "value='".$item_value."'")."
				".((!empty($validated)) ? $validated['message'] : '')." />";

	return $r;
}

function createNewField_datePicker($item_name, $item_value, $validated){

	$r = "<input ".((!empty($validated)) ? $validated['class'] : '')."
				type='date' 
				name='".$item_name."'
				".((!empty($validated)) ? "value='".$validated['value']."'" : "value='".$item_value."'")."
				".((!empty($validated)) ? $validated['message'] : '')." />";

	return $r;
}

function createNewField_dateTimePicker($item_name, $item_value, $validated){

	$r = "<input ".((!empty($validated)) ? $validated['class'] : '')."
				type='datetime' 
				name='".$item_name."'
				".((!empty($validated)) ? "value='".$validated['value']."'" : "value='".$item_value."'")."
				".((!empty($validated)) ? $validated['message'] : '')." />";

	return $r;
}

function createNewField_checkbox($item_choices, $item_name, $item_value, $validated){

	$r = '';

	$item_value = !empty($validated) ? $validated['value'] : (!empty($item_value) ? $item_value[0] : '');

	foreach($item_choices as $key => $value){
		$checked='';
		if($item_value === $value){
			$checked = 'checked';
		}

		$r .= "<input ".((!empty($validated)) ? $validated['class'] : '')."
					type='checkbox' 
					name='".$item_name."'
					value='".$value."'
					".$checked." />";
	}

	return $r;
}

function createNewField_select($item_choices, $item_name, $item_value, $validated){

	$item_value = !empty($validated) ? $validated['value'] : (!empty($item_value) ? $item_value[0] : $item_value);

	$r = "<select class='createInputs__select' 
			".((!empty($validated)) ? $validated['class'] : '')."
			name='".$item_name."'
			autocomplete='off' >";

	// Build the select list
	foreach($item_choices as $key => $value){

		$selected='';
		if($item_value === $value){
			$selected = 'selected="selected"';
		}

		$r .= "<option value='".$key."' ".$selected.">".$value."</option>";
	}

	$r .= "</select>";

	return $r;
}

function createNewField_radio($fieldInfo, $item_name, $item_label, $validated){

	$item_value = $fieldInfo['value']['value'];
	$item_choices = $fieldInfo["choices"];

	$r = "<p class=editInputs__paragraph ".$item_name.">";
	$r .= "<p class=editInputs__title ".$item_name.">".$item_label."</p>";

	// Build the select list
	foreach($item_choices as $key => $value){
		// Set the checked value
		$checked = '';
		if($key === $item_value){
			$checked = 'checked="checked"';
		}
		$r .= "<label class='editInputs__label'>".$value;
		$r .= "<input type='radio' name=item_".$item_name." value=".$key." ".$checked."/>";
		$r .= "</label>";
	}

	$r .= "</p>";

	return $r;
}

function createNewField_group($item_subfields, $item_name){

	$r = '';

	foreach($item_subfields as $item_subfield){

		$subfield_name = $item_subfield['name'];

		if( have_rows($item_name) ):
  			while( have_rows($item_name) ): the_row();

  				var_dump($item_subfield);
  				// $fieldObject = get_sub_field_object($subfield_name, $item_id);
				// $r .= createNewField($fieldObject, true);

	  		endwhile;
	  	endif;
	}

	return $r;
}

function createNewField_repeater($item_subfields, $item_name){

	$r = '';

	foreach($item_subfields as $item_subfield){
		$r .= createNewField($item_subfield, true);
	}

	return $r;
}

function createNewField_postObject($fieldInfo, $item_name, $item_value, $validated){

	$item_value = !empty($validated) ? $validated['value'] : $item_value;
	$postType = $fieldInfo['post_type'][0];

	$item_choices = get_posts([
		'post_type' => $postType,
		'post_status' => 'publish',
		'numberposts' => -1
	]);

	$r = "<select class='createInputs__select' 
			".((!empty($validated)) ? $validated['class'] : '')."
			name='".$item_name."'
			autocomplete='off' >";

	// Build the select list
	foreach($item_choices as $key => $object){

		$value = $object->post_title;
		$id = $object->ID;

		$selected='';
		if((int)$item_value === (int)$id){
			$selected = 'selected="selected"';
		}

		$r .= "<option value='".$id."' ".$selected.">".$value."</option>";
	}

	$r .= "</select>";

	return $r;
}

function createNewField_user($fieldInfo, $item_name, $item_value, $validated){

	$item_value = !empty($validated) ? $validated['value'] : $item_value;

	$item_role = $fieldInfo['role'];

	$users = get_users( array( 'role__in' => $item_role ));

	$r = "<select class='createInputs__select' 
			".((!empty($validated)) ? $validated['class'] : '')."
			name='".$item_name."'
			autocomplete='off' >";

	foreach($users as $value){

		$user_id = (int)$value->data->ID;
		$user = get_user_meta($user_id);
		$user_fullName = $user ? $user['first_name'][0].' '.$user['last_name'][0] : '';

		// Set the selected value
		$selected = '';
		if((int)$item_value === (int)$user_id){
			$selected = 'selected="selected"';
		}
		$r .= "<option value='".$user_id."' ".$selected.">".$user_fullName."</option>";
	}

	$r .= "</select>";

	return $r;
}

function createNewField_password($item_name, $item_value, $validated){

	$r = "<input ".((!empty($validated)) ? $validated['class'] : '')."
				type='password' 
				name=".$item_name."
				".((!empty($validated)) ? "value='".$validated['value']."'" : "value='".$item_value."'")."
				".((!empty($validated)) ? $validated['message'] : '')." />";

	return $r;
}

function createNewField_addFile($targets, $item_name, $item_label){

	$r = "<input id='createInputs__addNewFile'
				class='createInputs__addNewFile js-addNewFile button button-secondary'
				type='button' 
				name='".$item_name."''
				data-targets='".$targets."'
				value='".$item_label."'' />";

	return $r;
}

function validateData($postData, $type){

	$val = array(
		'value' => '',
		'class' => '',
		'message' => ''
	);

	if(empty($postData)){
		global $error;
		$error++;
		$val['class'] = 'class="createInputs__error"';
		$val['message'] = 'placeholder="Polje ne sme biti prazno."';
	} else {
		if($type === 'number' && $postData < 0){
			global $error;
			$error++;
			$val['class'] = 'class="createInputs__error"';
			$val['message'] = 'placeholder="Vrednost ne sme biti negativna."';
		} else {
			$val['value'] = htmlspecialchars($postData);
		}
	}

	return $val;

}

?>