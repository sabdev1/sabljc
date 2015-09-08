<div id="bshaper_main_window">
    <div class="bshaper_button"><span class="bshaper_metro_logo"><?php _e('Visual Page Builder', 'mvb') ?></span><i class="awesome-plus"></i> <a href="#" class="bshaper_add_section" data-where="top"><?php _e('Add section', 'mvb') ?></a></div>
    <!-- //start html content -->
    <ul id="mvb_sortable_list"><?php echo $meta_value ?></ul>
    <!-- //end html content -->
    <div class="clear"><!-- ~ --></div>
    <div class="bshaper_button">
    <a href="#" data-confirm="<?php _e('Are you sure you want to clear the contents of the editor?') ?>" class="mvb_clear_content"><i class="awesome-eraser"></i> <?php _e('Delete all blocks', 'mvb') ?></a>
        <i class="awesome-plus"></i><a href="#" class="bshaper_add_section" data-where="bottom"><?php _e('Add section', 'mvb') ?></a></div>
    <div class="mvb_modal"><!-- .for the loading animation --></div>
</div>
<!-- //.bshaper_main_window-->
<div id="bshaper_tmp" style="display: none;"></div>
<input type="hidden" value="<?php echo $post->ID ?>" class="bshaper_the_post_id" name="bshaper_the_post_id" />
<input type="hidden" value="<?php echo wp_create_nonce("bshaper_metro_builder"); ?>" class="bshaper_ajax_referrer" name="bshaper_metro_nonce" />
<input type="hidden" value="-1" class="bshaper_row_id" name="bshaper_row_id" />
<textarea name="bshaper_artist_content_html" id="bshaper_artist_content_html" style="display: none; width: 100%;"><?php echo $meta_value ?></textarea>

<div class="bshaper_metro_settings">
    <h2 class="mvb_section_h"><?php _e('Metro Visual Builder Settings', 'mvb') ?></h2>

    <label>
        <span><?php _e('Activate Metro Visual Builder?', 'mvb') ?></span>
        <select name="_bshaper_activate_metro_builder" class="input_select">
            <?php $yes_no = mvb_yes_no_both() ?>
            <?php foreach( $yes_no as $value => $lbl ): ?>
                  <option value="<?php echo $value ?>" <?php if( $value == $_bshaper_activate_metro_builder ): ?> selected="selected" <?php endif; ?>> <?php echo $lbl ?> </option>
            <?php endforeach; ?>
        </select>
    </label>
    <div class="clear"><!-- ~ --></div>
</div>

<?php $mvb_lang = explode("-", get_bloginfo('language')); ?>
<script type="text/javascript">
    var mvb_l_lang = "<?php echo $mvb_lang[0]; ?>";
</script>

