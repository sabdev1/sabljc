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
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}

?>

<div class="to-action-block row  <?php echo (!empty($css)) ? $css : '' ?> <?php echo $cr_effect; ?>"  <?php echo $addition_css_styles; ?>>
	
	<?php include(dirname(__FILE__).'/_title.php');?>

    <?php if (!empty($link_url) && !empty($button_text)){
        echo '<div class="nine columns text-holder">';
    } else {
        echo '<div class="twelve columns text-holder">';
    } ?>
	
    <?php if ($content): ?>
        <div class="block-title">
            <?php echo mvb_parse_content($content, TRUE) ?>
        </div>
    <?php endif; ?>

    <?php if ($description): ?>
        <div class="block-description">
            <?php echo mvb_parse_content($description, TRUE) ?>
        </div>
    <?php endif; ?>


    <?php echo '</div>'; ?>

    <?php if (!empty($link_url) && !empty($button_text)): ?>
        <div class="three columns">
            <a href="<?php echo $link_url ?>" class="button <?php echo (!empty($icon)) ? 'button-icon' : ''; ?>"

                <?php if (!empty($new_tab)): ?> target="_blank"<?php endif; ?>>

                <?php if (!empty($icon)) : ?><span class="icon <?php echo $icon; ?>"></span><?php endif; ?>
                <?php echo $button_text ?>

            </a>
        </div>
    <?php endif; ?>

</div>