<div class="bshaper_module bshaper_<?php echo $settings['color'] ?>">
    <div class="bshaper_module_icon bshaper_to_be_deleted">
    <?php if( isset( $image ) AND $image != '' ): ?>
        <img src="<?php echo mvb_aq_resize($image, 48, 48) ?>" width="48" />
    <?php else: ?>
        <img src="<?php echo $app_url ?>assets/images/icons/<?php echo $settings['icon'] ?>" width="48" />
    <?php endif; ?>
    </div>

    <div class="bshaper_meta bshaper_to_be_deleted">
        <h4><?php echo $settings['title'] ?></h4>
    </div>

    <div class="bshaper_overlay_content bshaper_to_be_deleted">
    <?php if( isset($main_title) AND $main_title != '' ): ?>
        <h4><?php echo mvb_base64_decode($main_title); ?></h4>
    <?php else: ?>
        <h4><?php echo $settings['description'] ?></h4>
    <?php endif; ?>
        <div class="bshaper_meta_actions">
            <a href="#" class="bshaper_edit_module"><?php _e('Edit module', 'mvb') ?></a>
            <a href="#" class="bshaper_delete_module"><?php _e('Delete module', 'mvb') ?></a>
            <span class="mvb_module_handler">-</span>
        </div>
    </div>

    <div class="bshaper_sh">[<?php echo strtolower($settings['identifier']) ?> <?php echo $str_of_atts ?>]<?php echo $content ?>[/<?php echo strtolower($settings['identifier']) ?>]</div>
    <div class="clear"><!-- ~ --></div>
</div>