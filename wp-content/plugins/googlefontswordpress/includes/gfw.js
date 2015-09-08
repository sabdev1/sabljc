$ = jQuery.noConflict();

//Loading Google Font API

if(typeof(google)!="undefined")
	google.load("webfont", "1");

function gfw_selector_update(obj){
	var selector = obj;
	var prototype = selector.parent().parent().parent().find('.gfw-selector-prototype');
	var collapsed = selector.parent().parent().parent().parent().find('.gfw-rule-collapsed span');
	var wrap = selector.parent();
	var text = selector.val();
	
	if( !text.length ){
		text = selector.attr('rel');
	}
	
	prototype.text(text);
	collapsed.text(text);
	
	var width = prototype.width();

	wrap.width(width+15);

	if( $.browser.webkit ){
		var offset = wrap.offset().left;
		selector.offset({left: offset});
	}
	
}

/**
 *	Collapse font rule
 *
 */
function gfw_rule_collapse(rule){
	var collapsed = rule.find('.gfw-rule-collapsed');
	var fieldset = rule.find('fieldset');

		collapsed.show();
		fieldset.hide();
		rule.addClass('collapsed');
}

/**
 *	Collapse font rule
 *
 */
function gfw_rule_collapse_toggle(rule){
	var collapsed = rule.find('.gfw-rule-collapsed');
	var fieldset = rule.find('fieldset');
	
	if( rule.hasClass('collapsed') ){
		collapsed.hide();
		fieldset.show();
		rule.removeClass('collapsed');
	}else{
		collapsed.show();
		fieldset.hide();
		rule.addClass('collapsed');
	}
}

/**
 *	Collapse all font rules
 *
 */

function gfw_collapse_all(){
	
	$('.gfw-rule').each(function(){
		var rule = $(this);
		var collapsed = rule.find('.gfw-rule-collapsed');
		var fieldset = rule.find('fieldset');

		collapsed.show();
		fieldset.hide();
		rule.addClass('collapsed');
	});
	
}

/**
 *	Expand all font rules
 *
 */

function gfw_expand_all(){
	$('.gfw-rule').each(function(){
		var rule = $(this);
		var collapsed = rule.find('.gfw-rule-collapsed');
		var fieldset = rule.find('fieldset');

		collapsed.hide();
		fieldset.show();
		rule.removeClass('collapsed');
	});
}

