<div class="wrap mvb_options_wrap">
<div id="icon-options-general" class="icon32">
  <br>
</div>
<h2><?php _e('Metro Visual Builder - Options', 'mvb') ?></h2>
<div class="clear"><!-- --></div>

<div class="mvb_options_form">
<?php if( isset($messenger_status) AND $messenger_status != '' ): ?>
    <div class="mvb_message_<?php echo $messenger_status ?>"><?php echo $messenger ?></div>
<?php endif; ?>

<form action="" method="post">
  <div class="mvb_form_row">
          <label for="mvb_cpts"><?php _e('Show the editor for', 'mvb'); ?>: </label>
          <div class="clear"><!-- --></div>
          <?php foreach ($mvb_post_types as $post_type => $post_type_label ): ?>
              <label class="checkbox_label"><input type="checkbox" value="<?php echo $post_type ?>" name="mvb_cpts[]"<?php if( in_array($post_type, $mvb_o_cpts) ): ?> checked="checked"<?php endif; ?> /><span><?php echo $post_type_label ?></span></label>
          <?php endforeach; ?>
  </div>
  <div class="clear"><!-- --></div>
<?php /*
  <div class="mvb_form_row">
      <label for="mvb_color_scheme"><?php _e('Color scheme', 'mvb'); ?>: </label>
      <select name="mvb_color_scheme" id="mvb_color_scheme" class="regular-text">
          <?php foreach ($mvb_skins as $skin => $skin_label ): ?>
             <option value="<?php echo $skin ?>"<?php if( $skin == $mvb_o_color_scheme ): ?> selected="selected"<?php endif; ?>><?php echo $skin_label ?></option>
          <?php endforeach; ?>
      </select>
  </div>
  <div class="clear"><!-- --></div>
*/ ?>
  <div class="mvb_form_row">
      <label for="mvb_grid"><?php _e('Grid', 'mvb'); ?>: </label>
      <select name="mvb_grid" id="mvb_grid" class="regular-text">
          <?php foreach ($mvb_grids as $grid => $grid_label ): ?>
             <option value="<?php echo $grid ?>"<?php if( $grid == $mvb_o_grid ): ?> selected="selected"<?php endif; ?>><?php echo $grid_label ?></option>
          <?php endforeach; ?>
      </select>
      <div class="mvb_help"><?php _e('Choose another grid ONLY if your theme uses that grid.', 'mvb') ?></div>
  </div>
  <div class="clear"><!-- --></div>

  <div class="mvb_form_row">
      <label for="mvb_activate"><?php _e('Activate Metro Visual Builder', 'mvb'); ?>: </label>
      <select name="mvb_activate" id="mvb_activate" class="regular-text">
          <?php foreach ($mvb_yes_no as $value => $label ): ?>
             <option value="<?php echo $value ?>"<?php if( $value == $mvb_o_activate ): ?> selected="selected"<?php endif; ?>><?php echo $label ?></option>
          <?php endforeach; ?>
      </select>
  </div>
  <div class="clear"><!-- --></div>

  <div class="mvb_form_row">
      <label for="mvb_show"><?php _e('Show Metro Visual Builder editor', 'mvb'); ?>: </label>
      <select name="mvb_show" id="mvb_show" class="regular-text">
          <?php foreach ($mvb_yes_no as $value => $label ): ?>
             <option value="<?php echo $value ?>"<?php if( $value == $mvb_o_show ): ?> selected="selected"<?php endif; ?>><?php echo $label ?></option>
          <?php endforeach; ?>
      </select>
      <div class="mvb_help"><?php _e('Show the editor in the add/edit page. You can temporarly hide it with this option.', 'mvb') ?></div>
  </div>
  <div class="clear"><!-- --></div>

  <input type="hidden" name="mvb_plugin_posted" value="posted" />
  <p class="submit">
    <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'mvb') ?>">
  </p>

</form>
</div>
<!-- .mvb_options_page -->
</div>
<!-- .wrap -->