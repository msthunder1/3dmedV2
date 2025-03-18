<?php

require_once("functions/_common/_pdfPrintTemplate.php");
require_once('libs/vendor/autoload.php');

$podjetje__arr = array(
	'naslov' => '3dMed',
	'email' => '3dMed.email@si',
	'maticna' => '3dmedMaticna123',
	'davcna' => '3dmedDavcna123',
	'trr_nlb' => '3dmedTRR_Nlb',
	'trr_sparkasse' => '3dmedTRR_Sparkasse',
	'logotip' => 'https://narocila.3dmed.si/wp-content/uploads/2020/03/3D-med-logo-dark.png',
	'podpis' => 'https://narocila.comma.si/wp-content/uploads/2021/06/podpis.png',
	'zig' => 'https://narocila.comma.si/wp-content/uploads/2021/06/zig.png',
);

$stranka__arr = array(
	'narocila' => [],
	'ime' => 'Ime podjetja',
	'naslov' => 'Naslov',
	'posta' => 'Pošta',
	'kraj' => 'Kraj',
	'drzava' => 'Država',
	'ddv' => 'DDV 1234',
);

$faktura__arr = array(
	'title' => 'Faktura naslov',
	'link' => 'Faktura povezava',
	'cena' => 'Znesek 123',
	'datum' => 'Datum 1.1.1111',
	'datumValute' => 'Datum valute 1.1',
	'status' => 'Status fakture',
	'referenca' => 'Referenca',
	'pripravil' => 'Pripravil je',
);

$pdf = pdfPrintTemplate($podjetje__arr, $stranka__arr, $faktura__arr);

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($pdf);
$mpdf->Output();

?>