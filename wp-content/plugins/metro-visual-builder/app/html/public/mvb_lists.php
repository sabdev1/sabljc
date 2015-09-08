<?php
$module_clas = (!empty($css)) ? $css : '';

# Addition CSS styles
$addition_css = '';

if (!empty($css_styles)) {
	$addition_css = 'style="'. $css_styles .'"';
}

$default_icon_html = '';

if (!empty($default_icon)) {
	$default_icon_html = '<i class="module-lists-icon '.$default_icon.'"></i>';
}

?>
<div class="module module-lists <?php echo $module_clas; ?>" <?php echo $addition_css; ?>>
	<?php include(dirname(__FILE__).'/_title.php'); ?>

	<?php if (!empty($r_items)): ?>
	<div class="row">
		<div class="column twelve">
			
			<ul>
			<?php foreach($r_items as $item): extract($item);
			
				$icon_html = '';
				$item_class = '';

				if (!empty($item_icon)) {
					$icon_html = '<i class="module-lists-icon '.$item_icon.'"></i>';
				} else {
					$icon_html = $default_icon_html;
				}

				if (!empty($icon_html)) {
					$item_class = 'item-has-icon';
				}
			?>
				<li class="<?php echo $item_class; ?>"><?php echo $icon_html; ?><?php echo $list_text; ?></li>
			<?php endforeach; ?>
			</ul>
			
		</div>
	</div>
	<?php endif; ?>
</div>
