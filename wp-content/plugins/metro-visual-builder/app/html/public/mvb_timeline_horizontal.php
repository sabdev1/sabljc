<?PHP

# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}
if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}

?><div class="module timeline_module <?php echo (!empty($css)) ? $css : ''; ?>"  <?php echo $addition_css_styles; ?>>

    <?php include(dirname(__FILE__).'/_title.php'); ?>

	<div class="row">
		<div class="timeline-horizontal-before mobile-hide">
			<i class="<?php echo $icon; ?>"></i>
		</div>
		<div id="timeline<?php echo $uniqid; ?>" class="timeline-horizontal columns twelve">
			<ul id="dates<?php echo $uniqid; ?>" class="timeline-titles">
				<?php foreach($items as $i => $item): ?>
					<li>
						<a href="#<?php echo $i.$uniqid; ?>">
							<?php echo $item['title']; ?>
							<span class="lead"><?php echo $item['subtitle']; ?></span>
							<span class="dot"></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
				
			<?php /* <div class="columns one timeline-horizontal-after mobile-hide"></div> */ ?>

			<div id="issues<?php echo $uniqid; ?>" class="timeline-items">
			<?php foreach($items as $i => $item): ?>
				<div id="<?php echo $i.$uniqid; ?>">
				
					<div class="row mvb_t_row" style="padding: 0px; margin: 0px;">
						<div class="twelve columns mobile-twelve mvb_first mvb_last">
							<div class="mvb_inner_wrapper">
									<?php echo $item['content']; ?>
							</div>
						</div>
					</div>
						
				</div>
			<?php endforeach; ?>
			</div>
		</div>
		
		<a href="#" id="next<?php echo $uniqid; ?>" class="timeline-nav timeline-nav-next">
			<i class="moon-checkmark"></i>
			<span><?php _e('Next date'); ?></span>
		</a>
		<a href="#" id="prev<?php echo $uniqid; ?>" class="timeline-nav timeline-nav-prev">
			<i class="moon-checkmark"></i>
			<span><?php _e('Prev date'); ?></span>
		</a>
		
	</div>
	
	<script type="text/javascript">
		jQuery(document).ready(function($){
			var Modernizr = window.Modernizr;
			var $issues = $('#issues<?php echo $uniqid; ?>');
			var _startAt = parseInt('<?php echo $animation_start_at; ?>');
			var initTimerlinr = function() {
				$('.testimonials-slide').trigger('jcarousel:reload');
				$().timelinr({
					orientation: 'horizontal',

					containerDiv: '#timeline<?php echo $uniqid; ?>',
					datesDiv: '#dates<?php echo $uniqid; ?>',
					issuesDiv : '#issues<?php echo $uniqid; ?>',
					prevButton: '#prev<?php echo $uniqid; ?>',
					nextButton: '#next<?php echo $uniqid; ?>',

					arrowKeys: 'false',

					datesSpeed: '<?php echo $animation_dates_speed; ?>',
					startAt: _startAt,

					afterItemActivate: function($item, settings) {
						jQuery('.testimonials-slide').trigger('jcarousel:reload');
						
						var $parent = $item.parent();

						$parent.siblings().removeClass('selected-parent');
						$parent.addClass('selected-parent');

						var index = $parent.parent().children().index($parent);
						_startAt = index + 1;
						
						var $issues = $(settings.issuesDiv);
						$issues.animate({
							height: $($issues.children().get(index)).height()
						}, 200);
					},
					issuesTransparency: 0
				});
			};
			
			var timelinrSetWidth = function(){
				$issues.find('.mvb_t_row').andSelf().css('width', $issues.parent().innerWidth() - 20);
				initTimerlinr();
			};

			timelinrSetWidth();
			$(window).load(timelinrSetWidth);
			
			if (Modernizr.touch) {
				$(window).on('orientationchange', timelinrSetWidth);
			} else {
				$(window).resize(timelinrSetWidth);
			}
		});
	</script>
</div>
