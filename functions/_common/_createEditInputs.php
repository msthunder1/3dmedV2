<?php

$error = 0;

function createInputForm($itemData, $callbackFn, $user=false){

	$id = $user ? 'user_'.$itemData["id"] : $itemData["id"];
	$item_id = $itemData["id"];
	unset($itemData["id"]); 

	$r = "<form method='post' name='updateFields' class='editInputs__form'>";

	foreach($itemData as $key => $data){

		if($user){
			$r .= getUserData($item_id);
		}

		$fieldInfo = get_field_object($key, $id);

		if($fieldInfo){
			$r .= createField($fieldInfo, $item_id);
		}

	}

	$r .= "<input type='hidden' name='item_id' value=".$item_id.">";
	$r .= "<p class='editInputs__submit submitButton'><input type='submit' name='SubmitButton' class='button button-primary'></p>";
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

function createField($fieldInfo, $item_id){

	$item_name = !empty($fieldInfo['_name']) ? $fieldInfo['_name'] : $fieldInfo['name'];
	$item_label = !empty($fieldInfo['label']) ? $fieldInfo['label'] : '' ;
	$item_value = !empty($fieldInfo['value']) ? $fieldInfo['value'] : (!empty($fieldInfo['default_value']) ? $fieldInfo['default_value'] : '');
	$item_required = $fieldInfo['required'];
	$item_type = $fieldInfo["type"];
	$validated = '';

	if($item_required){
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$postData = isset($_POST[$item_name]) ? $_POST[$item_name] : '';
			$validated = validateValue($postData, $fieldInfo["type"]);
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
			$r .= createField_text($item_name, $item_value, $validated);
			break;

		case 'textarea':
			$r .= createField_textarea($item_name, $item_value, $validated);
			break;

		case 'number':
			$r .= createField_number($item_name, $item_value, $validated);
			break;

		case 'file':
			$r .= createField_file($item_name, $item_value, $validated);
			break;

		case 'email':
			$r .= createField_email($item_name, $item_value, $validated);
			break;

		case 'date_picker':
			$r .= createField_datePicker($item_name, $item_value, $validated);
			break;

		case 'color_picker':
			$r .= createField_colorPicker($item_name, $item_value, $validated);
			break;

		case 'range':
			$r .= createField_range($item_name, $item_value, $validated);
			break;

		case 'checkbox':
			$r .= createField_checkbox($fieldInfo["choices"], $item_name, $item_value, $validated);
			break;

		case 'select':
			$r .= createField_select($fieldInfo["choices"], $item_name, $item_value, $validated);
			break;

		case 'radio':
			$r .= createField_radio($fieldInfo, $item_name, $item_label, $validated);
			break;

		case 'group':
			$r .= createField_group($fieldInfo['sub_fields'], $item_name, $item_id);
			break;

		case 'repeater':
			$r .= createField_repeater($fieldInfo["sub_fields"], $item_name, $item_id);
			break;

		case 'post_object':
			$r .= createField_postObject($fieldInfo, $item_name, $item_value, $validated);
			break;

		case 'user':
			$r .= createField_user($fieldInfo, $item_name, $item_value, $validated);
			break;
		
		default:
			break;
	}

	$r .= "</p>";

	return $r;

}

function createField_text($item_name, $item_value, $validated){

	$r = "<input ".((!empty($validated)) ? $validated['class'] : '')."
				type='text' 
				name='".$item_name."'
				".((!empty($validated)) ? "value='".$validated['value']."'" : "value='".$item_value."'")."
				".((!empty($validated)) ? $validated['message'] : '')." />";

	return $r;
}

function createField_textarea($item_name, $item_value, $validated){

	$r = "<textarea ".((!empty($validated)) ? $validated['class'] : '')."
				rows='4'
				name='".$item_name."'
				".((!empty($validated)) ? $validated['message'] : '').">"
				.((!empty($validated)) ? $validated['value'] : $item_value);
	$r .= '</textarea>';

	return $r;
}

function createField_number($item_name, $item_value, $validated){

	$r = "<input ".((!empty($validated)) ? $validated['class'] : '')."
				type='number' 
				name='".$item_name."'
				".((!empty($validated)) ? "value='".$validated['value']."'" : "value='".$item_value."'")."
				".((!empty($validated)) ? $validated['message'] : '')." />";

	return $r;
}

function createField_file($item_name, $item_value, $validated){

	$r = "file data here";

	return $r;
}

function createField_email($item_name, $item_value, $validated){

	$r = "<input ".((!empty($validated)) ? $validated['class'] : '')."
				type='email' 
				name='".$item_name."'
				".((!empty($validated)) ? "value='".$validated['value']."'" : "value='".$item_value."'")."
				".((!empty($validated)) ? $validated['message'] : '')." />";

	return $r;
}

function createField_datePicker($item_name, $item_value, $validated){

	$r = "<input ".((!empty($validated)) ? $validated['class'] : '')."
				type='date' 
				name='".$item_name."'
				".((!empty($validated)) ? "value='".$validated['value']."'" : "value='".$item_value."'")."
				".((!empty($validated)) ? $validated['message'] : '')." />";

	return $r;
}

function createField_colorPicker($item_name, $item_value, $validated){

	$r = "<input ".((!empty($validated)) ? $validated['class'] : '')."
				type='color' 
				name='".$item_name."'
				".((!empty($validated)) ? "value='".$validated['value']."'" : "value='".$item_value."'")."
				".((!empty($validated)) ? $validated['message'] : '')." />";

	return $r;
}

function createField_range($item_name, $item_value, $validated){

	$r = "<input ".((!empty($validated)) ? $validated['class'] : '')."
				type='range' 
				min='1' 
				max='10' 
				name='".$item_name."'
				id='itemInputId'
				".((!empty($validated)) ? "value='".$validated['value']."'" : "value='".$item_value."'")."
				oninput='itemOutputId.value = itemInputId.value' />";

	$r .= "<output name='outputName' id='itemOutputId'>".((!empty($validated)) ? $validated['value'] : $item_value)."</output>";

	return $r;
}

function createField_checkbox($item_choices, $item_name, $item_value, $validated){

	$r = '';

	$item_value = !empty($validated) ? $validated['value'] : $item_value[0];

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

function createField_select($item_choices, $item_name, $item_value, $validated){

	$item_value = !empty($validated) ? $validated['value'] : (!empty($item_value) ? $item_value : '');

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

function createField_radio($fieldInfo, $item_name, $item_label, $validated){

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

function createField_group($item_subfields, $item_name, $item_id){

	$r = '';

	foreach($item_subfields as $item_subfield){

		$subfield_name = $item_subfield['name'];

		if( have_rows($item_name) ):
  			while( have_rows($item_name) ): the_row();

  				$fieldObject = get_sub_field_object($subfield_name, $item_id);
				$r .= createField($fieldObject, true);

	  		endwhile;
	  	endif;
	}

	return $r;
}

function createField_repeater($item_subfields, $item_name, $item_id){

	$r = '';

	foreach($item_subfields as $item_subfield){

		$subfield_name = $item_subfield['name'];
		if($subfield_name === 'datoteka'){
			continue;
		}

		if( have_rows($item_name) ):
  			while( have_rows($item_name) ): the_row();

  				$fieldObject = get_sub_field_object($subfield_name, $item_id);
				$r .= createField($fieldObject, true);

	  		endwhile;
	  	endif;
	}

	return $r;
}

function createField_postObject($fieldInfo, $item_name, $item_value, $validated){

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

function createField_user($fieldInfo, $item_name, $item_value, $validated){

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

function getUserData($id){

	$user_meta = get_user_meta($id);
	$user_info = get_userdata($id);

    $userIme = array(
		'label' => 'Ime',
		'_name' => 'ime',
		'required' => 1,
		'type' => 'text',
		'value' => $user_meta["first_name"][0]
	);

    $userPriimek = array(
		'label' => 'Priimek',
		'_name' => 'priimek',
		'required' => 1,
		'type' => 'text',
		'value' => $user_meta["last_name"][0]
	);

    $userEmail = array(
		'label' => 'E-pošta',
		'_name' => 'email',
		'required' => 1,
		'type' => 'email',
		'value' => $user_info->data->user_email
	);

    $r = createField($userIme, $id);
    $r .= createField($userPriimek, $id);
    $r .= createField($userEmail, $id);

    return $r;

}

function validateValue($postData, $type){

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