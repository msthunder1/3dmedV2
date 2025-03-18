<?php

function singleFakture() {

	// POST request was send
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		// Submit button was clicked
		if (isset($_POST['posljiFormo'])) {
			$error = checkPostRequiredFields($_POST);
			if($error['count'] == 0){
				echo handlePostUpdate__fakture();
			} else {
				echo handlePostNotificationError($error['messages']);
			}
		}
	}

	$item_id = get_the_ID();

	$stranka__arr = array();
	$faktura__arr = array();

	$stranka = getField__value('stranka');
	$stranka__arr['id'] = $stranka_id = $stranka->ID;
	$stranka__arr['ime'] = $stranka_ime = get_field('ime_podjetja', $stranka_id);
	$stranka__arr['naslov'] = $stranka_naslov = get_field('naslov', $stranka_id);
	$stranka__arr['posta'] = $stranka_posta = get_field('postna_stevilka', $stranka_id);
	$stranka__arr['kraj'] = $stranka_kraj = get_field('kraj', $stranka_id);
	$stranka__arr['drzava'] = $stranka_drzava = get_field('drzava', $stranka_id);
	$stranka__arr['ddv'] = $stranka_ddv = get_field('davcna_stevilka', $stranka_id);
	$stranka__arr['narocila'] = $narocila_id = get_field('narocila');

	$faktura__arr['id'] = $item_id;
	$faktura__arr['title'] = get_the_title($item_id);
	$faktura__arr['status'] = getField__value('status_fakture');
	$faktura__arr['referenca'] = 'SI00 ' . get_field('referenca', $item_id);
	$faktura__arr['datum'] = get_the_date();
	$faktura__arr['datumValute'] = get_field('datum_valute', $item_id);
	$faktura__pripravil_object = get_field('pripravil', $item_id);
	$faktura__arr['pripravil'] = $faktura__pripravil_object->display_name ? $faktura__pripravil_object->display_name : '--';
	$faktura__arr['cena'] = get_field('cena', $item_id);
	$faktura__arr['popust'] = get_field('popust', $item_id);
	$faktura__arr['cena_s_popustom'] = get_field('cena_s_popustom', $item_id);

	?>
	<div class='form__wrapper faktureEdit'>
		<form method='post' name='updateFields' class='form'>

			<div class='form__title'>
				<h2>Pregled fakture: <?php echo $faktura__arr['title'] ?></h2>
			</div>

			<div class="faktureEdit__partCustomer">
				<div class="faktureEdit__partLeft">
					<div class="form__row">
						<div class="form__label">Naročnik:</div>
						
						<div class="form__column">
							<div class="form__value"><?php echo $stranka_ime ?></div>
							<div class="form__value"><?php echo $stranka_naslov ?></div>
							<div class="form__value"><?php echo $stranka_posta . ' ' . $stranka_kraj . ', ' . $stranka_drzava; ?></div>
						</div>
					</div>
					<div class="form__row">
						<div class="form__label"><?php echo getField__label('status_fakture') ?>:</div>
						<div class="form__value"><?php echo $faktura__arr['status'] ?></div>
					</div>
					<div class="form__row">
						<div class="form__label">Datum fakturiranja:</div>
						<div class="form__value"><?php echo $faktura__arr['datum'] ?></div>
					</div>
					<div class="form__row">
						<div class="form__label"><?php echo getField__label('cena'); ?>:</div>
						<div class="form__value"><?php echo getField__value('cena');?> €</div>
					</div>
					<?php
					$cena_s_popustom = getField__value('cena_s_popustom');
					if($cena_s_popustom){ ?>
						<div class="form__row">
							<div class="form__label"><?php echo getField__label('cena_s_popustom'); ?>:</div>
							<div class="form__value"><?php echo getField__value('cena_s_popustom');?> €</div>
						</div>
					<?php } ?>
				</div>
				<div class="faktureEdit__partRight">
					<div class="form__row transparent">
						<div class="faktureEdit__natisni js-printFaktura" data-stranka_id="<?php echo $stranka_id ?>" data-faktura_id="<?php echo $item_id ?>">
							<div class="faktureEdit__natisniIcon form__icon"><i class="far fa-file-pdf"></i></div>
							<div class="faktureEdit__natisniText form__iconText">Natisni Fakturo</div>
						</div>
					</div>
					<div class="form__row transparent">
						<div class="faktureEdit__ponovnoPoslji js-ponovnoPoslji" data-stranka_id="<?php echo $stranka_id ?>" data-faktura_id="<?php echo $item_id ?>">
							<div class="ponovnoPoslji ponovnoPoslji__poslji">
								<div class="faktureEdit__natisniIcon form__icon"><i class="far fa-envelope"></i></div>
								<div class="faktureEdit__natisniText form__iconText">Ponovno pošlji email</div>
							</div>
							<div class="ponovnoPoslji ponovnoPoslji__posiljam">
								<div class="faktureEdit__natisniIcon form__icon"><i class="far fa-clock"></i></div>
								<div class="faktureEdit__natisniText form__iconText">Pošiljam email</div>
							</div>
							<div class="ponovnoPoslji ponovnoPoslji__poslano">
								<div class="faktureEdit__natisniIcon form__icon"><i class="far fa-paper-plane"></i></div>
								<div class="faktureEdit__natisniText form__iconText">Email poslan</div>
							</div>
							<div class="ponovnoPoslji ponovnoPoslji__error">
								<div class="faktureEdit__natisniIcon form__icon"><i class="fa fa-exclamation"></i></div>
								<div class="faktureEdit__natisniText form__iconText">Email ni poslan. Napaka.</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form__row secondary">
				<div class="form__label">Pripravil:</div>
				<div class="form__value">
					<?php 
					$pripravil = getField__value('pripravil');
					echo $pripravil->display_name;
					?>
				</div>
			</div>

			<div class="form__row secondary">
				<div class="form__label">Naročila:</div>
				<div class="form__column">
					<div class="form__narocila--row">
						<div class="form__value--title">Številka naročila</div>
						<div class="form__value--title">Datum</div>
						<div class="form__value--title">Število elementov</div>
						<div class="form__value--title">Znesek</div>
						<div class="form__value--title">Pripravil</div>
					</div>
					<?php
					foreach($stranka__arr['narocila'] as $narocilo__id){ ?>
						<div class="form__narocila--row">
							<?php
							$narocilo__ime = get_the_title($narocilo__id);
							$narocilo__datum = get_field('datum_narocila_in_ura', $narocilo__id);
							$narocilo__pripravil_id = get_field('pripravil', $narocilo__id);
							$narocilo__pripravil_meta = get_user_meta($narocilo__pripravil_id);
							$narocilo__pripravil = $narocilo__pripravil_meta['first_name'][0] . ' ' . $narocilo__pripravil_meta['last_name'][0];
							$narocilo__stElementov = get_field('stevilo_elementov', $narocilo__id);
							$narocilo__znesek = get_field('znesek', $narocilo__id) ? get_field('znesek', $narocilo__id) : '0,00';

							?>
							<div class="form__value"><?php echo $narocilo__ime ?></div>
							<div class="form__value"><?php echo $narocilo__datum ?></div>
							<div class="form__value"><?php echo $narocilo__stElementov ?></div>
							<div class="form__value"><?php echo $narocilo__znesek ?> €</div>
							<div class="form__value"><?php echo $narocilo__pripravil ?></div>
						</div>
					<?php } ?>
				</div>
			</div>

			<input type='hidden' name='item_id' value='<?php echo $item_id?>' >

		</form>
	</div>

	<?php

}

