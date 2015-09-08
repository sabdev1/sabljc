<?php 

$_icon_html = '';
$_icon_background_type = (!empty($icon_background_type)) ? $icon_background_type : '';
$_icon_background_color = (!empty($icon_background_color)) ? '#'.$icon_background_color : '';
$_icon_background_color_style = (!empty($icon_background_color)) ? 'background-color: #'.$icon_background_color.'; ' : '';
$_icon_background_color_hover = (!empty($icon_background_color_hover)) ? '#'.$icon_background_color_hover : '';

$_icon_style = ((!empty($icon_size)) ? 'font-size: '.$icon_size.'px; ' : '')
	.((!empty($icon_color)) ? 'color: #'.$icon_color.'; ' : '');

$_icon_color = (!empty($icon_color)) ? '#'.$icon_color : '';
$_icon_color_hover = (!empty($icon_color_hover)) ? '#'.$icon_color_hover : '';

$_icon_align = (!empty($icon_align)) ? $icon_align : '';

$_icon_class_name = 'mvb-icon';

switch ($_icon_background_type) {
	case 'square':
		$_icon_html = '<div class="'.$_icon_class_name.' '.$_icon_align.'">'
			. '<div class="square" style="'.$_icon_background_color_style.$_icon_style.'" data-color="'.$_icon_background_color.'" data-hover-color="'.$_icon_background_color_hover.'">'
			. '<i class="'.$icon.'" style="'.$_icon_style.'" data-color="'.$_icon_color.'" data-hover-color="'.$_icon_color_hover.'"></i></div></div>';
		break;
	case 'circle':
		$_icon_html = '<div class="'.$_icon_class_name.' '.$_icon_align.'">'
			. '<div class="circle" style="'.$_icon_background_color_style.$_icon_style.'" data-color="'.$_icon_background_color.'" data-hover-color="'.$_icon_background_color_hover.'">'
			. '<i class="'.$icon.'" style="'.$_icon_style.'" data-color="'.$_icon_color.'" data-hover-color="'.$_icon_color_hover.'"></i></div></div>';
		break;
	case 'hexagon':
		$_icon_html = '<div class="'.$_icon_class_name.' '.$_icon_align.'">'
			. '<div class="hexagon" style="'.$_icon_background_color_style.$_icon_style.'" data-color="'.$_icon_background_color.'" data-hover-color="'.$_icon_background_color_hover.'">'
				. '<div><i class="'.$icon.'" style="'.$_icon_style.'" data-color="'.$_icon_color.'" data-hover-color="'.$_icon_color_hover.'"></i></div>'
				. '<div>&nbsp;</div>'
				. '<div>&nbsp;</div>'
			. '</div></div>';
		break;
	default:
		$_icon_html = '<div class="'.$_icon_class_name.' '.$_icon_align.'" style="">'
			. '<i class="'.$icon.'" style="'.$_icon_style.'" data-color="'.$_icon_color.'" data-hover-color="'.$_icon_color_hover.'"></i></div>';
		break;
}


echo $_icon_html;

?>

<script type="text/javascript">
	jQuery('document').ready(function($) {
		$('.<?php echo $_icon_class_name; ?>').hover(function() {
			over($(this));
		}, function() {
			out($(this));
		});
		
		function over(el) {
			if (el == undefined) {
				return;
			}
			
			if (el.children()[0].tagName === 'DIV') {
				el = el.children();
			}
			
			var hover_background_color = el.data('hover-color');
			var icon = el.find('i');
			var hover_color = icon.data('hover-color');
			
			if (hover_background_color != undefined && hover_background_color != '') {
				el.css('background-color', hover_background_color);
			}
			
			if (hover_color != undefined && hover_color != '') {
				icon.css('color', hover_color);
			}
		}
		
		function out(el) {
			if (el == undefined) {
				return;
			}
			
			if (el.children()[0].tagName === 'DIV') {
				el = el.children();
			}
			
			var background_color = el.data('color');
			var icon = el.find('i');
			var color = icon.data('color');
			
			if (background_color != undefined && background_color != '') {
				el.css('background-color', background_color);
			}
			
			if (color != undefined && color != '') {
				icon.css('color', color);
			}
		}
	});
</script>