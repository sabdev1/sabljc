<h3 class="media-title"><?php _e('Choose section style', 'mvb') ?></h3>

<div class="bshaper_section_types">
    <?php foreach( $metro_admin_rows as $row_id => $row ): ?>
        <a href="#mvb_grid_<?php echo $row_id ?>" class="mvb_add_section_type" title="<?php echo $row['title'] ?>"><img src="<?php echo $app_url ?>assets/images/grid/<?php echo $row_id ?>.png" /></a>
    <?php endforeach; ?>
</div>

<ul style="display: none;" id="bs_sampler">
<?php foreach( $metro_admin_rows as $row_id => $row ): ?>
    <li class="row bshaper_row" id="mvb_grid_<?php echo $row_id ?>" data-mvb-bgcolor="" data-mvb-bgimage="" data-mvb-bgrepeat="" data-mvb-bgposition="" data-mvb-textcolor="" data-mvb-cssclass="" data-mvb-totop="" data-mvb-css="" data-mvb-row_full_height="" data-mvb-section-padding="" data-mvb-video_display="" data-mvb-video_repeat="" data-mvb-video_shadow="" data-mvb-video_poster="" data-mvb-video_mp4="" data-mvb-video_webm="" data-mvb-video_ogg="">
        <div class="bshaper_handler">
            <i class="awesome-move"></i> <?php _e('reorder rows', 'mvb') ?>
            <a href="#" class="mvb_row_settings"><?php _e('row settings', 'mvb') ?></a>
            <a href="#" class="mvb_delete_section"><?php _e('delete section', 'mvb') ?></a>
        </div>
        <div class="clear"><!-- ~ --></div>

        <?php $nc = count($row['columns']); ?>
        <?php $i = 1; ?>

        <?php foreach( $row['columns'] as $column ): ?>
          <div class="<?php echo $metro_admin_grid[$column] ?> columns<?php if( $i == 1 ): ?> mvb_first<?php endif; ?><?php if( $i == $nc ): ?> mvb_last<?php endif; ?>" data-columns="<?php echo $column ?>" data-mvb-bgcolor="" data-mvb-bgimage="" data-mvb-bgrepeat="" data-mvb-bgposition="" data-mvb-textcolor="" data-mvb-totop="" data-mvb-cssclass="<?php if( $i == 1 ): ?> mvb_first<?php endif; ?><?php if( $i == $nc ): ?> mvb_last<?php endif; ?>" data-mvb-css="" data-mvb-smallclass="4" data-mvb-paddtop="" data-mvb-paddright="" data-mvb-paddbottom="" data-mvb-paddleft="">
            <div class="mvb_column_actions">
              <a class="bshaper_add_module" href="#">+ <?php _e('Add module', 'mvb') ?></a>
              <a class="mvb_column_settings" href="#">+ <?php _e('Column settings', 'mvb') ?></a>
            </div>
          </div>
          <?php $i++; ?>
        <?php endforeach; ?>
        <div class="clear"><!-- ~ --></div>
    </li>
    <!-- //.row-->
<?php endforeach; ?>
</ul>