<?php

hasAccess(array('administrator', '3dmed_admin', '3dmed_mini_admin', '3dmed_stranka'));

// As customers can view the Fakture too, we need to have a dynamic header
// If its a customer, show frontned header, else, show backend header
$header = userRoleBasedHeader();

get_header($header);

?>

<div class="backend">
	<div class="backend__wrapper">
		<div class="backend__container defaultContent">
			<?php singleFakture(); ?>
		</div>
	</div>
</div>

<?php

get_footer(); 

?>