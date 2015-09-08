<?php

class Metro_Factory {

	public $app_url = '/app/';
	public $app_path = '/app/';
	public $version = '1.0';
	public $module_action = 'add';
	public $default_heading = 'h3';
	public $default_color = '';
	public $loaded_shortcodes = array();
	public $metro_load_scripts = array();
	public $show_pill_sc = FALSE;
	public $show_pill_sc_column = FALSE;
	public $no_of_columns;

	function __construct($shortcodes) {
		$this->app_url = MVB_URL . $this->app_url;
		$this->app_path = MVB_PATH . $this->app_path;


		if (function_exists("__autoload"))
			spl_autoload_register("__autoload");

		spl_autoload_register(array($this, 'autoload'));

		if (is_admin()) {
			global $pagenow;

			if ($pagenow == 'post.php' OR $pagenow == 'post-new.php') {
				add_action('add_meta_boxes', array(&$this, 'add_the_meta_box'));
				add_action('admin_enqueue_scripts', array(&$this, 'load_assets'), 10, 1);
			}//endif;
			$this->loaded_shortcodes = $shortcodes;
		} else {
			add_action('wp_enqueue_scripts', array(&$this, 'load_assets'), 10, 1);
		}//endif;

		add_action('wp_footer', array(&$this, 'load_scripts'));

		add_filter('mvb_fields_filter', array(&$this, 'fields_filter'));
		add_filter('mvb_front_load_view_vars', array(&$this, 'front_load_view_vars'));
	}

//end __construct()

	public function add_shortcode($shortcode_class, $settings) {
		if (!array_key_exists($settings['section'], $this->loaded_shortcodes))
			return;

		if (isset($settings['section'])) {
			$this->loaded_shortcodes[$settings['section']]['modules'][$shortcode_class] = $settings;
		} else {
			$this->loaded_shortcodes['misc']['modules'][$shortcode_class] = $settings;
		}//endif;
	}

//end add_shortcode

	public function add_the_meta_box() {
		$mvb_cpts = mvb_get_option('cpts');
		$mvb_activate = mvb_get_option('activate');
		$mvb_show = mvb_get_option('show');

		if (is_array($mvb_cpts) AND !empty($mvb_cpts) AND $mvb_show == 1 AND $mvb_activate == 1) {
			foreach ($mvb_cpts as $cpt) {
				add_meta_box(
						'mvb_metro_builder'
						, __('Metro Visual Builder', 'mvb')
						, array(&$this, 'render_meta_box')
						, $cpt
						, 'advanced'
						, 'high'
				);
			}//end foreach;
		}//endif;
	}

//end add_the_meta_box()

	function render_meta_box() {
		$this->render_meta_box_content();
	}

//end render_meta_box()

	public function render_meta_box_content($meta_value = '') {
		global $post;
		$this->show_pill_sc = TRUE;
		$meta_key = '_bshaper_artist_content';
		$meta_value = get_post_meta($post->ID, $meta_key, true);
		$activate_metro = get_post_meta($post->ID, '_bshaper_activate_metro_builder', true);

		if ($activate_metro != '0' &&  $activate_metro != '2' )
			$activate_metro = 1;

		$load['_bshaper_activate_metro_builder'] = $activate_metro;

		$meta_value = $this->editor_parse_mvb_array($meta_value);

		$load['meta_value'] = $meta_value;
		$load['post'] = $post;

		$this->_load_view('html/editor.php', $load, TRUE);

		$this->show_pill_sc = FALSE;
	}

//end render_meta_box_content()

