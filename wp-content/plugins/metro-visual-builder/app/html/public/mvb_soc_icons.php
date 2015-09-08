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
<div class="module module-soc-icons <?php echo (!empty($css)) ? $css : ''; ?>"  <?php echo $addition_css_styles; ?>>
    <?php include(dirname(__FILE__).'/_title.php');?>

	<div class="soc-icons">
		<?php crum_social_networks(true); ?>
	</div>
</div>