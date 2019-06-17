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

function add_scripts() {
	wp_register_script( 'scripts.js', plugin_dir_url( __FILE__ ) . 'adds/js/scripts.js', array('jquery'), '1.1', true );
	wp_register_script( 'awesome-icons.js', plugin_dir_url( __FILE__ ) . 'adds/js/awesome-icons.js', array('jquery'), '1.1', true );

	if(is_user_logged_in() && (is_single() || is_home() || is_admin())){
		wp_enqueue_script( 'scripts.js' );	
		wp_enqueue_script( 'awesome-icons.js' );
		wp_enqueue_style( 'add-bookmark', plugin_dir_url( __FILE__ ) . 'adds/css/add-bookmark.css' );
		wp_localize_script( 'scripts.js', 'frontendajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	}
	
}

add_action( 'wp_enqueue_scripts', 'add_scripts');
add_action( 'admin_enqueue_scripts', 'add_scripts');

/* This function adds tag <i> to the end of posts title*/
function filter_function_name_11( $title, $id ) {
	if( is_user_logged_in() && (is_single() || is_home())){
		$added = TestMm2::is_bookmark($id) ? 'added' : '';
		$title = $title . '<i class="fa fa-bookmark add-bookmark ' . $added . '" data-post-id="' . $id . '" aria-hidden="true"></i>';
	}
	return $title;
}

add_filter( 'the_title', 'filter_function_name_11', 10, 2 );

/*This function adds bookmark and and handling ajax request*/
function add_to_bookmark_callback() {
	$post_to_add = $_POST['post-id'];
	$testmm = new TestMm2();
	$result = $testmm->add_bookmark($post_to_add);
	echo json_encode($result);
	
	wp_die(); // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
}

add_action('wp_ajax_add_to_bookmark' , 'add_to_bookmark_callback');

/*This function adds bookmark and and handling ajax request*/
function remove_bookmark_callback() {

	$post_id = $_POST['post-id'];
	$testmm = new TestMm2();
	$result = $testmm->remove_bookmark($post_id);
	echo json_encode(array('status' => 1));
	
	wp_die(); // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
}

add_action('wp_ajax_remove_bookmark' , 'remove_bookmark_callback');