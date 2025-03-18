<?php

function ajax__ponovnoPosljiEmail($data) {

	$stranka_id = (int)$_POST['stranka_id'];
	$faktura_id = (int)$_POST['faktura_id'];

	$podjetje_arr = array(
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

	$stranka_arr = array(
		'ime' => get_field('ime_podjetja', $stranka_id),
		'naslov' => get_field('naslov', $stranka_id),
		'posta' => get_field('postna_stevilka', $stranka_id),
		'kraj' => get_field('kraj', $stranka_id),
		'drzava' => get_field('drzava', $stranka_id),
		'ddv' => get_field('davcna_stevilka', $stranka_id),
	);

	$pripravil = '';
	$pripravil_obj = get_field("pripravil", $faktura_id);

	if (is_object($pripravil_obj)) {
		$pripravil_id = $pripravil_obj->ID;
	}

	if($pripravil_id){
		$pripravil = getCustom__usernameFromId($pripravil_id);
	}

	$faktura_arr = array(
		'narocila' => get_field('narocila', $faktura_id),
		'title' => get_the_title($faktura_id),
		'cena' => get_field('cena', $faktura_id),
		'datum' => get_the_date('', $faktura_id),
		'datumValute' => get_field('datum_valute', $faktura_id),
		'status' => get_field('status_fakture', $faktura_id),
		'referenca' => 'SI00 ' . get_field('referenca', $faktura_id),
		'pripravil' => $pripravil,
		'popust' => get_field('popust', $faktura_id),
		'cena_s_popustom' => get_field('cena_s_popustom', $faktura_id),
	);

	$pdf = pdfPrintTemplate($podjetje_arr, $stranka_arr, $faktura_arr);
	$pdf_file_url = wp_upload_dir()['path'].'/ponovnoPoslji.pdf';

	$mpdf = new \Mpdf\Mpdf();
	$mpdf->WriteHTML($pdf);
	$mpdf->Output($pdf_file_url, 'F');

	$email_data = array(
		'faktura_title' => $faktura_arr['title'],
		'faktura_link' => $faktura_arr['link'],
		'faktura_cena' => $faktura_arr['cena'],
		'stranka_id' => $stranka_id,
		'pdf' => $pdf_file_url
	);

	$email = 'predracun';

	if($faktura_arr['status'] === 'Račun'){
		$email = 'racun';
	}

	send_email($email, $stranka_id, $email_data);

	unlink($pdf_file_url);

	die();

}

add_action( 'wp_ajax_nopriv_ajax__ponovnoPosljiEmail', 'ajax__ponovnoPosljiEmail' );
add_action( 'wp_ajax_ajax__ponovnoPosljiEmail', 'ajax__ponovnoPosljiEmail' );

?>