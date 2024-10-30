<?php
/*
Plugin Name: Insert Wandering QR 
Plugin URI: http://thewandering.net/
Description: Create a station on Wandering (http://thewandering.net) through your blog, and insert it's QR code and link at the end of a post.
Author: Dehed
Author URI: http://dehed.com
Version: 0.2
*/

check_qr_setup_warning();

add_action( 'admin_menu', 'your_menu' );
function your_menu(){
	add_meta_box( 
        'myplugin_sectionid',
        'Add a "Wandering" activity to a post',
        'myplugin_inner_custom_box',
        'post' 
    );	
}

function myplugin_inner_custom_box( $post ) {
	check_qr_setup_warning();
	wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );
	
	if (check_qr_setup_warning()) {	
		echo "You must configure Wandering Settings before using the plugin.";
	}
	else {
		include 'diy.php';
		echo '<input type="button" value="add wadering" alt="#TB_inline?width=700&height=800&inlineId=add_wadering" class="thickbox" />';	
	  	diy_form($post->ID);
	}
}

function get_stationsID($postID){
	global $wpdb;
	return $wpdb->get_results("SELECT `id` FROM stations WHERE developerLearning = ".$postID);
}

add_filter( 'the_content', 'filter_add_qrcode' );

function filter_add_qrcode($content){
	$allID = get_post_meta($GLOBALS['post']->ID, 'wandering_link');
	if(!isset($allID[0]))return $content;
	foreach($allID as $aid){
		if($aid!=''){
		//this code show qr link,image in post
		$content.='<br/><h2>Experience with "Wandering":</h2>';
		$content.= '<strong><a href="'.$aid.'">Direct Link</a></strong>';
		$content.='<br/><img src="http://chart.googleapis.com/chart?cht=qr&chs=150x150&chl='.htmlentities($aid).'&choe=UTF-8"/><br/><br/>';
		}
	}
	return $content;
}

add_action('admin_menu', 'register_qr_menu_page');

function register_qr_menu_page()
{	
	add_menu_page('Wandering QR Settings', 'Wandering QR', 'administrator', __FILE__, 'qr_settings_page');
}

function qr_settings_page(){
	
	if(isset($_POST['update_settings']))
	{
		$settings = array('qr_name', 'qr_email','qr_settings_updated');
		
		foreach($settings as $setting)
			$data[$setting] = $_POST[$setting];
			
		update_option('qr_settings', $data);
		$_GET['settings-updated'] = true;
	}
	
	check_qr_setup_warning();
	
	require_once(ABSPATH . '/wp-load.php');
	require_once( ABSPATH . WPINC . '/template-loader.php' );
	
	$current_user = wp_get_current_user();
	
	if(0 == $current_user->ID) return; //exit	
	
	$current_user->display_name;
	$current_user->user_email;	
	
	include_once("qr_settings.php"); 	
}

function check_qr_setup_warning(){
	global $qr_settings_updated;
	if ( !get_option('qr_settings')) {	
		add_action('admin_notices', 'qr_warning');
		return;
	}
}

function qr_warning() {
	echo "
	<div id='akismet-warning' class='updated fade'><p> ".sprintf(__('You must <a href="%1$s">configure Wandering Settings</a> before using the plugin.'), "admin.php?page=insert-wandering-qr/qrcode.php")."</p></div>
	";
}
