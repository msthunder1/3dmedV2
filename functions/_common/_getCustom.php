<?php

function getCustom__latestSarzaOfMaterial($material){

	$sarza = 'Nobeno sejanje ni nastavljena.';

	$sejanja_query = get_posts(array(
		'numberposts'	=> 1,
		'post_type'		=> 'sejanja',
		'meta_key'		=> 'material',
		'meta_value'	=> $material,
		'orderby'		=> 'publish_date',
		'order' 		=> 'DESC',
	));
	if(!empty($sejanja_query)){
		$sejanje_id = $sejanja_query[0]->ID;
		$sarza = get_field('sarza', $sejanje_id);
	}

	return $sarza;
}

function getCustom__cenik($title){

	$ceniki_query = get_posts(array(
		'numberposts'	=> 1,
		'post_type'		=> 'ceniki',
		'title'			=> $title,
		'orderby'		=> 'publish_date',
		'order' 		=> 'ASC',
	));

	if(!$ceniki_query){
		return;
	}

	$cenik_id = $ceniki_query[0]->ID;

	$cena = get_field('cena', $cenik_id);

	return $cena;

}

function getCustom__createCenikSelect($title, $type, $counter, $value=''){

	$ceniki_query = get_posts(array(
		'numberposts'	=> 1,
		'post_type'		=> 'ceniki',
		'title'			=> $title,
		'orderby'		=> 'publish_date',
		'order' 		=> 'ASC',
	));

	if(!$ceniki_query){
		return;
	}

	$cenik_id = $ceniki_query[0]->ID;
	$cenik_cene_arr = get_field('spisek_cen', $cenik_id);

	foreach($cenik_cene_arr as $val){
		if($val['vrednost'] === ''){
			continue;
		}
		$cenik_cene[$val['vrednost']] = $val['naziv'];
	}

	$cenik_data = array(
		'label'    => 'modul_'.$counter.'_'.$type,
		'name'     => 'modul_'.$counter.'_'.$type,
		'type'     => 'select',
		'value'    => $value,
		'choices'  => $cenik_cene,
		'required' => 0
	);

	$r = getField__inputBasedOnType($cenik_data, $cenik_data['type']);

	return $r;

}

function getCustom__spisekCen($val){

	$field = get_field_object($val);

	$r = '<div class="spisekCen">';

	if($field){
		foreach($field['value'] as $subfield){
			if($subfield['naziv'] && $subfield['naziv'] !== '-- brez --'){
				$r .= '<div class="spisekCen__row">
						<div class="spisekCen__label">'.$subfield['naziv'].'</div>
						<div class="spisekCen__value">'.$subfield['vrednost'].'<span class="sign-eur">€</span></div>
					</div>';
			}
		}
	}

	$r .= '</div>';

	return $r;

}

function getCustom__cenikAbc($val){

	$seznam = array();

	$r = '<div class="cenikAbc">';

	if ( have_rows($val) ) {
		while( have_rows($val) ) {
			the_row();
			$seznam['a']['label'] = getField__Label('cenik_a', 'cenik_abc');
			$seznam['a']['value'] = getField__value('cenik_a', 'cenik_abc');
			$seznam['b']['label'] = getField__Label('cenik_b', 'cenik_abc');
			$seznam['b']['value'] = getField__value('cenik_b', 'cenik_abc');
			$seznam['c']['label'] = getField__Label('cenik_c', 'cenik_abc');
			$seznam['c']['value'] = getField__value('cenik_c', 'cenik_abc');
		}
	}

	if($seznam['a']['label'] && $seznam['a']['value']){
		$r .= '<div class="cenikAbc__cenik cenik_a">
				<div class="cenikAbc__cenikLabel">'.$seznam['a']['label'].'</div>
				<div class="cenikAbc__cenikValue">'.$seznam['a']['value'].'<span class="sign-eur">€</span></div>
			</div>';
	}

	if($seznam['b']['label'] && $seznam['b']['value']){
		$r .= '<div class="cenikAbc__cenik cenik_b">
				<div class="cenikAbc__cenikLabel">'.$seznam['b']['label'].'</div>
				<div class="cenikAbc__cenikValue">'.$seznam['b']['value'].'<span class="sign-eur">€</span></div>
			</div>';
	}

	if($seznam['c']['label'] && $seznam['c']['value']){
		$r .= '<div class="cenikAbc__cenik cenik_c">
				<div class="cenikAbc__cenikLabel">'.$seznam['c']['label'].'</div>
				<div class="cenikAbc__cenikValue">'.$seznam['c']['value'].'<span class="sign-eur">€</span></div>
			</div>';
	}

	$r .= '</div>';

	return $r;

}

function getCustom__user($type, $user_id){

	if(!$type){
		return "Ni podatka!";
	}

	if($type==='ime'){
		$user_meta = get_user_meta($user_id);
		$user_var = $user_meta["first_name"][0];

		$userData = array(
			'label'    => 'Ime',
			'name'     => 'ime',
			'type'     => 'text',
			'required' => 1,
			'value'    => $user_var
		);
	}
	if($type==='priimek'){
		$user_meta = get_user_meta($user_id);
		$user_var = $user_meta["last_name"][0];

		$userData = array(
			'label'    => 'Priimek',
			'name'     => 'priimek',
			'type'     => 'text',
			'required' => 1,
			'value'    => $user_var
		);
	}
	if($type==='email'){
		$user_info = get_userdata($user_id);
		$user_var = $user_info->data->user_email;

		$userData = array(
			'label'    => 'E-pošta',
			'name'     => 'email',
			'type'     => 'email',
			'required' => 1,
			'value'    => $user_var
		);
	}
	if($type==='roles'){
		$user_meta=get_userdata($user_id);
		$user_role=$user_meta->roles[0];

		global $wp_roles;
	    $wp_roles = new WP_Roles();

		foreach ($wp_roles->roles as $role_key => $role_details) {
			if ($role_key == $user_role) $user_var = $role_details['name'];
		}

	    $roles = array(
	    	'3dmed_admin'      => $wp_roles->roles['3dmed_admin']['name'],
	    	'3dmed_mini_admin' => $wp_roles->roles['3dmed_mini_admin']['name']
	    );

		$userData = array(
			'label'    => 'Vloge',
			'name'     => 'roles',
			'type'     => 'select',
			'required' => 1,
			'value'    => $user_var,
			'choices'  => $roles
		);
	}

	$r = getField__inputBasedOnType($userData, $userData['type']);

	return $r;
}

