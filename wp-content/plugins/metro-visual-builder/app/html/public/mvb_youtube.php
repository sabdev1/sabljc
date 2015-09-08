<?php

# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}
if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}

?><div class="bshaper_youtube_module <?php echo (!empty($css)) ? $css : ''; ?>"  <?php echo $addition_css_styles; ?>>
   
   <?php include(dirname(__FILE__).'/_title.php'); ?>
   
   <?php if( $width == '100%' AND $height == '100%' ):  ?>
         <div class="iframe_holder_responsive"><img class="ratio" src="<?php echo mvb_placeholder() ?>"/><iframe src="http://www.youtube.com/embed/<?php echo get_youtube_video_id($content) ?>" frameborder="0" allowfullscreen="<?php echo $allowfullscreen ?>"></iframe></div>
   <?php else: ?>
         <iframe src="http://www.youtube.com/embed/<?php echo get_youtube_video_id($content) ?>" frameborder="0" width="<?php echo $width ?>" height="<?php echo $height ?>" allowfullscreen="<?php echo $allowfullscreen ?>"></iframe>
   <?php endif; ?>
</div>