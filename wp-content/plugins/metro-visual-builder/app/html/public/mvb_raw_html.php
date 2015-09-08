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

<div class="bshaper_vimeo_module <?php echo (!empty($css)) ? $css : ''; ?>" <?php echo $addition_css_styles; ?>>
   <?php include(dirname(__FILE__).'/_title.php'); ?>
   
   <?php echo mvb_parse_content_html($content) ?>
</div>