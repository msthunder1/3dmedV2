<?php

function create_faktura_print_pdf($stranka, $faktura){

	$logo = srcset_image(632, '(max-width: 767px) 250px, (max-width: 1024px) 479px, 768px', 'print__logoImage', false);

	?>

	<div class="print" id="print">
		<div class="print__container">

			<div class="print__header">
				<div class="print__logo">
					<div class="print__logoImageWrapper"><?php echo $logo ?></div>
				</div>
				<div class="print__headerInfo">
					<div class="print__narocnikInfo infobox">
						<div class="infobox__row title"><?php echo $stranka['ime'] ?></div>
						<div class="infobox__row value"><?php echo $stranka['naslov'] ?></div>
						<div class="infobox__row value"><?php echo $stranka['posta'] . ' ' . $stranka['kraj'] . ', ' . $stranka['drzava']; ?></div>
						<div class="infobox__row value">ID za DDV: <?php echo $stranka['ddv'] ?></div>
					</div>
					<div class="print__fakturaInfo infobox">
						<div class="infobox__row title large">
							<div class="infobox__label">ŠT. FAKTURE</div>
							<div class="infobox__value"><?php echo $faktura['title'] ?></div>
						</div>
						<div class="infobox__row">
							<div class="infobox__label">Kraj</div>
							<div class="infobox__value">Maribor</div>
						</div>
						<div class="infobox__row">
							<div class="infobox__label">Referenca</div>
							<div class="infobox__value"><?php echo $faktura['referenca'] ?></div>
						</div>
						<div class="infobox__row">
							<div class="infobox__label">Datum</div>
							<div class="infobox__value"><?php echo $faktura['datum'] ?></div>
						</div>
						<div class="infobox__row">
							<div class="infobox__label">Datum valute</div>
							<div class="infobox__value"><?php echo $faktura['datumValute'] ?></div>
						</div>
					</div>
				</div>
			</div>

			<div class="print__body">
				<div class="print__bodyTop">

					<table class="print__table">
						<thead>
							<tr>
								<td>Zap. št.</td>
								<td>Storitev/izdelek</td>
								<td>Količina</td>
								<td>Cena EM</td>
								<td>Znesek</td>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 0;
							$znesek__skupaj = 0;
							foreach($stranka['narocila'] as $narocilo__id){ ?>
								<tr>
									<?php
									$narocilo__ime = get_the_title($narocilo__id);
									$narocilo__stElementov = get_field('stevilo_elementov', $narocilo__id);
									$narocilo__znesek = get_field('znesek', $narocilo__id) ? get_field('znesek', $narocilo__id) : '0,00';
									$znesek__skupaj = (float)$narocilo__znesek;
									$count++;
									?>
									<td><?php echo $count ?></td>
									<td><?php echo $narocilo__ime . ' (Št. elementov: '.$narocilo__stElementov.')' ?></td>
									<td style="text-align: center;">1</td>
									<td><?php echo $narocilo__znesek ?> €</td>
									<td style="text-align: right;"><?php echo $narocilo__znesek ?> €</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>

					<div class="znesek__skupaj">Skupaj za plačilo: <span><?php echo $znesek__skupaj ?>€</div></span></div>

				</div>
				<div class="print__bodyBottom">
					<div class="print__ddvinfo">
						<div>V skladu z vašim naročilom, Vam zaračunavamo polizdelke, kovinska ogrodja za zobne nadomestke.</div>
						<div>DDV ni zaračunan v skladu s 4. točko 1. odstavka 42. člena z DDV 1</div>
					</div>
					<div class="print__pripravilDirektor">
						<div class="print__pripravil infobox">
							<div class="infobox__row title">Pripravil/a</div>
							<div class="infobox__row value"><?php echo $faktura['pripravil'] ?></div>
						</div>
						<div class="print__direktor">
							<div class="infobox__row title"></div>
							<div class="infobox__row value"></div>
						</div>
					</div>
				</div>
			</div>



			<div class="print__footer">
				<div class="print__podjetjeNaslovPodatki">
					<div class="print__podjetjeNaslov infobox">
						<div class="infobox__row title"><?php the_field('ime_podjetja', 'option'); ?></div>
						<div class="infobox__row value"><?php the_field('naslov_podjetja', 'option'); ?></div>
						<div class="infobox__row value"><?php the_field('email_podjetja', 'option'); ?></div>
					</div>
					<div class="print__podjetjePodatki infobox">
						<div class="infobox__row">
							<?php
							$maticna_stevilka_obj = get_field_object('maticna_stevilka', 'option');
							?>
							<div class="infobox__label"><?php echo $maticna_stevilka_obj['label'] ?></div>
							<div class="infobox__value"><?php echo $maticna_stevilka_obj['value'] ?></div>
						</div>
						<div class="infobox__row">
							<?php
							$davcna_stevilka_obj = get_field_object('davcna_stevilka', 'option');
							?>
							<div class="infobox__label"><?php echo $davcna_stevilka_obj['label'] ?></div>
							<div class="infobox__value"><?php echo $davcna_stevilka_obj['value'] ?></div>
						</div>
						<div class="infobox__row">
							<?php
							$stevilka_trr_nlb_obj = get_field_object('stevilka_trr_pri_nlb_dd', 'option');
							?>
							<div class="infobox__label"><?php echo $stevilka_trr_nlb_obj['label'] ?></div>
							<div class="infobox__value"><?php echo $stevilka_trr_nlb_obj['value'] ?></div>
						</div>
						<div class="infobox__row">
							<?php
							$stevilka_trr_sparkasse_obj = get_field_object('stevilka_trr_pri_sparkasse_dd', 'option');
							?>
							<div class="infobox__label"><?php echo $stevilka_trr_sparkasse_obj['label'] ?></div>
							<div class="infobox__value"><?php echo $stevilka_trr_sparkasse_obj['value'] ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php } ?>