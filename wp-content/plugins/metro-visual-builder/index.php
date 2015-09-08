<?php
/*
Plugin Name: Metro Visual Builder
Plugin URI: 
Description: Content builder with drag and drop function
Version: 3.7.1
Author: bit.worker
Author URI: http://www.bitfabrika.com/
License:
*/

define( 'MVB_PATH', plugin_dir_path(__FILE__) );
define( 'MVB_URL', plugins_url().'/metro-visual-builder' );

/* the path to the custom modules */
define( 'MVB_C_PATH', get_stylesheet_directory().'/inc/mvb/' );

define( 'LD', 'mvb' );

load_plugin_textdomain( 'mvb', false, dirname( plugin_basename( __FILE__ ) ).'/languages/' );

if( is_admin() )
{
    register_activation_hook(__FILE__, 'mvb_plugin_activate');
    add_action('admin_init', 'mvb_plugin_redirect');
}//endif;

function mvb_plugin_activate() {
        add_option('mvb_do_activation_redirect', true);
    }//end mvb_plugin_activate()

function mvb_plugin_redirect() {
    if (get_option('mvb_do_activation_redirect', false)) {
        delete_option('mvb_do_activation_redirect');
        if(!isset($_GET['activate-multi']))
        {
            wp_redirect("options-general.php?page=mvb_options");
        }//endif;
    }//endif;
}//end mvb_plugin_redirect()

include 'app/dispatcher.php';