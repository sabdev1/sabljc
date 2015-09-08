<h1>Google Fonts WordPress</h1>

<div id="gfw-plugin-description">
	<ul>
		<li><?php _e('For more details about Google Web Fonts please visit', 'gfw')?> <a href="http://www.google.com/webfonts" title="<?php _e('Official Google Web Fonts website', 'gfw')?>"><?php _e('Google Fonts website', 'gfw')?></a></li>
	<? /*	<li><?php _e('Need help? Please visit', 'gfw')?> <a href="http://kringapps.com/gfw" title="<?php _e('Official gfw website', 'gfw')?>"><?php _e('official plugin website', 'gfw')?></a></li>*/?>
	</ul>
	
</div>

<div class="gfw-controls">
	<ul>
		<li><a href="javascript:void(0);" class="collapse-all"><?php _e('collapse all', 'gfw')?></a></li>
		<li><a href="javascript:void(0);" class="expand-all"><?php _e('expand all', 'gfw')?></a></li>
	</ul>
	<div class="save-all">
		<a href="javascript:void(0);"><span><?php _e('Save all changes', 'gfw')?></span></a>
	</div>
</div>

<div id="gfw-font-factory">
	<?php if( !empty( $rules ) ):?>
		<?php foreach( $rules as $k => $rule ): ?>
			<?php $rule['id'] = $k;?>
			<?php include('gfw_rule.php'); ?>
		<?php endforeach;?>
	<?php endif;?>
</div><!--#gfw-font-factory-->

<div class="gfw-controls">
	<ul>
		<li><a href="javascript:void(0);" class="collapse-all"><?php _e('collapse all', 'gfw')?></a></li>
		<li><a href="javascript:void(0);" class="expand-all"><?php _e('expand all', 'gfw')?></a></li>
	</ul>
	<div class="save-all">
		<a href="javascript:void(0);"><span><?php _e('Save all changes', 'gfw')?></span></a>
	</div>
</div>

<div id="gfw-add-rule">
	
	<a href="javascript:void(0);"><span><?php _e('New font rule', 'gfw')?></span></a>
	
</div>