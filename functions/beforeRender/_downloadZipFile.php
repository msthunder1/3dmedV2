<?php

if( isset($_POST['izvoziFaktureZaStranko']) ){

	$fakture = isset($_POST['faktureZaStranko']) ? $_POST['faktureZaStranko'] : $faktureZaStranko;
	$fakture = stripslashes($fakture);
	$fakture = unserialize($fakture);

	$uploadDir = trailingslashit( wp_upload_dir()['basedir'] ) . 'pdf';
	wp_mkdir_p( $uploadDir );

	$files = [];

	if($fakture){
		foreach ($fakture as $faktura) {
			$fakturaId = $faktura->ID;
			$strankaId = get_field("stranka", $fakturaId);
			$strankaName = get_the_title($strankaId);

			$title = "{$strankaName}-{$fakturaId}";
			$url = $uploadDir."/{$title}.pdf";

			$pdf = assemblePdfContent($strankaId, $fakturaId);

			$arr = [
				"url" => $url,
				"name" => $title.".pdf"
			];

			array_push($files, $arr);

			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($pdf);
			$mpdf->SetTitle($title);
			$mpdf->Output($url, 'F');
		}

		$zip_name = "fakture.zip";
		$zip_fullUrl = $uploadDir."/".$zip_name;
		
		$zip = new ZipArchive();
		$res = $zip->open($zip_fullUrl, ZipArchive::CREATE);
		
		if($res === TRUE){
			foreach($files as $file){

				$file_url = wp_make_link_relative($file['url']);
				$file_name = $file['name'];

				if (!file_exists($file_url)) { die("File $file_url doesent exist"); }
				if (!is_readable($file_url)) { die("File $file_url isnt readable"); }
				$zip->addFile($file_url, $file_name);
			}

			$zip->close();

		} else {
			exit("cannot open <$zip_fullUrl>\n");
		}

		header('Content-type: application/zip');  
		header('Content-Disposition: attachment; filename="'.$zip_name.'"');  
		readfile($zip_fullUrl); // auto download

		// Delete zip && pdfs
		unlink($zip_fullUrl);
		foreach ($files as $file) {
			unlink($file["url"]);
		}
		exit;

	}
}


?>