	public function editor_parse_mvb_array($arr) {
		if (!is_array($arr) OR empty($arr))
			return '';

		global $metro_admin_grid;
		global $metro_admin_rows;

		require_once($this->app_path . '/html/grids/admin-grid.php');

		$str = '';
		$the_row_class = $this->the_row_class();

		$_row_settings = '<a href="#" class="mvb_row_settings">' . __('row settings', 'mvb') . '</a>';

		$_delete_row = '<div class="bshaper_handler"><span class="handler-title"><i class="awesome-move"> </i>' . __('Re-order rows', 'mvb') . '</span> ' . $_row_settings . '<a href="#" class="mvb_delete_section">' . __('delete section', 'mvb') . '</a></div><div class="clear"><!-- --></div>';

		$_add_module = '<div class="mvb_column_actions"><a class="bshaper_add_module" href="#">+ ' . __('Add module', 'mvb') . '</a>';
		$_add_module .= '<a class="mvb_column_settings" href="#">+ ' . __('Column settings', 'mvb') . '</a></div>';

		foreach ($arr as $row_id => $row) {
			$str .= '<li class="row bshaper_row" data-mvb-bgcolor="' . $row['settings']['bgcolor'] .
					'" data-mvb-bgimage="' . $row['settings']['bgimage'] .
					'" data-mvb-bgrepeat="' . $row['settings']['bgrepeat'] .
					'" data-mvb-bgposition="' . $row['settings']['bgposition'] .
					'" data-mvb-textcolor="' . $row['settings']['textcolor'] .
					'" data-mvb-background_check="' . $row['settings']['background_check'] .
					'" data-mvb-row_padding_top="' . $row['settings']['row_padding_top'] .
					'" data-mvb-row_padding_bottom="' . $row['settings']['row_padding_bottom'] .
					'" data-mvb-row_full_width="' . $row['settings']['row_full_width'] .
					'" data-mvb-totop="' . $row['settings']['totop'] .
					'" data-mvb-row_full_height="' . $row['settings']['row_full_height'] .
					'" data-mvb-css="' . $row['settings']['css'] .
					'" data-mvb-cssclass_manual="' . $row['settings']['cssclass_manual'] .
					'" data-mvb-paddtop="' . $row['settings']['padding_top'] .
					'" data-mvb-paddbottom="' . $row['settings']['padding_bottom'] .
					'" data-mvb-post_id="' .
					'" data-mvb-video_display="' . $row['settings']['video_display'] .
					'" data-mvb-video_repeat="' . $row['settings']['video_repeat'] .
					'" data-mvb-video_shadow="' . $row['settings']['video_shadow'] .
					'" data-mvb-video_poster="' . $row['settings']['video_poster'] .
					'" data-mvb-video_mp4="' . $row['settings']['video_mp4'] .
					'" data-mvb-video_webm="' . $row['settings']['video_webm'] .
					'" data-mvb-video_ogg="' . $row['settings']['video_ogg'] .
					'" data-mvb-row_id="' . $row_id .
					'">' . $_delete_row;
			foreach ($row['columns'] as $column) {
				$str .= '<div class="' . $metro_admin_grid[$column['size']] .
						' columns" data-columns="' . $column['size'] .
						'" data-mvb-bgcolor="' . $column['settings']['bgcolor'] .
						'" data-mvb-bgimage="' . $column['settings']['bgimage'] .
						'" data-mvb-bgrepeat="' . $column['settings']['bgrepeat'] .
						'" data-mvb-bgposition="' . $column['settings']['bgposition'] .
						'" data-mvb-textcolor="' . $column['settings']['textcolor'] .
						'" data-mvb-background_check="' . $column['settings']['background_check'] .
						'" data-mvb-row_padding_top="' . ((isset($column['settings']['row_padding_top'])) ? $column['settings']['row_padding_top'] : '') .
						'" data-mvb-row_padding_bottom="' . ((isset($column['settings']['row_padding_bottom'])) ? $column['settings']['row_padding_bottom'] : '') .
						'" data-mvb-row_full_width="' . ((isset($column['settings']['row_full_width'])) ? $column['settings']['row_full_width'] : '') .
						'" data-mvb-totop="' . $column['settings']['totop'] .
						'" data-mvb-css="' . $column['settings']['css'] .
						'" data-mvb-cssclass_manual="' . ((isset($column['settings']['cssclass_manual'])) ? $column['settings']['cssclass_manual'] : '') .
						'" data-mvb-smallclass="' . $column['settings']['smallclass'] .
						'" data-mvb-paddtop="' . $column['settings']['padding_top'] .
						'" data-mvb-paddright="' . $column['settings']['padding_right'] .
						'" data-mvb-paddbottom="' . $column['settings']['padding_bottom'] .
						'" data-mvb-paddleft="' . $column['settings']['padding_left'] .
						'">' . do_shortcode($column['shortcodes']) . $_add_module . '</div>';
			}
			$str .= '<div class="clear"><!-- --></div></li>';
		}//endforeach;

		return $str;
	}

//end editor_parse_mvb_array();

