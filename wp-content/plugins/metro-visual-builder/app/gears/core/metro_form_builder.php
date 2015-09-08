<?php

class Metro_Form_Builder
{
    /**
	 * Build the form
	 *
	 * @access public
	 * @param array $fields
	 * @return array form fields
	 */

    public function build_form( $fields, $defaults )
    {
        $form_fields = array();
        global $mvb_metro_form_builder;

        foreach( $fields as $field_name => $field_options )
        {
            $method_name = '__add_'.$field_options['type'];
            $value = isset($defaults[$field_name]) ? $defaults[$field_name] : '';

            if( $field_options['type'] == 'repeater' )
            {
                $value = isset($defaults['content']) ? $defaults['content'] : array();
                $form_fields[$field_name] = $mvb_metro_form_builder->build_form_repeater( $field_name, $field_options, $value );
                //array_push($form_fields, $repeater_fields);
            }
            else
            {
                if( is_callable( array($mvb_metro_form_builder, $method_name) )  )
                    $form_fields[$field_name] = $mvb_metro_form_builder->$method_name($field_name, $field_options, $value);
            }//endif;
        }//end foreach()

        return $form_fields;
    }//end build_form();

    /**
	 * Build the repeater fields
	 *
	 * @access public
	 * @param array $fields
	 * @return array form fields
	 */

    public function build_form_repeater( $parent_field_name, $field_options, $content_value )
    {
        $form_fields = array();
        global $mvb_metro_form_builder;

        foreach( $field_options['fields'] as $field_name => $_field_options )
        {
            $method_name = '__add_'.$_field_options['type'];
            $value = '';

            if( !isset($_field_options['class']) )
            {
                $_field_options['class'] = 'mvb_repeater_field';
            }
            else
            {
                $_field_options['class'] .= ' mvb_repeater_field';
            }//endif

            if( isset($_field_options['s_title']) AND $_field_options['s_title'] == TRUE )
            {
                $_field_options['class'] .= ' mvb_st_section_title';
            }//endif;

            if( is_callable( array($mvb_metro_form_builder, $method_name) )  )
                $form_fields[$field_name] = $mvb_metro_form_builder->$method_name($field_name, $_field_options, $value);
        }//end foreach()

        $form_fields = $mvb_metro_form_builder->build_repeater($parent_field_name, $form_fields, $field_options, $content_value);

        return $form_fields;
    }//end build_form_repeater();

    /**
	 * Builds the repeater
	 *
	 * @access public
	 * @param string $field_name
	 * @param array $field_options
	 * @return string text field
	 */

