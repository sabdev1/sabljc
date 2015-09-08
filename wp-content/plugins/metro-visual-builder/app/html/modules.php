<div class="module_list">
<!--<h3><?php //_e('Available modules', 'mvb') ?></h3>-->

<ul class="bshaper_modules">
<?php foreach( $mvb_shortcodes as $section => $options ): ?>

<?php if( !empty($options['modules']) ): ?>
    <li class="bshaper_ml_title"><?php echo $options['title'] ?></li>

    <?php foreach( $options['modules'] as $mvb_class => $mvb_module ): ?>
	<li>
      <a href="#module" data-module="<?php echo $mvb_class ?>" class="<?php echo $mvb_module['class'] ?>">
          <span class="module_title"><?php echo $mvb_module['title'] ?></span>
          <span class="module_description"><?php echo $mvb_module['description'] ?></span>
      </a>
    </li>

    <?php endforeach; ?>
<?php endif; ?>
<?php endforeach; ?>
</ul>
<div class="clear"><!-- ~ --></div>
</div><!-- .module_list-->
<div class="clear"><!-- ~ --></div>

<div class="the_modules" style="display: none;">
    <a href="#" class="fa fa-angle-left bshaper_back_to_module_list"><?php //_e('go back', 'mvb') ?></a>
    <div id="bshaper_content_form_module"></div>
    <!-- #bshaper_content_form_module-->
</div>