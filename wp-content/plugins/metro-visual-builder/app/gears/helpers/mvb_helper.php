<?php
function mvb_get_align_class($align = '') {
	switch ($align) {
		case 'left': return ' text-left';
		case 'right': return ' text-right';
		case 'center': return ' text-center';
		default:		
	}
	
	return '';
}

function mvb_parse_content( $content, $do_shortcode = false )
{
    $content = html_entity_decode(stripslashes($content), ENT_COMPAT, 'UTF-8');
    $content = str_ireplace('<br class="mvb_break">', "\n", $content);
    $content = wpautop($content);

   if( $do_shortcode )
        return do_shortcode($content);

   return $content;
}//end mvb_parse_content()

function mvb_parse_content_html($text, $do_shortcode = false)
{
    $text = html_entity_decode(stripslashes($text), ENT_COMPAT, 'UTF-8');
    $text = str_ireplace('<br class="mvb_break">', "\n", $text);

    //return esc_textarea($text);
    if( $do_shortcode )

        return do_shortcode($text);

    return $text;
}//end mvb_parse_content_html()

function mvb_special_content( $text, $separator = '' )
{
    $text = str_ireplace('+|+', $separator, $text);
    return $text;
}//end mvb_special_content()

function mvb_prepare_content_html($text)
{
    $text = str_ireplace("\n", '<br class="mvb_break">', $text);
    return esc_html($text);
}//end bs_prepare_form()

if( !function_exists('mvb_placeholder') )
{
    function mvb_placeholder( $what = 'empty' )
    {
        if( $what == 'empty' )
        {
            return MVB_URL.'/app/assets/images/empty/empty.png';
        }
    } //edn mvb_placeholder
}//endif

if( !function_exists('mvb_get_image_url') )
{
    function mvb_get_image_url($attach)
    {
        if( is_numeric($attach) AND $attach > 0 )
        {
            return wp_get_attachment_url($attach);
        }
        else
        {
            return $attach;
        }
    }//end mvb_get_image_url()
}//endif;

function mvb_image_formats( $size, $image_sizes )
{
    $sizes = array(
        'square' => 1,
        'wide' => 1.7,
        'ultra-wide' => 3,
        'panoramic' => 2,
        '6:4' => 1.5,
        'auto' => 0,
        'circle' => 1
    );

    if( $size == 'auto' )
    {
        return 0;
    }

    if( !isset($sizes[$size]) )
    {
        $size = "square";
    }

    $what = $sizes[$size];

    return ceil($image_sizes['max_width']/$sizes[$size]);

}//end mvb_image_formats()

function mvb_num_to_string( $str = 1)
{
    $arr = array(1 => 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve');

    if( isset($arr[$str]) )
    {
        return $arr[$str];
    }
    else
    {
        return 'six';
    }

}//end mvb_num_to_string();

function mvb_foundation_columns( $columns )
{
    $max_width = 960;

    $sizes = array(
        12 => array(
            'ratio' => 1,
            'numeral' => 12
        ),

        11 => array(
            'ratio' => 8.33333 / 100,
            'numeral' => 11
        ),

        10 => array(
            'ratio' => 83.33333 / 100,
            'numeral' => 10
        ),

        9 => array(
            'ratio' => 75 / 100,
            'numeral' => 9
        ),

        8 => array(
            'ratio' => 66.66667 / 100,
            'numeral' => 8
        ),

        7 => array(
            'ratio' => 58.33333 / 100,
            'numeral' => 7
        ),

        6 => array(
            'ratio' => 50 / 100,
            'numeral' => 6
        ),

        5 => array(
            'ratio' => 41.66667 / 100,
            'numeral' => 5
        ),

        4 => array(
            'ratio' => 33.33333 / 100,
            'numeral' => 4
        ),

        3 => array(
            'ratio' => 25 / 100,
            'numeral' => 3
        ),

        2 => array(
            'ratio' => 16.66667 / 100,
            'numeral' => 2
        ),

        1 => array(
            'ratio' => 8.33333 / 100,
            'numeral' => 1
        )
    );

    if( !isset($sizes[$columns]) )
    {
        $columns = 12;
    }//endif;

    $sizes[$columns]['max_width'] = number_format($max_width * $sizes[$columns]['ratio'], 0);

    return $sizes[$columns];
}//end mvb_foundation_columns()

function get_youtube_video_id( $_url )
{
    parse_str( parse_url( $_url, PHP_URL_QUERY ), $_vars );

    if( isset($_vars['v']) AND $_vars['v'] != '' )
    {
        return $_vars['v'];
    }
    else
    {
        $_t_url = explode('/', $_url);
        return $_t_url[count($_t_url)-1];
    }
}// end get_youtube_video_id()

function mvb_get_gmap_url( $_url, $_style = 'm', $_zoom = '17' )
{
    return $_url.'&amp;output=embed';
}// end get_embed_url()

function mvb_wordwrap( $_text, $number_of_words){
	$output = '';

	$_text = strip_tags($_text);
	//$_text = str_word_count($_text, 1);
    //print_r($_text);
    $_text = explode(" ", $_text);
    $_text = array_slice( $_text, 0, $number_of_words);

	$_text = implode(" ", $_text);
	return trim($_text);
}// end mvb_wordwrap()

function mvb_return_3600( $seconds )
{
  return 3600;
}//end mvb_return_3600();

function mvb_initialize_options()
{
    global $__mvb_plugin_options;
    $__mvb_plugin_options = get_option('mvb_plugin_options');
}//end _bshaper_initialize_options

function mvb_get_option( $option_name = '', $default = FALSE )
{
    global $__mvb_plugin_options;

    if( isset( $__mvb_plugin_options[$option_name] ) AND $__mvb_plugin_options[$option_name] != '' )
    {
        return mvb_clean_option($__mvb_plugin_options[$option_name]);
    }
    else
    {
        return $default;
    }
}// end mvb_get_option()

function mvb_clean_option($val)
{
    if( is_array($val) )
    {
        return $val;
    }
    else
    {
        return esc_textarea(html_entity_decode(stripslashes($val)));
    }//endif

}//end mvb_clean_option();

function mvb_aq_resize($url, $width = null, $height = null, $crop = null, $single = true, $upscale = false)
{
    //check if url is attachment_id
    if( is_numeric($url) )
    {
        $meta_data = wp_get_attachment_metadata($url);

        //if image is smaller than the resized version, return url
        if( $meta_data['width'] > $width OR $meta_data['height'] > $height )
        {
            return wp_get_attachment_url($url);
        }//endif

        $url = wp_get_attachment_url($url);
    }//endif;



    return mvb_do_aq_resize($url, $width, $height, $crop, $single, $upscale);
}//end mvb_aq_resize()

function mvb_posts_select() {
	$cpts = mvb_get_option('cpts', 'any');
	$posts = get_posts(array('post_type' => $cpts, 'posts_per_page' => -1));
	
	$out_posts = array('');
	
	if (is_array($posts)) {
		foreach ($posts as $post) {
			$out_posts[$post->ID] = $post->post_title;
		}
	}
	
	return $out_posts;
}