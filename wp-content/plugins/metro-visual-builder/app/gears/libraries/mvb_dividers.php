<?php

class MVB_Dividers {
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
            'title'           =>      __('Divider module', 'mvb'),
            'description'     =>      __('Adds a Divider', 'mvb'),
            'identifier'      =>      __CLASS__,
            'icon'            =>      'appbar.interface.textbox.png',
			'class'            =>      'fa fa-align-justify',
			'section'         =>      'content',
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
    public static function fields() {
        global $mvb_metro_factory;
		
		$_dividers = self::dividers();
		
        $the_fields = array(
			'divider' => array(
                'type'      =>      'select',
                'label'     =>      __('Divider style', 'mvb'),
                'help'      =>      __('Select Divider style', 'mvb'),
                'default'   =>      'thin',
                'options'   =>      $_dividers,
                'col_span'  =>      'lbl_full'
            ),

            'separator-link' => array('type'     =>  'separator'),
			
			'link_url' => array(
				'type'      =>      'text',
				'label'     =>      __('Link (URL)', 'mvb'),
				'help'      =>      __('Set link href', 'mvb'),
				'col_span'  =>      'lbl_full'
			),

			'page_id' => array(
				'type'      =>      'mvb_dropdown',
				'label'     =>      __('Link to page', 'mvb'),
				'help'      =>      __('Or select page', 'mvb'),
				'what'      =>      'pages',
				'default'   =>      '0',
				'col_span'  =>      'lbl_half',
			),
			
			'link_icon' => array(
				'type'      =>      'icon',
				'label'     =>      __('Link Icon', 'mvb'),
				'col_span'  =>      'lbl_half',
			),

			'link_text' => array(
				'type'      =>      'text',
				'label'     =>      __('Link text', 'mvb'),
				'default'   =>      __('Read more'),
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

	public static function dividers() {
		return array(
			'thin' => __('Thin', 'mvb'),
			'fat' => __('Fat', 'mvb'),
			'dotted' => __('Dotted', 'mvb'),
			'small' => __('Default', 'mvb'),
		);
	}

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
    public static function render( $atts, $content = null ) {
        global $mvb_metro_factory;
        $load = $atts;
			
        $load['content'] = $content;

        return $mvb_metro_factory->_load_view('html/public/mvb_dividers.php', $load);
    }//end render();
	
}//end class