    public function build_repeater( $field_name, $form_fields, $settings, $content_value )
    {
        $fields = implode("", $form_fields);
        global $mvb_metro_form_builder;
        ob_start();
        ?>
        <div class="clear"><!-- --></div>
        <ul class="repeater_sortable" id="<?php echo $field_name ?>_sortable" data-field="<?php echo $field_name ?>">
        <?php if( is_array($content_value) AND !empty($content_value) ): ?>
             <?php foreach( $content_value as $panel ): ?>
             <?php $_fields = ''; ?>
             <?php $s_title = '' ?>
                    <?php foreach( $settings['fields'] as $f_panel_name => $f_panel_settings ): ?>
                        <?php
                        $val = isset($panel[$f_panel_name]) ? $panel[$f_panel_name] : '';
                        if( !isset($f_panel_settings['class']) )
                        {
                            $f_panel_settings['class'] = 'mvb_repeater_field';
                        }
                        else
                        {
                            $f_panel_settings['class'] .= ' mvb_repeater_field';
                        }//endif

                        if( isset($f_panel_settings['s_title']) AND $f_panel_settings['s_title'] == TRUE )
                        {
                            $f_panel_settings['class'] .= ' mvb_st_section_title';
                            $s_title = $val;
                        }//endif;

                       $method_name = '__add_'.$f_panel_settings['type'];
                       if( is_callable( array($mvb_metro_form_builder, $method_name) )  ):
                             $_fields .= $mvb_metro_form_builder->$method_name($f_panel_name, $f_panel_settings, $val);
                       endif;
                       ?>
                  <?php endforeach; ?>
                 <li>
                  <span class="bshaper_hide_section_h">
					  <a href="#" class="bshaper_hide_section"><?php echo $settings['label'] ?>: <span class="bshaper_section_name"><?php echo mvb_base64_decode($s_title); ?></span><span class="bshaper_handler_acc"></span></a>
                    <span class="bshaper_remove_section"><label><?php _e('remove', 'mvb') ?>: <input type="checkbox" value="yes" class="bshaper_remove_section_cbx" /></label></span>
                    <div class="clear"><!-- ~ --></div>
                  </span>

                  <div class="bshaper_section_holder" style="display: none;">
                      <?php echo $_fields ?>
                      <div class="clear"><!-- ~ --></div>
                  </div>
                </li>
                <!-- //li-->
             <?php endforeach; ?>
        <?php endif; ?>
        </ul>
        <div class="clear"><!-- --></div>
        <a href="#" class="bshaper_acc_add_section" data-what="<?php echo $field_name ?>_sortable"><?php echo $settings['button'] ?></a>
        <div class="clear"><!-- --></div>

       <ul class="<?php echo $field_name ?>_sortable_shadow_ul shadow_ul">
          <li>
          <span class="bshaper_hide_section_h">
			  <a href="#" class="bshaper_hide_section"><?php echo $settings['label'] ?>: <span class="bshaper_section_name"><?php echo $settings['lbl_d']; ?></span><span class="bshaper_handler_acc"></span></a>
            <span class="bshaper_remove_section"><label><?php _e('remove', 'mvb') ?>: <input type="checkbox" value="yes" class="bshaper_remove_section_cbx" /></label></span>
            <div class="clear"><!-- ~ --></div>
          </span>

          <div class="bshaper_section_holder" style="display: none;">
              <?php echo $fields ?>
              <div class="clear"><!-- ~ --></div>
        </div>
        </li>
        <!-- //li-->
       </ul>

        <?php
        return ob_get_clean();
    }//end build_repeater()


    /**
     * Add Icon field
     *
     * @access public
     * @param string $field_name
     * @param array $field_options
     * @return string icon field
     */

    public function __add_icon( $field_name, $options, $value )
    {
        ob_start();
        ?>
        <?php if( !isset($options['col_span']) ): ?><div class="clear"><!-- ~ --></div><?php endif; ?>
        <label<?php if( isset($options['col_span']) ): ?> class="<?php echo $options['col_span'] ?>"<?php endif; ?>><span><?php echo $options['label'] ?>:</span>
            <input type="text"  name="<?php echo $field_name ?>" value="<?php echo $value ?>" class="widefat bshaper_form_fields iconname mvb_module_<?php echo $field_name ?> mvb_module_field<?php if( isset($options['class']) ): ?> <?php echo $options['class'] ?><?php endif; ?>" />
            <a href="#" class="button crum-icon-add" title="<?php echo __('Add Icon','crum'); ?>"><?php echo __('Add Icon','crum'); ?></a>
            <?php if( isset($options['help']) ): ?><span class="bshaper_helper_info"><?php echo $options['help'] ?></span><?php endif; ?>
        </label>
        <?php
        return ob_get_clean();
    }//end __add_icon()
	

	/**
	 * Add Text field
	 *
	 * @access public
	 * @param string $field_name
	 * @param array $field_options
	 * @return string text field
	 */

    public function __add_text( $field_name, $options, $value )
    {
        ob_start();
		
		$value = mvb_base64_decode($value);
		
        ?>
        <?php if( !isset($options['col_span']) ): ?><div class="clear"><!-- ~ --></div><?php endif; ?>
        <label<?php if( isset($options['col_span']) ): ?> class="<?php echo $options['col_span'] ?>"<?php endif; ?>><span><?php echo $options['label'] ?>:</span>
          <input type="text" value="<?php echo $value ?>" name="<?php echo $field_name ?>" class="widefat bshaper_form_fields mvb_module_<?php echo $field_name ?> mvb_module_field<?php if( isset($options['class']) ): ?> <?php echo $options['class'] ?><?php endif; ?>" />
          <?php if( isset($options['help']) ): ?><span class="bshaper_helper_info"><?php echo $options['help'] ?></span><?php endif; ?>
        </label>
        <?php
        return ob_get_clean();
    }//end __add_text()

