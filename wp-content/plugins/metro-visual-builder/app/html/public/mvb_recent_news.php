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

?>

<?php $unique_id = 'mrn-'.mt_rand(); ?>

<div class="module module-recent-news <?php echo (!empty($css)) ? $css : ''; ?>"  <?php echo $addition_css_styles; ?>>

	<?php include(dirname(__FILE__).'/_title.php'); ?>

	<div class="row">
	
		<div class="recent-news-list columns <?php echo (!empty($description)?'nine':'twelve'); ?>" <?php echo $addition_css_styles; ?> id="<?php echo $unique_id; ?>">
			<div class="recent-news-list-wrap">
			<?php 
			$the_query = null;
			$sticky = get_option( 'sticky_posts' );

			if (!empty($categories)) {
				$args = array(
					'category_name' => $categories,
					'posts_per_page' => -1,
					'ignore_sticky_posts' => 1,
					'post__not_in' => $sticky,
				);
			} else {
				$args = array(
					'posts_per_page' => -1,
					'ignore_sticky_posts' => 1,
					'post__not_in' => $sticky,
				);
			}
			?>

			<?php
			$the_query = new WP_Query($args);
			while ($the_query->have_posts()) :
				$the_query->the_post();      
			?>

			<?php if (has_post_thumbnail()) : ?>

			<div class="item">
				<?php
				if (has_post_thumbnail()) {
					$thumb = get_post_thumbnail_id();
					$img_url = wp_get_attachment_url($thumb, 'medium'); //get img URL
				} else {
					$img_url = get_template_directory_uri() . '/img/no-image-large.jpg';
				}

				$article_image = aq_resize($img_url, 460, 380, true);
				?>

				<div class="entry-thumb entry-thumb-hover">
					<img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
					<a href="<?php the_permalink(); ?>" class="hover-link"></a>
				</div>

				<div class="box-name">
					<a href="<?php the_permalink(); ?>">
						<?php the_title(); ?>
					</a>
				</div>

				<?php get_template_part('templates/entry-meta', 'widget'); ?>
			</div>

			<?php endif; ?>

			<?php 
			endwhile;
			wp_reset_query(); 
			?>
			</div>
		</div>

		<?php if (!empty($description) && $description != '') : ?>
		<div class="recent-news-description columns three">
			<div class="recent-news-description-content">
				<?php echo wpautop($description); ?>
			</div>

			<?php if (!empty($show_link) && $show_link) : ?>
			<a class="read-more" href=""><?php echo ($link_title != '') ? $link_title : __('Read all news', 'mvb'); ?></a>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		
	</div>
	
	<script type="text/javascript">
	(function($){
		var $container = jQuery('#<?php echo $unique_id ?>');
		var sliderInit = function() {
//			var containerWidth = $container.width();
			var itemWidth = Math.round(870 / 3);

			if ($container.data('flexslider')) {
				$container.flexslider('destroy');
			}

			$container.flexslider({
				selector: ".recent-news-list-wrap > .item",
				namespace: "recent-news-",
				animation: "slide",
				animationLoop: true,
				direction: "horizontal",
				itemWidth: itemWidth,
				itemMargin: 20,
				minItems: 1,
				maxItems: 3,
				move: 1,
				slideshow: false,
				//controlsContainer: ".clients-list",
				controlNav: false,
				directionNav: true,
				prevText: "",
				nextText: ""
			});
		};
		
		jQuery(document).ready(sliderInit);
		jQuery(window).resize(sliderInit);
	})(jQuery);
	</script>
</div>
