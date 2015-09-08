<?php
	$thumbnail_default_size = array(180, 180);
	$thumbnail_parallelogram_size = array(262, 130);
?>

<?php
$column_number = (!empty($column_number)) ? $column_number : '';
$panel['main_title'] = (isset($panel['main_title'])) ? $panel['main_title'] : '';
$panel['sub_title'] = (isset($panel['sub_title'])) ? $panel['sub_title'] : '';

$icons = '';

# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}
if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}

?>

<div class="team_module module row <?php echo (!empty($css)) ? $css : ''; ?>"  <?php echo $addition_css_styles; ?>>

    <?php include(dirname(__FILE__).'/_title.php'); ?>

    <?php if (!empty($r_items) && count($r_items) > 0): ?>

        <?php foreach ($r_items as $panel): ?>

            <?php if (!empty($panel['effects'])) {
                $cr_effect = ' cr-animate-gen"  data-gen="' . $panel['effects'] . '" data-gen-offset="bottom-in-view';
            } else {
                $cr_effect = '';
            } ?>

            <?php
			if (isset($panel['thumbnail_transform']) && strcmp($panel['thumbnail_transform'], 'avatar_parallelogram')===0) {
				$thumbnail_size = $thumbnail_parallelogram_size;
			} else {
				$thumbnail_size = $thumbnail_default_size;
			}
             
			
            $url = (isset($panel['image'])) ? wp_get_attachment_url($panel['image']) : '';
            $article_image = aq_resize($url, $thumbnail_size[0], $thumbnail_size[1], true);

            $url_flip = (isset($panel['image_flip'])) ? wp_get_attachment_url($panel['image_flip']) : '';
            $flip_image = aq_resize($url_flip, $thumbnail_size[0], $thumbnail_size[1], true);
			
			if (isset($panel['link_url']) && $panel['link_url'] != '') {
				$_link = $panel['link_url'];
			} elseif (isset($panel['page_id']) && is_numeric($panel['page_id']) && $panel['page_id'] > 0) {
				$_link = get_page_link($panel['page_id']);
			} else {
				$_link = null;
			}
			
			if (isset($panel['link_title']) && $panel['link_title'] != '') {
				$_link_title = $panel['link_title'];
			} else {
				$_link_title = 'Read more';
			}

            ?>

            <div class="<?php echo $column_number ?> columns  <?php echo $cr_effect; ?>">

                <div class="team_member_box">

                    <?php if ($article_image) {

                        if ($flip_image) { ?>
							<?php if (isset($panel['thumbnail_transform']) && strcmp($panel['thumbnail_transform'], 'avatar_parallelogram')===0) : ?>
							<div class="avatar_parallelogram_wrap slidebox">
							<?php else : ?>
							<div class="avatar slidebox"> 
							<?php endif; ?>
									<div class="front">
										<img src="<?php echo $article_image; ?>" alt="<?php echo $panel['main_title'] ?>"/>
									</div>
									<div class="back">
										<img src="<?php echo $flip_image; ?>" alt="<?php echo $panel['main_title'] ?>"/>
									</div>
							<?php if (isset($panel['thumbnail_transform']) && strcmp($panel['thumbnail_transform'], 'avatar_parallelogram')===0) : ?>
							</div>
							<?php else : ?>
							</div>     
                    
							<?php endif; ?>                                    
                        <?php } else { ?>
							<?php if (isset($panel['thumbnail_transform']) && strcmp($panel['thumbnail_transform'], 'avatar_parallelogram')===0) : ?>
								<div class="avatar_parallelogram_wrap">
							<?php endif; ?>
										<div class="avatar">
											<img src="<?php echo $article_image; ?>" alt="<?php echo $panel['main_title'] ?>"/>
										</div>
							<?php if (isset($panel['thumbnail_transform']) && strcmp($panel['thumbnail_transform'], 'avatar_parallelogram')===0) : ?>
								</div>
							<?php endif; ?>
                        <?php }  ?>

                    <?php } ?>


                    <div class="block-title"><?php echo $panel['main_title'] ?></div>
                    <span class="dopinfo"><?php echo $panel['sub_title'] ?></span>

                    <?php if (isset($panel['content'])): ?>
                        <div class="text">
                            <?php echo mvb_parse_content($panel['content'], TRUE); ?>
                        </div>
                    <?php endif; ?>
					
					<?php if(!empty($_link)): ?>
					<p class="text-left">
						<a href="<?php echo $_link; ?>" class="read-more"><?php echo $_link_title; ?></a>
					</p>
					<?php endif; ?>


                    <?php
                    $social_networks = array(
                        "tw" => "Twitter",
                        "fb" => "Facebook",
                        "li" => "LinkedIN",
                        "gp" => "Google +",
                        "in" => "Instagram",
                        "vi" => "Vimeo",
                        "lf" => "Last FM",
                        "vk" => "Vkontakte",
                        "yt" => "YouTube",
                        "de" => "Devianart",
                        "pi" => "Picasa",
                        "pt" => "Pinterest",
                        "wp" => "Wordpress",
                        "db" => "Dropbox",
                    );
                    $social_icons = array(
                        "fb" => "soc_icon-facebook",
                        "gp" => "soc_icon-google__x2B_",
                        "tw" => "soc_icon-twitter-3",
                        "in" => "soc_icon-instagram",
                        "vi" => "soc_icon-vimeo",
                        "lf" => "soc_icon-last_fm",
                        "vk" => "soc_icon-rus-vk-01",
                        "yt" => "soc_icon-youtube",
                        "de" => "soc_icon-deviantart",
                        "li" => "soc_icon-linkedin",
                        "pi" => "soc_icon-picasa",
                        "pt" => "soc_icon-pinterest",
                        "wp" => "soc_icon-wordpress",
                        "db" => "soc_icon-dropbox",
                        "rss" => "soc_icon-rss",
                    );

                    foreach ($social_networks as $short => $original) {

                        $link = (isset($panel[$short . "_link"])) ? $panel[$short . "_link"] : '';
                        $icon = (isset($social_icons[$short])) ? $social_icons[$short] : '';

                        if ($link != '') {
                            $icons .= '<a href="' . $link . '" class="' . $icon . '" title="' . $original . '"></a>';
                        }
                    }

                    if ($icons) {
                        echo '<div class="soc-icons">';
                        echo $icons;
                        echo '</div>';

                        $icons ='';
                    }

                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script type="text/javascript">
	jQuery(window).load(function() {
		jQuery('.avatar_parallelogram_wrap img').each(function() {
			var $img = jQuery(this);
			var $parent = $img.parents('.avatar_parallelogram_wrap');			
			var $parent_height = $parent.height();
			var $img_height = $img.height();
			var $top = 0;
			
			if ($img_height > $parent_height) {
				$top = Math.round(($img_height - $parent_height) / 2);
			}
			
			$img.css('position', 'relative').css('top', -$top);
		});
	});
</script>