    /**
	 * Add Textarea field
	 *
	 * @access public
	 * @param string $field_name
	 * @param array $field_options
	 * @return string text field
	 */

    public function __add_textarea( $field_name, $options, $value )
    {
        ob_start();
		
		global $mvb_metro_factory;
		
		$value = mvb_base64_decode($value);
		
        ?>
        <?php if( !isset($options['col_span']) ): ?><div class="clear"><!-- ~ --></div><?php endif; ?>
        <label<?php if( isset($options['col_span']) ): ?> class="<?php echo $options['col_span'] ?>"<?php endif; ?>><span><?php echo $options['label'] ?>:</span>

          <?php if( isset($options['editor']) AND $options['editor'] === TRUE ): ?>

			<?php if( isset($options['insert_image']) AND $options['insert_image'] === TRUE ): ?>
			<div class="mvb-editor-tools"></div>
			<?php endif; ?>
			
			<textarea type="text" name="<?php echo $field_name ?>" class="widefat mvb_textarea_with_editor bshaper_form_fields mvb_module_<?php echo $field_name ?> mvb_module_field<?php if( isset($options['class']) ): ?> <?php echo $options['class'] ?><?php endif; ?>"><?php echo mvb_parse_content($value); ?></textarea>

          <?php else: ?>

            <textarea type="text" name="<?php echo $field_name ?>" class="widefat bshaper_form_fields mvb_module_<?php echo $field_name ?> mvb_module_field<?php if( isset($options['class']) ): ?> <?php echo $options['class'] ?><?php endif; ?>"><?php if( $field_name == 'content' ): ?><?php echo mvb_parse_content_html($value) ?><?php else: ?><?php echo mvb_special_content($value, "\n") ?><?php endif; ?></textarea>

          <?php endif; ?>

          <?php if( isset($options['help']) ): ?><span class="bshaper_helper_info"><?php echo $options['help'] ?></span><?php endif; ?>
        </label>
        <?php
        return ob_get_clean();
    }//end __add_textarea()

    /**
	 * Add Colorpicker field
	 *
	 * @access public
	 * @param string $field_name
	 * @param array $field_options
	 * @return string text field
	 */

    public function __add_colorpicker( $field_name, $options, $value )
    {
        ob_start();
        ?>
        <?php if( !isset($options['col_span']) ): ?><div class="clear"><!-- ~ --></div><?php endif; ?>
        <label<?php if( isset($options['col_span']) ): ?> class="<?php echo $options['col_span'] ?>"<?php endif; ?>><span><?php echo $options['label'] ?>:</span>
          <div class="clear"><!-- ~ --></div>
          <input type="text" value="<?php echo $value ?>" name="<?php echo $field_name ?>" id="mvb_module_<?php echo $field_name ?>" class="widefat bshaper_form_fields bshaper_color_field mvb_color_field mvb_module_<?php echo $field_name ?> mvb_module_field<?php if( isset($options['class']) ): ?> <?php echo $options['class'] ?><?php endif; ?>" />
          <span class="bshaper_color_preview" id="mvb_module_<?php echo $field_name ?>_label"<?php if( trim($value) != '' ): ?> style="background-color: #<?php echo $value ?>"<?php endif; ?>>&nbsp;</span>
          <?php if( isset($options['help']) ): ?><span class="bshaper_helper_info"><?php echo $options['help'] ?></span><?php endif; ?>
        </label>
        <?php
        return ob_get_clean();
    }//end __add_colorpicker()

    /**
	 * Add Select field
	 *
	 * @access public
	 * @param string $field_name
	 * @param array $field_options
	 * @return string text field
	 */