	function _load_view($_file, $vars = array(), $do_echo = FALSE) {
		$t = array(
			'app_path' => $this->app_path,
			'app_url' => $this->app_url
		);

		extract($t);

		if (!is_admin()) {
			$vars = apply_filters('mvb_front_load_view_vars', $vars);
		}

		if (!empty($vars))
			extract($vars);

		$the_include_file = $app_path . $_file;
		$the_include_custom_file = MVB_C_PATH . $_file;

		if (is_file($the_include_custom_file)) {
			$the_include_file = $the_include_custom_file;
		}

		ob_start();
		include $the_include_file;

		if (!$do_echo)
			return ob_get_clean();

		echo ob_get_clean();
	}

// end _load_view()

	public function autoload($the_class) {
		$the_class = strtolower($the_class);
		if (strpos($the_class, 'mvb_') === 0) {

			$c_path = MVB_C_PATH . 'gears/libraries/';
			$path = MVB_PATH . 'app/gears/libraries/';

			$the_file = $path . $the_class . '.php';
			$the_c_file = $c_path . $the_class . '.php';

			if (file_exists($the_c_file))
				$the_file = $the_c_file;
			//echo $the_file;
			include_once($the_file);
		}//endif
	}

//end autoload

	function defaults($vars = array()) {
		$to_return = array();

		foreach ($vars as $var_name => $var_options) {
			$to_return[$var_name] = isset($var_options['default']) ? $var_options['default'] : '';
		}

		return $to_return;
	}

//end defaults();

	function get_sc_posts($vars = array()) {
		$to_return = array();
		$for_content = '';

		foreach ($vars as $var_name => $var_options) {
			if ($var_options['type'] == 'repeater') {
				$for_content .= $this->do_post_repeater_shortcode($var_name, $var_options);
			} else {
				$to_return[$var_name] = isset($_POST[$var_name]) ? $this->clean_value($var_name, $_POST[$var_name], $var_options['type']) : '';
			}//endif;
		}//endforeach;

		if (!isset($to_return['content']))
			$to_return['content'] = $for_content;

		return $to_return;
	}

//end get_sc_posts();

	public function do_post_repeater_shortcode($var_name, $var_options) {
		$str_of_atts = '';
		$sh_name = 'mvb_' . $var_name;

		if (isset($_POST[$var_name])) {

			foreach ($_POST[$var_name] as $panel) {
				$str_of_atts .= '[' . $sh_name;
				$arr_keys = array();

				foreach ($var_options['fields'] as $field => $field_settings) {
					if ($this->store_value($field)) {
						$value = isset($panel[$field]) ? $this->clean_value($field, $panel[$field], $field_settings['type']) : '';
						$str_of_atts .= ' ' . $field . '="' . $value . '"';
					}//endif;
					$arr_keys[] = $field;
				}//endforeach;

				$str_of_atts .= ' sh_keys="' . implode(",", $arr_keys) . '"';

				$str_of_atts .= ']';

				if (array_key_exists('content', $panel)) {
					$str_of_atts .= $this->clean_value('content', $panel['content'], 'textarea');
				}

				$str_of_atts .= '[/' . $sh_name . ']';
			}//endforeach;
		}

		return $str_of_atts;
	}

//end do_post_repeater_shortcode()

	public function do_repeater_shortcode($content) {
		global $__metro_core;
		$__metro_core->sh_tmp_repeater = array();
		$tmp_panels = do_shortcode($content);

		return $__metro_core->sh_tmp_repeater;
	}

//end do_repeater_shortcode()

