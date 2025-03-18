<?php

function srcset_image($image_id, $image_size = "100vw", $classes = "", $echo = true){
	$full = wp_get_attachment_image_src($image_id, "full");
	$largest = wp_get_attachment_image_src($image_id, "largest");
	$laptop = wp_get_attachment_image_src($image_id, "laptop");
	$tablet = wp_get_attachment_image_src($image_id, "tablet");
	$small = wp_get_attachment_image_src($image_id, "small");
	$smaller = wp_get_attachment_image_src($image_id, "smaller");
	$tiny = wp_get_attachment_image_src($image_id, "tiny");
	$tiniest = wp_get_attachment_image_src($image_id, "tiniest");

	$src = "";

	if(getBrowser()["name"] == "Internet Explorer"){
		$src = "src = '" . $full[0] . "'";
	}

	$string = "<img " . $src . " srcset='".$tiny[0]." 250w, " .
				$smaller[0]." 479w, " .
				$small[0]." 768w, " .
				$tablet[0]." 1024w, " .
				$laptop[0]." 1480w, " .
				$largest[0]." 1800w' ";
	if($image_size){
		$string .= "sizes='".$image_size."' ";
	}

	if($classes){
		$string .= "class='".$classes."'";
	}

	$string .= "/>";

	if($echo){
		echo $string;
	} else {
		return $string;
	}
}

?>