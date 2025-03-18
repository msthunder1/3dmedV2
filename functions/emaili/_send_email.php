<?php

function send_email($type, $user_id='', $email_data=''){

	if(!$type){
		return;
	}

	$emaili_query = get_posts(array(
		'numberposts'	=> 1,
		'post_type'		=> 'emaili',
		'meta_key'		=> 'poslji_ob',
		'meta_value'	=> $type,
		'orderby'		=> 'publish_date',
    	'order' 		=> 'ASC',
	));

	if(empty($emaili_query)){
		return;
	}

	$email_id = $emaili_query[0]->ID;
	$user_id = $user_id ? $user_id : get_current_user_id();

	if($email_id && $user_id){

		if($type === 'registracija'){
			email__registracija($email_id, $user_id);
		}

		if($type === 'predracun'){
			email__predracun($email_id, $user_id, $email_data);
		}

		if($type === 'racun'){
			email__racun($email_id, $user_id, $email_data);
		}
	}
}

function email__registracija($email_id, $user_id){

	// TODO
	// $email_head = get_field('glava', $email_id);
	// $email_vsebina = get_field('vsebina', $email_id);

	$user = get_user_by('id', $user_id);
	$user_email = $user->user_email;
	$user_full_name = $user->user_firstname .' '. $user->user_lastname;

	$subject = "Pozdravljeni " . $user_full_name . ", dobrodošli na 3Dmed!";
	$body = '<h1>'.$user_full_name.'</h1></br>
			<p>Zahvaljujemo se vam, da ste se pridružili naši strani. Vaš račun je sedaj aktiven.</p>
			<p>Vaše uporabniško ime je '.$user_email.'</p>
			<p>Za vsa vprašanja smo vam na voljo.</p>
			<p>Lep pozdrav,</p>
			<p>ekipa 3Dmed</p>';

	email__send($user_email, $subject, $body);

}

function email__predracun($email_id, $user_id, $email_data){

	$subject = get_field('glava', $email_id);
	$body = get_field('vsebina', $email_id);

	$faktura_title = $email_data['faktura_title'];
	$faktura_link = $email_data['faktura_link'];
	$faktura_cena = $email_data['faktura_cena'];

	$podjetje_ime = get_field('ime_podjetja', 'option');
	$podjetje_naslov = get_field('naslov_podjetja', 'option');
	$podjetje_trr = get_field("stevilka_trr_pri_sparkasse_dd", "option");

	$stranka_id = $email_data['stranka_id'];
	$stranka_ime = get_field('ime_podjetja', $stranka_id);
	$stranka_naslov = get_field('naslov', $stranka_id);
	$stranka_postna_stevilka = get_field('postna_stevilka', $stranka_id);
	$stranka_kraj = get_field('kraj', $stranka_id);

	$attachments = $email_data['pdf'];

	$body = '<h2>Spoštovani</h2>
	<p>v povezavi vam pošiljamo predračun št. '.$faktura_title.', ki vsebuje vaša odprta naročila za dogovorjeno obdobje.</p>
	<p>Predračun je osnova za izdajo računa, ki bo izdan v roku 3 dni. V kolikor želite na predračun podati ugovor ali zahtevo po spremembi morate to storiti v roku 3 dni. Po preteku tega roka ugovor ni možen.</p>
	<p><a href="'.$faktura_link.'">Predračun si lahko ogledate tukaj.</a></p>
	<p>Lep pozdrav, ekipa 3D MED</p>
	<hr>
	<h2>PODATKI ZA NAKAZILO:</h2>
	<p>Pošiljatelj:</p>
	'.$podjetje_ime.'<br />
	'.$podjetje_naslov.'<br />
	'.$podjetje_trr.'<br />

	<p>Prejemnik:</p>
	'.$stranka_ime.'<br />
	'.$stranka_naslov.'<br />
	'.$stranka_postna_stevilka.', '.$stranka_kraj.'<br />

	<p>Znesek za plačilo:'.$faktura_cena.'</p>
	<p>Namen: plačilo predračuna</p>';

	$stranka_email = get_field('e-naslov_podjetja', $user_id);

	email__send($stranka_email, $subject, $body, $attachments);

}

function email__racun($email_id, $user_id, $email_data){

	$subject = get_field('glava', $email_id);
	$body = get_field('vsebina', $email_id);

	$faktura_title = $email_data['faktura_title'];
	$faktura_link = $email_data['faktura_link'];
	$faktura_cena = $email_data['faktura_cena'];

	$podjetje_ime = get_field('ime_podjetja', 'option');
	$podjetje_naslov = get_field('naslov_podjetja', 'option');
	$podjetje_trr = get_field("stevilka_trr_pri_sparkasse_dd", "option");

	$stranka_id = $email_data['stranka_id'];
	$stranka_ime = get_field('ime_podjetja', $stranka_id);
	$stranka_naslov = get_field('naslov', $stranka_id);
	$stranka_postna_stevilka = get_field('postna_stevilka', $stranka_id);
	$stranka_kraj = get_field('kraj', $stranka_id);

	$attachments = $email_data['pdf'];

	$body = '<h2>Spoštovani</h2>
	<p>v povezavi vam pošiljamo račun št. '.$faktura_title.', ki vsebuje vaša odprta naročila za dogovorjeno obdobje.</p>
	<p><a href="'.$faktura_link.'">Račun si lahko ogledate tukaj.</a></p>
	<p>Lep pozdrav, ekipa 3D MED</p>
	<hr>
	<h2>PODATKI ZA NAKAZILO:</h2>
	<p>Pošiljatelj:</p>
	'.$podjetje_ime.'<br />
	'.$podjetje_naslov.'<br />
	'.$podjetje_trr.'<br />

	<p>Prejemnik:</p>
	'.$stranka_ime.'<br />
	'.$stranka_naslov.'<br />
	'.$stranka_postna_stevilka.', '.$stranka_kraj.'<br />

	<p>Znesek za plačilo:'.$faktura_cena.'</p>
	<p>Namen: plačilo predračuna</p>';

	$stranka_email = get_field('e-naslov_podjetja', $user_id);

	email__send($stranka_email, $subject, $body, $attachments);

}

function email__send($to, $subject, $body, $attachments = ''){

	$headers[] = 'Content-Type: text/html; charset=UTF-8';

	if (wp_mail($to, $subject, $body, $headers, $attachments)) {
		error_log("email has been successfully sent to user whose email is " . $to);
	} else {
		error_log("email failed to sent to user whose email is " . $to);
	}

}

?>