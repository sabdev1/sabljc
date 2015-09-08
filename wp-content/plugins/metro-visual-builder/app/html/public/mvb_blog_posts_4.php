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

<div class="module_posts-style-2 <?php echo (!empty($css)) ? $css : ''; ?>"  <?php echo $addition_css_styles; ?>>

    <?php include(dirname(__FILE__).'/_title.php');?>

    <?php


    if (!empty($categories)) {
        $args = array(
            'category_name' => $categories,
            'posts_per_page' => $no_of_posts,
            'ignore_sticky_posts' => 'true'
        );
    } else {
        $args = array(
            'posts_per_page' => $no_of_posts,
            'ignore_sticky_posts' => 'true'
        );
    }

    $the_query = new WP_Query($args);

    ?>
    <div class="post-list row">

        <?php

        while ($the_query->have_posts()) : $the_query->the_post(); ?>

            <article class="hentry medium-news clearfix columns four <?php echo $cr_effect; ?>">
                <?php

                if (has_post_thumbnail()) {
                    $thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url($thumb, 'thumb'); //get img URL
                    $article_image = aq_resize($img_url, 280, 185, true);
                    ?>
                    <div class="entry-thumb">
                        <img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
                        <a href="<?php the_permalink(); ?>" class="link"></a>
                    </div>

                <?php } ?>

                <div class="box-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
				
				<?php if (!empty($show_author) || !empty($show_date) || !empty($show_comments) ): ?>
					<div class="entry-meta dopinfo">
						<?php
						if (!empty($show_author)) {
							get_template_part('templates/entry-meta/mini', 'author');
							get_template_part('templates/entry-meta/mini', 'delim');
						}

						if (!empty($show_date)) {
							get_template_part('templates/entry-meta/mini', 'date');
						}

						if (!empty($show_comments)) {
							get_template_part('templates/entry-meta/mini', 'comments');
						}
						?>
					</div>
				<?php endif; ?>
				
				<div class="entry-summary">
                    <p><?php echo mvb_wordwrap(get_the_excerpt(), $excerpt_length); ?></p>
                </div>
				
				<a href="<?php the_permalink(); ?>" class="read-more"><?php _e('Read more info', 'mvb'); ?></a>

            </article>

        <?php endwhile; ?>

    </div>

    <?php wp_reset_postdata(); ?>

</div>
