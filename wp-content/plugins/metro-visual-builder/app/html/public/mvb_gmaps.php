<?php if (!empty($effects)){
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
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

<?php 
$columns = (!empty($columns)) ? $columns : '';
?>

<div class="gmap_module <?php echo (!empty($css)) ? $css : ''; ?> <?php echo $cr_effect; ?>"  <?php echo $addition_css_styles; ?>>

    <?php include(dirname(__FILE__).'/_title.php'); ?>

    <?php if (!empty($content)) {$columns = 'six';} else {$columns = 'twelve';} ?>


    <div class="row map-widget ">

        <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>

        <div class="<?php echo $columns; ?> columns">

            <div id="map-<?php echo (!empty($unique_id)) ? $unique_id : '' ?>" class="gmap-container" style="height: <?php echo (!empty($height)) ? $height : 0; ?>px;"></div>

            <script type="text/javascript">
                jQuery(document).ready(function () {
					jQuery("#map-<?php echo (!empty($unique_id)) ? $unique_id : '' ?>").bind('gmap-reload', function() {
						gmap3_init();
					});
					
					gmap3_init();
					
					function gmap3_init() {
						jQuery("#map-<?php echo (!empty($unique_id)) ? $unique_id : '' ?>").gmap3('destroy');
						
						jQuery("#map-<?php echo (!empty($unique_id)) ? $unique_id : '' ?>").gmap3({
							marker: {
								address: "<?php echo (!empty($address)) ? $address : ''; ?>"
							},
							map: {
								options: {
									zoom: 14,
									navigationControl: true,
									scrollwheel: false,
									streetViewControl: true
								}
							}
						});
					}
                });
            </script>

        </div>

        <?php if (!empty($content)) { ?>

            <div class="<?php echo $columns; ?> columns">

                <?php echo mvb_parse_content($content); ?>

            </div>

        <?php } ?>

    </div>
</div>