function getCustom__seznamCen(){

	$cenik1 = 'Člen 1-6';

	$ceniki_query = get_posts(array(
		'numberposts'	=> 1,
		'post_type'		=> 'ceniki',
		'title'			=> $cenik1,
		'orderby'		=> 'publish_date',
		'order' 		=> 'ASC',
	));

	$cenik1_id = $ceniki_query[0]->ID;

	$cene1 = get_field('cenik_abc', $cenik1_id);

	$cena1_a = $cene1['cenik_a'];
	$cena1_b = $cene1['cenik_b'];
	$cena1_c = $cene1['cenik_c'];

	$cenik2 = 'Člen 6-16';

	$ceniki_query = get_posts(array(
		'numberposts'	=> 1,
		'post_type'		=> 'ceniki',
		'title'			=> $cenik2,
		'orderby'		=> 'publish_date',
		'order' 		=> 'ASC',
	));

	$cenik2_id = $ceniki_query[0]->ID;

	$cene2 = get_field('cenik_abc', $cenik2_id);

	$cena2_a = $cene2['cenik_a'];
	$cena2_b = $cene2['cenik_b'];
	$cena2_c = $cene2['cenik_c'];

	$r = '<div class="seznam__cenik">';
		$r .= '<div class="seznam__title">'.$cenik1.'</div>';
		$r .= '<div class="seznam__row">';
			$r .= '<div class="seznam__column">';
				$r .= '<div class="seznam__label">Cena A</div>';
				$r .= '<div class="seznam__cena">'.$cena1_a.'<span class="sign-eur">€</span></div>';
			$r .= '</div>';
			$r .= '<div class="seznam__column">';
				$r .= '<div class="seznam__label">Cena B</div>';
				$r .= '<div class="seznam__cena">'.$cena1_b.'<span class="sign-eur">€</span></div>';
			$r .= '</div>';
			$r .= '<div class="seznam__column">';
				$r .= '<div class="seznam__label">Cena A</div>';
				$r .= '<div class="seznam__cena">'.$cena1_c.'<span class="sign-eur">€</span></div>';
			$r .= '</div>';
		$r .= '</div>';
	$r .= '</div>';
	$r .= '<div class="seznam__cenik secondary">';
		$r .= '<div class="seznam__title">'.$cenik2.'</div>';
		$r .= '<div class="seznam__row">';
			$r .= '<div class="seznam__column">';
				$r .= '<div class="seznam__label">Cena A</div>';
				$r .= '<div class="seznam__cena">'.$cena2_a.'<span class="sign-eur">€</span></div>';
			$r .= '</div>';
			$r .= '<div class="seznam__column">';
				$r .= '<div class="seznam__label">Cena B</div>';
				$r .= '<div class="seznam__cena">'.$cena2_b.'<span class="sign-eur">€</span></div>';
			$r .= '</div>';
			$r .= '<div class="seznam__column">';
				$r .= '<div class="seznam__label">Cena A</div>';
				$r .= '<div class="seznam__cena">'.$cena2_c.'<span class="sign-eur">€</span></div>';
			$r .= '</div>';
		$r .= '</div>';
	$r .= '</div>';

	return $r;

}

function getCustom__usernameFromId($user_id){

	if(!$user_id){
		return;
	}

	$user_meta = get_user_meta($user_id);
	$user_data = get_userdata($user_id);

	$user_ime = $user_meta['first_name'][0];
	$user_priimek = $user_meta['last_name'][0];
	$user_email = $user_data->data->user_email;
	$user_telefon = $user_meta['telefon'][0];

	$pripravil = $user_ime." ".$user_priimek;

	return $pripravil;

}

function getCustom__datoteke($id){

	$r = '<div class="fileList">';

	if ( have_rows( 'modul' ) ) {
		while( have_rows( 'modul' ) ) {
			the_row();

			$object = get_sub_field_object('datoteka');
			$object_id = $object['value'];

			if($object_id){
				$object_link = wp_get_attachment_url($object_id);
				$attachment_dir = get_attached_file($object_id);
				$object_size_bytes = file_exists($attachment_dir) ? filesize($attachment_dir) : 0;
				$object_size = formatBytes($object_size_bytes);
				$object_name = basename ($attachment_dir);

				$r .= '<div class="fileList__file">';
					$r .= '<a class="fileList__link js-image-view" href="#" data-object="'.$object_link.'" >';
						$r .= '<i class="fileList__icon fas fa-cube"></i>';
						$r .= '<span class="fileList__size">'.$object_size.'</span>';
					$r .= '</a>';
				$r .= '</div>';

			} else {
				$r = '<i class="fileList__nofile fas fa-ban"></i>';
			}
		}
	}

	return $r;

}

?>
