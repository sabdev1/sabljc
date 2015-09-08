<?php

class MVB_Gallery
{
    /**
	 * The modules settings
	 *
	 * @access public
	 * @param none
	 * @return array settings
	 */

    public static function settings()
    {
        return array(
            'title'           =>      __('Image gallery module', 'mvb'),
            'description'     =>      __('Add an image gallery', 'mvb'),
            'identifier'      =>      __CLASS__,
            'icon'            =>      'appbar.image.multiple.png',
			'class'            =>      'fa fa-picture-o',
            'section'         =>      'presentation',
            'color'           =>      'gray'
        );
    }//end settings()

    /**
	 * The shortcodes attributes with the field options
	 *
	 * @access private
	 * @param array $atts
	 * @return shortcode output
	 */

    public static function fields()
    {
        global $mvb_metro_factory;

        $the_fields = array(
            'main_title' => array(
                'type'      =>      'text',
                'label'     =>      __('Title', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),

            'gallery_photo' => array(
                'type'      =>      'repeater',
                'button'    =>      __('Add photo', 'mvb'),
                'label'     =>      __('Photo', 'mvb'),
                'lbl_d'     =>      __('Photo Title', 'mvb'),
                'fields'    =>      array(
                    'image' => array(
                        'type'      =>      'image',
                        'label'     =>      __('Image', 'mvb'),
                        'col_span'  =>      'lbl_half'
                    ),

                    'main_title' => array(
                        'type'      =>      'text',
                        's_title'   =>      TRUE,
                        'label'     =>      __('Photo Title', 'mvb'),
                        'col_span'  =>      'lbl_half'
                    ),

                    'gall_tags' => array(
                        'type'      =>      'text',
                        'label'     =>      __('Picture tags', 'mvb'),
                        'col_span'  =>      'lbl_half',
                        'help'      =>      __('Separate tags with commas', 'mvb'),
                    )
                )//end repeater_fields
            ),

            'no_of_columns_photos' => array(
                'type'      =>      'select',
                'label'     =>      __('Number of columns', 'mvb'),
                'default'   =>      3,
                'options'   =>      array(2 => 2, 3 => 3, 4 => 4, 6 => 6),
                'col_span'  =>      'lbl_third',
            ),

            'isotope_filtering' => array(
                'type'      =>      'select',
                'label'     =>      __('Isotope filtering', 'mvb'),
                'default'   =>      0,
                'options'   =>      mvb_yes_no(),
                'col_span'  =>      'lbl_third',
            ),

            'image_format' => array(
                'type'      =>      'select',
                'label'     =>      __('Image format', 'mvb'),
                'default'   =>      'auto',
                'options'   =>      mvb_get_image_sizes(),
                'col_span'  =>      'lbl_third',
            ),

            'css' => array(
                'type'      =>      'text',
                'label'     =>      __('Additional CSS classes', 'mvb'),
                'help'      =>      __('Separated by space', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),
	        'css_styles' => array(
		        'type'      =>      'text',
		        'label'     =>      __('Additional CSS styles', 'mvb'),
		        'help'      =>      __('Separated by <b>;</b>', 'mvb'),
		        'col_span'  =>      'lbl_full'
	        ),

            'unique_id' => array(
                'type'      =>      'text',
                'default'   =>      uniqid('mvbacc_'),
                'label'     =>      __('Unique ID', 'mvb'),
                'help'      =>      __('Must be unique for every module on the page.', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),
        );
		
		$the_fields = apply_filters('mvb_fields_filter', $the_fields);

        return $the_fields;
    }//end fields();


    /**
	 * The private code for the shortcode. used in the custom editor
	 *
	 * @access public
	 * @param array $atts
	 * @return shortcode output
	 */

    public static function admin_render( $atts = array(), $content = '' )
    {
        global $mvb_metro_factory;
        global $mvb_metro_form_builder;
        $form_fields = self::fields();

        $load = shortcode_atts( $mvb_metro_factory->defaults($form_fields), $atts );
        $load['content'] = $content;

        if( $mvb_metro_factory->show_pill_sc OR $mvb_metro_factory->show_pill_sc_column )
        {
            if( method_exists(__CLASS__, 'the_pill') )
            {
                return self::the_pill($load, self::settings());
            }
            else
            {
                return $mvb_metro_factory->the_pill($load, self::settings());
            }

        }
        else
        {
            $load['content'] = $mvb_metro_factory->do_repeater_shortcode($content);

            $load['form_fields_html'] = $mvb_metro_form_builder->build_form($form_fields, $load);
            $load['settings'] = self::settings();
            $load['form_fields'] = $form_fields;
            $load['module_action'] = $mvb_metro_factory->module_action;

            return $mvb_metro_factory->_load_view('html/private/mvb_form.php', $load);
        }//endif

    }//end admin_render();

    /**
	 * The private code for the repeater shortcode. used in the custom editor
	 *
	 * @access public
	 * @param array $atts
	 * @return shortcode output
	 */

    public static function repeater_admin_render( $atts = array(), $content = '' )
    {
        global $__metro_core;

        if( !isset($atts['sh_keys']) OR trim($atts['sh_keys']) == '' )
            return;

        $keys = explode(",", $atts['sh_keys']);
        $tmp = array();

        foreach( $keys as $key )
        {
            if( $key != 'content' )
                $tmp[$key] = (isset($atts[$key])) ? $atts[$key] : '';
        }//endforeach;

        if( in_array('content', $keys) )
            $tmp['content'] = $content;

        $__metro_core->sh_tmp_repeater[] = $tmp;
    }//end repeater_admin_render();

    public static function repeater_render( $atts = array(), $content = '' )
    {
        global $mvb_metro_factory;
        self::repeater_admin_render($atts, $content);
    }//end repeater_render()

    /**
	 * The public code for the shortcode
	 *
	 * @access public
	 * @param array $atts
	 * @return shortcode output
	 */
    public static function render( $atts, $content = null )
    {
        global $mvb_metro_factory;

        $load = $atts;

        $load['r_items'] = $mvb_metro_factory->do_repeater_shortcode($content);

		$load['image_format'] = (isset($load['image_format'])) ? $load['image_format'] : '';
		$load['sizes'] = (isset($load['sizes'])) ? $load['sizes'] : '';

        $load['sizes'] = mvb_foundation_columns($mvb_metro_factory->no_of_columns);
        $load['image_height'] = mvb_image_formats($load['image_format'], $load['sizes']);

        $_nfc = floor(12/$load['no_of_columns_photos']);
        $load['_css_no_of_columns'] = mvb_num_to_string( $_nfc );

        $i = 0;
        $_tags_by_id = array();
        $_tags = array();

        if( isset($load['isotope_filtering']) && $load['isotope_filtering'] )
        {
             $_sh_js = array(
                'depends' => array('jquery'),
                'js' => array(
                    'mvb_isotope' => $mvb_metro_factory->app_url.'/assets/js/isotope/isotope.min.js'
                )
            );

            if( is_array($load['r_items']) AND !empty($load['r_items']) )
            {
                  foreach( $load['r_items'] as $item )
                  {
                        if( isset($item['gall_tags']) && trim($item['gall_tags']) != '' )
                        {
                             $m = array();
                             $tmp = explode(",", $item['gall_tags']);

                             foreach( $tmp as $t )
                             {
                                  $san = sanitize_title(trim($t));
                                  $m[] = $san;
                                  if( !array_key_exists($san, $_tags) )
                                  {
                                        $_tags[$san] = trim($t);
                                  }//endif;
                             }//endforeach;
                             $_tags_by_id[$i] = implode(" ", $m);
                             $i++;
                        }//endif;
                  }//endforeach;
             }//endif;

             $load['_tags'] = $_tags;
             $load['_tags_by_id'] = $_tags_by_id;

             if( !empty($_tags) )
             {
                $mvb_metro_factory->queue_scripts($_sh_js, __CLASS__);
             }//endif;
         }//endif;


        return $mvb_metro_factory->_load_view('html/public/mvb_gallery.php', $load);
    }//end render();
}//end class