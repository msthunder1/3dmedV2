<?php

function handlePostNotificationError($errors){

	$r = '<div class="flashMessage error">';

	foreach($errors as $error){
		$r .= '<div class="flashMessage__single">'.$error.'</div>';
	}

	$r .= '</div>';

	return $r;

}

function handlePostNotificationUpdate($messages, $class='success'){

	$r = '<div class="flashMessage '.$class.'">';

	foreach($messages as $message){
		$r .= '<div class="flashMessage__single">'.$message.'</div>';
	}

	$r .= '</div>';

	return $r;

}

?>