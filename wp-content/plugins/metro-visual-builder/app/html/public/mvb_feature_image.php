<?php
if (!empty($effects)) {
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
}

# IMG Wrapper options
$link = '';

$image_align = (!empty($image_align)) ? $image_align : '';
$image = (!empty($image)) ? $image : '';
$main_title = (!empty($main_title)) ? $main_title : '';


if (!empty($link_url)) {
	$link = $link_url;
} elseif (!empty($page_id) && is_numeric($page_id) && $page_id > 0) {
	$link = get_page_link($page_id);
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

<div class="module feature-image-module <?php echo (!empty($css)) ? $css : ''; ?> <?php echo $cr_effect; ?>"  <?php echo $addition_css_styles; ?>>
	<?php //$image_align ?>
	<div class="row">
		<div class="column six <?php if(strcmp($image_align, 'right')===0): ?>push-six<?php endif; ?> text-center">
			<div class="img-wrap">
				<a href="<?php echo (!empty($link)) ? $link : ''; ?>" class="hover-link"></a>
				<img src="<?php echo mvb_get_image_url($image); ?>" alt= "<?php echo strip_tags($main_title); ?>" />
			</div>
		</div>
		<div class="column six <?php if(strcmp($image_align, 'right')===0): ?>pull-six text-right mobile-text-center<?php endif; ?>">
			<?php if (!empty($content)) : ?>
				<div class="content-wrap">
					<?php include(dirname(__FILE__).'/_title.php');?>

					<?php echo $content; ?>

					<?php if (!empty($read_more)) : ?>
						<div class="clear"></div>
						<a class="read-more" href="<?php echo (!empty($link)) ? $link : ''; ?>"><?php echo (!empty($read_more_text)) ? $read_more_text : ''; ?></a>
					<?php endif; ?>
				</div>
			<?php else : ?>
				<?php include(dirname(__FILE__).'/_title.php');?>
			<?php endif; ?>
		</div>	
	</div>
</div>