<?php 
/* 
Template Name: Template - content
*/

$header = userRoleBasedHeader();

get_header($header);

?>

<div class="default__wrapper">
	<div class="default__container">
		<div class="container--mid">

		<?php
		if ( have_posts() ){
			while ( have_posts() ) {
				the_post(); ?>

				<h1><?php the_title();?></h1>
				<?php the_content(); ?>

			<?php }
		}
		?>

		</div>
	</div>
</div>

<?php

get_footer(); 

?>