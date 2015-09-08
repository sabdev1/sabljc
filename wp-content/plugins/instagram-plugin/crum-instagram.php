<?php
/*
Plugin Name: Crum Instagram Widget
Description: Promote your Instagram photo through your Wordpress website using Instagram Widget.
Version: 1
Author: DFD (inspired by Rolly G. Bueno Jr.)
Author URI: http://dfd.name
License: GPL v2.0.1
Copyright: Crumina 2012 Rolly G. Bueno Jr.
*/

add_action('init', 'crInstFollowerCookie');
DEFINE( "crum_simple_instagram_plugin_path", plugin_dir_path(__FILE__)  );
DEFINE('crum_simple_instagram_plugin_url', get_bloginfo('wpurl') . '/wp-content/plugins/crum-instagram/');
require crum_simple_instagram_plugin_path . 'crum-instagram-functions.php';
require crum_simple_instagram_plugin_path . 'crum-instagram-widget.php';

/**
 * Plugin installation
*/

function crum_simple_instagram_activate()
{

    add_option( 'si_access_token' );
    add_option( 'si_user_id' );

}

/**
 * Uninstall, drop table
*/

function crum_simple_instagram_deactivate()
{

	delete_option( 'si_access_token' );
	delete_option( 'si_user_id' );

}
/**
 * hook registration
*/
register_activation_hook(__FILE__,'crum_simple_instagram_activate');
register_deactivation_hook( __FILE__, 'crum_simple_instagram_deactivate' );

function crInstFollowerCookie()
{
		if( isset( $_GET['access_token'] ) ):
				setcookie( 'visitor_access_token', $_GET['access_token'], strtotime( " + 14 days" ) );
		endif; 
}


/**
 * admin menu
*/
function register_custom_menu_page() 
{
	$page = add_options_page(' Instagram', ' Instagram', 'manage_options', 'crum-instagram', 'option_page_crum_simple_instagram' );

	add_action( 'admin_head-' . $page, 'crum_simple_instagram_admin_head' );
}

add_action( 'admin_menu', 'register_custom_menu_page' );

/**
 * Add stylesheet to  Instagram
 * option page
*/
function crum_simple_instagram_admin_head() {
    $siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/css/crum-instagram-admin.css';
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
    
    	?>
	<?php
    
}


function option_page_crum_simple_instagram()
{

	if( isset( $_POST['sIntClearCache'] ) ):
		sIntClearCache();
		echo '<div id="message" class="updated fade"><p>Cache folder has been cleanup!</p></div>';
	endif;	
	
	//check jpeg compression value
	if( isset( $_POST['JPEGCompression'] ) ):
		if( $_POST['JPEGCompression'] > 100 || $_POST['JPEGCompression'] < 10 ):
			update_option( 'JPEGCompression', '80' );
		else:
			update_option( 'JPEGCompression', $_POST['JPEGCompression'] );
		endif;
		
	endif;
	
	global $wpdb;
			
	/**
	 * Save info to database
	 * v1.2.5 uses wp options	 
	*/
	if( isset( $_GET['access_token'] ) && isset( $_GET['id'] ) ):
		update_option( 'si_access_token', $_GET['access_token'] );
		update_option( 'si_user_id', $_GET['id'] );
	endif;
	
	/*
	 * Info query to check if database
	 * has record.
	*/

	$info = array( 'si_access_token' => get_option( 'si_access_token' ), 'si_user_id' => get_option( 'si_user_id' ) );
	
	if( isset( $_POST['sIntLogout'] ) == "log_out" ):


		delete_option( 'si_access_token' );
		delete_option( 'si_user_id' );
		
		?> <meta http-equiv="refresh" content="0;url=<?php echo get_admin_url() . 'options-general.php?page=crum-instagram'; ?>"> <?Php
	endif;
	
	
	?>
	<div class="wrap">
	<div id="icon-plugins" class="icon32"></div><h2> Instagram</h2>	
	<?php if( !$info['si_access_token'] && !$info['si_user_id'] ): ?> 
		<?php if( $_GET['access_token'] == "" && $_GET['id'] == "" ): ?>
			<div class="error">
			 <p>You did not authorize  Instagram. This plugin will not work without your authorization. </p>
			</div>
		<?php endif; ?>
	<a href=" <?php echo crInstLogin( '?return_uri=' . base64_encode( get_admin_url() . 'options-general.php?page=crum-instagram'  )  ) ?> "><img src="<?php echo plugin_dir_url(__FILE__) . 'images/instagram-login.jpg'; ?>" title="Login to Instagram and authorize  Instagram plugin" alt="Login to Instagram and authorize  Instagram plugin" /></a>
	<?php ?>
	<?php else: ?>
	<?php 
		if( isset( $_GET['access_token'] ) && $_GET['id'] ):
		?> <meta http-equiv="refresh" content="0;url=<?php echo get_admin_url() . 'options-general.php?page=crum-instagram'; ?>"> <?Php
		endif;
	?>
	
	<iframe src="https://instagram.com/accounts/logout/" width="0" height="0">Logout</iframe>
	<?php
		$user = crInstGetInfo( user_id(), access_token() );
	?>
	<div id="sInts-welcome">Welcome <?php echo $user['data']['full_name']; ?>. You can start using Instagram widget. You can find it in Apperance -> Widgets</div>

	<form name="itw_logout" method="post" action="<?php echo str_replace( '%7E', '~', htmlentities( get_admin_url() . 'options-general.php?page=crum-instagram'  )  ); ?>">
	<input type="hidden" name="sIntLogout" value="log_out">
	<input type="submit" class="button" value="Log out" name="logout" onclick="" >
	</form>

	<!-- END CSS -->
	</div>

    <?php endif; ?>

	<?php
}

function crInstAdminNotice()
{
	global $wpdb;
	
	/*
	 * Info query to check if database
	 * has record.
	*/
	$info = array( 'si_access_token' => get_option( 'si_access_token' ), 'si_user_id' => get_option( 'si_user_id' ) );
	
	if( !$info['si_access_token'] && !$info['si_user_id'] ):
	
	echo '<div class="error">';
        echo '<p> Instagram has not been setup correctly. Kindly <a href="options-general.php?page=crum-instagram">authorize</a>  Instagram. </p>';
    	echo '</div>';
    	
    	endif;
}

add_action('admin_notices', 'crInstAdminNotice');
