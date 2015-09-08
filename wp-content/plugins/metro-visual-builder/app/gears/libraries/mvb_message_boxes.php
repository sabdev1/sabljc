<?php

class MVB_Message_Boxes
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
            'title'           =>      __('Message Box module', 'mvb'),
            'description'     =>      __('Adds a message Box block', 'mvb'),
            'identifier'      =>      __CLASS__,
            'icon'            =>      'appbar.interface.textbox.png',
			'class'            =>      'fa fa-align-justify',
            'section'         =>      'content',
            'color'           =>      'gray'
        );
    }//end settings()
	
	public static function styles() {
		return array(
			'info' => __('Info', 'mvb'),
			'success' => __('Success', 'mvb'),
			'warning' => __('Warning', 'mvb'),
			'error' => __('Error', 'mvb'),
		);
	}

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
			
            'content' => array(
                'type'      =>      'textarea',
                'editor'    =>      TRUE,
                'label'     =>      __('Content', 'mvb'),
            ),
			
			'box_style' => array(
                'type'      =>      'select',
                'label'     =>      __('Box style', 'mvb'),
                'help'      =>      __('Select box style', 'mvb'),
                'default'   =>      '',
                'options'   =>      self::styles(),
                'col_span'  =>      'lbl_full'
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
			
            'separator-heading' => array('type'     =>  'separator'),
			
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
		
		switch($atts['box_style']) {
			case 'info': $load['message_icon'] = 'moon-info'; break;
			case 'success': $load['message_icon'] = 'moon-checkmark-circle'; break;
			case 'warning': $load['message_icon'] = 'moon-warning'; break;
			case 'error': $load['message_icon'] = 'moon-cancel-circle'; break;
			default: $load['message_icon'] = ''; break;
		}

        return $mvb_metro_factory->_load_view('html/public/mvb_message_boxes.php', $load);
    }
	
}
