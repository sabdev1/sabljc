<?php

# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}
if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}

?>

<div class="bshaper_flickr_module <?php echo (!empty($css)) ? $css : ''; ?>"  <?php echo $addition_css_styles; ?>>
   <?php if(!empty($main_title)): ?>
   <<?php echo (!empty($heading)) ? $heading : '' ?> class="modTitle"<?php if(!empty($heading_color)): ?> style="color: #<?php echo $heading_color ?>"<?php endif; ?>>
              <?php echo $main_title ?>
   </<?php echo (!empty($heading)) ? $heading : '' ?>>
   <?php endif; ?>

   <div class="flickr_sh">
       <div id="<?php echo (!empty($unique_id)) ? $unique_id : '' ?>" class="mvb_row"></div>
       <script type="text/javascript">
          jQuery(function($){
              var the_width = Math.floor(jQuery('#<?php echo (!empty($unique_id)) ? $unique_id : '' ?>').width() / 3 );

              $('#<?php echo (!empty($unique_id)) ? $unique_id : '' ?>').jflickrfeed({
              	limit: <?php echo (!empty($no_of_photos)) ? $no_of_photos : '' ?>,
              	qstrings: {
              		id: '<?php echo (!empty($username)) ? $username : '' ?>'
              	},
              	itemTemplate: '<div class="mvbc-<?php echo (!empty($mod_nr_of_columns)) ? $mod_nr_of_columns : ''; ?> mvb-col"><div class="imgWrap"><a href="{{image}}" data-rel="prettyPhoto[flickr_<?php echo (!empty($unique_id)) ? $unique_id : '' ?>]"><img src="{{image_s}}" alt="{{title}}" /></a></div></div>'
              }, function(data) {
              	if (!jQuery.browser.msie && typeof('prettyPhoto') == "function")
                  {
            		jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
						hook: 'data-rel',
            			theme:'dark_rounded',
            			overlay_gallery: false,
            			show_title: true
            		});
                  }//endif
                  return false;
              });

          });
      </script>
    </div>
    <?php if(!empty($view_profile_text)): ?>
        <div class="clear"><!-- ~ --></div>
        <a href="http://www.flickr.com/photos/<?php echo (!empty($username)) ? $username : '' ?>" target="_blank" class="bshaper_button"><?php echo $view_profile_text ?></a>
    <?php endif; ?>
</div>