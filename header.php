<!DOCTYPE html>

<html <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<?php include_once get_template_directory() . '/_common.php'; ?>

		<?php wp_head(); ?>
		
		<script type="text/javascript">
			var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		</script>
		
	</head>

	<body <?php body_class(); ?> >

		<div class="main__wrapper">

			<div class="header">
				<?php include_once get_template_directory() . '/header/header.php'; ?>
			</div>

			<?php include_once get_template_directory() . '/includes/loggedInAs.php'; ?>

			<div class="content__wrapper">