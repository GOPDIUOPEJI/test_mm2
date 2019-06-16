<?php
/**
* Plugin Name: test_mm2 Plugin
* Plugin URI: https://www.yourwebsiteurl.com/
* Description: This is the very first plugin I ever created.
* Version: 1.0
* Author: Paul
* Author URI: http://yourwebsiteurl.com/
**/

include( plugin_dir_path( __FILE__ ) . 'class.TestMm2.php');

function add_menupage(){
	add_menu_page( 'TestMm2', 'TestMm2', 'edit_posts', 'test_mm2', 'interface_function', 'dashicons-admin-tools', 99 ); 
}

function interface_function() {
	$test_mm = new TestMm2();
	$test_mm->get_interface(get_plugin_data(__FILE__)['Name']);
}

add_action( 'admin_menu', 'add_menupage' );

add_filter( 'the_title', 'filter_function_name_11', 10, 2 );
function filter_function_name_11( $title, $id ) {
	if( is_single() || is_home() ){
		$title = $title . '<button class="add-bookmark">love it</button>';
	}

	return $title;
}