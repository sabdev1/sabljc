<?php
/*
Plugin Name: Google Fonts WordPress
Contributors: andrei_ivasiuc, 314media
Author: 314media
Author URI: http://www.314media.com/googlefontswordpress
Donate link: http://www.314media.com/googlefontswordpress
Tags: google fonts, google, fonts, plugin, admin, google font API, free fonts, easy font replacement, web safe fonts, web fonts, font replacement, fancy fonts, better fonts,
Requires at least: 3.5.1
Tested up to: 3.5.1
Version: 1.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Description: Google Fonts WordPress allows you to use Google Fonts on your WordPress website.  Preview and change styles with sliders LIVE.



*/

define( 'gfw_INCLUDES', 'includes/' );

include( gfw_INCLUDES . '/font_list.php' );

$new_fonts_file = dirname(__FILE__) . '/fonts.txt';

if( file_exists( $new_fonts_file ) ){
	$new_fonts = file( $new_fonts_file );
	$google_fonts = array_merge($google_fonts, $new_fonts);
	asort($google_fonts);
}

add_action('admin_init', 'gfw_init');

function gfw_init(){
	global $google_fonts;

	$gfw_fonts_url = 'http://fonts.googleapis.com/css?family=' . urlencode( join('|', $google_fonts) );
}

function gfw_print_scripts(){
	wp_enqueue_script( 'google.api', 'https://www.google.com/jsapi' );
	wp_enqueue_script( 'gfw', plugins_url('/'.gfw_INCLUDES.'/gfw.js', __FILE__), array('jquery') );
	
wp_enqueue_script('jquery-ui-slider', false, array('jquery'), false, false);
	/*wp_enqueue_script( 'jquery.slider', plugins_url('/'.gfw_INCLUDES.'/slider/js/slider.js', __FILE__), array('jquery') );	*/
	wp_enqueue_script( 'jquery.colorpicker', plugins_url('/'.gfw_INCLUDES.'/colorpicker/js/colorpicker.js', __FILE__), array('jquery') );
	
}

function gfw_print_styles(){
	wp_enqueue_style( 'gfw', plugins_url('/'.gfw_INCLUDES.'/gfw.css', __FILE__) );
	wp_enqueue_style( 'jquery.slider', plugins_url('/'.gfw_INCLUDES.'/slider/css/slider.css', __FILE__) );
	wp_enqueue_style( 'jquery.colorpicker', plugins_url('/'.gfw_INCLUDES.'/colorpicker/css/colorpicker.css', __FILE__) );
	
}

add_action('init', 'gfw_frontend');

function gfw_frontend(){
	
	load_plugin_textdomain( 'gfw', false, dirname( plugin_basename( __FILE__ ) ) . '/' . gfw_INCLUDES . 'languages/' );
	
	wp_enqueue_script( 'google.api', 'https://www.google.com/jsapi' );

	// Getting font family names
	
	$rules = unserialize( get_option('gfw-rules') );
	$families = array();
	
	if( !empty( $rules ) ){
		
		foreach( $rules as $rule ){
			$families[] = $rule['font_family'];
		}	

		$google_fonts_url = 'http://fonts.googleapis.com/css?family=' . join('|', $families) . '&subset=cyrillic,cyrillic-ext,latin,latin-ext';
	
		wp_enqueue_style( 'google.fonts', $google_fonts_url );
	}
}

add_action('wp_head', 'gfw_js_rules');

function gfw_js_rules(){
	
	$rules = unserialize( get_option('gfw-rules') );
	
	$html = '';
	
	if( !empty($rules) ){
	
		$html .= '<style type="text/css" media="screen">';
	
		foreach( $rules as $id => $rule ){

			$html .= "$rule[selector]{\n";
			$html .= "font-family: '$rule[font_family]' !important;\n";
			$html .= "font-weight: $rule[font_weight] !important;\n";
			$html .= "font-style: $rule[font_style] !important;\n";
			$html .= "font-size: $rule[font_size]px !important;\n";
			$html .= "color: #$rule[font_color] !important;\n";
			$html .= "line-height: $rule[font_line_height]em !important;\n";
			$html .= "word-spacing: $rule[font_word_spacing]em !important;\n";
			$html .= "letter-spacing: $rule[font_letter_spacing]em !important;\n";
			$html .= "}\n";
		}
		$html .= "</style>";
	
	}

	echo $html;
}

add_action('admin_menu', 'gfw_menu');

function gfw_menu(){
	$subpage['parent_slug'] = 'themes.php';
	$subpage['page_title'] = __("gfw", 'gfw');
	$subpage['menu_title'] = __('Fonts', 'gfw');
	$subpage['capability'] = 'manage_options';
	$subpage['menu_slug'] = 'gfw_page';
	$subpage['function'] = 'gfw_page';
	
	$page = add_submenu_page( $subpage['parent_slug'], $subpage['page_title'], $subpage['menu_title'], $subpage['capability'], $subpage['menu_slug'], $subpage['function']);
	
	add_action( "admin_print_scripts-$page", 'gfw_print_scripts' );
	add_action( "admin_print_styles-$page", 'gfw_print_styles' );
	
}

function gfw_page(){
	global $google_fonts, $rules, $rule;
	
	$rules = unserialize( get_option('gfw-rules') );
	
	include( gfw_INCLUDES . 'gfw_page.php' );
}

/**
 * gfw AJAX functionality
 *
 * @author Andrei Ivasiuc
 */

add_action('wp_ajax_gfw_add_rule', 'ajax_gfw_add_rule');

function ajax_gfw_add_rule() {
	global $rule, $google_fonts;
	
	$rule = array();
	
	$rule['id'] = 'fc-' . time();
	$rule['selector'] = __('Enter selector here', 'gfw');
	$rule['font_family'] = 'PT Sans';
	$rule['font_variant'] = 'r';
	$rule['font_size'] = '12';
	$rule['font_color'] = '000000';
	$rule['font_line_height'] = '1.4';
	$rule['font_word_spacing'] = '0';
	$rule['font_letter_spacing'] = '0';
	$rule['collapsed'] = false;

	
	include( gfw_INCLUDES . 'gfw_rule.php' );
	
	die();
}

add_action('wp_ajax_gfw_save_all', 'ajax_gfw_save_all');

function ajax_gfw_save_all() {
	
	$rules = $_POST['rules'];
	
	update_option( 'gfw-rules', serialize( $rules ) );

	die();
}


add_action('wp_ajax_gfw_delete', 'ajax_gfw_delete');

function ajax_gfw_delete() {
	
	$rules = unserialize( get_option('gfw-rules') );
	
	$rule = $_POST['rule'];

	unset($rules[$rule]);
	
	update_option( 'gfw-rules', serialize( $rules ) );

	die();
}


?>