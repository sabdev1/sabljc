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

$box_styles = array_keys(MVB_Message_Boxes::styles());
$box_style = (!empty($box_style) && in_array($box_style, $box_styles)) ? 'boxed-content-style-'.$box_style : 'boxed-content-style-'.$box_styles[0];

$icon = '';
if (isset($message_icon) && !empty($message_icon)) {
	$icon = '<i class="'.$message_icon.' boxed-content-icon"></i>';
}
?>

<div class="module module-message-boxes <?php echo (!empty($css)) ? $css : ''; ?> <?php echo $cr_effect; ?>" <?php echo $addition_css_styles; ?>>

    <?php include(dirname(__FILE__).'/_title.php'); ?>

    <div class="boxed-content <?php echo $box_style; ?>">
        <?php echo $icon; ?> <?php echo mvb_parse_content($content, true) ?>
    </div>


</div>
