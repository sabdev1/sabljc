<?php

function mvb_get_image_sizes( $_selected = 'square' )
{
    return array('square' => 'Square', /*'circle' => 'Circle',*/ 'wide' => 'Wide', 'ultra-wide' => 'Ultra-wide', 'panoramic' => 'Panoramic', '6:4' => '6:4', 'auto' => 'Auto');
}//end mvb_get_image_sizes

function mvb_icons( $_selected = 'suitcase' )
{
    $items = array('', 'suitcase', 'user-md', 'quote-right', 'bar-chart'); 
    $str = '';

    foreach( $items as $val )
    {
        $val == $_selected ? $t = ' selected="selected"' : $t = '';

        $str .= '<option value="'.$val.'"'.$t.'>'.$val.'</option>';
    }//endforeach

    return $str;

}//end mvb_icons

function mvb_get_select_options( $options = array(), $_selected = '' )
{
    if( empty($options) )
    {
        return '';
    }

    $str = '';

    foreach( $options as $h => $lbl )
    {
        $h == $_selected ? $t = ' selected="selected"' : $t = '';

        $str .= '<option value="'.$h.'"'.$t.'>'.$lbl.'</option>';
    }//endforeach

    return $str;

}//end mvb_get_select_options

function mvb_get_bgrepeat()
{
    return array(
        ''              =>      __('None', 'mvb'),
        'repeat'        =>      __('repeat', 'mvb'),
        'no-repeat'     =>      __('no-repeat', 'mvb'),
        'repeat-y'      =>      __('repeat-y', 'mvb'),
        'repeat-x'      =>      __('repeat-x', 'mvb'),
    );
}//end mvb_get_bgrepeat();

function crum_get_padding()
{
    return array(
        'medium-padding'     =>      __('Medium', 'mvb'),
        'extra-small-padding'=>      __('Extra Small', 'mvb'),
        'small-padding'      =>      __('Small', 'mvb'),
        'large-padding'      =>      __('Large', 'mvb'),
        'more-medium-padding'=>      __('Normal', 'mvb'),
        'no-padding'         =>      __('None', 'mvb'),
        ''                   =>      __('Default', 'mvb'),
    );
}

function dfd_get_background_check() {
	return array(
		'' => __('Default', 'mvb'),
		'background--dark' => __('Dark', 'mvb'),
//		'background--red'	=>	__('Red', 'mvb'),
	);
}

function crum_get_bgattachment()
{
    return array(
        'scroll'            =>      __('Normal', 'mvb'),
        'fixed'             =>      __('Fixed', 'mvb'),
        'parallax'          =>      __('Parallax', 'mvb'),
    );
}//end mvb_get_bgrepeat();

function crum_get_chart_size()
{
    return array(
        'normal'            =>      __('Normal', 'mvb'),
        'large'             =>      __('Large', 'mvb'),
    );
}

function crum_get_align() {
	return array(
		'left' => __('Left', 'mvb'),
		'right' => __('Right', 'mvb'),
	);
}

function crum_get_align_ext() {
	return array(
		0 => __('Default', 'mvb'),
		'left' => __('Left', 'mvb'),
		'right' => __('Right', 'mvb'),
		'center' => __('Center', 'mvb'),
	);
}

function crum_get_valign()
{
    return array(
        'vertical'            =>      __('Vertical', 'mvb'),
        'horizontal'          =>      __('Horizontal', 'mvb'),
    );
}

function crum_get_position()
{
    return array(
        'top'            =>      __('Top', 'mvb'),
        'bot'         =>      __('Bottom', 'mvb'),
    );
}

function crum_appear_effects() {
    return array(
        '0'                   =>     'None',

        '-'                   =>     '-----',

        'flash'               =>     'Flash',
        'shake'               =>     'Shake',
        'bounce'              =>     'Bounce',
        'tada'                =>     'TaDa',
        'swing'               =>     'Swing',
        'wobble'              =>     'Wobble',
        'wiggle'              =>     'Wiggle',
        'pulse'               =>     'Pulse',
        'hinge'               =>     'Hinge',

        '--'                   =>     '-----',

        'flip'                =>     'Flip',
        'flipInX'             =>     'Flip In by X',
        'flipOutX'            =>     'Flip Out by X',
        'flipInY'             =>     'Flip In by I',
        'flipOutY'            =>     'Flip Out by Y',

        '---'                   =>     '-----',

        'fadeIn'                =>     'Fade In',
        'fadeInUp'              =>     'Fade In Up',
        'fadeInDown'            =>     'Fade In Down',
        'fadeInLeft'            =>     'Fade In left',
        'fadeInRight'           =>    'Fade In Right',
        'fadeInUpBig'           =>    'Fade In Up Big',
        'fadeInDownBig'         =>   'Fade In Down Big',
        'fadeInLeftBig'         =>    'Fade In Left Big',
        'fadeInRightBig'        =>    'Fade In Right Big',

        '-----'                   =>     '-----',

        'bounceIn'                =>     'Bounce In',
        'bounceInUp'              =>     'Bounce In UP',
        'bounceInDown'            =>     'Bounce In Down',
        'bounceInLeft'            =>     'Bounce In Left',
        'bounceInRight'           =>     'Bounce In Right',

        '--------'                =>     '-----',

        'rotateIn '               =>     'Rotate In',
        'rotateInUpLeft'          =>     'Rotate In UP Left',
        'rotateInUpRight'         =>     'Rotate In UP Right',
        'rotateInDownLeft'        =>     'Rotate In Down Left',
        'rotateInDownRight'       =>     'Rotate In Down Right',

        '---------'               =>     '-----',

        'lightSpeedIn'            =>     'Light Speed In',

        '-----------'             =>     '-----',

        'rollIn'                  =>     'RollIn'


    );
}