function handlePostUpdate__fakture(){

	$item_id = $_POST["item_id"];
	$messages = array();

	if(isset($_POST["material"]['value'])){
		$val = $_POST["material"]['value'];
		update_field('material', $val, $item_id);
		array_push($messages, "Material uspešno posodobljen.");
	}

	if(isset($_POST["vsebnik"]['value'])){
		$val = $_POST["vsebnik"]['value'];
		update_field('vsebnik', $val, $item_id);
		array_push($messages, "Vsebnik uspešno posodobljen.");
	}
	
	if(isset($_POST["sito"]['value'])){
		$val = $_POST["sito"]['value'];
		update_field('sito', $val, $item_id);
		array_push($messages, "Sito uspešno posodobljeno.");
	}
	
	if(isset($_POST["datum_sejanja"]['value'])){
		$val = $_POST["datum_sejanja"]['value'];
		update_field('datum_sejanja', $val, $item_id);
		array_push($messages, "Datum sejanja uspešno posodobljen.");
	}
	
	if(isset($_POST["sejalec"]['value'])){
		$val = is_numeric($_POST["sejalec"]['value']) ? (int)$_POST["sejalec"]['value'] : 0;
		if($val > 0){
			update_field('sejalec', $val, $item_id);
			array_push($messages, "Sejalec uspešno posodobljen.");
		}
	}
	
	if(isset($_POST["sarza"]['value'])){
		$val = $_POST["sarza"]['value'];
		update_field('sarza', $val, $item_id);
		array_push($messages, "Šarža uspešno posodobljena.");
	}

	return handlePostNotificationUpdate($messages);
}

?>