    public function __add_select( $field_name, $options, $value )
    {
        ob_start();
        ?>
        <?php if( !isset($options['col_span']) ): ?><div class="clear"><!-- ~ --></div><?php endif; ?>
        <label<?php if( isset($options['col_span']) ): ?> class="<?php echo $options['col_span'] ?>"<?php endif; ?>><span><?php echo $options['label'] ?>:</span>
          <select type="text" name="<?php echo $field_name ?>" class="widefat bshaper_form_fields mvb_select_field mvb_module_<?php echo $field_name ?> mvb_module_field<?php if( isset($options['class']) ): ?> <?php echo $options['class'] ?><?php endif; ?>">
                <?php foreach( $options['options'] as $opt_id => $opt_lbl ): ?>
                    <option value="<?php echo $opt_id ?>"<?php if( $value == $opt_id ): ?> selected="selected"<?php endif; ?>><?php echo $opt_lbl ?></option>
                <?php endforeach; ?>
          </select>
          <?php if( isset($options['help']) ): ?><span class="bshaper_helper_info"><?php echo $options['help'] ?></span><?php endif; ?>
        </label>
        <?php
        return ob_get_clean();
    }//end __add_select()




	/**
	 * Add Select field
	 *
	 * @access public
	 * @param string $field_name
	 * @param array $field_options
	 * @return string text field
	 */

	public function __add_customselectinput( $field_name, $options, $value )
	{
		ob_start();
		?>

		<?php if( !isset($options['col_span']) ): ?><div class="clear"><!-- ~ --></div><?php endif; ?>
		<div class="autocomplite-block <?php if( isset($options['col_span']) ): echo $options['col_span']; endif; ?>">
			<label><span><?php echo $options['label'] ?>:</span></label>

			<div class="dropdownlist">
				<div class="autocomplite-pseudo-fild">

					<?php if ( array_key_exists($value, $options['options']) ) { echo $options['options'][$value]; } else { echo $value; } ?>
					<b class="caret"></b>
				</div>
				<div class="autocomplite-conteiner">
					<input type="text" value="<?php echo $value; ?>" name="<?php echo $field_name ?>" class="
		               widefat
		               bshaper_form_fields
		               mvb_module_field
	                   mvb_module_<?php echo $field_name ?>
		               mvb_module_field<?php if( isset($options['class']) ): ?> <?php echo $options['class'] ?><?php endif; ?>" />
					<?php foreach( $options['options'] as $opt_id => $opt_lbl ): ?>
						<div class="value <?php echo ( $value == $opt_id ) ? 'checked' : ''; ?>" data-value="<?php echo $opt_id ?>" ><?php echo $opt_lbl; ?></div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="clear"><!-- ~ --></div>
		</div>

		<?php if( isset($options['help']) ): ?><span class="bshaper_helper_info"><?php echo $options['help'] ?></span><?php endif; ?>

		<?php
		return ob_get_clean();
	}//end __add_customselectinput()

    /**
	 * Add Select Multiple field
	 *
	 * @access public
	 * @param string $field_name
	 * @param array $field_options
	 * @return string text field
	 */

    public function __add_select_multi( $field_name, $options, $value )
    {
        $sortable = isset($options['sortable']) ? 'true' : 'false';
        $callback = $options['callback'];
        ob_start();
        ?>
        <?php if( !isset($options['col_span']) ): ?><div class="clear"><!-- ~ --></div><?php endif; ?>
        <label<?php if( isset($options['col_span']) ): ?> class="<?php echo $options['col_span'] ?>"<?php endif; ?>><span><?php echo $options['label'] ?>:</span>
          <select type="text" name="<?php echo $field_name ?>" id="mvb_asm_id_<?php echo $field_name ?>" class="widefat bshaper_artist_input_multiselect_asm_ns bshaper_form_fields mvb_select_field mvb_asm_field mvb_module_<?php echo $field_name ?> mvb_module_field<?php if( isset($options['class']) ): ?> <?php echo $options['class'] ?><?php endif; ?>" multiple="multiple" data-sortable="<?php echo $sortable ?>" title="<?php echo $options['title'] ?>">
                <?php echo $callback($options['options'], $value) ?>
          </select>
          <?php if( isset($options['help']) ): ?><span class="bshaper_helper_info"><?php echo $options['help'] ?></span><?php endif; ?>
        </label>
        <div class="clear"><!-- ~ --></div>
        <?php
        return ob_get_clean();
    }//end __add_select_multi()

