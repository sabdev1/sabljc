<?php

class MVB_Call_To_Action
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
            'title'           =>      __('Call to Action', 'mvb'),
            'description'     =>      __('Add call to action module', 'mvb'),
            'identifier'      =>      __CLASS__,
            'icon'            =>      'appbar.transit.depart.png',
			'class'            =>      'fa fa-truck',
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
            'button_text' => array(
                'type'      =>      'text',
                'label'     =>      __('Button text', 'mvb'),
                'col_span'  =>      'lbl_third'
            ),
            'icon' => array(
                'type'      =>      'icon',
                'label'     =>      __('Icon', 'mvb'),
                'col_span'  =>      'lbl_third',
            ),

            'new_tab' => array(
                'type'      =>      'select',
                'label'     =>      __('Opens in new tab', 'mvb'),
                'default'   =>      0,
                'options'   =>      mvb_yes_no(),
                'col_span'  =>      'lbl_third',
            ),

            'separator' => array('type'     =>  'separator'),

            'link_url' => array(
                'type'      =>      'text',
                'label'     =>      __('Link (URL)', 'mvb'),
                'col_span'  =>      'lbl_half',
            ),

            'page_id' => array(
                'type'      =>      'mvb_dropdown',
                'label'     =>      __('Link to page', 'mvb'),
                'what'      =>      'pages',
                'default'   =>      0,
                'col_span'  =>      'lbl_half',
            ),


            'separator2' => array('type'     =>  'separator'),

            'content' => array(
                'type'      =>      'textarea',
                'editor'    =>      false,
                'label'     =>      __('Content', 'mvb'),
            ),
            'description' => array(
                'type'      =>      'textarea',
                'editor'    =>      false,
                'label'     =>      __('Description', 'mvb'),
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
            $load['form_fields_html'] = $mvb_metro_form_builder->build_form($form_fields, $load);
            $load['settings'] = self::settings();
            $load['form_fields'] = $form_fields;
            $load['module_action'] = $mvb_metro_factory->module_action;
            $load['content'] = $content;

            return $mvb_metro_factory->_load_view('html/private/mvb_form.php', $load);
        }//endif

    }//end admin_render();

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
        $load['content'] = $content;

		$load['link_url'] = (isset($load['link_url'])) ? $load['link_url'] : '';
		$load['page_id'] = (isset($load['page_id'])) ? $load['page_id'] : '';
		
        if( $load['link_url'] == '' AND $load['page_id'] > 0 )
        {
            $load['link_url'] = get_page_link($load['page_id']);
        }//endif;

        return $mvb_metro_factory->_load_view('html/public/mvb_call_to_action.php', $load);
    }//end render();
}//end class