<?php

function pdfPrintTemplate($podatkiPodjetja, $podatkiStranke, $podatkiFakture){

	ob_start();

	$count = 0;
	$znesek__skupaj = 0;
	$body__core = '';

	$datumStoritve_od = date('01.m.Y', strtotime($podatkiFakture['datum'] . ' - 1 month'));
	$datumStoritve_do = date('t.m.Y', strtotime($podatkiFakture['datum']. ' - 1 month'));
	$datumValute = date('d.m.Y', strtotime($podatkiFakture['datumValute']));

	if($podatkiFakture['status'] === 'Račun'){
		$prefix = 'Št. računa';
	} else {
		$prefix = 'Št. predračuna';
	}

	foreach($podatkiFakture['narocila'] as $narocilo__id){

		$narocilo__ime = get_the_title($narocilo__id);
		$narocilo__stElementov = get_field('stevilo_elementov', $narocilo__id);
		$narocilo__znesek = get_field('znesek', $narocilo__id) ? get_field('znesek', $narocilo__id) : '0,00';
		$znesek__skupaj += (float)$narocilo__znesek;
		$count++;

		$body__core .= '<tr class="tr-narocilo">
			<td class="td-narocilo">'.$count.'</td>
			<td class="td-narocilo">'.$narocilo__ime.'</td>
			<td class="td-narocilo right-aligned">'.$narocilo__stElementov.'</td>
			<td class="td-narocilo right-aligned">1</td>
			<td class="td-narocilo right-aligned">'.$narocilo__znesek.' €</td>
			<td class="td-narocilo right-aligned">0</td>
			<td class="td-narocilo right-aligned">0</td>
			<td class="td-narocilo right-aligned">'.$narocilo__znesek.' €</td>
		</tr>';
	}

	$header = '<table>
		<tr>
			<td>
				<img class="logo" src="'.$podatkiPodjetja['logotip'].'"/>
			</td>
			<td class="right-aligned">'.$podatkiPodjetja['naslov'].'</td>
		</tr>
	</table>

	<hr />

	<table>
		<tr>
			<td>ID za DDV: '.$podatkiPodjetja['davcna'].', MS: '.$podatkiPodjetja['maticna'].', e: '.$podatkiPodjetja['email'].'</td>
		</tr>
		<tr>
			<td>TRR: '.$podatkiPodjetja['trr_sparkasse'].'</td>
		</tr>
	</table>

	<p></p>

	<table>
		<tr>
			<td>

				<table>
					<tr><td></td></tr>
					<tr><td class="bold">'.$podatkiStranke['ime'].'</td></tr>
					<tr><td>'.$podatkiStranke['naslov'].'</td></tr>
					<tr><td>'.$podatkiStranke['posta'].' '.$podatkiStranke['kraj'].', '.$podatkiStranke['drzava'].'</td></tr>
				</table>

			</td>
			<td>

				<table class="print__podatkiRacuna">
					<tr><td class="large">'.$prefix.'</td><td class="large">'.$podatkiFakture['title'].'</td></tr>
					<tr><td>Kraj</td><td>Maribor</td></tr>
					<tr><td>Referenca</td><td>'.$podatkiFakture['referenca'].'</td></tr>
					<tr><td>Datum računa</td><td>'.$podatkiFakture['datum'].'</td></tr>
					<tr><td>Datum storitve</td><td>'.$datumStoritve_od.'</td></tr>
					<tr><td></td><td>'.$datumStoritve_do.'</td></tr>
					<tr><td>Datum valute</td><td>'.$datumValute.'</td></tr>
				</table>

			</td>
		</tr>
	</table>';

	$znesek = '<div class="right-aligned">Skupaj za plačilo: <strong>'.$znesek__skupaj.' €</strong></div>';

	if($podatkiFakture['popust'] && $podatkiFakture['cena_s_popustom']){
		$znesek = '
			<div class="right-aligned">Skupaj brez popustov: <span>'.$znesek__skupaj.'€</span></div>
			<div class="right-aligned">Dodaten popust: <span>'.$podatkiFakture['popust'].'%</span></div>
			<div class="right-aligned medium">Skupaj za plačilo: <span>'.$podatkiFakture['cena_s_popustom'].'€</span></div>
		';
	}

	$body = '<div class="print__body">
		<div class="print__bodyTop">

			<p>ID za DDV: '.$podatkiStranke['ddv'].'</p>

			<table class="bordered">
				<thead>
					<tr>
						<td width="5%"><strong>Zap</strong></td>
						<td width="28%"><strong>Storitev/izdelek</strong></td>
						<td width="17%" class="right-aligned"><strong>Št. elementov</strong></td>
						<td width="10%" class="right-aligned"><strong>Kol.</strong></td>
						<td width="15%" class="right-aligned"><strong>Cena EM</strong></td>
						<td width="10%" class="right-aligned"><strong>%DDV</strong></td>
						<td width="5%" class="right-aligned"><strong>DDV</strong></td>
						<td width="10%" class="right-aligned"><strong>Znesek</strong></td>
					</tr>
				</thead>
				<tbody>'.$body__core.'</tbody>
			</table>

			<p></p>'.$znesek.'

		</div>
	</div>';

	$footer = '<div class="print__bodyBottom">

	<p></p>
	<p></p>
	
	<table>
		<tr>
			<td>V skladu z vašim naročilom, Vam zaračunavamo polizdelke,</td>
		</tr>
		<tr>
			<td>kovinska ogrodja za zobne nadomestke.</td>
		</tr>
		<tr>
			<td>DDV ni zaračunan v skladu s 4. točko 1. odstavka 42. člena z DDV 1</td>
		</tr>
		<tr><td><p></p></td></tr>
		<tr>
			<td>Upoštevamo izključno pisne reklamacije v 3. dnevnem roku.</td>
		</tr>
		<tr>
			<td>Zahvaljujemo se vam za zaupanje.</td>
		</tr>
	</table>

	<p></p>

	<table>
		<tr>
			<td>Pripravil/a</td>
			<td class="right-aligned"></td>
		</tr>
		<tr>
			<td>'.$podatkiFakture['pripravil'].'</td>
			<td class="right-aligned"></td>
		</tr>
	</table>

	<p></p>
	<p></p>

	<table>
		<tr>
			<td width="30%"></td>
			<td width="40%" class="center-aligned"><img src="'.$podatkiPodjetja['zig'].'" width="150px" /></td>
			<td width="30%" class="center-aligned"><img src="'.$podatkiPodjetja['podpis'].'" width="75px" /></td>
		</tr>
	</table>';

	$style = '<style>
		.print{
			font-size: 12px;
		}

		table{
			width: 100%;
		}

		table.bordered{
			border: 1px solid #555555;
			border-collapse: collapse;
		}

		.td-narocilo{
			border-top: 1px solid #555555;
		}

		.bold{
			font-weight: bold;
		}

		.logo{
			width: 150px;
		}

		.right-aligned{
			text-align: right;
		}

		.center-aligned{
			text-align: center;
		}

		.large{
			font-size: 17px;
			font-weight: bold;
		}

		.medium{
			font-size: 14px;
			font-weight: bold;
		}

		.print__podatkiRacuna{
			text-align: right;
		}
	</style>';

	echo $style.'<div class="print show"><div class="print__container">'.$header.$body.$footer.'</div></div>';

	$html = ob_get_contents();
	ob_end_clean();

	return $html;

}

?>