	function clean_value($key = '', $value, $type = 'text', $html = '') {
		if ($type == 'textarea' AND empty($html)) {
			$value = str_replace("\n", '<br class="mvb_break">', $value);
		} elseif ($type == 'textarea') {
			$value = str_replace("\n", '+|+', $value);
		} elseif ($type == 'select_multi') {
			$value = implode(",", $value);
		}

		if (($type === 'text' || $type === 'textarea') && !in_array($key, array('unique_id'))) {
			$value = mvb_base64_encode($value);
		}

		return $value;
	}

//end clean_value()

	public function the_pill($vars, $settings) {
		$str_of_atts = '';
		foreach ($vars as $var_name => $var_value) {
			if ($this->store_value($var_name))
				$str_of_atts .= ' ' . $var_name . '="' . addslashes(wp_kses($var_value, array('span' => array('class')))) . '"';
		}//endforeach;

		$load['str_of_atts'] = $str_of_atts;
		$load['settings'] = $settings;
		$load['content'] = mvb_prepare_content_html($vars['content']);
		$load['main_title'] = isset($vars['main_title']) ? $vars['main_title'] : '';
		$load['image'] = isset($vars['image']) ? $vars['image'] : '';


		return $this->_load_view('html/private/the_pill.php', $load);
	}

//end the_pill;

	public function store_value($var_name) {
		if ($var_name == 'content' OR strstr($var_name, '_repeater') OR strstr($var_name, '_no_store') OR strstr($var_name, 'separator'))
			return FALSE;

		return TRUE;
	}

//end store_value()

	function load_assets() {
		if (is_admin()) {
			wp_enqueue_script('jquery');

			wp_register_script(
					'mvb_support', $this->app_url . 'assets/js/custom/mvb_support.js', array('jquery'), false, true
			);

			wp_register_script(
					'mvb_filemanager', $this->app_url . 'assets/js/custom/mvb_filemanager.js', array('jquery'), false, true
			);

			wp_enqueue_script('mvb_support');
			wp_enqueue_script('mvb_filemanager');

			wp_register_style('colorpickerz_css', $this->app_url . 'assets/css/colorpicker.css');
			wp_enqueue_style('colorpickerz_css');
			wp_enqueue_script('colorpickerz', $this->app_url . 'assets/js/colorpicker/colorpicker.js');

			wp_register_style(
					'mvb_style', $this->app_url . 'assets/css/mvb_style.css'
			);

			wp_register_style(
					'fa_style', $this->app_url . 'assets/fonts/fontawesome/css/font-awesome.min.css'
			);

			wp_register_style(
					'bs-jquery-ui', $this->app_url . 'assets/css/jquery-ui/metro/jquery-ui.css'
			);

			wp_register_style('bp_asmSelect_css', $this->app_url . 'assets/js/asmSelect/jquery.asmselect.css');
			wp_enqueue_style('bp_asmSelect_css');

			wp_enqueue_script('bp_asmSelect', $this->app_url . 'assets/js/asmSelect/jquery.asmselect.js', array('jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-droppable'), 1, TRUE);

			wp_enqueue_script('jquery-ui-dialog');



			wp_enqueue_style('mvb_style');
			wp_enqueue_style('fa_style');
			wp_enqueue_style('bs-jquery-ui');
		} else {
			//load_public assets;
			wp_enqueue_script('jquery');
			wp_register_style(
					'metro_builder_shortcodes', $this->app_url . '/assets/css/mvb_shortcodes.css'
			);
			wp_register_script('metro_builder_main', $this->app_url . '/assets/js/main.js', array('jquery'));

			wp_enqueue_script('metro_builder_main');
			wp_enqueue_style('metro_builder_shortcodes');

			$color_scheme = mvb_get_option('color_scheme');

			if ($color_scheme != 'none') {
				wp_register_style(
						'metro_builder_skin', $this->app_url . '/assets/css/' . $color_scheme . '/style.css'
				);

				wp_enqueue_style('metro_builder_skin');
			}//endif $color_scheme
		}
	}

//end load_assets()