    /**
	 * Add Image select field
	 *
	 * @access public
	 * @param string $field_name
	 * @param array $field_options
	 * @return string text field
	 */

    public function __add_select_image( $field_name, $options, $value )
    {
        $i = 1;
        ob_start();
        ?>
        <?php if( !isset($options['col_span']) ): ?><div class="clear"><!-- ~ --></div><?php endif; ?>
        <label<?php if( isset($options['col_span']) ): ?> class="<?php echo $options['col_span'] ?>"<?php endif; ?>><span><?php echo $options['label'] ?>:</span>
            <?php foreach( $options['options'] as $opt_id ): ?>
                <?php $opt_id == $value ? $t = ' checked="checked"' : $t = ''; ?>
                <label class="btn_style" for="<?php echo $field_name.'_'.$i ?>"><input type="radio" name="<?php echo $field_name ?>" class="bshaper_form_fields mvb_select_image_field mvb_module_<?php echo $field_name ?> mvb_module_field<?php if( isset($options['class']) ): ?> <?php echo $options['class'] ?><?php endif; ?> bshaper_module_button_style" value="<?php echo $opt_id ?>" id="<?php echo $field_name.'_'.$i ?>" <?php echo $t ?> /><img src="<?php echo $opt_id ?>" /></label>
            <?php $i++; ?>
            <?php endforeach; ?>
          <?php if( isset($options['help']) ): ?><span class="bshaper_helper_info"><?php echo $options['help'] ?></span><?php endif; ?>
        </label>
        <?php
        return ob_get_clean();
    }//end __add_select_image()

    /**
	 * Add Select field with special values
	 *
	 * @access public
	 * @param string $field_name
	 * @param array $field_options
	 * @return string text field
	 */

    public function __add_mvb_dropdown( $field_name, $options, $value )
    {
        $_css_class = 'widefat bshaper_form_fields mvb_module_'.$field_name.' mvb_module_field';
        if( isset($options['class']) )
            $_css_class .= ' '.$options['class'];
        ob_start();
        ?>
        <?php if( !isset($options['col_span']) ): ?><div class="clear"><!-- ~ --></div><?php endif; ?>
        <label<?php if( isset($options['col_span']) ): ?> class="<?php echo $options['col_span'] ?>"<?php endif; ?>><span><?php echo $options['label'] ?>:</span>
          <?php if( $options['what'] == 'pages' ): ?>
               <?php $pages = wp_dropdown_pages( array('echo' => false, 'selected' => $value, 'show_option_none' => __('Select page', 'mvb'), 'show_option_none_value' => '0') ) ?>
                <?php $pages = str_replace("<select ", '<select class="'.$_css_class.'"', $pages) ?>
                <?php echo $pages; ?>
          <?php endif; ?>
          <?php if( isset($options['help']) ): ?><span class="bshaper_helper_info"><?php echo $options['help'] ?></span><?php endif; ?>
        </label>
        <?php
        return ob_get_clean();
    }//end __add_mvb_dropdown()

    /**
	 * Add a separator
	 *
	 * @access public
	 * @param string $field_name
	 * @param array $field_options
	 * @return string text field
	 */

    public function __add_separator( $field_name, $options, $value )
    {
        ob_start();
        ?>
         <div class="clear mvb_separator<?php if( isset($options['border']) AND $options['border'] ): ?> mvb_separator_border<?php endif; ?>"><!-- ~ --></div>
         <?php if( isset($options['text']) AND $options['text'] != '' ): ?>
         <h3 class="mvb_section_title"><?php echo $options['text'] ?></h3>
         <?php endif; ?>
        <?php
        return ob_get_clean();
    }//end __add_separator()

