<?php if (!empty($effects)) {
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<?php

$preloader_class = (!empty($preloader)) ? 'sb-has-preloader' : '';
$start_height = ( !empty($preloader) && !empty($start_height) ) ? ' min-height: '.$start_height.'px; ' : '';


# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}

$addition_css_styles .= $start_height;

if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}

$uniqid = uniqid('module_shortcode_');
?>

<div class="module shortcode  <?php echo (!empty($css)) ? $css : ''; ?> <?php echo $cr_effect; ?> <?php echo $preloader_class; ?>" <?php echo $addition_css_styles; ?> id="<?php echo $uniqid; ?>">
	<?php if (!empty($preloader)): ?>
	<div class="sb-preloader">
		<ul class="sb-preloader-spinner"><li></li><li></li><li></li><li></li></ul>
	</div>
	<?php endif; ?>
	
	<?php include(dirname(__FILE__).'/_title.php'); ?>

	<?php echo mvb_parse_content_html($content, TRUE) ?>
</div>

<script type="text/javascript">
	jQuery(window).load(function() {
		var $module = jQuery('#<?php echo $uniqid; ?>');

		$module.animate({'min-height': 0}, 200);
		jQuery('.sb-preloader', $module).animate({
			'opacity': 0
		}, 200, function() {
			jQuery(this)
					.parent()
					.css('min-height', '0')
					.removeClass('sb-has-preloader')
					.end()
					.remove();
		});
	});
</script>