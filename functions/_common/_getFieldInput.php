<?php

function getField__text($field){

	$value = $field['value'] ? $field['value'] : '';
	$value_name = $field['name'];
	$value_required = $field['required'] ? 'required' : '';
	$value_validate = postValidation($field);
	$error_class = $error_msg = '';

	// If we have some validated data, show that instead
	if(!empty($value_validate)){
		$value = is_array($value_validate) ? $value_validate['value'] : $value_validate;
		$error_class = is_array($value_validate) ? $value_validate['class'] : '';
		$error_msg = is_array($value_validate) ? $value_validate['message'] : '';
	}

	$r = "<input class='form__input form__input-text {$value_required} {$error_class}' type='text' name='{$value_name}[value]' value='{$value}' placeholder='{$error_msg}' />";
	$r .= "<input type='hidden' name='{$value_name}[required]' value='{$value_required}' />";

	return $r;
}

function getField__number($field){

	$value = (isset($field['value']) && $field['value'] !== '') ? $field['value'] : '';
	$value_name = $field['name'];
	$value_required = $field['required'] ? 'required' : '';
	$value_validate = postValidation($field);
	$error_class = $error_msg = '';

	// If we have some validated data, show that instead
	if(!empty($value_validate)){
		$value = is_array($value_validate) ? $value_validate['value'] : $value_validate;
		$error_class = is_array($value_validate) ? $value_validate['class'] : '';
		$error_msg = is_array($value_validate) ? $value_validate['message'] : '';
	}

	$r = "<input class='form__input form__input-number {$value_required} {$error_class}' type='number' name='{$value_name}[value]' value='{$value}' placeholder='{$error_msg}' step='.01' />";
	$r .= "<input type='hidden' name='{$value_name}[required]' value='{$value_required}' />";

	return $r;
}

function getField__email($field){

	$value = $field['value'] ? $field['value'] : '';
	$value_name = $field['name'];
	$value_required = $field['required'] ? 'required' : '';
	$value_validate = postValidation($field);
	$error_class = $error_msg = '';

	// If we have some validated data, show that instead
	if(!empty($value_validate)){
		$value = is_array($value_validate) ? $value_validate['value'] : $value_validate;
		$error_class = is_array($value_validate) ? $value_validate['class'] : '';
		$error_msg = is_array($value_validate) ? $value_validate['message'] : '';
	}

	$r = "<input class='form__input form__input-email {$value_required} {$error_class}' type='email' name='{$value_name}[value]' value='{$value}' placeholder='{$error_msg}' />";
	$r .= "<input type='hidden' name='{$value_name}[required]' value='{$value_required}' />";

	return $r;
}

function getField__password($field){

	$value = $field['value'] ? $field['value'] : '';
	$value_name = $field['name'];
	$value_required = $field['required'] ? 'required' : '';
	$value_validate = postValidation($field);
	$error_class = $error_msg = '';

	// If we have some validated data, show that instead
	if(!empty($value_validate)){
		$value = is_array($value_validate) ? $value_validate['value'] : $value_validate;
		$error_class = is_array($value_validate) ? $value_validate['class'] : '';
		$error_msg = is_array($value_validate) ? $value_validate['message'] : '';
	}

	$r = "<input class='form__input form__input-password {$value_required} {$error_class}' type='password' name='{$value_name}[value]' value='{$value}' placeholder='{$error_msg}' />";
	$r .= "<input type='hidden' name='{$value_name}[required]' value='{$value_required}' />";

	return $r;
}

function getField__textarea($field){

	$value = $field['value'] ? $field['value'] : '';
	$value_name = $field['name'];
	$value_required = $field['required'] ? 'required' : '';
	$value_validate = postValidation($field);
	$placeholder = $field['placeholder'] ? $field['placeholder'] : '';
	$error_class = '';

	// If we have some validated data, show that instead
	if(!empty($value_validate)){
		$value = is_array($value_validate) ? $value_validate['value'] : $value_validate;
		$error_class = is_array($value_validate) ? $value_validate['class'] : '';
		$placeholder = is_array($value_validate) ? $value_validate['message'] : $placeholder;
	}

	$r = "<textarea class='form__textarea {$value_required} {$error_class}' rows='4' name='{$value_name}[value]' placeholder='{$placeholder}'>{$value}</textarea>";
	$r .= "<input type='hidden' name='{$value_name}[required]' value='{$value_required}' />";

	return $r;
}

function getField__checkbox($field){

	$value = $field['value'] ? $field['value'][0]['value'] : '';
	$value_name = $field['name'];
	$value_required = $field['required'] ? 'required' : '';
	$value_choices = $field['choices'];
	$value_validate = postValidation($field);
	$error_class = '';

	// If we have some validated data, show that instead
	if(!empty($value_validate)){
		$value = is_array($value_validate) ? (isset($value_validate['value']) ? $value_validate['value'] : $value_validate) : $value_validate;
		$error_class = is_array($value_validate) ? (isset($value_validate['class']) ? $value_validate['class'] : '' ) : '';
	}

	$r = '';

	foreach($value_choices as $key => $val){
		$checked='';
		if($value === $key){
			$checked = 'checked';
		}

		$r .= "<input type='checkbox' class='form__checkbox {$value_required} {$error_class}' name='{$value_name}[value]' value='{$key}' {$checked}/>";
		$r .= "<input type='hidden' name='{$value_name}[required]' value='{$value_required}' />";
	}

	return $r;
}