	public function load_scripts() {

		if (!empty($this->metro_load_scripts)) {
			foreach ($this->metro_load_scripts as $sh) {

				if (!empty($sh['js'])) {

					foreach ($sh['js'] as $identifier => $_path) {
						wp_register_script($identifier, $_path, array(), '0.9.53', true);
						wp_enqueue_script($identifier);
					}
				}
			}
		}
	}

	public function queue_scripts($_js_scripts, $key = '-') {
		if (!array_key_exists($key, $this->metro_load_scripts)) {
			$this->metro_load_scripts[$key] = $_js_scripts;
		}//endif;
	}

// end queue_scripts()

	public function parse_mvb_array($arr) {
		if (empty($arr))
			return '';

		global $metro_grid_container;
		global $metro_basic_row;
		global $metro_basic_grid;
		global $metro_mobile_grid;

		$str = '<div class="mvb_container' . $metro_grid_container . '">';

		$grid_file = $this->get_grid_config_file();
		include_once($grid_file);


		$the_row_class = $this->the_row_class($metro_basic_row);
		
		if (!empty($arr[0]['settings']['row_full_height'])) {
			wp_enqueue_script('jquery.scrollto', MVB_URL.'/app/assets/js/jquery.scrollTo.min.js', array('jquery'));
			wp_deregister_script('smooth-scroll');
		}

		foreach ($arr as $row) {
			$row_css = $this->build_mod_css($row['settings']);

			$my_row_css = $this->build_row_css($row['settings']);

			if ($row['settings']['totop']) {
				$totop_button = '<a href="#" class="back-to-top"></a>';
			} else {
				$totop_button = '';
			}

			$str_video = '';
			if (
					isset($row['settings']['video_display']) && $row['settings']['video_display'] == 1 &&
					(!empty($row['settings']['video_mp4']) || !empty($row['settings']['video_webm']) || !empty($row['settings']['video_ogg'])) // MP4 required option
			) {

				$video_attrs = array(
					'autoplay="autoplay"',
					'tabindex="0"',
				);

				if ($row['settings']['video_repeat'] == 1) {
					$video_attrs[] = 'loop="loop"';
				}

				if (!empty($row['settings']['video_poster'])) {
					$_poster_image_url = mvb_get_image_url($row['settings']['video_poster']);
					if (!empty($_poster_image_url)) {
						$video_attrs[] = 'poster="' . $_poster_image_url . '"';
					}
				}

				$str_video .= '<div class="row-video"><div class="row-video-container">';

				if (!empty($row['settings']['video_shadow'])) {
					$str_video .= '<div class="row-video-mask row-video-mask-'.$row['settings']['video_shadow'].'"></div>';
				}

				$str_video .= '<video ' . implode(' ', $video_attrs) . '>';
				if (!empty($row['settings']['video_mp4'])) {
					$str_video .= '<source src="' . mvb_get_image_url($row['settings']['video_mp4']) . '" type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\' />';
				}
				if (!empty($row['settings']['video_webm'])) {
					$str_video .= '<source src="' . mvb_get_image_url($row['settings']['video_webm']) . '" type=\'video/webm; codecs="vp8, vorbis"\' />';
				}
				if (!empty($row['settings']['video_ogg'])) {
					$str_video .= '<source src="' . mvb_get_image_url($row['settings']['video_ogg']) . '" type=\'video/ogg; codecs="theora, vorbis"\' />';
				}
				$str_video .= '</video>';
				$str_video .= '</div></div>';
			}

			$row_padding_classes = '';

			if (!empty($row['settings']['row_padding_top'])) {
				if (is_numeric($row['settings']['row_padding_top'])) {
					$my_row_css .= " padding-top: " . $row['settings']['row_padding_top'] . "px; ";
				} else {
					$row_padding_classes .= ' mvb-padding-top-' . $row['settings']['row_padding_top'];
				}
			}

			if (!empty($row['settings']['row_padding_bottom'])) {
				if (is_numeric($row['settings']['row_padding_bottom'])) {
					$my_row_css .= " padding-bottom: " . $row['settings']['row_padding_bottom'] . "px; ";
				} else {
					$row_padding_classes .= ' mvb-padding-bottom-' . $row['settings']['row_padding_bottom'];
				}
			}

			if (!empty($row['settings']['row_full_width']) && $row['settings']['row_full_width'] == 1) {
				$row_padding_classes .= ' mvb-row-fullwidth';
			}

			$row_classes = $row_padding_classes . ' ' . ((isset($row['settings']['cssclass_manual'])) ? $row['settings']['cssclass_manual'] : '');
			$class_darklight = '';
			
			if (!empty($row['settings']['row_full_height'])) {
				$row_classes .= ' mvb-row-fullheight';
			}

			$str .= '<section class="row-wrapper ' . $row_classes . '"' . $row_css . '>';
			$str .= $str_video;
			$str .= '<div class="' . $the_row_class . ' ' . $class_darklight . ' ' . $row_padding_classes . '" style="' . $my_row_css . '">';
			$str .= $totop_button;
			foreach ($row['columns'] as $column) {
				$column_css = $this->build_mod_css($column['settings']);

				$this->no_of_columns = $column['size'];

				$background_check = (isset($column['settings']['background_check'])) ? $column['settings']['background_check'] : '';
				if (empty($background_check) && !empty($row['settings']['background_check'])) {
					$background_check = $row['settings']['background_check'];
				}

				$str .= '<div class="' . $background_check . ' ' . $this->the_column_class($column['size'], $column['settings']['smallclass'], $metro_basic_grid, $metro_mobile_grid) . ' ' . $column['settings']['cssclass'] . '"><div class="mvb_inner_wrapper"' . $column_css . '>' . do_shortcode($column['shortcodes']) . '</div></div>';
			}
			$str .= '</div></section>';
		}//endforeach;

		$str .= '</div>';

		return $str;
	}

//end parse_mvb_array();

