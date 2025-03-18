<?php 
/* 
Template Name: Template - frontend
*/

hasAccess();

get_header('frontend');

?>

<div class="frontend">
	<div class="frontend__wrapper">
		<div class="frontend__container defaultContent">

			<?php
			if ( have_posts() ){
				while ( have_posts() ) : the_post();
				the_content();
				endwhile ?>
			<?php } ?>
			
		</div>
	</div>
</div>

<?php

get_footer(); 

?>