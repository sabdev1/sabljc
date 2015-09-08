<?php

# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}
if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}

$uniq_id = uniqid('features_module_img_');

?>

<div id="<?php echo $uniq_id; ?>" class="features_module_img module <?php echo (!empty($css)) ? $css : ''; ?>"  <?php echo $addition_css_styles; ?>>

	<?php 
	$_link = '';
	?>
	
    <?php include(dirname(__FILE__).'/_title.php'); ?>

    <?php if (count($r_items) > 0): ?>
        <div class="row">
            <?php foreach ($r_items as $panel): ?>

                <?php if ($panel['effects']) {
                    $cr_effect = ' cr-animate-gen"  data-gen="' . $panel['effects'] . '" data-gen-offset="bottom-in-view';
                } else {
                    $cr_effect = '';
                } ?>

                <?php if ($panel['link_url'] != '') {

                    $_link = $panel['link_url'];

                } elseif (is_numeric($panel['page_id']) AND $panel['page_id'] > 0) {

                    $_link = get_page_link($panel['page_id']);

                }

                ?>

                <div class="<?php echo $column_number ?> columns feature-block-image <?php echo $cr_effect; ?>">

                    <?php
					
                    $img = mvb_aq_resize($panel['image'], 352);

                    $style = 'color: #' . $panel['color'] . ' ';

                    ?>

                    <div class="picture" style=" <?php echo $style; ?>">
                        <?php if ($panel['image']) {
							echo '<div class="picture-mask">';
                            echo '<img src="' . $img . '" alt="' . $panel['main_title'] . '" class="blurImage" >';
							echo '</div>';
                        } ?>

                        <?php if ($_link) {

                            echo '<a class="" href="' . $_link . '"> </a>';

                        }; ?>

                        <?php if (($panel['main_title']) || ($panel['sub_title'])) {
                            echo '<div class="feature-title">' . $panel['main_title'] . '';

                            if ($panel['sub_title']) {
                                echo '<div class="subtitle">' . $panel['sub_title'] . '</div>';
                            }
                            echo '</div>';
                        }
                        ?>

                    </div>

                    <?php if ($panel['content'] != ''): ?>
                        <div class="content">

                            <?php echo mvb_parse_content($panel['content'], TRUE); ?>
                        </div>
                    <?php endif; ?>


                </div>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
	wp_enqueue_script('feature-image-box-transform');
?>

<script type="text/javascript">
	jQuery(window).load(function() {
		jQuery('#<?php echo $uniq_id; ?>.features_module_img .row').featureImageBoxTransform({
			deg: -25,
			itemClass: '.feature-block-image',
			height: 215,
			margin_right: 18
		});
	});
</script>