	public function build_row_css($settings) {
		$css = '';
		if ($settings['css'])
			$css .= $settings['css'];

		return $css;
	}

	public function build_mod_css($settings) {
		$css = '';

		if ($settings['bgimage'] != '') {
			$css .= 'background-image: url(' . mvb_get_image_url($settings['bgimage']) . ');';
		}

		if ($settings['bgrepeat'] != '') {
			$css .= 'background-repeat: ' . $settings['bgrepeat'] . ';';
		}

		if ($settings['bgcolor'] != '') {
			$css .= 'background-color: #' . $settings['bgcolor'] . ';';
		}

		if ($settings['textcolor'])
			$css .= 'color: #' . $settings['textcolor'] . ';';

		if (isset($settings['padding_top']) AND $settings['padding_top'] != '') {
			if ($settings['padding_top'] == 'large-padding') {
				$css .= 'padding-top: 85px; ';
			} elseif ($settings['padding_top'] == 'medium-padding') {
				$css .= 'padding-top: 60px; ';
			} elseif ($settings['padding_top'] == 'more-medium-padding') {
				$css .= 'padding-top: 50px; ';
			} elseif ($settings['padding_top'] == 'small-padding') {
				$css .= 'padding-top: 25px; ';
			} elseif ($settings['padding_top'] == 'extra-small-padding') {
				$css .= 'padding-top: 10px; ';
			} elseif ($settings['padding_top'] == 'no-padding') {
				$css .= 'padding-top: 0px; ';
			} elseif (is_numeric($settings['padding_top'])) {
				$css .= 'padding-top: ' . $settings['padding_top'] . 'px; ';
			} else {
				$css .= 'padding-top: ' . $settings['padding_top'] . '; ';
			}
		}

		if (isset($settings['padding_right']) AND $settings['padding_right'] != '') {
			if ($settings['padding_right'] == 'large-padding') {
				$css .= 'padding-right: 85px; ';
			} elseif ($settings['padding_right'] == 'medium-padding') {
				$css .= 'padding-right: 60px; ';
			} elseif ($settings['padding_right'] == 'more-medium-padding') {
				$css .= 'padding-right: 50px; ';
			} elseif ($settings['padding_right'] == 'small-padding') {
				$css .= 'padding-right: 25px; ';
			} elseif ($settings['padding_right'] == 'extra-small-padding') {
				$css .= 'padding-right: 10px; ';
			} elseif ($settings['padding_right'] == 'no-padding') {
				$css .= 'padding-right: 0px; ';
			} elseif (is_numeric($settings['padding_right'])) {
				$css .= 'padding-right: ' . $settings['padding_right'] . 'px; ';
			} else {
				$css .= 'padding-right: ' . $settings['padding_right'] . '; ';
			}
		}

		if (isset($settings['padding_bottom']) AND $settings['padding_bottom'] != '') {
			if ($settings['padding_bottom'] == 'large-padding') {
				$css .= 'padding-bottom: 85px; ';
			} elseif ($settings['padding_bottom'] == 'medium-padding') {
				$css .= 'padding-bottom: 60px; ';
			} elseif ($settings['padding_bottom'] == 'more-medium-padding') {
				$css .= 'padding-bottom: 50px; ';
			} elseif ($settings['padding_bottom'] == 'small-padding') {
				$css .= 'padding-bottom: 25px; ';
			} elseif ($settings['padding_bottom'] == 'extra-small-padding') {
				$css .= 'padding-bottom: 10px; ';
			} elseif ($settings['padding_bottom'] == 'no-padding') {
				$css .= 'padding-bottom: 0px; ';
			} elseif (is_numeric($settings['padding_bottom'])) {
				$css .= 'padding-bottom: ' . $settings['padding_bottom'] . 'px; ';
			} else {
				$css .= 'padding-bottom: ' . $settings['padding_bottom'] . '; ';
			}
		}

		if (isset($settings['padding_left']) AND $settings['padding_left'] != '') {
			if ($settings['padding_left'] == 'large-padding') {
				$css .= 'padding-left: 85px; ';
			} elseif ($settings['padding_left'] == 'medium-padding') {
				$css .= 'padding-left: 60px; ';
			} elseif ($settings['padding_left'] == 'more-medium-padding') {
				$css .= 'padding-left: 50px; ';
			} elseif ($settings['padding_left'] == 'small-padding') {
				$css .= 'padding-left: 25px; ';
			} elseif ($settings['padding_left'] == 'extra-small-padding') {
				$css .= 'padding-left: 10px; ';
			} elseif ($settings['padding_left'] == 'no-padding') {
				$css .= 'padding-left: 0px; ';
			} elseif (is_numeric($settings['padding_left'])) {
				$css .= 'padding-left: ' . $settings['padding_left'] . 'px; ';
			} else {
				$css .= 'padding-left: ' . $settings['padding_left'] . '; ';
			}
		}

		if ($settings['bgposition'] != '') {

			$css .= 'background-position: center;';

			if ($settings['bgposition'] != 'parallax') {
				$css .= 'background-attachment: ' . $settings['bgposition'] . ';';
			} else {
				$css .= 'background-attachment: scroll; ';
			}
		}
		if ($css != '' && (strcmp($settings['bgposition'], 'parallax') !== 0)) {
			$css = ' style="' . $css . '"';
		} else {
			$css = ' style="' . $css . '" data-speed="1" data-offsetY="0" data-type="background"';
		}


		return $css;
	}

//end build_mod_css()