function getField__select($field, $validate = true){

	// If value is NULL, the set it to emptry string
	if(!$field['value']){
		$field['value'] = '';
	}

	$value_default = isset($field['default_value'][0]) ? $field['default_value'][0] : '';
	$value = $field['value'] === '' ? $value_default : $field['value'];

	$value_name = $field['name'];
	$value_required = $field['required'] ? 'required' : '';
	$value_choices = $field['choices'];
	$value_validate = postValidation($field);
	$error_class = '';

	// If we have some validated data, show that instead
	if(!empty($value_validate && $validate)){
		$value = is_array($value_validate) ? $value_validate['value'] : $value_validate;
		$error_class = is_array($value_validate) ? $value_validate['class'] : '';
	}

	$r = "<select class='form__select {$value_required} {$error_class}' name='{$value_name}[value]' autocomplete='off' >";
	// Build the select list
	foreach($value_choices as $key => $val){

		$selected='';

		if(is_string($value) && is_string($key)){
			if($value === $key){
				$selected = 'selected="selected"';
			}
		} else {
			if((int)$value === (int)$key){
				$selected = 'selected="selected"';
			}
		}

		$r .= "<option value='".$key."' ".$selected.">".$val."</option>";
	}

	$r .= "</select>";
	$r .= "<input type='hidden' name='{$value_name}[required]' value='{$value_required}' />";

	return $r;
}

function getField__date($field){

	$value = $field['value'] ? str_replace('/', '-', $field['value']) : '';
	$value_date = $value ? date('Y-m-d', strtotime($value)) : $value;
	$field['value'] = $value_date;
	$value_name = $field['name'];
	$value_required = $field['required'] ? 'required' : '';
	$value_validate = postValidation($field);
	$error_class = $error_msg = '';

	// If we have some validated data, show that instead
	if(!empty($value_validate)){
		$value_date = is_array($value_validate) ? $value_validate['value'] : $value_validate;
		$error_class = is_array($value_validate) ? $value_validate['class'] : '';
		$error_msg = is_array($value_validate) ? $value_validate['message'] : '';
	}

	$r = "<input class='form__input form__input-date {$value_required} {$error_class}' type='date' name='{$value_name}[value]' value='{$value_date}' placeholder='{$error_msg}' />";
	$r .= "<input type='hidden' name='{$value_name}[required]' value='{$value_required}' />";

	return $r;
}

function getField__color($field){

	$value = $field['value'] ? $field['value'] : '';
	$value_name = $field['name'];
	$value_required = $field['required'] ? 'required' : '';
	$value_validate = postValidation($field);
	$error_class = $error_msg = '';

	// If we have some validated data, show that instead
	if(!empty($value_validate)){
		$value = is_array($value_validate) ? $value_validate['value'] : $value_validate;
		$error_class = is_array($value_validate) ? $value_validate['class'] : '';
		$error_msg = is_array($value_validate) ? $value_validate['message'] : '';
	}

	$r = "<input class='form__input form__input-color {$value_required} {$error_class}' type='color' name='{$value_name}[value]' value='{$value}' placeholder='{$error_msg}' />";
	$r .= "<input type='hidden' name='{$value_name}[required]' value='{$value_required}' />";

	return $r;
}

function getField__file($field){

	$value = $field['value'] ? $field['value'] : '';
	$value_name = $field['name'];
	$value_required = $field['required'] ? 'required' : '';
	$value_validate = postValidation($field);
	$error_class = $error_msg = '';

	if(!empty($value_validate)){
		$value = is_array($value_validate) ? $value_validate['value'] : $value_validate;
		$error_class = is_array($value_validate) ? $value_validate['class'] : '';
		$error_msg = is_array($value_validate) ? $value_validate['message'] : '';
	}

	// No validation for file possible
	$r = "<input class='form__input form__input-file js-input-file {$value_required} {$error_class}' type='file' name='{$value_name}[value]' value='{$value}' placeholder='{$error_msg}' />";
	$r .= "<progress class='form__progress js-input-file-progress hidden'></progress>";
	$r .= "<input type='hidden' name='{$value_name}[required]' value='{$value_required}' />";

	return $r;
}

