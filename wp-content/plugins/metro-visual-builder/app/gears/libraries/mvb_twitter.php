<?php
class MVB_Twitter
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
            'title'           =>      __('Twitter Module', 'mvb'),
            'description'     =>      __('Add a twitter row', 'mvb'),
            'identifier'      =>      __CLASS__,
            'icon'            =>      'appbar.interface.textbox.png',
			'class'            =>      'fa fa-align-justify',
            'section'         =>      'custom',
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

		$the_fields = array(
			'effects' => array(
				'type' => 'select',
				'label' => __('Appear effects', 'mvb'),
				'help' => __('Select one of appear effects for block', 'mvb'),
				'default' => '0',
				'options' => crum_appear_effects(),
				'col_span' => 'lbl_half'
			),
			'css' => array(
				'type' => 'text',
				'label' => __('Additional CSS classes', 'mvb'),
				'help' => __('Separated by space', 'mvb'),
				'col_span' => 'lbl_third'
			),
			'css_styles' => array(
				'type' => 'text',
				'label' => __('Additional CSS styles', 'mvb'),
				'help' => __('Separated by <b>;</b>', 'mvb'),
				'col_span' => 'lbl_full'
			),
		);

		$the_fields = apply_filters('mvb_fields_filter', $the_fields);

		return $the_fields;
	}

	/**
	 * The private code for the shortcode. used in the custom editor
	 *
	 * @access public
	 * @param array $atts
	 * @return shortcode output
	 */
    public static function admin_render( $atts = array(), $content = '' ) {
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
        $load['content'] = '[dfd_twitter_row]';

        return $mvb_metro_factory->_load_view('html/public/mvb_shortcode.php', $load);
    }//end render();

}//end class