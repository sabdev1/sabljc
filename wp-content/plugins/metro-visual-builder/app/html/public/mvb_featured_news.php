<?php if (!empty($effects)) {
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
} ?>

<?php

$link_label = (!empty($link_label)) ? $link_label : '';

# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}
if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}

?>

<div class="module module-sticky-news <?php echo (!empty($css)) ? $css : ''; ?> <?php echo $cr_effect; ?>"  <?php echo $addition_css_styles; ?> >

    <?php include(dirname(__FILE__).'/_title.php');?>

    <div class="crum_stiky_news">

        <div class="row">

            <?php

            while (have_posts()) :    the_post(); ?>

                <div class="twelve columns">
                    <div class="blocks-label">
						
						<i class="moon-mic-3"></i>
						
                        <?php
                        if (!empty($link_url)) {

                            echo '<a href="' . $link_url . '">' . $link_label . '</a>';

                        } else {
                            echo $link_label;
                        }  ?>

                    </div>

                    <div class="blocks-text">
                        <p>
                            <a href="<?php the_permalink(); ?>"><?php echo mvb_wordwrap(get_the_excerpt(), $excerpt_length); ?></a>
                        </p>
                    </div>

                </div>

            <?php endwhile;

            wp_reset_query(); ?>

        </div>
    </div>
</div>