<?php

class Metro_Shortcodes
{
    public $the_method = 'render';

    public function __construct( $_front_end_ajax_is_calling = false )
    {
        if( is_admin() && !$_front_end_ajax_is_calling )
            $this->the_method = 'admin_render';


        $this->_add_shortcode( 'mvb_recent_works', 'MVB_recent_works', $this->the_method);
		$this->_add_shortcode( 'mvb_recent_works_wide', 'MVB_recent_works_wide', $this->the_method);

        $this->_add_shortcode( 'mvb_our_team', 'MVB_Our_Team', $this->the_method);

        $this->_add_shortcode( 'mvb_charts', 'MVB_Charts', $this->the_method);
        $this->_add_shortcode( 'mvb_chart', 'MVB_Charts', 'repeater_'.$this->the_method);

        $this->_add_shortcode( 'mvb_recent_news', 'MVB_recent_news', $this->the_method);
        $this->_add_shortcode( 'mvb_featured_news', 'MVB_Featured_News', $this->the_method);
        $this->_add_shortcode( 'mvb_3_posts', 'MVB_3_Posts', $this->the_method);
        $this->_add_shortcode( 'mvb_4_posts', 'MVB_4_Posts', $this->the_method);
        $this->_add_shortcode( 'mvb_posts_carousel', 'MVB_Posts_Carousel', $this->the_method);

        $this->_add_shortcode( 'mvb_timeline', 'MVB_Timeline', $this->the_method);
        $this->_add_shortcode( 'mvb_timeline_horizontal', 'MVB_Timeline_Horizontal', $this->the_method);

        $this->_add_shortcode( 'mvb_text', 'MVB_Text', $this->the_method);
		
		$this->_add_shortcode( 'mvb_sliding_texts', 'MVB_Sliding_Texts', $this->the_method);
		$this->_add_shortcode( 'mvb_sliding_text', 'MVB_Sliding_Texts', 'repeater_'.$this->the_method);
		
        $this->_add_shortcode( 'mvb_multicolumn_texts', 'MVB_Multicolumn_Texts', $this->the_method);
		$this->_add_shortcode( 'mvb_multicolumn_text', 'MVB_Multicolumn_Texts', 'repeater_'.$this->the_method);
		
        $this->_add_shortcode( 'mvb_boxed_content', 'MVB_Boxed_Content', $this->the_method);
        $this->_add_shortcode( 'mvb_message_boxes', 'MVB_Message_Boxes', $this->the_method);
        $this->_add_shortcode( 'mvb_dividers', 'MVB_Dividers', $this->the_method);

        $this->_add_shortcode( 'mvb_video', 'MVB_Video', $this->the_method);

        $this->_add_shortcode( 'mvb_raw_html', 'MVB_Raw_HTML', $this->the_method);
        $this->_add_shortcode( 'mvb_raw_javascript', 'MVB_Raw_Javascript', $this->the_method);
        $this->_add_shortcode( 'mvb_shortcode', 'MVB_Shortcode', $this->the_method);
        $this->_add_shortcode( 'mvb_sidebar', 'MVB_Sidebar', $this->the_method);

        $this->_add_shortcode( 'mvb_skills', 'MVB_Skills', $this->the_method);
        $this->_add_shortcode( 'mvb_skill', 'MVB_Skills', 'repeater_'.$this->the_method);
		
		$this->_add_shortcode( 'mvb_slide_paralax', 'MVB_Slide_Paralax', $this->the_method);
		
        $this->_add_shortcode( 'mvb_tabs', 'MVB_Tabs', $this->the_method);
        $this->_add_shortcode( 'mvb_tabs_list', 'MVB_Tabs_List', $this->the_method);
        $this->_add_shortcode( 'mvb_tab', 'MVB_Tabs', 'repeater_'.$this->the_method);
        $this->_add_shortcode( 'mvb_accordion', 'MVB_Accordion', $this->the_method);
        $this->_add_shortcode( 'mvb_accordion_panel', 'MVB_Accordion', 'repeater_'.$this->the_method);
        $this->_add_shortcode( 'mvb_gmaps', 'MVB_Gmaps', $this->the_method);
        $this->_add_shortcode( 'mvb_testimonials', 'MVB_Testimonials', $this->the_method);
        $this->_add_shortcode( 'mvb_testimonial_user', 'MVB_Testimonials', 'repeater_'.$this->the_method);

		$this->_add_shortcode( 'mvb_facts', 'MVB_Facts', $this->the_method);
		$this->_add_shortcode( 'mvb_fact', 'MVB_Facts', 'repeater_'.$this->the_method);
		
        $this->_add_shortcode( 'mvb_image', 'MVB_Image', $this->the_method);
		$this->_add_shortcode( 'mvb_feature_image', 'MVB_Feature_Image', $this->the_method);
		$this->_add_shortcode( 'mvb_icon', 'MVB_Icon', $this->the_method);
        $this->_add_shortcode( 'mvb_soc_icons', 'MVB_Soc_Icons', $this->the_method);

        $this->_add_shortcode( 'mvb_blog_posts_2', 'MVB_Blog_posts_2', $this->the_method); // Tiny Post list
        $this->_add_shortcode( 'mvb_blog_posts_4', 'MVB_Blog_posts_4', $this->the_method); // Post list

        $this->_add_shortcode( 'mvb_call_to_action', 'MVB_Call_To_Action', $this->the_method);
		
		$this->_add_shortcode( 'mvb_contact_form', 'MVB_Contact_Form', $this->the_method);
		$this->_add_shortcode( 'mvb_words_from', 'MVB_Words_From', $this->the_method);
		$this->_add_shortcode( 'mvb_qr', 'MVB_Qr', $this->the_method);

        $this->_add_shortcode( 'mvb_clients', 'MVB_Clients', $this->the_method);
        $this->_add_shortcode( 'mvb_single_client', 'MVB_Clients', 'repeater_'.$this->the_method);
		
		$this->_add_shortcode( 'mvb_clients_tiles', 'MVB_Clients_Tiles', $this->the_method);
        $this->_add_shortcode( 'mvb_single_client_tiles', 'MVB_Clients_Tiles', 'repeater_'.$this->the_method);

        $this->_add_shortcode( 'mvb_presentation_boxes', 'MVB_Presentation_Boxes', $this->the_method);
        $this->_add_shortcode( 'mvb_presentation_box', 'MVB_Presentation_Boxes', 'repeater_'.$this->the_method);
		
		$this->_add_shortcode( 'mvb_presentation_boxes_polygon', 'MVB_Presentation_Boxes_Polygon', $this->the_method);
        $this->_add_shortcode( 'mvb_presentation_box_polygon', 'MVB_Presentation_Boxes_Polygon', 'repeater_'.$this->the_method);
		
        $this->_add_shortcode( 'mvb_presentation_boxes_tiles', 'MVB_Presentation_Boxes_Tiles', $this->the_method);
        $this->_add_shortcode( 'mvb_presentation_box_tiles', 'MVB_Presentation_Boxes_Tiles', 'repeater_'.$this->the_method);
		
        $this->_add_shortcode( 'mvb_presentation_boxes_undertitle', 'MVB_Presentation_Boxes_Undertitle', $this->the_method);
        $this->_add_shortcode( 'mvb_presentation_box_undertitle', 'MVB_Presentation_Boxes_Undertitle', 'repeater_'.$this->the_method);
		
        $this->_add_shortcode( 'mvb_presentation_boxes_left_icon', 'MVB_Presentation_Boxes_Left_Icon', $this->the_method);
        $this->_add_shortcode( 'mvb_presentation_box_left_icon', 'MVB_Presentation_Boxes_Left_Icon', 'repeater_'.$this->the_method);

        $this->_add_shortcode( 'mvb_presentation_boxes_vertical', 'MVB_Presentation_Boxes_Vertical', $this->the_method);

        $this->_add_shortcode( 'mvb_presentation_boxes_img', 'MVB_Presentation_Boxes_Img', $this->the_method);
        $this->_add_shortcode( 'mvb_presentation_box_img', 'MVB_Presentation_Boxes_Img', 'repeater_'.$this->the_method);
		
        $this->_add_shortcode( 'mvb_features_list', 'MVB_Features_list', $this->the_method);
		$this->_add_shortcode( 'mvb_features_item', 'MVB_Features_list', 'repeater_'.$this->the_method);
		
        $this->_add_shortcode( 'mvb_lists', 'MVB_lists', $this->the_method);
		$this->_add_shortcode( 'mvb_list', 'MVB_lists', 'repeater_'.$this->the_method);

	    $this->_add_shortcode( 'mvb_banner', 'MVB_Banner', $this->the_method);
		
	    $this->_add_shortcode( 'mvb_twitter', 'MVB_Twitter', $this->the_method);

    }//end __construct();

    public function _add_shortcode( $shortcode, $the_class, $the_method )
    {
        global $mvb_metro_factory;
        add_shortcode( $shortcode, array($the_class, $the_method) );

        if( is_admin() )
        {
            $o_the_class = new $the_class;
            $mvb_metro_factory->add_shortcode( $the_class, $o_the_class->settings() );
        }//ednif;
    }//end _add_shortcode()

}// end class
