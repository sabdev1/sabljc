<?php

$font_variants = array(
	'r' => __('Regular', 'gfw'),
	'i' => __('Italic', 'gfw'),
	'b' => __('Bold', 'gfw'),
	'ib' => __('BoldItalic', 'gfw'),
)

?>
<div id="gfw-rule-<?php echo $rule['id'];?>" class="gfw-rule<?php if($rule['collapsed']=='true'):?> collapsed<?php endif?>" rel="<?php echo $rule['id'];?>">
	<div class="gfw-rule-controls">
		<a href="javascript:void(0);" class="collapse" title="<?php _e('Collapse rule', 'gfw')?>"><img src="<?php echo plugins_url('images/collapse.png', __FILE__);?>" alt="collapse"/></a>
		<a href="javascript:void(0);" class="delete" title="<?php _e('Delete rule', 'gfw')?>"><img src="<?php echo plugins_url('images/delete.png', __FILE__);?>" alt="delete"/></a>
	</div>
	
	<div class="gfw-rule-collapsed">
		<span></span>
	</div>
	
	<fieldset>
		<legend>
			<span class="gfw-selector-wrap">
				<input type="text" value="<?php echo $rule['selector']?>" class="gfw-selector" rel="<?php _e('Enter selector here', 'gfw');?>"/>
			</span>
		</legend>
	
		<span class="gfw-selector-prototype"></span>
	
		<div class="gfw-font-settings">

			<div class="gfw-font-wrap">
				
				<div class="gfw-font-family-wrap">
					<label><?php _e('Font family', 'gfw');?></label>
					<select class="gfw-font-family" name="font[family]">
						<?php foreach( $google_fonts as $font ):?>
							<?php if( $font == $rule['font_family'] ):?>
							<option selected="selected"><?php echo $font;?></option>
							<?php else: ?>
							<option><?php echo $font;?></option>
							<?php endif;?>
						<?php endforeach; ?>
					</select>
				</div><!-- .gfw-font-family-wrap -->

				<div class="gfw-font-variant-wrap">
					<label><?php _e('Variant', 'gfw');?></label>
					<select class="gfw-font-variant" name="font[variant]">
						<?php foreach( $font_variants as $k => $variant ):?>
							<?php if( $k == $rule['font_variant'] ):?>
							<option selected="selected" value="<?php echo $k ?>"><?php echo $variant;?></option>
							<?php else: ?>
							<option value="<?php echo $k ?>"><?php echo $variant;?></option>
							<?php endif;?>
						<?php endforeach; ?>
					</select>
				</div><!-- .gfw-font-variant-wrap -->
				
			</div><!-- .gfw-font-wrap -->
			
			<div class="gfw-font-outfit-wrap">
				
				<div class="gfw-font-size-wrap">
					<label><?php _e('Font size', 'gfw');?></label>
					<div class="gfw-font-size-slider"></div>
					<input type="hidden" class="gfw-font-size" value="<?php echo $rule['font_size']?>"/>
				</div><!-- .fontiffic-font-size-wrap -->
				
				<div class="gfw-font-color-outer-wrap">
					<label><?php _e('Font color', 'gfw');?></label>
					<span class="gfw-font-color-wrap">
						<label for="fc">#</label>
						<input type="text" size="6" name="font[color]" class="gfw-font-color" maxlength="6" value="<?php echo $rule['font_color']?>"/>
						
					</span>
					<img src="<?php echo plugins_url( 'images/color.png', __FILE__ );?>" alt="Color wheel" class="gfw-colorwheel"/>
				</div><!-- .fontiffic-font-color-outer-wrap -->
				
			</div><!-- .gfw-font-outfit-wrap -->
			
			<div class="gfw-font-spacing">
				<div class="gfw-spacing-line-wrap">
					<label><?php _e('Line height', 'gfw');?></label>
					<div class="gfw-spacing-line"></div>
					<input type="hidden" class="gfw-font-spacing-line" value="<?php echo $rule['font_line_height']?>"/>
				</div><!-- .gfw-spacing-line-wrap -->
				<div class="gfw-spacing-word-wrap">
					<label><?php _e('Word spacing', 'gfw');?></label>
					<div class="gfw-spacing-word"></div>
					<input type="hidden" class="gfw-font-spacing-word" value="<?php echo $rule['font_word_spacing']?>"/>
				</div><!-- .gfw-spacing-word-wrap -->
				<div class="gfw-spacing-letter-wrap">
					<label><?php _e('Letter spacing', 'gfw');?></label>
					<div class="gfw-spacing-letter"></div>
					<input type="hidden" class="gfw-font-spacing-letter" value="<?php echo $rule['font_letter_spacing']?>"/>
				</div><!-- .gfw-spacing-letter-wrap -->
			</div><!-- .fontiffic-font-spacing -->
	
		</div><!-- .gfw-font-factory -->
		
		<div class="gfw-font-preview">
			<label><?php _e('Preview', 'gfw');?><span class="gfw-font-summary"><span class="fontfamily"><?php echo $rule['font_family'];?></span>, <span class="fontsize"><?php echo $rule['font_size'];?>px</span>, <span class="fontvariant"><?php echo $font_variants[$rule['font_variant']];?></span></span></label>
				<textarea><?php _e('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'gfw');?></textarea>
		</div><!-- .gfw-font-preview -->
	
	</fieldset>

</div>