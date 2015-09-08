<?php if (!empty($effects)) {
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
}

# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}
if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="'.$addition_css_styles.'"';
}

$box_style = (!empty($box_style)) ? 'boxed-content-style-'.$box_style : 'boxed-content-style-default';
?>

<div class="module module-boxed-content <?php echo (!empty($css)) ? $css : ''; ?> <?php echo $cr_effect; ?>" <?php echo $addition_css_styles; ?>>

    <?php include(dirname(__FILE__).'/_title.php'); ?>

    <div class="boxed-content <?php echo $box_style; ?>">
        <?php echo mvb_parse_content($content, true) ?>
    </div>


</div>