function gfw_init_rules(){
	
	// Update font preview
	
	$('.gfw-rule').each(function(){
		var rule = $(this);
		
		var font_family = rule.find('.gfw-font-family').val();
		var font_size = rule.find('.gfw-font-size').val();
		var line_height = rule.find('.gfw-font-spacing-line').val();
		var word_spacing = rule.find('.gfw-font-spacing-word').val();
		var letter_spacing = rule.find('.gfw-font-spacing-letter').val();
		var font_color = rule.find('.gfw-font-color').val();
		
		WebFont.load({
			google: {
		    	families: [ font_family + "::cyrillic,latin" ]
			},
			loading: function() {
				//$('.gfw-font-preview textarea').css('color', '#fff');
			},
			fontactive: function(){
				rule.find('.gfw-font-preview textarea').css('font-family', font_family);
				rule.find('.gfw-font-summary .fontfamily').text(font_family);
			}
		});
		
		rule.find('.gfw-font-preview textarea').css({
			'font-size': font_size + 'px',
			'line-height': line_height + 'em',
			'word-spacing': word_spacing + 'em',
			'letter-spacing': letter_spacing + 'em',
			'color': '#' + font_color
		});
		
		// Setup color picker
		
		rule.find('.gfw-colorwheel').ColorPicker({
			color: '#000000',
			onChange: function (hsb, hex, rgb) {
				rule.find('.gfw-font-preview textarea').css('color', '#' + hex);
				rule.find('.gfw-font-color').val(hex);
			}
		});
		
		
	});

	// Font family select
	$('.gfw-font-family').change(function(){
		var rule = $(this).parent().parent().parent().parent().parent();
		var font_family = $(this).val();
		
		WebFont.load({
			google: {
		    	families: [ font_family + "::cyrillic,latin" ]
			},
			loading: function() {
				//$('.gfw-font-preview textarea').css('color', '#fff');
			},
			fontactive: function(){
				rule.find('.gfw-font-preview textarea').css('font-family', font_family);
				rule.find('.gfw-font-summary .fontfamily').text(font_family);
			}
		});
		
	});
	
	$('.gfw-font-variant').change(function(){
		var rule = $(this).parent().parent().parent().parent().parent();
		var font_variant = $(this).val();
		
		switch( font_variant ){
			case 'i':
				rule.find('.gfw-font-preview textarea').css('font-weight', 'normal');
				rule.find('.gfw-font-preview textarea').css('font-style', 'italic');
				rule.find('.gfw-font-summary .fontvariant').text("Italic");
			break;
			case 'b':
				rule.find('.gfw-font-preview textarea').css('font-weight', 'bold');
				rule.find('.gfw-font-preview textarea').css('font-style', 'normal');
				rule.find('.gfw-font-summary .fontvariant').text("Bold");
			break;
			case 'ib':
				rule.find('.gfw-font-preview textarea').css('font-weight', 'bold');
				rule.find('.gfw-font-preview textarea').css('font-style', 'italic');
				rule.find('.gfw-font-summary .fontvariant').text("BoldItalic");
			break;
			default:
				rule.find('.gfw-font-preview textarea').css('font-weight', 'normal');
				rule.find('.gfw-font-preview textarea').css('font-style', 'normal');
				rule.find('.gfw-font-summary .fontvariant').text("Regular");
			break;
		}
		
		
	});

	// Font size slider

	$('.gfw-font-size-slider').each(function(){
		var rule = $(this).parent().parent().parent().parent().parent();
		
		var font_size_value = rule.find('.gfw-font-size').val();
		if( font_size_value == '' ){
			font_size_value = 12;
		}
		
		$(this).slider({
			min: 8,
			max: 70,
			value: font_size_value,
			slide: function(event, ui){
				var rule = $(this).parent().parent().parent().parent().parent();
				rule.find('.gfw-font-summary .fontsize').text(ui.value + 'px');
				rule.find('.gfw-font-preview textarea').css('font-size', ui.value);
				rule.find('.gfw-font-size').val(ui.value);
			}
		});
		
	});

	// Font spacing sliders
	
	// Line height
	$('.gfw-spacing-line').each(function(){
		var rule = $(this).parent().parent().parent().parent().parent();
		
		var font_line_height_value = rule.find('.gfw-font-spacing-line').val();
		if( font_line_height_value == '' ){
			font_line_height_value = 1;
		}
		
		$(this).slider({
			min: 0,
			max: 5,
			value: font_line_height_value,
			step: 0.1,
			slide: function(event, ui){
				var rule = $(this).parent().parent().parent().parent().parent();
				rule.find('.gfw-font-preview textarea').css('line-height', ui.value + 'em' );
				rule.find('.gfw-font-spacing-line').val(ui.value);
			}
		});
	});
	
	// Word spacing
	$('.gfw-spacing-word').each(function(){
		var rule = $(this).parent().parent().parent().parent().parent();
		
		var font_word_spacing_value = rule.find('.gfw-font-spacing-word').val();
		if( font_word_spacing_value == '' ){
			font_word_spacing_value = 0;
		}
		
		$(this).slider({
			min: 0,
			max: 3,
			value: font_word_spacing_value,
			step: 0.01,
			slide: function(event, ui){
				var rule = $(this).parent().parent().parent().parent().parent();
				rule.find('.gfw-font-preview textarea').css('word-spacing', ui.value + 'em' );
				rule.find('.gfw-font-spacing-word').val(ui.value);
			}
		});
	});
	
	// Letter spacing

	$('.gfw-spacing-letter').each(function(){
		var rule = $(this).parent().parent().parent().parent().parent();
		
		var font_letter_spacing_value = rule.find('.gfw-font-spacing-letter').val();
		if( font_letter_spacing_value == '' ){
			font_letter_spacing_value = 0;
		}
		
		$(this).slider({
			min: 0,
			max: 3,
			value: font_letter_spacing_value,
			step: 0.01,
			slide: function(event, ui){
				var rule = $(this).parent().parent().parent().parent().parent();
				rule.find('.gfw-font-preview textarea').css('letter-spacing', ui.value + 'em' );
				rule.find('.gfw-font-spacing-letter').val(ui.value);
			}
		});
	});
	
	$('.gfw-selector').each(function(){
		
		/* Init all selector fields */
		gfw_selector_update($(this));
		
		$(this).focus(function(){
			var selector = $(this);
			var legend = selector.parent().parent();
			legend.addClass('focused');
			
			var text = selector.val();
			var rel = selector.attr('rel');
			
			if( text == rel ){
				selector.val('');
			}
			
		});
		
		$(this).blur(function(){
			var selector = $(this);
			var legend = selector.parent().parent();
			legend.removeClass('focused');
			
			var text = selector.val();
			var rel = selector.attr('rel');
			
			if( text == '' ){
				selector.val(rel);
			}
		});
		
		$(this).keyup(function(){
			gfw_selector_update($(this));
		});
	});
	
	// Rule controls
	$('.gfw-rule-controls .collapse').unbind();
	$('.gfw-rule-controls .collapse').click(function(){
		var rule = $(this).parent().parent();
		gfw_rule_collapse_toggle(rule);
	});
	
	$('.gfw-rule-controls .delete').unbind();
	$('.gfw-rule-controls .delete').each(function(){
		var rule = $(this).parent().parent();
		
		$(this).click(function(){
			

			if( confirm( 'Are you sure you want to delete the rule?' ) ){
				rule.slideUp('slow', function(){
					rule.remove();
					
					var data = {
							action: 'gfw_delete',
							rule: rule.attr('rel'),
						};

						$.post(ajaxurl, data, function(response) {
						});
					
				});
			}
		});
	});
	
	// Collapse at load
	$('.gfw-rule').each(function(){
		var rule = $(this);
		if( rule.hasClass('collapsed') ){
			gfw_rule_collapse(rule);
		}
	});
}

