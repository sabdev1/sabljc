<?php

# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}
if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}

?><div class="vertical_tabs_module module <?php echo (!empty($css)) ? $css : ''; ?>"  <?php echo $addition_css_styles; ?>>

	<?php include(dirname(__FILE__).'/_title.php'); ?>

    <div class="row">
        <div class="five columns">
            <dl class="vertical tabs">

                <?php $i = 1; ?>
                <?php foreach ($r_items as $item): ?>

                    <dd <?php if ($i == '1'): ?> class="active"<?php endif; ?>>
                        <a href="#<?php echo $unique_id . '-' . $i ?>">
                            <?php /* <span class="icon"><i class="<?php echo $item['icon']; ?>"></i></span> */ ?>
                            <span class="tab-title"><?php echo esc_attr($item['tab_title']); ?></span>
                        </a>
                    </dd>

                    <?php $i++; ?>
                <?php endforeach; ?>

            </dl>
        </div>

        <div class="seven columns">
            <ul class="tabs-content">

                <?php $i = 1; ?>
                <?php foreach ($r_items as $item): ?>

                    <li <?php if ($i == '1'): ?> class="active"<?php endif; ?> id="<?php echo $unique_id . '-' . $i; ?>Tab">
                        <?php echo mvb_parse_content_html($item['content'], TRUE) ?>
                    </li>

                    <?php $i++; ?>
                <?php endforeach; ?>

            </ul>
        </div>
    </div>
</div>
