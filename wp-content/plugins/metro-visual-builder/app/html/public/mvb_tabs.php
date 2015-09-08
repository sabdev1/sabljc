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

<div class="tabs_module module <?php echo (!empty($css)) ? $css : ''; ?>"  <?php echo $addition_css_styles; ?>>

    <?php include(dirname(__FILE__).'/_title.php'); ?>

    <dl class="tabs horisontal clearfix">
        <?php $i = 1; ?>
        <?php foreach( $r_items as $item ): ?>
			<dt></dt>
            <dd <?php if( $i == '1'): ?> class="active"<?php endif; ?>><a href="#<?php echo $unique_id.'_'.$i ?>"><?php echo $item['tab_title'] ?></a></dd>
            <?php $i++; ?>
        <?php endforeach; ?>
    </dl>
    <ul class="tabs-content clearfix">
        <?php $i = 1; ?>
        <?php foreach( $r_items as $item ): ?>
            <li <?php if( $i == '1'): ?> class="active"<?php endif; ?> id="<?php echo $unique_id.'_'.$i ?>Tab"><?php echo mvb_parse_content($item['content'], TRUE) ?></li>
            <?php $i++; ?>
        <?php endforeach; ?>
    </ul>
</div>