	public function the_row_class($grid_row_class = '') {

		return $grid_row_class . ' mvb_t_row';
	}

//end the_row_class()

	public function the_column_class($size, $smallsize = 4, $metro_basic_grid, $metro_mobile_grid) {
		$smallsize = ($smallsize > 4) ? 4 : $smallsize;
		return $metro_basic_grid[$size] . ' ' . $metro_mobile_grid[$smallsize];
	}

//end the_column_class;

	public function get_grid_config_file() {
		$mvb_grid = mvb_get_option('grid');

		if ($mvb_grid == 'custom')
			return MVB_C_PATH . '/factory/mvb-custom/grids/custom.php';
		else
			return MVB_PATH . '/app/html/grids/' . $mvb_grid . '.php';
	}

//end get_grid_config_file()

	public function the_title_field() {
		$fields = array(
			'main_title' => array(
				'type' => 'text',
				's_title' => TRUE,
				'label' => __('Title', 'mvb'),
			),
			'main_title_type' => array(
				'type' => 'select',
				'label' => __('Title type', 'mvb'),
				'default' => 0,
				'options' => array(
					__('Small title(h3)', 'mvb'),
					__('Big title (h2)', 'mvb')
				),
				'col_span' => 'lbl_half'
			),
			'main_title_align' => array(
				'type' => 'select',
				'label' => __('Title Align', 'mvb'),
				'default' => 0,
				'options' => crum_get_align_ext(),
				'col_span' => 'lbl_half'
			),
			'main_title_style' => array(
				'type' => 'select',
				'label' => __('Title italic', 'mvb'),
				'default' => 0,
				'options' => mvb_yes_no(),
				'col_span' => 'lbl_half'
			),
			'main_title_allocate' => array(
				'type' => 'select',
				'label' => __('Title allocate', 'mvb'),
				'default' => 0,
				'options' => mvb_yes_no(),
				'col_span' => 'lbl_half'
			),
			'separator-main-title' => array('type' => 'separator'),
			'sub_title' => array(
				'type' => 'text',
				'label' => __('Sub Title', 'mvb'),
			),
			'sub_title_align' => array(
				'type' => 'select',
				'label' => __('Sub Title Align', 'mvb'),
				'default' => 0,
				'options' => crum_get_align_ext(),
			),
			'separator-sub-title' => array('type' => 'separator'),
		);

		return $fields;
	}
	
