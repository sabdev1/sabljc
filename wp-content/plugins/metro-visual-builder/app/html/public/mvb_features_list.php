<?php 
$cols = (!empty($cols)) ? $cols : '';

switch($cols) {
	case 3:
		$item_class = 'four';
		break;
	case 2:
		$item_class = 'six';
		break;
	case 1:
	default:
		$item_class = 'twelve';
}

$style = '';


# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}
if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}

?>
<div class="module module-features-list <?php echo (!empty($css)) ? $css : ''; ?>"  <?php echo $addition_css_styles; ?>>

	<?php include(dirname(__FILE__).'/_title.php'); ?>

	<div class="row">
		
		<?php if (!empty($r_items)) : ?>
		
		<?php foreach($r_items as $item): ?>
		<?php
			$style = '';
			
			if (isset($item['color'])) {
				$style .= ' color: #' . $item['color'] . ';';
			}
			
			# Display Item Link
			$read_more = (isset($item['read_more'])) ? $item['read_more'] : '';
			if ($read_more) {

				if (isset($item['link_url'])) {
					$link_url = $item['link_url'];
				} elseif (isset($item['page_id']) && is_numeric($item['page_id']) && $item['page_id'] > 0) {
					$link_url = get_page_link($item['page_id']);
				} else {
					$read_more = false;
					$link_url = false;
				}
			}

			?>
			<div class="columns <?php echo $item_class; ?> <?php echo (isset($item['css'])) ? $item['css'] : ''; ?>" style="<?php echo $style; ?>">
				<div class="module-feature-box">
					
					<?php if ($read_more): ?>
					
						<a href="<?php echo $link_url; ?>">
							<?php echo (isset($item['main_title'])) ? $item['main_title'] : ''; ?>
						</a>
					
					<?php else: ?>

						<span>
							<?php echo (isset($item['main_title'])) ? $item['main_title'] : ''; ?>
						</span>
					
					<?php endif; ?>
					
				</div>
			</div>
		
		<?php endforeach; ?>
		
		<?php endif; ?>
		
		<?php
			# Read More Link
			if (!empty($display_read_more)) {

				if (!empty($page_id) && is_numeric($page_id) && $page_id > 0) {
					$link_url = get_page_link($item['page_id']);
				} elseif(empty($link_url)) {
					$link_url = false;
					$display_read_more = false;
				}
			}

		?>
		<?php if (!empty($display_read_more)): ?>
		<div class="columns twelve">
			<a href="<?php echo $link_url; ?>" class="read-more">
				<?php echo (!empty($read_more_text)) ? $read_more_text : ''; ?>
			</a>
		</div>
		<?php endif; ?>
		
	</div>
</div>
