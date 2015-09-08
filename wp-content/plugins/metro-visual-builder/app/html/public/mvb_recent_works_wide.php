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

<?php 
	$uniqid = uniqid('rww_dn_');
?>

<div class="module recent-block-wide  <?php echo (!empty($css)) ? $css : ''; ?> <?php echo $cr_effect; ?>" <?php echo $addition_css_styles; ?>>
<?php if (!isset($simple_mode) || !$simple_mode): ?>
	<div class="row">
		<div class="column twelve">
			<?php include(dirname(__FILE__).'/_title.php');?>
		</div>
		
		<ul id="<?php echo $uniqid; ?>" class="flex-direction-nav"></ul>
	</div>
<?php endif; ?>

	<div class="recent-block-wide-container">
		<div class="recent-block-wide-wrap">
			<ul class="recent-block-wide-list">

				<?php
				$i = 0;

				$args = array(
					'post_type' => 'my-product'
				);

				$the_query = new WP_Query($args);
				while ($the_query->have_posts()) : $the_query->the_post();

					if (has_post_thumbnail()) {
						$thumb = get_post_thumbnail_id();
						$img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
					} else {
						$img_url = get_template_directory_uri() . '/img/no-image-large.jpg';
					}

					$article_image = aq_resize($img_url, 400, 280, true);

				?>

				<li class="recent-works-item recent-block-wide-item <?php echo ($i > 0 && $i < 4) ? '' : ''/* 'with-mask'*/; ?>">
					<?php /* <div class="mask"></div> */ ?>
					<div class="entry-thumb">
						<img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>" />
					</div>
					
					<?php get_template_part('templates/portfolio/entry-meta'); ?>
				</li>

				<?php
				$i++;

				endwhile;
				?>
			</ul>
		</div>
	</div>
	
</div>

<script type="text/javascript">
	(function($){
		
		$(window).load(function() {
			var $window = $(this);
			var items_on_screen;
			
			var $module_container = $('.recent-block-wide');
			var $wrap = $module_container.find('.recent-block-wide-wrap');
			var $list = $wrap.find('.recent-block-wide-list');
			var item_width;
			var wrapTimeID;
			var $slider_el = $('.recent-block-wide-wrap');
			var $prev = $('<li><a href="#" class="flex-prev"></a></li>');
			var $next = $('<li><a href="#" class="flex-next"></a></li>');
			
			var setSizes = function(resize) {
				if ($window.width()>800) {
					items_on_screen = 3;
				} else {
					items_on_screen = 2;
				}
				var screen_width = $('.header-wrap > .row > .columns.twelve').outerWidth() - (10 * 2);
				item_width = Math.floor(screen_width / items_on_screen);
				var wrap_width = Math.floor(item_width * (items_on_screen+2));
				var wrap__offset = Math.floor( (wrap_width - $module_container.width()) / 2 );
				
				$wrap.css({
					width: wrap_width,
					left: -wrap__offset
				});
				
				if (resize != undefined && resize == true) {
					<?php if ($slideshow) : ?>
						$slider_el.jcarouselAutoscroll('stop');
						$slider_el.jcarousel('scroll', 0);
						$slider_el.jcarouselAutoscroll('start');
					<?php endif; ?>
				}
				
				$wrap.find('.recent-block-wide-item').width(item_width);
			}
			
			var initSlider = function() {
				
				$slider_el
					.on('jcarousel:createend', function(event, carousel) {
						$('#<?php echo $uniqid; ?>').append($prev).append($next);
						$prev.jcarouselControl({target: '-=1'});
						$next.jcarouselControl({target: '+=1'});
						
						<?php if ($slideshow) : ?>
							$list.find('.recent-block-wide-item').hover(function() {
								$slider_el.jcarouselAutoscroll('stop');
							}, function() {
								$slider_el.jcarouselAutoscroll('start');
							});
						<?php endif; ?>
					})
					.jcarousel({
						wrap: 'circular',
						transitions: true
					});

				<?php if ($slideshow) : ?>
				$slider_el.jcarouselAutoscroll({
					interval: <?php if (!empty($slideshow_speed) && is_numeric($slideshow_speed)) { echo intval($slideshow_speed); } else { echo 3000; } ?>,
					target: '+=1',
					autostart: true
				});
				<?php endif; ?>
			};
			
			setSizes();
			initSlider();
			
			$(window).resize(function() {
				if (wrapTimeID) {
					clearTimeout(wrapTimeID);
				}

				wrapTimeID = setTimeout(function(){
					setSizes(true);
				}, 200);
			});
			
		});
		
	})(jQuery);
</script>
