<?php

class MVB_Skills
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
            'title'           =>      __('Personal skills', 'mvb'),
            'description'     =>      __('Add a skill section', 'mvb'),
            'identifier'      =>      __CLASS__,
            'icon'            =>      'appbar.graph.bar.png',
			'class'            =>      'fa fa-bar-chart-o',
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

            'image' => array(
                'type'      =>      'image',
                'label'     =>      __('Image', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),

            'name' => array(
                'type'      =>      'text',
                'label'     =>      __('Name', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),

            'client_job' => array(
                'type'      =>      'text',
                'label'     =>      __('Job position', 'mvb'),
                'col_span'  =>      'lbl_half'
            ),

            'description' => array(
                'type'      =>      'textarea',
                'label'     =>      __('Description', 'mvb'),
            ),
			
			'separator-animate' => array('type'     =>  'separator'),
					
			'animate_skill' => array(
				'type'		=> 'select',
				'label'		=> __('Animate skills', 'mvb'),
				'default'	=> 0,
				'options'	=> mvb_yes_no(),
			),

            'skill' => array(
                'type'      =>      'repeater',
                'button'    =>      __('Add skill', 'mvb'),
                'label'     =>      __('Skill', 'mvb'),
                'lbl_d'     =>      __('Skill Title', 'mvb'),
                'fields'    =>      array(
                    'skill_title' => array(
                        'type'      =>      'text',
                        's_title'   =>      TRUE,
                        'label'     =>      __('Skill Title', 'mvb'),
                        'col_span'  =>      'lbl_half'
                    ),

                    'skill_percent' => array(
                        'type'      =>      'text',
                        'label'     =>      __('Skill percent', 'mvb'),
                        'col_span'  =>      'lbl_forth'
                    ),
					
					'separator' => array('type'     =>  'separator'),
					
					'icon' => array(
                        'type'      =>      'icon',
                        'label'     =>      __('Icon', 'mvb'),
                        'col_span'  =>      'lbl_forth',
                    ),
					
					'icon_color' => array(
                        'type'      =>      'colorpicker',
                        'label'     =>      __('Icon text color', 'mvb'),
                        'default'   =>      'c0c0c0',
                        'col_span'  =>      'lbl_forth',
                    ),

                ),
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
        global $__metro_core;

        if( !isset($atts['sh_keys']) OR trim($atts['sh_keys']) == '' )
            return;

        $keys = explode(",", $atts['sh_keys']);
        $tmp = array();

        foreach( $keys as $key )
        {
            $tmp[$key] = isset($atts[$key]) ? $atts[$key] : '';
        }//endforeach;

        $__metro_core->sh_tmp_repeater[] = $tmp;
    }//end repeater_admin_render();

    public static function repeater_render( $atts = array(), $content = '' )
    {
        global $mvb_metro_factory;
        self::repeater_admin_render($atts, $content = '');
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


        return $mvb_metro_factory->_load_view('html/public/mvb_skills.php', $load);
    }//end render();
}//end class