	public function the_icon_field() {
		$fields = array(
			'icon' => array(
				'type' => 'icon',
				'label' => __('Icon', 'mvb'),
			),
			// background
			'icon_background_type' => array(
				'type' => 'select',
				'label' => __('Icon background type', 'mvb'),
				'default' => '',
				'options' => mvb_icon_background_type()
			),
			'icon_background_color' => array(
				'type'	=>	'colorpicker',
				'label'	=>	__('Icon background color', 'mvb'),
			),
			'icon_background_color_hover' => array(
				'type'	=>	'colorpicker',
				'label'	=>	__('Icon background color hover', 'mvb'),
			),
			// font size
			'icon_size' => array(
				'type'      =>      'text',
				'label'     =>      __('Icon size (in px)', 'mvb'),
				'default'   =>      '120',
			),
			// icon color
			'icon_color' => array(
				'type'      =>      'colorpicker',
				'label'     =>      __('Icon Color', 'mvb'),
				'default'   =>      'DBDBDB',
				'col_span'  =>      'lbl_third',
			),
			'icon_color_hover' => array(
				'type'      =>      'colorpicker',
				'label'     =>      __('Icon Color hover', 'mvb'),
				'default'   =>      'DBDBDB',
				'col_span'  =>      'lbl_third',
			),
			// align
			'icon_align' => array(
				'type' => 'select',
				'label' => __('Icon Align', 'mvb'),
				'options' => crum_get_align_ext(),
			),
			
		);

		return $fields;
	}

	public function fields_filter($fields) {
		
		// Title
		unset($fields['main_title']);
		unset($fields['sub_title']);
		$fields = array_merge($this->the_title_field(), $fields);
		// End title
		
		// Icon
		$fields = mvb_replace_field($fields, 'icon', $this->the_icon_field());
		// End icon

		return $fields;
	}

	public function front_load_view_vars($vars) {

		if (!is_array($vars)) {
			return $vars;
		}
		
		return self::decode_vars($vars);
	}

	private static function decode_vars($data) {
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				if (is_array($value)) {
					$data[$key] = self::decode_vars($value);
				} else {
					$data[$key] = (false !== strpos($value, '?=')) ? mvb_base64_decode($value) : $value;
				}
			}
		}

		return $data;
	}

}

//end class
