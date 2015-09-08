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

<div class="testimonials_module <?php echo (!empty($css)) ? $css : ''; ?> <?php echo $cr_effect; ?>"  <?php echo $addition_css_styles; ?>>

    <?php include(dirname(__FILE__).'/_title.php'); ?>

    <div id="<?php echo $unique_id ?>">

        <div class="testimonials-slide">
			<?php if(!empty($r_items)): ?>
			<ul <?php if (count($r_items) === 1) echo 'class="one-item"'?>>
				<?php foreach ($r_items as $item):
				if (isset($item['link_url']) && $item['link_url'] != '') {
					$_link = $item['link_url'];
				} elseif (isset($item['page_id']) && is_numeric($item['page_id']) && $item['page_id'] > 0) {
					$_link = get_page_link($item['page_id']);
				} else {
					$_link = null;
				}
				?>

                <li class="testimonials_item">

					<div class="left">
						<div class="avatar">
							<?php
							if (isset($item['image']) && $item['image']) {
								$img_url = wp_get_attachment_url($item['image']);
								$article_image = aq_resize($img_url, 200, 80, true);
							?>

							<img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>">

							<?php } ?>
						</div>
						
						<div class="cite">
							<?php if (isset($item['main_title']) && $item['main_title']): ?>
								<span class="quote-author box-name"><?php echo $item['main_title']; ?></span>
							<?php endif;

							if (isset($item['client_job']) && $item['client_job']): ?>
								<span class="quote-sub dopinfo"><?php echo $item['client_job']; ?></span>
							<?php endif; ?>
						</div>
					</div>
					<div class="right">
						<blockquote>
							<?php echo mvb_parse_content($item['content']) ?>
						</blockquote>
						<?php if(!empty($_link)): ?>
						<p class="text-center">
							<a href="<?php echo $_link; ?>" class="read-more">Read more link</a>
						</p>
						<?php endif; ?>
					</div>
                </li>

            <?php endforeach;
				endif; ?>
			</ul>
        </div>
		<div class="testimonials-pagination"></div>
    </div>
    <?php if (!empty($r_items) && count($r_items) > 1): ?>

		<script type="text/javascript">
			(function($) {
				var $container = $('#<?php echo $unique_id ?>');
				var $jcarousel = $('.testimonials-slide', $container);
				var $jpagination = $('.testimonials-pagination', $container);
				var jtimerid;

				var bindNav = function() {
					if ($jpagination.find('.testimonials-control').length > 0) return;
					$jpagination
							.prepend('<a href="#prev" class="testimonials-control-prev testimonials-control">previous</a>')
							.append('<a href="#prev" class="testimonials-control-next testimonials-control">next</a>');

					$('.testimonials-control-prev', $container)
						.jcarouselControl({
							carousel: $jcarousel,
							target: '-=1'
						});

					$('.testimonials-control-next', $container)
						.jcarouselControl({
							carousel: $jcarousel,
							target: '+=1'
						});
				};

				jQuery(window).load(function(){
					$jcarousel
						.on('jcarousel:reload jcarousel:create', function () {
							var width = $jcarousel.innerWidth();

							if (width >= 800) {
								width = width / 2;
							}

							$jcarousel.jcarousel('items').css('width', width + 'px');

							if (jtimerid) clearTimeout(jtimerid);
							jtimerid = setTimeout(bindNav, 200);
						})
						.jcarousel({
							wrap: 'circular'
						});

					$jpagination
						.on('jcarouselpagination:createend jcarouselpagination:reloadend', bindNav)
						.on('jcarouselpagination:active', 'a', function() {
							$(this).addClass('active');
						})
						.on('jcarouselpagination:inactive', 'a', function() {
							$(this).removeClass('active');
						})
						.on('click', function(e) {
							e.preventDefault();
						})
						.jcarouselPagination({
							carousel: $jcarousel,
							perPage: 1,
							item: function(page) {
								return '<a href="#' + page + '" class="testimonials-nav-item">' + page + '</a>';
							}
						});
				});
			})(jQuery);
	</script>
    <?php endif; ?>

</div>
