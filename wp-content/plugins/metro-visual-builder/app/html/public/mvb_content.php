<?php

# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}
if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}


?><div class="bshaper_content_module <?php echo (!empty($css)) ? $css : ''; ?>"  <?php echo $addition_css_styles; ?>>

	<?php include(dirname(__FILE__) . '/_title.php'); ?>

	<div class="bshaper_text">
		<?php echo wpautop(do_shortcode($post->post_content)); ?>
	</div>
</div>