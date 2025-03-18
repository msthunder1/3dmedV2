<?php 
/* 
Template Name: Template - backend
*/

hasAccess(array('administrator', '3dmed_admin', '3dmed_mini_admin'));

get_header('backend');

?>

<div class="backend">
	<div class="backend__wrapper">
		<div class="backend__container defaultContent">

			<?php
			if ( have_posts() ){
				while ( have_posts() ) : the_post(); ?>
					
					<div class="defaultContent__titleWrapper">
						<h1 class="defaultContent__title"><?php the_title(); ?></h1>
					</div>
					
					<div class="defaultContent__content">
						<?php the_content(); ?>
					</div>

				<?endwhile ?>
			<?php } ?>
			
		</div>
	</div>
</div>

<?php

get_footer(); 

?>