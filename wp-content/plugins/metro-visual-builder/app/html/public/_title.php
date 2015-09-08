<?php

global $mvb_metro_factory;

$before_title = '';
$after_title = '';

$before_sub_title = '';
$after_sub_title = '';
$sub_title_class = 'widget-sub-title';

$text_align = '';

$before_allocate = '';
$after_allocate = '';

$main_title_allocate = (!empty($main_title_allocate)) ? $main_title_allocate : '';
$sub_title_align = (!empty($sub_title_align)) ? $sub_title_align : '';
$main_title_style = (!empty($main_title_style)) ? $main_title_style : '';
$main_title_type = (!empty($main_title_type)) ? $main_title_type : '';

$main_title = (!empty($main_title)) ? $main_title : '';
$sub_title = (!empty($sub_title)) ? $sub_title : '';

if (intval($main_title_allocate) == 1) {
	$before_allocate = '<span class="widget-title-highlight">';
	$after_allocate = '</span>';
}

$title_class = 'widget-title';
if ($main_title_style) {
	$title_class .= ' widget-title-italic';
}

if (isset($main_title_align))
	$title_class .= ' '. mvb_get_align_class($main_title_align);

if (isset($sub_title_align))
	$sub_title_class .= ' '. mvb_get_align_class($sub_title_align);

if (intval($main_title_type) == 0) {
	
	if (class_exists('SB_Title_Allocate')) {
		$main_title = SB_Title_Allocate::wrap_rand_letter($main_title, $before_allocate, $after_allocate);
	} 
	
	$before_title = '<h3 class="'.$title_class.'">';
	$after_title = '</h3>';
	
	$before_sub_title = '<h4 class="'.$sub_title_class.'">';
	$after_sub_title = '</h4>';
} else {
	if (class_exists('SB_Title_Allocate')) {
		$main_title = SB_Title_Allocate::wrap_last_worlds($main_title, $before_allocate, $after_allocate);
	}
	
	$before_title = '<h2 class="'.$title_class.'">';
	$after_title = '</h2>';
	
	$before_sub_title = '<h3 class="'.$sub_title_class.'">';
	$after_sub_title = '</h3>';
}

if (!empty($main_title)) {
	echo $before_title . $main_title . $after_title;
}

if (!empty($sub_title)) {
	echo $before_sub_title . $sub_title . $after_sub_title;
}
