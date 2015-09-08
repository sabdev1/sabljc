<h2 class="mvb_module_title"><?php echo $settings['title'] ?></h2>
<span class="module_description"><?php echo $settings['description'] ?></span>
<div class="module_form mvb_the_form_wrapper">
  <div class="clear"><!-- ~ --></div>

  <?php foreach( $form_fields_html as $field ): ?>
        <?php echo $field ?>
  <?php endforeach; ?>
  <div class="clear"><!-- ~ --></div>

  <input type="hidden" name="mvb_the_module" class="mvb_the_module" value="<?php echo $settings['identifier'] ?>" />
  <input type="hidden" name="mvb_the_action" class="mvb_the_action" value="<?php echo $module_action ?>" />
  <input type="button" class="button-primary bshaper_add_module bshaper_add_module_html" value="<?php _e('Save changes', 'mvb') ?>" />
</div>