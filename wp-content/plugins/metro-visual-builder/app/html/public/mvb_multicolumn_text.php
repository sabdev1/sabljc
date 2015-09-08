<?php
if (!empty($effects)) {
	$cr_effect = ' cr-animate-gen"  data-gen="' . $effects . '" data-gen-offset="bottom-in-view';
} else {
	$cr_effect = '';
}

$text_align = (!empty($text_align)) ? $text_align : '';

# Text align
$textwidget_class = 'textwidget ' . mvb_get_align_class($text_align);

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

	<?php if (count($r_items) > 0): ?>
	<div class="row">
		<?php foreach($r_items as $item): ?>
			<?php extract($item); ?>
			<div class="columns <?php echo $text_columns_class; ?>">
				<?php include(dirname(__FILE__) . '/_title.php'); ?>

				<div class="<?php echo $textwidget_class; ?>">
					<?php echo mvb_parse_content($content, true) ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div>