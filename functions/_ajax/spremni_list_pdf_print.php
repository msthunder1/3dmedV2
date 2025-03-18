<?php

function ajax__spremni_list_pdf_print($data) {

	$narocilo__id = $_POST['narocilo__id'];

	$narocilo = get_post($narocilo__id);

	$t=time();
	$current__date = date("d.m.Y",$t);

	$narocnik__id = get_field('narocnik_id', $narocilo__id);
	$narocnik__ime = get_field('ime_podjetja', $narocnik__id);
	$narocnik__naslov = get_field('naslov', $narocnik__id);
	$narocnik__postnaStevilka = get_field('postna_stevilka', $narocnik__id);
	$narocnik__kraj = get_field('kraj', $narocnik__id);

	$narocil__id = get_field('narocilo_oddal_id', $narocilo__id);
	$narocil__meta = get_user_meta($narocil__id);
	$narocil__data = get_userdata($narocil__id);
	$narocil__ime = $narocil__meta['first_name'][0];
	$narocil__priimek = $narocil__meta['last_name'][0];
	$narocil__email = $narocil__data->user_email;
	$narocil__telefon = $narocil__meta['telefon'][0];

	$narocilo__title = get_the_title($narocilo__id);
	$narocilo__komentar = get_field('opombe_administratorja', $narocilo__id);
	$narocilo__datum_storitve = get_field('datum_storitve', $narocilo__id);
	$narocilo__datum_dobave = get_field('datum_dobave', $narocilo__id);
	$opombe__stranke = get_field('opombe_stranke', $narocilo__id);

	$podjetje_ime = get_field('ime_podjetja', 'option');
	$podjetje_naslov = get_field('naslov_podjetja', 'option');

	$body = '';
	$slike_izdelkov = '';

	$buildHeader = function ($counter) use ($narocilo__title, $narocilo__datum_storitve, $narocnik__ime, $narocnik__naslov, $narocnik__postnaStevilka, $narocnik__kraj, $narocil__ime, $narocil__priimek, $narocil__email, $narocil__telefon){
		$header = '<table>
			<tr>
				<td class="right-aligned">
					<img class="logo" src="https://narocila.3dmed.si/wp-content/uploads/2020/03/3D-med-logo-dark.png"/>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td width="50%"><h2>Spremni list: '.$narocilo__title.'-'.$counter.'</h2></td>
				<td width="50%" class="right-aligned"><h2>Datum naročila: <strong>'.$narocilo__datum_storitve.'</strong></h2></td>
			</tr>
		</table>
		<table border="1" class="bordered">
			<tr>
				<td width="25%">Številka naročila</td>
				<td colspan="3"><strong>'.$narocilo__title.'</strong></td>
			</tr>
			<tr>
				<td width="25%">Naročnik</td>
				<td><strong>'.$narocnik__ime.'</strong><br />
					'.$narocnik__naslov.'<br />
					'.$narocnik__postnaStevilka.' '.$narocnik__kraj.'
				</td>
			</tr>
			<tr>
				<td width="25%">Naročil/a</td>
				<td width="25%">'.$narocil__ime.' '.$narocil__priimek.'</td>
				<td width="25%">E: '.$narocil__email.'</td>
				<td width="25%">T: '.$narocil__telefon.'</td>
			</tr>
		</table>
		<p></p>';

		return $header;
	};

	$footer = '<table border="1" class="bordered">
		<tr>
			<td width="25%">Proizvajalec:</td>
			<td width="75%"><strong>'.$podjetje_ime.'</strong> '.$podjetje_naslov.'</td>
		</tr>
		<tr>
			<td width="25%">Komentar:</td>
			<td width="75%">'.$narocilo__komentar.'</td>
		</tr>
	</table>
	<p></p>
	<table border="1" class="bordered">
		<tr>
			<td width="25%">Opombe stranke:</td>
			<td width="75%">'.$opombe__stranke.'</td>
		</tr>
	</table>
	<p></p>';

	$priloge = '<table border="1" class="bordered">
		<tr>
			<td width="100%">Priloge</td>
		</tr>
	</table>'.$slike_izdelkov;

	if ( have_rows( 'modul', $narocilo__id) ) {

		$field_object = get_field_object('modul', $narocilo__id);
		$total_rows = count($field_object['value']);
		$counter = 0;

		while( have_rows( 'modul', $narocilo__id ) ) {
			the_row();

			$counter++;
			$zobotehnicni_status = get_sub_field('zobotehnicni_status');
			
			$stevilo_elementov = get_sub_field('stevilo_elementov');
			$material__id = get_sub_field('material');
			$material = $material__id ? get_the_title($material__id) : '';
			$gostota = $material__id ? get_field('gostota', $material__id) : '';
			$sarza__id = get_sub_field('sarza__lot');
			$sarza = $sarza__id ? get_field('sarza', $sarza__id) : '';
			$file__id = get_sub_field('datoteka');
			$file = basename ( get_attached_file($file__id));
			$slika_izdelka_id = get_sub_field('slika_izdelka');
			$slika_izdelka = $slika_izdelka_id ? wp_get_attachment_url($slika_izdelka_id) : '';

			$st__clenov = get_sub_field('komadi_za_clen');
			$st__em = get_sub_field('komadi_za_em');
			$st__elementov = (int)$st__clenov + (int)$st__em;

			// Če imamo izbrano nekaj pri vezilkah, dodamo še 1 element
			$vizilke = get_sub_field('vizilke');
			if($vizilke !== 'zero'){
				$st__elementov = $st__elementov + 1;
			}

			$body .= $buildHeader($counter);

			$body .= '<table border="1" class="bordered">
				<tr>
					<td width="25%">Zobozdravnik / pacient</td>
					<td width="25%">'.$zobotehnicni_status.'</td>
					<td width="25%">Št. elementov: '.$st__elementov.'</td>
					<td width="25%">Masa na enoto: '.$gostota.' g</td>
				</tr>
				<tr>
					<td width="25%">Ime datoteke:</td>
					<td colspan="3">'.$file.'</td>
				</tr>
				<tr>
					<td width="25%">Material:</td>
					<td width="25%">'.$material.'</td>
					<td colspan="2">Šarža / LOT: '.$sarza.'</td>
				</tr>
				<tr>
					<td width="25%">Datum izdelave:</td>
					<td width="25%">'.$narocilo__datum_storitve.'</td>
					<td colspan="2">Predviden rok dostave: '.$narocilo__datum_dobave.'</td>
				</tr>
			</table>
			<p></p>';

			$body .= $footer;

			if($slika_izdelka !== ''){
				$body .= '<table border="1" class="bordered" cellpadding="5">
					<tr>
						<td width="100%">Priloge</td>
					</tr>
					<tr>
						<td width="100%">
							<table border="0" class="bordered">
								<tr>
									<td width="70%" align="center"><img class="priloga" src="'.$slika_izdelka.'" /></td>
									<td width="30%" class="stamp" align="center" vertical-align="middle"><p></p><img class="zig" src="https://narocila.3dmed.si/wp-content/uploads/2022/03/zig_podpis.png" /></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>';	
			}

			if($counter != $total_rows ){
				// Expect for the last row
				$body .= '<br pagebreak="true"/>';
			}			
		}
	}


	$style = '<style>
		.print{
			font-size: 11px;
		}

		table{
			width: 100%;
		}

		table.bordered{
			border-collapse: collapse;
		}

		td{
			padding: 3px;
		}

		h2{
			font-weight: normal;
			font-size: 15px;
		}

		p{
			margin: 0;
		}

		.logo{
			width: 150px;
		}

		.priloga{
			width: 400px;
		}

		.zig{
			width: 85px;
		}

		.right-aligned{
			text-align: right;
		}
	</style>';

	$html = $style.'<div class="print show">
		<div class="print__container">'.$body.'</div>
	</div>';

	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	 
	$pdf->SetCreator("3Dmed");
	$pdf->SetAuthor('3Dmed');
	$pdf->SetTitle('3Dmed test faktura');
	 
	$pdf->setHeaderData();
	$pdf->setFooterData();
	 
	$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	 
	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	 
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	 
	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	 
	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	 
	// ---------------------------------------------------------
	 
	// set default font subsetting mode
	 
	$pdf->setFont('dejavusans', '', 10, '', true);
	 
	$pdf->AddPage();
	 
	$pdf->writeHTML($html);

	$pdf_file_name = 'spremni_list_'.$narocilo__title;
	$pdf_file_path = wp_upload_dir()['path'] .'/'. $pdf_file_name .'.pdf';
	$pdf_file_url = wp_upload_dir()['url'] .'/'. $pdf_file_name .'.pdf';

	$pdf->Output($pdf_file_path, 'F');

	echo $pdf_file_url;

	wp_die();

}

add_action( 'wp_ajax_nopriv_ajax__spremni_list_pdf_print', 'ajax__spremni_list_pdf_print' );
add_action( 'wp_ajax_ajax__spremni_list_pdf_print', 'ajax__spremni_list_pdf_print' );

?>