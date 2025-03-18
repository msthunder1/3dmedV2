<?php

if ( function_exists('register_sidebar') ){

	register_sidebar(array(
		'id' => 'footer_widget_1',
		'name' => 'Footer widget 1',
		'before_widget' => '<div class = "widget__1">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'id' => 'footer_widget_2',
		'name' => 'Footer widget 2',
		'before_widget' => '<div class = "widget__2">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'id' => 'footer_widget_3',
		'name' => 'Footer widget 3',
		'before_widget' => '<div class = "widget__3">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'id' => 'footer_widget_4',
		'name' => 'Footer widget 4',
		'before_widget' => '<div class = "widget__4">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

}

?>