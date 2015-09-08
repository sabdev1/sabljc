<?php

class MVB_Charts
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
            'title'           =>      __('Pie chart module', 'mvb'),
            'description'     =>      __('Add Charts', 'mvb'),
            'identifier'      =>      __CLASS__,
            'icon'            =>      'appbar.paper.png',
			'class'            =>      'fa fa-file-text-o',
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
            ),

            'presentation_box' => array(
                'type'      =>      'repeater',
                'button'    =>      __('Add Pie Chart', 'mvb'),
                'label'     =>      __('Pie Chart', 'mvb'),
                'lbl_d'     =>      __('Pie Chart', 'mvb'),
                'fields'    =>      array(

                    'main_title' => array(
                        'type'      =>      'text',
                        's_title'   =>      TRUE,
                        'label'     =>      __('Title', 'mvb'),
                        'col_span'  =>      'lbl_half'
                    ),
                    'sub_title' => array(
                        'type'      =>      'text',
                        'label'     =>      __('Subtitle', 'mvb'),
                        'col_span'  =>      'lbl_half'
                    ),
					
					'separator' => array('type'     =>  'separator'),
                    
					'icon' => array(
                        'type'      =>      'icon',
                        'label'     =>      __('Icon', 'mvb'),
                        'col_span'  =>      'lbl_third',
                    ),
					
					'icon_color' => array(
                        'type'      =>      'colorpicker',
                        'label'     =>      __('Icon text color', 'mvb'),
                        'default'   =>      'c0c0c0',
                        'col_span'  =>      'lbl_third',
                    ),
					
					'separator2' => array('type'     =>  'separator'),
					
                    'item_size' => array(
                        'type'      =>      'select',
                        'label'     =>      __('Select size', 'mvb'),
                        'options'   =>      crum_get_chart_size(),
                        'col_span'  =>      'lbl_third',
                    ),
                    'percent' => array(
                        'type'      =>      'text',
                        'label'     =>      __('Percent', 'mvb'),
                        'col_span'  =>      'lbl_third'
                    ),

                    'separator' => array('type'     =>  'separator'),

                    'chart_main' => array(
                        'type'      =>      'colorpicker',
                        'label'     =>      __('Chart main color', 'mvb'),
                        'default'    =>     '36bae2',
                        'col_span'  =>      'lbl_half',
                    ),
                    'chart_bg' => array(
                        'type'      =>      'colorpicker',
                        'label'     =>      __('Chart secondary color', 'mvb'),
                        'default'    =>     '8397a0',
                        'col_span'  =>      'lbl_half',
                    ),

                    'separator2' => array('type'     =>  'separator'),

                    'link_url' => array(
                        'type'      =>      'text',
                        'label'     =>      __('Link (URL)', 'mvb'),
                        'col_span'  =>      'lbl_half'
                    ),

                    'page_id' => array(
                        'type'      =>      'mvb_dropdown',
                        'label'     =>      __('Link to page', 'mvb'),
                        'what'      =>      'pages',
                        'default'   =>      0,
                        'col_span'  =>      'lbl_half',
                    ),


                    'content' => array(
                        'type'      =>      'textarea',
                        'label'     =>      __('Content', 'mvb'),
                    ),


                    'separator-effects' => array('type'     =>  'separator'),

                    'effects' => array(
                        'type'      =>      'select',
                        'label'     =>      __('Appear effects', 'mvb'),
                        'help'      =>      __('Select one of appear effects for block', 'mvb'),
                        'default'   =>      '0',
                        'options'   =>      crum_appear_effects(),
                        'col_span'  =>      'lbl_half'
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




                )//end repeater_fields
            ),

            'separator' => array('type'     =>  'separator'),


            'unique_id' => array(
                'type'      =>      'text',
                'default'   =>      uniqid('mvbtab_'),
                'label'     =>      __('Unique ID', 'mvb'),
                'help'      =>      __('Must be unique for every module on the page.', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),

            'css' => array(
                'type'      =>      'text',
                'label'     =>      __('Additional CSS classes', 'mvb'),
                'help'      =>      __('Separated by space', 'mvb'),
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
            if ( $key != 'content' ) {
                $tmp[$key] = (isset($atts[$key])) ? $atts[$key] : '';
			}
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

        $_sh_js = array(
            'js' => array(
                'charts-js' => get_template_directory_uri() . '/assets/js/chart.min.js'
            )
        );
        $mvb_metro_factory->queue_scripts($_sh_js, __CLASS__);

        $load['r_items'] = $mvb_metro_factory->do_repeater_shortcode($content);
        $load['num_panels'] = count($load['r_items']);

        $no_of_panels = count($load['r_items']);
        if( $no_of_panels == 0 OR $no_of_panels > 12 )
        {
            return;
        }

        $load['column_number'] = mvb_num_to_string(12/$no_of_panels);
        $load['sizes'] = mvb_foundation_columns(ceil($mvb_metro_factory->no_of_columns/$no_of_panels));


        return $mvb_metro_factory->_load_view('html/public/mvb_charts.php', $load);
    }//end render();
}//end class