function getField__range($field){

	$value = $field['value'] ? $field['value'] : '';
	$value_name = $field['name'];
	$value_required = $field['required'] ? 'required' : '';
	$value_validate = postValidation($field);
	$error_class = '';

	// If we have some validated data, show that instead
	if(!empty($value_validate)){
		$value = is_array($value_validate) ? $value_validate['value'] : $value_validate;
		$error_class = is_array($value_validate) ? $value_validate['class'] : '';
	}

	$min = $field['min'];
	$max = $field['max'];

	$r = "<input class='form__input form__input-range {$value_required} {$error_class}' type='range' name='{$value_name}[value]' value='{$value}' id='rangeInputId' min='{$min}' max='{$max}'
				oninput='rangeOutputId.value = rangeInputId.value' />";

	$r .= "<output class='form__output' name='outputName' id='rangeOutputId'>".((!empty($validated)) ? $validated['value'] : $value)."</output>";
	$r .= "<input type='hidden' name='{$value_name}[required]' value='{$value_required}' />";

	return $r;
}

function getField__user($field){

	$value = $field['value'] ? $field['value'] : '';
	$value_name = $field['name'];
	$value_required = $field['required'] ? 'required' : '';
	$value_validate = postValidation($field);
	$error_class = '';
	$role = $field['role'];
	$users = get_users( array( 'role__in' => $role ));

	// If we have some validated data, show that instead
	if(!empty($value_validate)){
		$value = is_array($value_validate) ? $value_validate['value'] : $value_validate;
		$error_class = is_array($value_validate) ? $value_validate['class'] : '';
	}

	$r = "<select class='form__select {$value_required} {$error_class}' name='{$value_name}[value]' autocomplete='off' >";

	foreach($users as $val){

		$user_id = (int)$val->data->ID;
		$user = get_user_meta($user_id);
		$user_fullName = $user ? $user['first_name'][0].' '.$user['last_name'][0] : '';

		// Set the selected value
		$selected = '';
		if((int)$value === (int)$user_id){
			$selected = 'selected="selected"';
		}
		$r .= "<option value={$user_id} {$selected}>{$user_fullName}</option>";
	}

	$r .= "</select>";
	$r .= "<input type='hidden' name='{$value_name}[required]' value='{$value_required}' />";

	return $r;
}

function getField__postObject($field){

	$value = $field['value'] ? $field['value'] : '';
	$value_name = $field['name'];
	$value_required = $field['required'] ? 'required' : '';
	$value_validate = postValidation($field);
	$error_class = '';
	$postType = $field['post_type'][0];

	$value_choices = get_posts([
		'post_type' => $postType,
		'post_status' => 'publish',
		'numberposts' => -1
	]);

	// If we have some validated data, show that instead
	if(!empty($value_validate)){
		$value = is_array($value_validate) ? $value_validate['value'] : $value_validate;
		$error_class = is_array($value_validate) ? $value_validate['class'] : '';
	}

	$r = "<select class='form__select {$value_required} {$error_class}' name='{$value_name}[value]' autocomplete='off' >";

	foreach($value_choices as $object){

		$val = $object->post_title;
		$id = $object->ID;
		$privzeto = get_field('privzeto', $id);

		$selected='';

		if($value === ''){
			if(is_array($privzeto) && !empty($privzeto)){
				if($privzeto[0]['value'] === 'da'){
					$selected = 'selected="selected"';
				}
			}
		} else {
			if((int)$value === (int)$id){
				$selected = 'selected="selected"';
			}
		}

		$r .= "<option value={$id} {$selected}>{$val}</option>";
	}

	$r .= "</select>";
	$r .= "<input type='hidden' name='{$value_name}[required]' value='{$value_required}' />";

	return $r;
}

function getField__group($field){

	$subfields = $field['sub_fields'];

	$r = '';

	foreach($subfields as $subfield){

		$subfield_name = $subfield['name'];

		if( have_rows($subfield_name) ):
  			while( have_rows($subfield_name) ): the_row();

  				$subfieldObject = get_sub_field_object($subfield_name);
  				$subfieldType = $subfieldObject['type'];

				$r .= getField__inputBasedOnType($subfieldObject, $subfieldType);

	  		endwhile;
	  	endif;
	}

	return $r;
}

function postValidation($field){

	$value_required = $field['required'];
	$value_name = $field['name'];
	$value = $field['value'];

	// Field is required
	if($value_required){
		// POST was send && the field is in the POST
		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST[$value_name])) {
			$post_value = isset($_POST[$value_name]['value']) ? $_POST[$value_name]['value'] : $value;
			$value = validation($post_value, $field['type']);
		}
	// Field not required
	} else {
		// POST was send && the field is in the POST
		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST[$value_name])) {
			$value = isset($_POST[$value_name]['value']) ? $_POST[$value_name]['value'] : $value;
		}
	}

	return $value;

}

function validation($data, $type){

	$val = array(
		'value' => '',
		'class' => '',
		'message' => ''
	);

	if($data === ''){
		global $error;
		$error++;
		$val['class'] = 'error';
		$val['message'] = 'Polje ne sme biti prazno.';
	} else {
		if($type === 'number' && $data < 0){
			global $error;
			$error++;
			$val['class'] = 'error';
			$val['message'] = 'Vrednost ne sme biti negativna.';
		} else {
			$val['value'] = htmlspecialchars($data);
		}
	}

	return $val;

}

?>
