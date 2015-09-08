<?php
global $mvb_metro_factory;
require_once('gears/helpers/mvb_helper.php');

$_is_not_yet_installed = get_option('mvb_plugin_installed');
$theme_identifier = 'mvb-identity';
$__mvb_plugin_options = array();

if( $_is_not_yet_installed == $theme_identifier )
{
    mvb_initialize_options();
}
else
{
    require_once('gears/core/metro_options.php');
    Metro_Options::install();
    mvb_initialize_options();
}

/* start - load module sections */
global $mvb_module_sections_shortcodes;

$deco_module_settings_file = MVB_C_PATH.'/modules/module_sections.php';

if( file_exists($deco_module_settings_file) )
{
    require_once($deco_module_settings_file);
}
else
{
    require_once('html/module_sections.php');
}
/* end - load module sections */

if( !function_exists('aq_resize') )
{
    require_once('assets/libs/aq_resize/aq_resize.php');
}

require_once('gears/core/metro_core.php');
require_once('gears/core/metro_factory.php');
require_once('gears/core/metro_shortcodes.php');

$__metro_core = new Metro_Core();

$deco_metro_factory = MVB_C_PATH.'/gears/core/deco_metro_factory.php';
$deco_metro_shortcodes = MVB_C_PATH.'/gears/core/deco_metro_shortcodes.php';

if( file_exists($deco_metro_factory) )
{
    require_once($deco_metro_factory);
    $mvb_metro_factory = new Deco_Metro_Factory(new Metro_Factory($mvb_module_sections_shortcodes));

}
else
{
    $mvb_metro_factory = new Metro_Factory($mvb_module_sections_shortcodes);
}



if( is_admin() )
{
    //admin section
    require_once('assets/libs/phpQuery/phpQuery-onefile.php');
    require_once('gears/helpers/mvb_private_helper.php');
    require_once('gears/core/metro_form_builder.php');
    require_once('gears/core/metro_ajax.php');
    require_once('gears/core/metro_options.php');
    $deco_metro_form_builder = MVB_C_PATH.'/gears/core/deco_metro_form_builder.php';
    $deco_metro_ajax = MVB_C_PATH.'/gears/core/deco_metro_ajax.php';
    $deco_metro_options = MVB_C_PATH.'/gears/core/deco_metro_options.php';

    if( file_exists($deco_metro_ajax) )
    {
        require_once($deco_metro_ajax);
        new Deco_Metro_Ajax(new Metro_Ajax());

    }
    else
    {
        new Metro_Ajax();
    }//endif;

    if( file_exists($deco_metro_form_builder) )
    {
        require_once($deco_metro_form_builder);
        $mvb_metro_form_builder = new Deco_Metro_Form_Builder(new Metro_Form_Builder());

    }
    else
    {
        $mvb_metro_form_builder = new Metro_Form_Builder();
    }//endif;

    if( file_exists($deco_metro_options) )
    {
        require_once($deco_metro_options);
        new Deco_Metro_Options(new Metro_Options());

    }
    else
    {
        new Metro_Options();
    }//endif;

}
else
{
    //public
    require_once('gears/helpers/mvb_private_helper.php');

    $bs_is_the_main_loop = FALSE;

    function main_loop_test($query) {
      global $wp_the_query;
      global $bs_is_the_main_loop;

      if( is_singular('post') )
      {
            return TRUE;
      } 

      if ( $query === $wp_the_query )
      {
        $bs_is_the_main_loop = TRUE;
      }
      else
      {
        $bs_is_the_main_loop = FALSE;
      }//endif;
    }//end main_loop_test()

    add_action('loop_start', 'main_loop_test');
    add_filter('the_content', 'mvb_the_content');

    function mvb_the_content($content = false)
    {
        $mvb_activate = mvb_get_option('activate');

        if( $mvb_activate != 1 )
            return $content;

        if( is_single() OR is_page() OR is_404() )
        {
            global $bs_is_the_main_loop;
            global $post;

            $mvb_cpts = mvb_get_option('cpts');
            if( !in_array($post->post_type, $mvb_cpts) )
                return $content;

            $enable_composer = get_post_meta( $post->ID, '_bshaper_activate_metro_builder', true );

            if( (!$bs_is_the_main_loop AND !is_singular('post')) OR $enable_composer == '0' )
            {
                return $content;
            }//endif;

            $meta_value = get_post_meta( $post->ID, '_bshaper_artist_content', true );
            if( !empty($meta_value) )
            {
                global $mvb_metro_factory;

                $_html = '<div class="mvb_content">'.$mvb_metro_factory->parse_mvb_array($meta_value).'</div>';
	            if( $enable_composer == 2 )
                    return '<div class="row"><section id="main_content" class="twelve column" role="main">'.$content.'</section></div>'.$_html;
	            return $_html;
            }
            else
            {
                return $content;
            }
        }
        return $content;
    }//end mvb_the_content()

}//endif;

if( file_exists($deco_metro_shortcodes) )
{
    require_once($deco_metro_shortcodes);
    new Deco_Metro_Shortcodes(new Metro_Shortcodes());

}
else
{
    new Metro_Shortcodes();
}