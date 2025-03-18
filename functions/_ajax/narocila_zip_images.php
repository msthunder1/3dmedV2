<?php

function ajax__narocila_zip_images($data) {
	$files = $_POST['files'];
	$fileSuffix = $_POST['fileSuffix'];

	$uploads_dir = wp_upload_dir()["path"];

	if (!is_writable($uploads_dir)) { die('directory not writable'); }

	$zip_name = $uploads_dir."/paket".$fileSuffix.".zip";

	zipFilesAndDownload($zip_name, $files);

	wp_die();

}

add_action( 'wp_ajax_nopriv_ajax__narocila_zip_images', 'ajax__narocila_zip_images' );
add_action( 'wp_ajax_ajax__narocila_zip_images', 'ajax__narocila_zip_images' );

function zipFilesAndDownload($zip_name, $files){
	
	$zip = new ZipArchive();
	$res = $zip->open($zip_name, ZipArchive::CREATE);
	
	if($res === TRUE){
		foreach($files as $file){

			$path = rtrim(get_home_path(),"/");

			$file_url = $path.wp_make_link_relative($file['url']);
			$file_name = $file['name'];

			if (!file_exists($file_url)) { die("File $file_url doesent exist"); }
			if (!is_readable($file_url)) { die("File $file_url isnt readable"); }
			$zip->addFile($file_url, $file_name);
		}

		$zip->close();

	} else {
		exit("cannot open <$zip_name>\n");
	}

	$relative_url = explode(get_home_path(), $zip_name);
	$absolute_url = get_site_url()."/".$relative_url[1];

	echo $absolute_url;
}

?>