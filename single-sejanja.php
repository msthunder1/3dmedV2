<?php

hasAccess(array('administrator', '3dmed_admin', '3dmed_mini_admin'));

get_header('backend');

?>

<div class="backend">
	<div class="backend__wrapper">
		<div class="backend__container defaultContent">
			<?php singleSejanje(); ?>
		</div>
	</div>
</div>

<?php

get_footer(); 

?>