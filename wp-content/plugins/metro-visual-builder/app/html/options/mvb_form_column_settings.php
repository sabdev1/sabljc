<h2 class="mvb_module_title"><?php _e('Columns Settings', 'mvb') ?></h2>
<span class="module_description"><?php _e('The column settings', 'mvb') ?></span>
<div class="module_form mvb_the_form_wrapper">
  <div class="clear"><!-- ~ --></div>

  <?php foreach( $form_fields_html as $field ): ?>
        <?php echo $field ?>
  <?php endforeach; ?>
  <div class="clear"><!-- ~ --></div>

  <input type="button" class="button-primary mvb_submit_column_settings" value="<?php _e('Save changes', 'mvb') ?>" />
</div>