<?php

// Support for Post thumbnails
add_theme_support( 'post-thumbnails' ); 

/*
** Update CSS within in Admin **
*/
function admin_style() {
	wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/css/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

/*
** WP Login styles **
*/
function my_custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri() . '/css/login.css" />';
}
add_action('login_head', 'my_custom_login');

/*
** Enqueue js **
*/
function mst_include_libs() {
	/* 
	** Libraries **
	*/
	// Jquery
	wp_enqueue_script( 'jQuery', get_stylesheet_directory_uri().'/js/libs/jquery-2.1.3.min.js', array(), null, false );
	// Datatables
	wp_enqueue_script( 'Datatables', get_stylesheet_directory_uri().'/js/libs/datatables.js', array(), null, false );
	wp_enqueue_script( 'Datatables responsive', get_stylesheet_directory_uri().'/js/libs/dataTables.responsive.js', array(), null, false );
	// Filesaver
	wp_enqueue_script( 'Filesaver', get_stylesheet_directory_uri().'/js/libs/filesaver/FileSaver.min.js', array(), null, false );
	// STL viewer
	wp_enqueue_script( 'STL viewer', get_stylesheet_directory_uri().'/js/libs/stl_viewer/stl_viewer.min.js', array(), null, false );
	// Uploader
	wp_enqueue_script( 'File uploader', get_stylesheet_directory_uri().'/js/libs/uploader/jquery.dm-uploader.min.js', array(), null, false );
	// HTML2PDF
	wp_enqueue_script( 'HTML2PDF', get_stylesheet_directory_uri().'/js/libs/html2pdf/html2pdf.bundle.min.js', array(), null, false );

	/*
	** Scripts **
	*/
	wp_enqueue_script( 'Main script', get_stylesheet_directory_uri().'/js/main_script.js', array(), null, false );
}
add_action( 'wp_enqueue_scripts', 'mst_include_libs' );