$(document).ready(function(){
	
	gfw_init_rules();
	
	// Add new font rule
	$('#gfw-add-rule a').click(function(){
		var data = {
				action: 'gfw_add_rule'
			};

			$.post(ajaxurl, data, function(response) {
				var container = '#gfw-font-factory';
				$(container).append(response);
				gfw_init_rules();
			});
		
	});
	
	// Save all changes
	$('.save-all a').click(function(){
		
		var rules = new Array();
		
		var button = $(this);
		
		button.addClass('ajax');
		
		$('.gfw-rule').each(function(){
			var rule = $(this);
			
			var font_variant = rule.find('.gfw-font-variant').val();
			var font_weight = "normal";
			var font_style = "normal";
			
			switch(font_variant){
				case 'r': // Regular
				break;
				case 'b': // Bold
					font_weight = "bold";
					font_style = "normal";
				break;
				case 'i': // Italic
					font_weight = "normal";
					font_style = "italic";
				break;
				case 'ib': // Bold Itali
					font_weight = "bold";
					font_style = "italic";
				break;
			}
			
			rule_capsule = {
				//id: rule.attr('rel'),
				selector: rule.find('.gfw-selector').val(),
				font_family: rule.find('.gfw-font-family').val(),
				font_variant: font_variant,
				font_weight: font_weight,
				font_style: font_style,
				font_size: rule.find('.gfw-font-size').val(),
				font_color: rule.find('.gfw-font-color').val(),
				font_line_height: rule.find('.gfw-font-spacing-line').val(),
				font_word_spacing: rule.find('.gfw-font-spacing-word').val(),
				font_letter_spacing: rule.find('.gfw-font-spacing-letter').val(),
				collapsed: (rule.hasClass('collapsed'))?true:false
			};
			rules.push( rule_capsule );
		});
		
		var data = {
				action: 'gfw_save_all',
				rules: rules,
			};

			$.post(ajaxurl, data, function(response) {
				var container = '#gfw-font-factory';
				$(container).append(response);
				gfw_init_rules();
				button.removeClass('ajax');
			});
		
	});

	// Collapse all, uncollapse all
	$('.gfw-controls .collapse-all').click(function(){
		gfw_collapse_all();
	});
	
	$('.gfw-controls .expand-all').click(function(){
		gfw_expand_all();
	});
	
	
});