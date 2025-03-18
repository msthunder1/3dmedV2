<?php

function getOption__Label($val){
	$field = get_field_object($val, "option");
	$field_label = $field['label'];
	
	return $field_label;
}

function getOption__value($val){
	$field = get_field_object($val, "option");
	$field_value = $field['value'];
	
	if(is_array($field_value)){
		if(empty($field_value)){
			$field_value = '';
		} else {
			if(array_key_exists("value", $field_value)){
				$field_value = $field_value['value'];
			} else {
				$field_value = $field_value[0]['value'];
			}
		}
	}

	return $field_value;
}

function getOption__input($val){

	$field = get_field_object($val, "option");
	$field_type = $field['type'];

	switch ($field_type) {
		case 'text':
			return getField__text($field);
			break;

		case 'number':
			return getField__number($field);
			break;

		case 'email':
			return getField__email($field);
			break;

		case 'textarea':
			return getField__textarea($field);
			break;

		default:
			break;
	}
}

?>