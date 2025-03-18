<?php 
/* 
Template Name: Template - STL
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
						<div id="stl_cont" style="width:500px;height:500px;margin:0 auto;"></div> 
						<?php the_content(); ?>
					</div>

				<?endwhile ?>
			<?php } ?>
			
		</div>
	</div>
</div>

<script>
    var stl_viewer=new StlViewer ( document.getElementById("stl_cont"), {
        models: [
            {filename:"/wp-content/themes/3dmed/2020-N-10723-1-DC.stl"}
        ]
    });
</script>

<?php

get_footer(); 

?>