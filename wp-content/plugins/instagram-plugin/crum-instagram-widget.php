<?php
/**
* Showing self feed in
* widget.
*/
class Crumina_Instagram_Widget extends WP_Widget {
	private $display_photos = 3;
	private $item_width = 280;
	private $avatar_width = 160;
	
	/** constructor */
	function __construct() {
		parent::WP_Widget( /* Base ID */'instagram_widget', /* Name */'Widget: Latest Instagram Feed', array( 'description' => 'Display your latest feeds. This will display your photo and includes media of people you\'re following.' ) );
	}
	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );

		$widget_title = $instance['widget_title'];

        if (isset($instance['auto_play'])) {
            $auto_play = 'true';
        } else {
            $auto_play = 'false';
        }
		
        $info = crInstGetInfo( user_id(), access_token() );

		echo $before_widget;

		echo $before_title . $widget_title . $after_title;

		echo '<div class="instagram-wrap">';
		
        echo crInstShowInfo(
			$info,
			array(
				'website' => true, 
				'media' => true, 
				'followers' => true, 
				'following' => true, 
				'profile_pic' => true
			),
			$this->avatar_width
		);
		
		echo crInstShowWidgetData(
				crInstGetSelfFeed( access_token() ),
				$info,
				$this->display_photos, 
				$this->item_width, 
				"sIntSelfFeed", 
				$instance['display_caption']
			);

		echo '</div>';
?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$("a[data-rel^='sIntSelfFeed']").prettyPhoto({
					hook: 'data-rel',
					autoplay_slideshow: <?php echo $auto_play; ?>,
					social_tools: false
				});
			});
		</script>
<?php

		echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['widget_title'] = strip_tags($new_instance['widget_title']);
		$instance['auto_play'] = strip_tags($new_instance['auto_play']);
		$instance['display_caption'] = strip_tags($new_instance['display_caption']);

		return $instance;
	}
	/** @see WP_Widget::form */
	function form( $instance ) {

		if ( $instance ) {
			$widget_title = esc_attr( $instance[ 'widget_title' ] );
			$auto_play = esc_attr( $instance[ 'auto_play' ] );
			$display_caption = esc_attr( $instance[ 'display_caption' ] );
		}
		else {
			$widget_title = __( 'My Instagram Feed', 'text_domain' );
			$auto_play = __( 'true', 'auto_play' );
			$display_caption = __( 'true', 'display_caption' );
		}

		?>

		<p>
		<label for="<?php echo $this->get_field_id('widget_title'); ?>"><?php _e('Widget Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" type="text" value="<?php echo $widget_title; ?>" />
		</p>


        <p>
            <i>For using that widget you must login to your instagram on Istagram plugin page <a href="options-general.php?page=crum-instagram">Settings -> Instagram</a></i>

        </p>

		<p>
		<label for="<?php echo $this->get_field_id('display_caption'); ?>"><?php _e('Display Photo Caption:'); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('display_caption'); ?>" name="<?php echo $this->get_field_name('display_caption'); ?>">
		 <option value="true" <?php selected( $display_caption, "true" ); ?>>Yes</option>
		 <option value="false" <?php selected( $display_caption, "false" ); ?>>No</option>
		</select>
		<span style="font-style: italic; font-size: 11px;">prettyPhoto sometimes unresponsive on long photo description and this is the major drawback in previous version of Simply Instagram. Turn this feature off when it does.</span>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('auto_play'); ?>"><?php _e('Auto Play Slideshow:'); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('auto_play'); ?>" name="<?php echo $this->get_field_name('auto_play'); ?>">
		 <option value="true" <?php selected( $auto_play, "true" ); ?>>Yes</option>
		 <option value="false" <?php selected( $auto_play, "false" ); ?>>No</option>
		</select>
		</p>

		<?php
	}
}
/**
* Register the widget using hook.
*/

add_action( 'widgets_init', create_function( '', 'register_widget("Crumina_Instagram_Widget");' ) );

