<?php

function createField__label($field, $groupId){

	$fieldObj = acf_get_field($field, $groupId);
	$field_label = $fieldObj['label'];

	return $field_label;
}

function createField__input($field, $groupId){

	$fieldObj = acf_get_field($field, $groupId);
	$field_type = $fieldObj['type'];

	switch ($field_type) {
		case 'text':
			return getField__text($fieldObj);
			break;

		case 'number':
			return getField__number($fieldObj);
			break;

		case 'email':
			return getField__email($fieldObj);
			break;

		case 'password':
			return getField__password($fieldObj);
			break;

		case 'textarea':
			return getField__textarea($fieldObj);
			break;

		case 'checkbox':
			return getField__checkbox($fieldObj);
			break;

		case 'select':
			return getField__select($fieldObj);
			break;

		case 'date_picker':
			return getField__date($fieldObj);
			break;

		case 'file':
			return getField__file($fieldObj);
			break;

		case 'range':
			return getField__range($fieldObj);
			break;

		case 'user':
			return getField__user($fieldObj);
			break;

		case 'post_object':
			return getField__postObject($fieldObj);
			break;

		default:
			break;
	}
}

?>