function mst_include_scripts() {
	/*
	** Scripts **
	*/
	wp_enqueue_script( 'Main script', get_stylesheet_directory_uri().'/js/main_script.js', array(), null, false );

	wp_localize_script( 'Main script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'mst_include_scripts' );
add_action( 'wp_ajax_nopriv_ajaxlogin','mst_include_scripts' );

/*
** Enqueue secondary CSS **
*/
function mst_include_style() {
	// Fonts
	// wp_enqueue_style( 'PTSans', get_stylesheet_directory_uri() . '/fonts/ptsans.css', array(), null, false );
	wp_enqueue_style( 'OpenSans', get_stylesheet_directory_uri() . '/fonts/opensans/opensans.css', array(), null, false );
	wp_enqueue_style( 'Fontawesome', get_stylesheet_directory_uri() . '/fonts/fontawesome/all.css', array(), null, false );
	// Datatables styles
	wp_enqueue_style( 'Datatables CSS', get_stylesheet_directory_uri() . '/css/datatables.css', array(), null, false );
	wp_enqueue_style( 'Datatables Buttons CSS', get_stylesheet_directory_uri() . '/css/buttons.dataTables.css', array(), null, false );
	wp_enqueue_style( 'Datatables Responsive CSS', get_stylesheet_directory_uri() . '/css/responsive.dataTables.css', array(), null, false );
	// Main style
	wp_enqueue_style( 'Main style', get_stylesheet_directory_uri() . '/css/main.css', array(), null, false );
	// Print
	wp_enqueue_style( 'Print style', get_stylesheet_directory_uri() . '/css/print.css', array(), null, false );
}
add_action( 'wp_enqueue_scripts', 'mst_include_style', 9998 );

/*
** Remove WP admin toolbar **
*/
add_filter('show_admin_bar', '__return_false');

/*
** Additional image sizes **
*/
add_image_size('largest', 1800, 9999);
add_image_size('laptop', 1480, 9999);
add_image_size('tablet', 1024, 9999);
add_image_size('small', 768, 9999);
add_image_size('smaller', 479, 9999);
add_image_size('tiny', 250, 9999);
add_image_size('tiniest', 75, 9999);

/*
** User Upload File **
*/
function upload_user_file( $file = array() ) {

    require_once( ABSPATH . 'wp-admin/includes/admin.php' );

	$file_return = wp_handle_upload( $file, array('test_form' => false ) );
	
	if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
		return false;
	} else {

		$filename = $file_return['file'];

		$attachment = array(
	    	'post_mime_type' => $file_return['type'],
	    	'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
	    	'post_content' => '',
	    	'post_status' => 'inherit',
	    	'guid' => $file_return['url']
		);

		$attachment_id = wp_insert_attachment( $attachment, $file_return['file'] );

		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
		wp_update_attachment_metadata( $attachment_id, $attachment_data );

		if( 0 < intval( $attachment_id ) ) {
	    	return $attachment_id;
		}
	}

	return false;
}

/*
** Rearrange the admin menu **
*/
function custom_menu_order($menu_ord) {
	if (!$menu_ord) return true;
	return array(
		'edit.php?post_type=sejanja',
		'edit.php?post_type=ceniki',
		'edit.php?post_type=statusi',
		'edit.php?post_type=materiali',
		'edit.php?post_type=stranke',
		'edit.php?post_type=narocila',
		'edit.php?post_type=emaili',
		'edit.php?post_type=fakture',
		'separator1', // First separator
		'index.php', // Dashboard
	);
}

add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order
add_filter('menu_order', 'custom_menu_order');

// Register Menus
function register_my_menu() {
	register_nav_menu('header-menu',__( 'Header Menu' ));
}
add_action( 'init', 'register_my_menu' );

/*
** 3dmed Shortcodes **
*/
add_shortcode( 'login', 'login_shortcode' );
add_shortcode( 'sejanje', 'sejanje_shortcode' );
add_shortcode( 'cenik', 'cenik_shortcode' );
add_shortcode( 'statusi', 'statusi_shortcode' );
add_shortcode( 'materiali', 'materiali_shortcode' );
add_shortcode( 'stranke', 'stranke_shortcode' );
add_shortcode( 'registracija', 'registracija_shortcode' );
add_shortcode( 'administratorji', 'administratorji_shortcode' );
add_shortcode( 'administrator', 'administrator_shortcode' );
add_shortcode( 'narocila', 'narocila_shortcode' );
add_shortcode( 'narocila_stranke', 'narocila_stranke_shortcode' );
add_shortcode( 'seznam_prejetih_narocil', 'seznam_prejetih_narocil_shortcode' );
add_shortcode( 'oddaj_narocilo', 'oddaj_narocilo_shortcode' );
add_shortcode( 'oddaj_narocilo_admin', 'oddaj_narocilo_admin_shortcode' );
add_shortcode( 'dodaj_sejanje', 'dodaj_sejanje_shortcode' );
add_shortcode( 'dodaj_material', 'dodaj_material_shortcode' );
add_shortcode( 'dodaj_administratorja', 'dodaj_administratorja_shortcode' );
add_shortcode( 'osebni_podatki', 'osebni_podatki_shortcode' );
add_shortcode( 'pregled_faktur', 'pregled_faktur_shortcode' );
add_shortcode( 'pregled_faktur_stranke', 'pregled_faktur_stranke_shortcode' );
add_shortcode( 'odprta_narocila', 'odprta_narocila_shortcode' );
add_shortcode( 'backend_welcome_screen', 'backend_welcome_screen_shortcode' );
add_shortcode( 'email_settings', 'email_settings_shortcode' );
add_shortcode( 'image_content_block', 'image_content_block_shortcode' );
add_shortcode( 'izvoz_faktur', 'izvoz_faktur_shortcode' );

/*
** Global options **
*/
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> '3Dmed General Settings',
		'menu_title'	=> '3Dmed General Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'redirect'		=> false
	));

	acf_add_options_page(array(
		'page_title' 	=> '3Dmed Email Settings',
		'menu_title'	=> '3Dmed Email Settings',
		'menu_slug' 	=> 'theme-email-settings',
		'redirect'		=> false
	));

	acf_add_options_page(array(
		'page_title' 	=> '3Dmed Invoice Settings',
		'menu_title'	=> '3Dmed Invoice Settings',
		'menu_slug' 	=> 'theme-invoice-settings',
		'redirect'		=> false
	));
}

/*
** Libraries **
*/
require_once('libs/main.php');

/*
** 3dmed General functions **
*/
require_once('functions/main.php');

?>