    /**
	 * Add Image field
	 *
	 * @access public
	 * @param string $field_name
	 * @param array $field_options
	 * @return string text field
	 */

    public function __add_image( $field_name, $options, $value )
    {
        ob_start();
        ?>
        <?php if( !isset($options['col_span']) ): ?><div class="clear"><!-- ~ --></div><?php endif; ?>
        <label<?php if( isset($options['col_span']) ): ?> class="<?php echo $options['col_span'] ?>"<?php endif; ?>><span><?php echo $options['label'] ?>:</span>
          <div class="bshaper_metro_photo_holder">
               <input type="hidden" name="<?php echo $field_name ?>" class="widefat bshaper_module_image mvb_module_<?php echo $field_name ?> mvb_module_field<?php if( isset($options['class']) ): ?> <?php echo $options['class'] ?><?php endif; ?>" value="<?php echo $value ?>" />

               <div class="bshaper_metro_item_actions">
                  <a href="#" class="bshaper_metro_upload_file"><?php _e('Upload file', 'mvb') ?></a>
                  <a href="#" class="bshaper_metro_delete_btn"<?php if( $value == '' ): ?> style="display: none;"<?php endif; ?>><?php _e('Delete file', 'mvb') ?></a>
               </div>
               <div class="bshaper_metro_image_holder">
                  <?php if( $value != '' ): ?>
                        <img src="<?php echo mvb_aq_resize($value, 150) ?>" width="150" />
                  <?php endif; ?>
                  <div class="clear"><!-- ~ --></div>
               </div>
           </div>
          <?php if( isset($options['help']) ): ?><span class="bshaper_helper_info"><?php echo $options['help'] ?></span><?php endif; ?>
        </label>
        <?php
        return ob_get_clean();
    }//end __add_image()

    /**
	 * Add Upload field
	 *
	 * @access public
	 * @param string $field_name
	 * @param array $field_options
	 * @return string text field
	 */

    public function __add_upload( $field_name, $options, $value )
    {
        ob_start();
        ?>
        <?php if( !isset($options['col_span']) ): ?><div class="clear"><!-- ~ --></div><?php endif; ?>
        <label<?php if( isset($options['col_span']) ): ?> class="<?php echo $options['col_span'] ?>"<?php endif; ?>><span><?php echo $options['label'] ?>:</span>
          <input type="text" value="<?php echo $value ?>" name="<?php echo $field_name ?>" class="widefat bshaper_form_fields mvb_module_<?php echo $field_name ?> mvb_module_field<?php if( isset($options['class']) ): ?> <?php echo $options['class'] ?><?php endif; ?>" />
          <input name="b_img_dl" rel="mvb_module_<?php echo $field_name ?>" class="metro_document_upload" type="button" value="<?php _e('Upload', 'mvb') ?>" />

          <?php if( isset($options['help']) ): ?><span class="bshaper_helper_info"><?php echo $options['help'] ?></span><?php endif; ?>
        </label>
        <?php
        return ob_get_clean();
    }//end __add_upload()

    /**
	 * Add block of text for info
	 *
	 * @access public
	 * @param string $field_name
	 * @param array $field_options
	 * @return string text field
	 */

    public function __add_helper( $field_name, $options, $value )
    {
        ob_start();
        ?>
        <?php if( !isset($options['col_span']) ): ?><div class="clear"><!-- ~ --></div><?php endif; ?>
        <div class="bshaper_tip"><?php echo $options['value'] ?></div>
        <?php
        return ob_get_clean();
    }//end __add_helper()

    /**
	 * Add a section title
	 *
	 * @access public
	 * @param string $field_name
	 * @param array $field_options
	 * @return string text field
	 */

    public function __add_section_title( $field_name, $options, $value )
    {
        ob_start();
        ?>
        <div class="clear"><!-- --></div>
        <h3 class="mvb_section_title"><?php echo $options['value'] ?></h3>
        <div class="clear"><!-- --></div>
        <?php
        return ob_get_clean();
    }//end __add_section_title()
}//end class