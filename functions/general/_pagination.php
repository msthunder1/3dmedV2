<?php

function displayPagination($the_query, $kupec, $currentPage){

	$args = array();

	if(isset($kupec['ime'])){
		$args['paginationStrankaIme'] = $kupec["ime"];
	}
	if(isset($kupec['id'])){
		$args['paginationStrankaId'] = $kupec["id"];
	}

	echo paginate_links(
		array(
			'base'         => str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ),
			'format'       => '?stran=%#%',
			'total'        => $the_query->max_num_pages,
			'current'      => $currentPage,
			'show_all'     => false,
			'type'         => 'plain',
			'end_size'     => 2,
			'mid_size'     => 1,
			'prev_next'    => true,
			'prev_text'    => sprintf( '<i></i> %1$s', __( '<', 'text-domain' ) ),
			'next_text'    => sprintf( '%1$s <i></i>', __( '>', 'text-domain' ) ),
			'add_args'     => $args,
			'add_fragment' => '',
		)
	);
}

?>