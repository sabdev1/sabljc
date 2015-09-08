<?php
/**
 * Features List
 */
class MVB_lists {
    /**
	 * The modules settings
	 *
	 * @access public
	 * @param none
	 * @return array settings
	 */
    public static function settings() {
        return array(
            'title'			=> __('Lists', 'mvb'),
            'description'	=> __('Add a feature', 'mvb'),
            'identifier'	=> __CLASS__,
            'icon'			=> 'appbar.interface.list.png',
            'class'			=> 'fa fa-list-ul',
            'section'		=> 'presentation',
            'color'			=> 'gray'
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
			
			'default_icon' => array(
                'type'		=> 'icon',
                'label'		=> __('Default Icon', 'mvb'),
                'col_span'	=> 'lbl_half',
            ),
			
			'separator-items' => array('type'     =>  'separator'),

            'list' => array(
                'type'      => 'repeater',
                'button'    => __('Add List Item', 'mvb'),
                'label'     => __('Item', 'mvb'),
                'lbl_d'     => __('Item Title', 'mvb'),
                'fields'    => array(

                    'list_text' => array(
                        'type'		=> 'text',
                        'label'		=> __('Text', 'mvb'),
                        'col_span'	=> 'lbl_full'
                    ),

                    'item_icon' => array(
						'type'		=> 'icon',
						'label'		=> __('Icon', 'mvb'),
						'col_span'	=> 'lbl_half',
					),
                ),
            ),
			
            'separator-add' => array('type'     =>  'separator'),

            'css' => array(
                'type'	=> 'text',
                'label'	=> __('Additional CSS classes', 'mvb'),
                'help'	=> __('Separated by space', 'mvb')
            ),
			
			'css_styles' => array(
                'type'      =>      'text',
                'label'     =>      __('Additional CSS styles', 'mvb'),
                'help'      =>      __('Separated by <b>;</b>', 'mvb'),
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

    public static function admin_render($atts = array(), $content = '') {
		global $mvb_metro_factory;
		global $mvb_metro_form_builder;
		$form_fields = self::fields();

		$load = shortcode_atts($mvb_metro_factory->defaults($form_fields), $atts);
		$load['content'] = $content;

		if ($mvb_metro_factory->show_pill_sc OR $mvb_metro_factory->show_pill_sc_column) {
			if (method_exists(__CLASS__, 'the_pill')) {
				return self::the_pill($load, self::settings());
			} else {
				return $mvb_metro_factory->the_pill($load, self::settings());
			}
		} else {
			$load['content'] = $mvb_metro_factory->do_repeater_shortcode($content);

			$load['form_fields_html'] = $mvb_metro_form_builder->build_form($form_fields, $load);
			$load['settings'] = self::settings();
			$load['form_fields'] = $form_fields;
			$load['module_action'] = $mvb_metro_factory->module_action;

			return $mvb_metro_factory->_load_view('html/private/mvb_form.php', $load);
		}//endif
	}

	/**
	 * The private code for the repeater shortcode. used in the custom editor
	 *
	 * @access public
	 * @param array $atts
	 * @return shortcode output
	 */
	public static function repeater_admin_render($atts = array(), $content = '') {
		global $mvb_metro_factory;
		global $__metro_core;

		if (!isset($atts['sh_keys']) OR trim($atts['sh_keys']) == '') {
			return;
		}

		$keys = explode(",", $atts['sh_keys']);
		$tmp = array();

		foreach ($keys as $key) {
			if ($key != 'content') {
				$tmp[$key] = (isset($atts[$key])) ? $atts[$key] : '';
			}
		}

		if (in_array('content', $keys))
			$tmp['content'] = $content;

		$__metro_core->sh_tmp_repeater[] = $tmp;
	}

	public static function repeater_render($atts = array(), $content = '') {
		global $mvb_metro_factory;
		self::repeater_admin_render($atts, $content);
	}

	/**
	 * The public code for the shortcode
	 *
	 * @access public
	 * @param array $atts
	 * @return shortcode output
	 */
	public static function render($atts, $content = null) {
		global $mvb_metro_factory;

		$load = $atts;
		$load['r_items'] = $mvb_metro_factory->do_repeater_shortcode($content);

		return $mvb_metro_factory->_load_view('html/public/mvb_lists.php', $load);
	}

}
