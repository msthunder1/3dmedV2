<?php

function getUserField__Label($val, $user_id){
	$field = get_field_object($val, "user_{$user_id}");
	$field_label = $field['label'];
	
	return $field_label;
}

function getUserField__value($val, $user_id){
	$field = get_field_object($val, "user_{$user_id}");
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

function getUserField__input($val, $user_id){

	$field = get_field_object($val, "user_{$user_id}");
	$field_type = $field['type'];

	switch ($field_type) {
		case 'text':
			return getField__text($field);
			break;

		case 'number':
			return getField__number($field);
			break;

		case 'textarea':
			return getField__textarea($field);
			break;

		case 'checkbox':
			return getField__checkbox($field);
			break;

		case 'select':
			return getField__select($field);
			break;

		case 'date_picker':
			return getField__date($field);
			break;

		case 'user':
			return getField__user($field);
			break;

		case 'post_object':
			return getField__postObject($field);
			break;

		default:
			break;
	}
}

?>