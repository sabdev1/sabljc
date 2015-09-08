<?php

class MVB_Presentation_Boxes_Tiles
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
            'title'           =>      __('Presentation Boxes with tiles', 'mvb'),
            'description'     =>      __('Add a presentation box', 'mvb'),
            'identifier'      =>      __CLASS__,
            'icon'            =>      'appbar.interface.list.png',
            'class'            =>      'fa fa-list-ul',
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

            'separator1' => array('type'     =>  'separator'),

            'presentation_box' => array(
                'type'      =>      'repeater',
                'button'    =>      __('Add box', 'mvb'),
                'label'     =>      __('Box', 'mvb'),
                'lbl_d'     =>      __('Box Title', 'mvb'),
                'fields'    =>      array(

                    'image' => array(
                        'type'      =>      'image',
                        'label'     =>      __('Image', 'mvb'),
                        'col_span'  =>      'lbl_half'
                    ),

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

                    'color' => array(
                        'type'      =>      'colorpicker',
                        'label'     =>      __('Background Color', 'mvb'),
                        'default'   =>      '61727b',
                        'col_span'  =>      'lbl_third',
                    ),
					
					'icon_color' => array(
                        'type'      =>      'colorpicker',
                        'label'     =>      __('Icon text color', 'mvb'),
                        'default'   =>      'DBDBDB',
                        'col_span'  =>      'lbl_third',
                    ),
					
					'icon_shadow_color' => array(
                        'type'      =>      'colorpicker',
                        'label'     =>      __('Icon shadow color', 'mvb'),
                        'default'   =>      'DBDBDB',
                        'col_span'  =>      'lbl_third',
                    ),
					
					'separator' => array('type'     =>  'separator'),

                    'icon' => array(
                        'type'      =>      'icon',
                        'label'     =>      __('Icon', 'mvb'),
                        'col_span'  =>      'lbl_third',
                    ),

                    'separator1' => array('type'     =>  'separator'),

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

                    'read_more' => array(
                        'type'      =>      'select',
                        'label'     =>      __('Display the "read more" link', 'mvb'),
                        'default'   =>      1,
                        'options'   =>      mvb_yes_no(),
                        'col_span'  =>      'lbl_half',
                    ),

                    'read_more_text' => array(
                        'type'      =>      'text',
                        'label'     =>      __('"Read more" link text', 'mvb'),
                        'default'   =>      __('Read more', 'mvb'),
                        'col_span'  =>      'lbl_half',
                    ),


                    'separator-effects' => array('type'     =>  'separator'),

                    'effects' => array(
                        'type'      =>      'select',
                        'label'     =>      __('Appear effects', 'mvb'),
                        'help'      =>      __('Select one of appear effects for block', 'mvb'),
                        'default'   =>      '0',
                        'options'   =>      crum_appear_effects(),
                        'col_span'  =>      'lbl_third'
                    ),

                    'css' => array(
                        'type'      =>      'text',
                        'label'     =>      __('Additional CSS classes', 'mvb'),
                        'help'      =>      __('Separated by space', 'mvb'),
                        'col_span'  =>      'lbl_third'
                    ),

                )//end repeater_fields
            ),

            'separator' => array('type'     =>  'separator'),

            'css' => array(
                'type'      =>      'text',
                'label'     =>      __('Additional CSS classes', 'mvb'),
                'help'      =>      __('Separated by space', 'mvb'),
	            'col_span'  =>      'lbl_third'
            ),
	        'css_styles' => array(
		        'type'      =>      'text',
		        'label'     =>      __('Additional CSS styles', 'mvb'),
		        'help'      =>      __('Separated by <b>;</b>', 'mvb'),
		        'col_span'  =>      'lbl_full'
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
        global $mvb_metro_factory;
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

        $no_of_panels = count($load['r_items']);

        if( $no_of_panels == 0 OR $no_of_panels > 12 )
        {
            return;
        }
		
		foreach ($load['r_items'] as $k=>$row) {
			# Alignment
			$load['r_items'][$k]['alignment'] = 1; // Align left
			
			if (empty($load['r_items'][$k]['read_more_text'])) {
				$load['r_items'][$k]['read_more_text'] = __('Read more', 'dfd');
			}
		}
		
		$load['few_rows'] = 0;
		$load['module_class'] = '';
		$load['box_hover_with_class'] = 'feature-box-wrap-tiles';
		
		$load['icon_over_title'] = true;
		$load['icon_class'] = '';
		
		$load['column_number'] = mvb_num_to_string(12/$no_of_panels);
		$load['sizes'] = mvb_foundation_columns(ceil($mvb_metro_factory->no_of_columns/$no_of_panels));
		
        return $mvb_metro_factory->_load_view('html/public/mvb_presentation_boxes.php', $load);
    }//end render();
}//end class