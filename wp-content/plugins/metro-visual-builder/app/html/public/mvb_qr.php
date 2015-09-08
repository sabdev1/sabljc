<?php if (!empty($effects)) {
	$cr_effect = ' cr-animate-gen"  data-gen="' . $effects . '" data-gen-offset="bottom-in-view';
} else {
	$cr_effect = '';
}

# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}
if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}

$id = uniqid('qr_code_');

?>

<div class="module module-qr <?php echo (!empty($css)) ? $css : ''; ?> <?php echo $cr_effect; ?>" <?php echo $addition_css_styles; ?>>
	
	<?php include(dirname(__FILE__).'/_title.php'); ?>
	
	<div id="<?php echo $id; ?>" class="qr_code left"></div>
	<div class="content">
		<?php if (!empty($icon_content)) : ?>
		<i class="<?php echo $icon_content; ?>"></i>
		<?php endif; ?>
		
		<?php echo $content; ?>
	</div>
	
	<script type="text/javascript">
		<?php if (!empty($qr_content)) : ?>
		jQuery(document).ready(function(){
			jQuery('#<?php echo $id; ?>').qrcode({width: 105, height: 105, text: "<?php echo $qr_content; ?>"});
		});
		<?php endif; ?>
	</script>
</div>
