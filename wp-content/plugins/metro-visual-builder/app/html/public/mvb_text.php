<?php
if (!empty($effects)) {
	$cr_effect = ' cr-animate-gen"  data-gen="' . $effects . '" data-gen-offset="bottom-in-view';
} else {
	$cr_effect = '';
}

$text_align = (!empty($text_align)) ? $text_align : '';

# Text align
$textwidget_class = 'textwidget ' . mvb_get_align_class($text_align);

# Drop Caps
if (isset($dropcaps_enable) && $dropcaps_enable==1) {
	$dropcaps_types = MVB_Text::dropcaps_types();
	$dropcaps_styles = MVB_Text::dropcaps_styles();

	if (empty($dropcaps_type)) {
		$dropcaps_type = $dropcaps_types[0];
	}

	if (empty($dropcaps_style)) {
		$dropcaps_style = $dropcaps_styles[0];
	}

	$textwidget_class .= " dropcaps dropcaps-type-{$dropcaps_type} dropcaps-style-{$dropcaps_style} ";
}

# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}
if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}


?>

<div class="module module-text <?php echo (!empty($css)) ? $css : ''; ?> <?php echo $cr_effect; ?>" <?php echo $addition_css_styles; ?>>

	<?php include(dirname(__FILE__) . '/_title.php'); ?>

    <div class="<?php echo $textwidget_class; ?>">
		<?php echo mvb_parse_content($content, true) ?>
    </div>

</div>
