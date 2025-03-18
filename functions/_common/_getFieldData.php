<?php

function getField__Label($val, $parent=false){

	if(!$parent){
		$field = get_field_object($val);
		$field_label = $field['label'];
	} else {
		$field = get_sub_field_object($val);
		$field_label = $field['label'];
	}
	
	return $field_label;
}

function getField__value($val, $parent=false){

	if(!$parent){
		$field = get_field_object($val);
		$field_value = $field['value'];
	} else {
		$field = get_sub_field_object($val);
		$field_value = $field['value'];
	}

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

function getField__input($val, $parent=false){

	if(!$parent){
		$field = get_field_object($val);
		$field_type = $field['type'];
	} else {
        $field = get_sub_field_object($val);
		$field_type = $field['type'];
	}

	return getField__inputBasedOnType($field, $field_type);

}

function getField__inputBasedOnType($field, $field_type){

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

		case 'password':
			return getField__password($field);
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

		case 'color_picker':
			return getField__color($field);
			break;

		case 'file':
			return getField__file($field);
			break;

		case 'range':
			return getField__range($field);
			break;

		case 'user':
			return getField__user($field);
			break;

		case 'post_object':
			return getField__postObject($field);
			break;

		case 'group':
			return getField__group($field);
			break;

		default:
			break;
	}
}

?>