function mvb_get_bgposition()
{
    return array(
        ''                           =>      __('None', 'mvb'),
        'left top'                   =>     'left top',
        'left center'                =>     'left center',
        'left bottom'                =>     'left bottom',
        'right top'                  =>     'right top',
        'right center'               =>     'right center',
        'right bottom'               =>     'right bottom',
        'center top'                 =>     'center top',
        'center center'              =>     'center center',
        'center bottom'              =>     'center bottom'
    );
}//end mvb_get_bgposition();

function mvb_get_col_span()
{
    return array(1 => 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
}//end mvb_get_col_span()

function mvb_get_col_span_small()
{
    return array(1 => 1, 2, 3, 4);
}//end mvb_get_col_span()

function dfd_tumbnail_transform() {
	return array(
		'' => __('None', 'mvb'),
		'avatar_parallelogram' => __('Parallelogram', 'mvb'),
	);
}

function mvb_homeboxes_icons()
{
    $icons = array('servPulse' => 'servPulse', 'servArrowsIn' => 'servArrowsIn', 'servArrowsOut' => 'servArrowsOut', 'servGift' => 'servGift', 'servDesign' => 'servDesign', 'servDevelopment' => 'servDevelopment', 'servPower' => 'servPower', 'servDevices' => 'servDevices', 'servEcommerce' => 'servEcommerce', 'servGlobe' => 'servGlobe', 'servGraph' => 'servGraph', 'servHelp' => 'servHelp', 'servList' => 'servList', 'servPhoto' => 'servPhoto', 'servPiechart' => 'servPiechart', 'servSecurity' => 'servSecurity', 'servSupport' => 'servSupport', 'servRadioactive' => 'servRadioactive', 'servTime' => 'servTime', 'servVideo' => 'servVideo', 'servWheels' => 'servWheels');
    //return mvb_get_select_options($icons, $selected);
    return $icons;
}//end mvb_homeboxes_icons()

function mvb_get_select_cpt_options( $options, $_selected = '' )
{
    if( empty($options) )
    {
        return '';
    }

    $str = '';

    while( $options->have_posts() )
    {
        $options->the_post();
        get_the_ID() == $_selected ? $t = ' selected="selected"' : $t = '';

        $str .= '<option value="'.get_the_ID().'"'.$t.'>'.get_the_title().'</option>';
    }//endwhile

    return $str;

}//end mvb_get_select_cpt_options

function mvb_get_select_options_multi( $what = '', $_selected = '' )
{
    $args = array(
        'type' => 'post',
        'hide_empty' => 0
    );

    $args['taxonomy'] = $what;
    $categories = get_categories( $args);

    $str = '';

    $_selected = explode(',', $_selected);

    foreach( $categories as $category )
    {
        in_array($category->slug, $_selected) ? $t = ' selected="selected" ' : $t = ' ';


        $str .= '<option value="'.$category->slug.'"'.$t.' data-sortby="'.array_search($category->slug, $_selected).'">'.$category->name.'</option>';
    }//endforeach

    return $str;

}//end mvb_get_select_options_multi

function mvb_get_cpt_select_options_multi( $what = '', $_selected = array() )
{
    $args = array(
        'hide_empty' => 0,
        'posts_per_page' => 999
    );

    $args['post_type'] = $what;
    query_posts( $args);

    $str = '';

    while( have_posts() )
    {
        the_post();
        in_array(get_the_ID(), $_selected) ? $t = ' selected="selected" ' : $t = ' ';


        $str .= '<option value="'.get_the_ID().'"'.$t.' data-sortby="'.array_search(get_the_ID(), $_selected).'">'.get_the_title().'</option>';
    }//endwhile
    wp_reset_query();

    return $str;

}//end mvb_get_cpt_select_options_multi()

function mvb_get_headings( $_selected = 'h3' )
{
    return array('h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6');
}//end mvb_get_headings

function mvb_get_pinterest_styles( $_selected = 'follow-me-on-pinterest-button.png' )
{
    $_styles = array('http://passets-lt.pinterest.com/images/about/buttons/follow-me-on-pinterest-button.png', 'http://passets-lt.pinterest.com/images/about/buttons/pinterest-button.png', 'http://passets-lt.pinterest.com/images/about/buttons/big-p-button.png', 'http://passets-lt.pinterest.com/images/about/buttons/small-p-button.png');

    return $_styles;

}//end mvb_get_pinterest_styles

function mvb_yes_no( $_selected = 0 )
{
    return array(1 => __('Yes', 'mvb'), 0 => __('No', 'mvb'));
}//end mvb_yes_no

function mvb_yes_no_both( $_selected = 0 )
{
	return array(1 => __('Yes', 'mvb'), 0 => __('No', 'mvb'), 2 => __('Both', 'mvb'));
}//end mvb_yes_no_both

function crum_align( $_selected = 0 )
{
    return array(1 => __('Align left', 'crum'), 0 => __('Align top', 'crum'));
}//end mvb_yes_no



function mvb_widgetareas( $_selected = '' )
{

    $_options = get_option('bs_widget_areas');
    if( !is_array($_options) OR empty($_options) )
    {
        return '';
    }//endif;

    $str = '';

    foreach( $_options as $_area )
    {
        $_area['unique_id'] == $_selected ? $t = ' selected="selected"' : $t = '';

        $str .= '<option value="'.$_area['unique_id'].'"'.$t.'>'.$_area['name'].'</option>';
    }//endforeach

    return $str;

}//end mvb_widgetareas

function br2nl($str) {
   $str = preg_replace("/(\r\n|\n|\r)/", "", $str);
   return preg_replace("=<br */?>=i", "\n\n", $str);
}//end br2nl()

function bs_prepare_form($text)
{
    return esc_textarea(html_entity_decode(stripslashes($text)));
}//end bs_prepare_form()

function bs_raw_html($text)
{
    return esc_textarea(html_entity_decode(stripslashes($text)));
}//end bs_raw_html()

function mvb_get_cpts( $cpt_type )
{
    $args = array( 'post_type' => $cpt_type );
    return new WP_Query( $args );
}//end mvb_get_cpts()

function dfd_sidebar_list() {
	$arr = array();
	if (class_exists('SMK_Sidebar_Generator')){

		$the_sidebars = smk_get_all_sidebars();

		if( is_array($the_sidebars) ){
			$select_str = __('-- Select a sidebar --', 'crum');
			$the_sidebars = array_merge(
								array('' => $select_str),
								$the_sidebars
							);
		}

		foreach ($the_sidebars as $key => $value) {
			$arr[$key] = $value;
		}

	} else {
		$arr[] = __('Please install SMK Sidebar Generator plugin in Apperance -> Install plugins','crum');
	}

	return $arr;
}

function mvb_boxed_content_styles() {
	return array(
		'' => __('Default', 'mvb'),
		'gray' => __('Gray', 'mvb'),
		'red' => __('Red', 'mvb'),
		'dark' => __('Dark', 'mvb'),
	);
}

function mvb_base64_encode($data='') {
	if (empty($data))
		return $data;
	
	return '?='.base64_encode(str_replace(array('"', "'"), array('&quot;', '&#039;'), stripslashes($data)));
}

function mvb_base64_decode($data='') {
	if (preg_match('/^\?=/', $data)) {
		return base64_decode(preg_replace('/^\?=/', '', $data));
	} else {
		return $data;
	}
}

function mvb_icon_background_type() {
	return array(
		'' => __('No', 'mvb'),
		'square' => __('Square', 'mvb'),
		'circle' => __('Circle', 'mvb'),
		'hexagon' => __('Hexagon', 'mvb'),
	);
}

function mvb_replace_field($fields, $field_name, $new_field) {
	if (empty($field_name)) {
		return $fields;
	}
	
	if (!is_array($fields)) {
		return $fields;
	}
	
	$out = array();
	foreach ($fields as $field_key=>$field_value) {
		if (!isset($fields[$field_key]['fields'])) {
			if ($field_key === $field_name 
					&& isset($field_value['custom']) 
					&& $field_value['custom'] === true) {
				unset($fields[$field_key]);
				$out = array_merge($out, $new_field);
			} else {
				$out[$field_key] = $field_value;
			}
		} else {
			$out[$field_key] = $fields[$field_key];
			$out[$field_key]['fields'] = array();
			
			foreach ($fields[$field_key]['fields'] as $child_field_key=>$child_field_value) {
				if ($child_field_key === $field_name 
						&& isset($child_field_value['custom'])
						&& $child_field_value['custom'] === true) {
					$out[$field_key]['fields'] = array_merge($out[$field_key]['fields'], $new_field);
				} else {
					$out[$field_key]['fields'][$child_field_key] = $child_field_value;
				}
			}
		}
	}
	
	return $out;
}