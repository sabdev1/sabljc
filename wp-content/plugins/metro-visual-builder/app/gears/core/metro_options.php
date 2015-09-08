<?php

class Metro_Options
{
    public $app_url;
    public $app_path;
    public $messenger;
    public $messenger_status;

    function __construct()
    {
        global $mvb_metro_factory;

        $this->app_url = MVB_URL.$this->app_url;
        $this->app_path = MVB_PATH.$this->app_path;

        add_action('admin_menu', array(&$this, 'theme_menu'));

        global $pagenow;
        if( $pagenow == 'options-general.php' )
        {
            add_action('admin_enqueue_scripts', array(&$this, 'load_assets'), 10, 1);
        }//endif;

    }//end __construct

    static function install()
    {
        $options = self::the_options();
        //var_dump($options);
        add_option('mvb_plugin_options', $options);
        add_option('mvb_plugin_installed', 'mvb-identity');
    }//end options()

    public static function the_options() {
        return array(
            'color_scheme' => 'none',
            'cpts' => array('page', 'post'),
            'activate' => 1,
            'show' => 1,
            'grid' => 'default',
        );
    }//end the_options();

    private function save_options() {
        $options = self::the_options();
        $new_options = array();

        foreach( $options as $name => $default )
        {
            $new_options[$name] = isset($_POST['mvb_'.$name]) ? $_POST['mvb_'.$name] : $default;
        }//endforeach()

        if( update_option('mvb_plugin_options', $new_options) )
        {
            $this->messenger = __('The options were saved!', 'mvb');
            $this->messenger_status = 'success';
        }
        else
        {
            $this->messenger = __('The options were NOT saved!', 'mvb');
            $this->messenger_status = 'error';
        }//endif;
    }//end save_options()

    public function theme_menu() {
    	//create new top-level menu
    	add_submenu_page('options-general.php', 'Metro Visual Builder', 'Metro Visual Builder', 'administrator', 'mvb_options', array(&$this, 'the_settings_page'), $this->app_url.'assets/images/factory-icon.png');
    }// end theme_menu();

    public function the_settings_page()
    {
        global $mvb_metro_factory;
        $load = array();

        if( isset($_POST['mvb_plugin_posted']) AND $_POST['mvb_plugin_posted'] == 'posted' )
        {
            $this->save_options();
            mvb_initialize_options();
        }

        if( $this->messenger_status != '' )
        {
            $load['messenger_status'] = $this->messenger_status;
            $load['messenger'] = $this->messenger;
            $this->messenger_status = '';
            $this->messenger = '';
        }

        $load['post_types'] = get_post_types(array('_builtin' => false),'objects');
        $mvb_post_types = array('page' => __('Pages', 'mvb'), 'post' => __('Posts', 'mvb'));

        foreach( $load['post_types'] as $post_type )
        {
            $mvb_post_types[$post_type->name] = $post_type->labels->name;
        }// endforeach;

        $load['mvb_yes_no'] = mvb_yes_no();
        $load['mvb_grids'] = array('default' => __('Default Grid', 'mvb'), 'custom' => __('Custom', 'mvb'), 'foundation.v3' => __('Foundation v3', 'mvb'), 'foundation.v4' => __('Foundation v4', 'mvb'), 'bootstrap' => __('Bootstrap', 'mvb'));
        $load['mvb_post_types'] = $mvb_post_types;
        $load['mvb_skins'] = array('none' => __('None', 'mvb'), 'red' => __('MVB Red', 'mvb'), 'green' => __('MVB Green', 'mvb'), 'blue' => __('MVB Blue', 'mvb'));

        $load['mvb_o_activate'] = mvb_get_option('activate');
        $load['mvb_o_show'] = mvb_get_option('show');
        $load['mvb_o_color_scheme'] = mvb_get_option('color_scheme');
        $load['mvb_o_cpts'] = mvb_get_option('cpts');
        $load['mvb_o_grid'] = mvb_get_option('grid');

        echo $mvb_metro_factory->_load_view('html/options/page.php', $load);
    } //end the_settings_page

    function load_assets()
    {
        wp_register_style(
                'mvb_style',
                $this->app_url.'/app/assets/css/mvb_style.css'
            );

        wp_enqueue_style('mvb_style');
    }    //end load_assets()


}//end class