<?php

function cron_function_fakture_predracun_v_racun(){

	$date = date('Ymd');

	$items = get_posts([
		'post_type' => 'fakture',
		'post_status' => 'publish',
		'orderby' => 'ID',
		'order' => 'ASC',
		'numberposts' => -1,
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => 'status_fakture',
				'value' => 'Predračun',
			)
		),
	]);

	$fakture = array();

	foreach($items as $faktura){

		$ID = $faktura->ID;
		$datum_valute = get_field('datum_valute', $ID);

		if($datum_valute <= $date){
			array_push($fakture, $faktura);
		}
		
	}
	
	foreach($fakture as $faktura){
		
		$faktura__id = $faktura->ID;
		$stranka__obj = get_field('stranka', $faktura__id);
		$stranka__id = $stranka__obj->ID;
		
		$dateForTitle = date("Y");
		$serial = get_field("stevilo_racuna", "option");

		update_field( 'stevilo_racuna', $serial+1, 'option' );

		wp_update_post(array(
			'ID' => $faktura__id,
			'post_title' => 'R-'.$dateForTitle.'-'.$serial
		));

		// Posodobi status fakturiranja
		update_field('status_fakture', 'Račun', $faktura__id);

		$faktura__arr['title'] = get_the_title($faktura__id);
		$faktura__arr['link'] = get_permalink($faktura__id);

		// Pošlje se email z računom
		$podjetje__arr = array(
			'naslov' => get_field('naslov_podjetja', 'option'),
			'email' => get_field('email_podjetja', 'option'),
			'maticna' => get_field_object("maticna_stevilka", "option")['value'],
			'davcna' => get_field_object("davcna_stevilka", "option")['value'],
			'trr_nlb' => get_field_object("stevilka_trr_pri_nlb_dd", "option")['value'],
			'trr_sparkasse' => get_field_object("stevilka_trr_pri_sparkasse_dd", "option")['value'],
			'logotip' => get_field('logotip_podjetja', 'option'),
			'podpis' => get_field('podpis_podjetja', 'option'),
			'zig' => get_field('zig_podjetja', 'option'),
		);

		$stranka__arr = array(
			'ime' => get_field('ime_podjetja', $stranka__id),
			'naslov' => get_field('naslov', $stranka__id),
			'posta' => get_field('postna_stevilka', $stranka__id),
			'kraj' => get_field('kraj', $stranka__id),
			'drzava' => get_field('drzava', $stranka__id),
			'ddv' => get_field('davcna_stevilka', $stranka__id),
		);

		$pripravil = '';
		$pripravil__obj = get_field("pripravil", $faktura__id);

		if (is_object($pripravil__obj)) {
			$pripravil__id = $pripravil__obj->ID;
		}

		if($pripravil__id){
			$pripravil = getCustom__usernameFromId($pripravil__id);
		}

		$faktura__arr = array(
			'narocila' => get_field('narocila', $faktura__id),
			'title' => get_the_title($faktura__id),
			'cena' => get_field('cena', $faktura__id),
			'datum' => get_the_date('', $faktura__id),
			'datumValute' => get_field('datum_valute', $faktura__id),
			'status' => get_field('status_fakture', $faktura__id),
			'referenca' => 'SI00 ' . get_field('referenca', $faktura__id),
			'pripravil' => $pripravil,
			'popust' => get_field('popust', $faktura__id),
			'cena_s_popustom' => get_field('cena_s_popustom', $faktura__id),
		);

		$pdf = pdfPrintTemplate($podjetje__arr, $stranka__arr, $faktura__arr);
		$pdf_file_url = wp_upload_dir()['path'].'/racun.pdf';

		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($pdf);
		$mpdf->Output($pdf_file_url, 'F');

		$email_data = array(
			'faktura_title' => $faktura__arr['title'],
			'faktura_link' => $faktura__arr['link'],
			'faktura_cena' => $faktura__arr['cena'],
			'stranka_id' => $stranka_id,
			'pdf' => $pdf_file_url
		);

		send_email('racun', $stranka__id, $email_data);

		unlink($pdf_file_url);

	}

}

add_action( 'fakture_predracun_v_racun', 'cron_function_fakture_predracun_v_racun' );

?>