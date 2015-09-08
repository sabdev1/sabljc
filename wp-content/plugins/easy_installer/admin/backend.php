<?php
/**
 *  Name - Installer Panel
 *  Dependency - Core Admin Class
 *  Version - 1.0
 *  Code Name - Nobody
 */

class IOAEasyFrontInstaller extends PLUGIN_IOA_PANEL_CORE {
	
	
	// init menu
	function __construct () { 

		add_action('admin_menu',array(&$this,'manager_admin_menu'));
        add_action('admin_init',array(&$this,'manager_admin_init'));
        
	 }
	
	// setup things before page loads , script loading etc ...
	function manager_admin_init(){	 }
	
	function manager_admin_menu(){
		add_theme_page('Installer Panel', 'Installer Panel', 'edit_theme_options', 'easint' ,array($this,'manager_admin_wrap'));
	}

	
	/**
	 * Main Body for the Panel
	 */

	function panelmarkup(){	
	   global $easy_metadata, $config_suboption;
		
		$layouts = array(
			'first' => __('Corporate Light', 'dfd_import'),
			'first_dark' => __('Corporate Dark', 'dfd_import'),
			'second' => __('Portfolio presentation', 'dfd_import'),
			'third' => __('Web design agency', 'dfd_import'),
			'fourth' => __('Content parallax light', 'dfd_import'),
			'fourth_dark' => __('Content parallax dark', 'dfd_import'),
			'fifth' => __('Presentation layout', 'dfd_import'),
			'sixth' => __('Creative studio', 'dfd_import'),
			'seventh' => __('Portfolio parallax', 'dfd_import'),
			'eighth' => __('Scrolling content layout', 'dfd_import'),
			'ninth' => __('Side menu page', 'dfd_import'),
			'tenth' => __('Freelancer boxed style', 'dfd_import'),
			'eleventh' => __('One page agency', 'dfd_import'),
			'twelfth' => __('Magazine layout', 'dfd_import'),
			'thirteenth' => __('Freelancer one page scroll', 'dfd_import'),
			'fourteenth' => __('Creative agency', 'dfd_import'),
			'fifteenth' => __('Double parallax', 'dfd_import'),
			'shop_main' => __('Shop interior', 'dfd_import'),
			'shop_second' => __('Shop boxed style', 'dfd_import'),
			'shop_third' => __('Shop bright', 'dfd_import'),
			'shop_fourth' => __('One page scroll shop', 'dfd_import'),
			'shop_fifth' => __('Shop parallax', 'dfd_import'),
			'shop_sixth' => __('Only thumbs shop', 'dfd_import'),
		);
		
		$prefix = __('Install layout ', 'dfd_import');
		
		if( (isset($_GET['page']) && $_GET['page'] == 'easint') && isset($_GET['demo_install'])  ) :
			easy_import_start();
			EASYFInstallerHelper::beginInstall();
		endif; 
		if( (isset($_GET['page']) && $_GET['page'] == 'easint') ) :
			if(isset($_GET['demo_layout_select'])) {
				$dummy_file = $_GET['demo_layout_select'];
				if(array_key_exists($dummy_file, $layouts)) {
					$config_suboption = '_'.$dummy_file;
					easy_import_start();
					EASYFInstallerHelper::beginInstall();
				}
			}
		endif;
		
		?>
		
		<?php if(isset($_GET['demo_install'])): easy_success_notification(); endif; ?>

		<div class="demo-installer clearfix">
			<h2><?php echo $easy_metadata['data']->panel_title; ?></h2>

			<p><?php echo $easy_metadata['data']->panel_text; ?></p>

			<a href="<?php echo admin_url() ?>themes.php?page=easint&amp;demo_install=true" class="button-install"><?php _e("Install Main demo content") ?></a>
			<?php /*
			<div class="install-layouts-section">
				<?php foreach($layouts as $value => $name) : ?>
					<a href="<?php echo admin_url() ?>themes.php?page=easint&amp;demo_layout_select=<?php echo $value; ?>" class="button-layout-install">
						<img src="<?php echo EASY_F_PLUGIN_URL . 'demo_data_here/thumbs/'.$value.'.jpg'; ?>" />
						<div class="button-title"><?php echo $prefix.$name; ?></div>
					</a>
				<?php endforeach; ?>
			</div>
			*/ ?>
		</div>

		<?php
	    
	}
}

new IOAEasyFrontInstaller();