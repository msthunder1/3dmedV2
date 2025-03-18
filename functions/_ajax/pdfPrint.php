<?php

function ajax__pdfPrint($data) {

	$stranka_id = (int)$_POST['stranka_id'];
	$faktura_id = (int)$_POST['faktura_id'];

	$pdf = assemblePdfContent($stranka_id, $faktura_id);

	$mpdf = new \Mpdf\Mpdf();
	$mpdf->WriteHTML($pdf);
	$mpdf->SetTitle($faktura__arr['title']);
	$pdfString = $mpdf->Output('', 'S');
	$pdfBase64 = base64_encode($pdfString);

	echo 'data:application/pdf;base64,' . $pdfBase64;
	die();

}

function assemblePdfContent($stranka_id, $faktura_id){
	$podjetje__arr = array(
		'naslov' => get_field('naslov_podjetja', 'option'),
		'email' => get_field('email_podjetja', 'option'),
		'maticna' => get_field_object("maticna_stevilka", "option")['value'],
		'davcna' => get_field_object("davcna_stevilka", "option")['value'],
		'trr_nlb' => get_field_object("stevilka_trr_pri_nlb_dd", "option")['value'],
		'trr_sparkasse' => get_field_object("stevilka_trr_pri_sparkasse_dd", "option")['value'],
		'logotip' => get_field("logotip_podjetja", "option"),
		'podpis' => get_field("podpis_podjetja", "option"),
		'zig' => get_field("zig_podjetja", "option"),
	);

	$stranka__arr = array(
		'ime' => get_field('ime_podjetja', $stranka_id),
		'naslov' => get_field('naslov', $stranka_id),
		'posta' => get_field('postna_stevilka', $stranka_id),
		'kraj' => get_field('kraj', $stranka_id),
		'drzava' => get_field('drzava', $stranka_id),
		'ddv' => get_field('davcna_stevilka', $stranka_id),
	);

	$pripravil = '';
	$pripravil__obj = get_field("pripravil", $faktura_id);

	if (is_object($pripravil__obj)) {
		$pripravil__id = $pripravil__obj->ID;
	}

	if($pripravil__id){
		$pripravil = getCustom__usernameFromId($pripravil__id);
	}

	$faktura__arr = array(
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

	$pdf = pdfPrintTemplate($podjetje__arr, $stranka__arr, $faktura__arr);

	return $pdf;
}

add_action( 'wp_ajax_nopriv_ajax__pdfPrint', 'ajax__pdfPrint' );
add_action( 'wp_ajax_ajax__pdfPrint', 'ajax__pdfPrint' );

?>