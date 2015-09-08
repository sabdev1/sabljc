var mvb_data;
var is_mvb_call = true;
var id_iterator = 1;

jQuery(document).bind({
    ajaxStart: function() {
        if( is_mvb_call )
            jQuery('body').addClass("mvb_loading");
    },
    ajaxStop: function() {
       is_mvb_call = false;
       jQuery('body').removeClass("mvb_loading");
    }
});

jQuery(document).ready(function($){
    var $__x = '';
    var $__xrow = '';
    var $__xcolumn = '';
    $.ajaxSetup({
       url: ajaxurl,
       async: true
     });

    var where_to_add = 'top';

    $( ".columns" ).sortable({
            connectWith: ".columns",
            handle: '.mvb_module_handler',
            delay: 100,
            placeholder: "column_placeholder",
            dropOnEmpty: true,
            update : bs_update_field
        });

    $( "#mvb_sortable_list" ).sortable({update : bs_update_field, delay: 100, handle: '.bshaper_handler', axis: 'y', placeholder: 'row_placeholder'});

    $(".mvb_delete_section").live('click', function(e){
        e.preventDefault();

        if( confirm("Are you sure you want to remove this row?") )
        {
            $(this).parents(".bshaper_row").fadeOut("slow").remove();
            bs_update_field_manual();
        }//endif;
    });

    $("a.bshaper_delete_module").live('click', function(e){
        e.preventDefault();
        if( confirm("Are you sure you want to remove this module?") )
        {
            $(this).parents(".bshaper_module").fadeOut("slow").remove();
            bs_update_field_manual();
        }//endif;

    });

    $("a.mvb_row_settings").live('click', function(e){
        e.preventDefault();
        //bs_update_field_manual();
        is_mvb_call = true;
        var therow = $(this).parents('.bshaper_row');
        $__xrow = therow;
		
		if ($('.bshaper_row_id').length) {
			$('.bshaper_row_id').val('-1');
		}

        var data = {
              		action: 'getRowSettings',
              		bgimage: therow.attr('data-mvb-bgimage'),
              		bgrepeat: therow.attr('data-mvb-bgrepeat'),
              		bgposition: therow.attr('data-mvb-bgposition'),
              		bgcolor: therow.attr('data-mvb-bgcolor'),
              		textcolor: therow.attr('data-mvb-textcolor'),
                    padding_top: therow.attr('data-mvb-paddtop'),
              		padding_bottom: therow.attr('data-mvb-paddbottom'),
              		css: therow.attr('data-mvb-css'),
              		background_check: therow.attr('data-mvb-background_check'),
              		row_padding_top: therow.attr('data-mvb-row_padding_top'),
              		row_padding_bottom: therow.attr('data-mvb-row_padding_bottom'),
              		row_full_width: therow.attr('data-mvb-row_full_width'),
              		cssclass_manual: therow.attr('data-mvb-cssclass_manual'),
                    totop: therow.attr('data-mvb-totop'),
					row_full_height: therow.attr('data-mvb-row_full_height'),
					post_id: therow.attr('data-mvb-post_id'),
              		video_display: therow.attr('data-mvb-video_display'),
              		video_repeat: therow.attr('data-mvb-video_repeat'),
              		video_shadow: therow.attr('data-mvb-video_shadow'),
              		video_poster: therow.attr('data-mvb-video_poster'),
              		video_mp4: therow.attr('data-mvb-video_mp4'),
              		video_webm: therow.attr('data-mvb-video_webm'),
              		video_ogg: therow.attr('data-mvb-video_ogg')
              	 };

        $.post(ajaxurl, data, function(_html) {
			if ($('.bshaper_row_id').length) {
				$('.bshaper_row_id').val(therow.attr('data-mvb-row_id'));
			}			
            $('#bshaper_tmp').html(_html).dialog( {modal:false,height: 600,width: 700, 'title' : 'Row Settings', zIndex: 100, open : mvb_dialog_open, beforeClose : mvb_dialog_close} );
            mvb_do_asm_select();
	        customselectinput();

            $('#bshaper_tmp').find('.mvb_color_field').each(function(i){

                var element_s = $('#bshaper_tmp').find('.mvb_color_field:eq('+i+')');

                if( !element_s.hasClass('mvb_repeater_field') )
                {
                  var c_id = element_s.attr('id');
                  bshaper_artist_color_picker("#"+c_id);
                  initialize_fields();
                  initialize_color_pickers();
                }//endif;
            });
      	});
    });

    $(".mvb_submit_row_settings").live('click', function(){
        var therow = $__xrow;
        therow.attr('data-mvb-bgimage', $("#bshaper_tmp").find('.mvb_module_bgimage').val());
        therow.attr('data-mvb-bgrepeat', $("#bshaper_tmp").find('.mvb_module_bgrepeat').val());
        therow.attr('data-mvb-bgposition', $("#bshaper_tmp").find('.mvb_module_bgposition').val());
        therow.attr('data-mvb-bgcolor', $("#bshaper_tmp").find('.mvb_module_bgcolor').val());
        therow.attr('data-mvb-textcolor', $("#bshaper_tmp").find('.mvb_module_textcolor').val());
        therow.attr('data-mvb-css', $("#bshaper_tmp").find('.mvb_module_css').val());
        therow.attr('data-mvb-paddtop', $("#bshaper_tmp").find('.mvb_module_padding_top').val());
        therow.attr('data-mvb-paddbottom', $("#bshaper_tmp").find('.mvb_module_padding_bottom').val());
        therow.attr('data-mvb-background_check', $("#bshaper_tmp").find('.mvb_module_background_check').val());
        therow.attr('data-mvb-row_padding_top', $("#bshaper_tmp").find('.mvb_module_row_padding_top').val());
        therow.attr('data-mvb-row_padding_bottom', $("#bshaper_tmp").find('.mvb_module_row_padding_bottom').val());
        therow.attr('data-mvb-row_full_width', $("#bshaper_tmp").find('.mvb_module_row_full_width').val());
        therow.attr('data-mvb-cssclass_manual', $("#bshaper_tmp").find('.mvb_module_cssclass_manual').val());
        therow.attr('data-mvb-totop', $("#bshaper_tmp").find('.mvb_module_totop').val());
		therow.attr('data-mvb-row_full_height', $("#bshaper_tmp").find('.mvb_module_row_full_height').val());
		therow.attr('data-mvb-post_id', $("#bshaper_tmp").find('.mvb_module_post_id').val());
        therow.attr('data-mvb-video_display', $("#bshaper_tmp").find('.mvb_module_video_display').val());
        therow.attr('data-mvb-video_repeat', $("#bshaper_tmp").find('.mvb_module_video_repeat').val());
        therow.attr('data-mvb-video_poster', $("#bshaper_tmp").find('.mvb_module_video_poster').val());
        therow.attr('data-mvb-video_mp4', $("#bshaper_tmp").find('.mvb_module_video_mp4').val());
        therow.attr('data-mvb-video_webm', $("#bshaper_tmp").find('.mvb_module_video_webm').val());
        therow.attr('data-mvb-video_shadow', $("#bshaper_tmp").find('.mvb_module_video_shadow').val());
        therow.attr('data-mvb-video_ogg', $("#bshaper_tmp").find('.mvb_module_video_ogg').val());

        $('#bshaper_tmp').dialog( "close" );

        bs_update_field_manual();

    });//end click .mvb_submit_row_settings

    $("a.mvb_column_settings").live('click', function(e){
        e.preventDefault();
        //bs_update_field_manual();
        is_mvb_call = true;
        var thecolumn = $(this).parents('.columns');
        $__xcolumn = thecolumn;
		
        var data = {
              		action: 'getColumnSettings',
              		bgimage: thecolumn.attr('data-mvb-bgimage'),
              		bgrepeat: thecolumn.attr('data-mvb-bgrepeat'),
              		bgposition: thecolumn.attr('data-mvb-bgposition'),
              		bgcolor: thecolumn.attr('data-mvb-bgcolor'),
              		background_check: thecolumn.attr('data-mvb-background_check'),
              		textcolor: thecolumn.attr('data-mvb-textcolor'),
              		css: thecolumn.attr('data-mvb-css'),
              		cssclass: thecolumn.attr('data-mvb-cssclass'),
                    totop: thecolumn.attr('data-mvb-totop'),
              		padding_top: thecolumn.attr('data-mvb-paddtop'),
              		padding_right: thecolumn.attr('data-mvb-paddright'),
              		padding_bottom: thecolumn.attr('data-mvb-paddbottom'),
              		padding_left: thecolumn.attr('data-mvb-paddleft'),
              		smallclass: thecolumn.attr('data-mvb-smallclass')
              	 };

        $.post(ajaxurl, data, function(_html) {
            $('#bshaper_tmp').html(_html).dialog( {modal:false,height: 600,width: 700, 'title' : 'Column Settings', zIndex: 100, open : mvb_dialog_open, beforeClose : mvb_dialog_close} );
            mvb_do_asm_select();
	        customselectinput();

            $('#bshaper_tmp').find('.mvb_color_field').each(function(i){

                var element_s = $('#bshaper_tmp').find('.mvb_color_field:eq('+i+')');

                if( !element_s.hasClass('mvb_repeater_field') )
                {
                  var c_id = element_s.attr('id');
                  bshaper_artist_color_picker("#"+c_id);
                  initialize_fields();
                  initialize_color_pickers();
                }//endif;
            });
      	});
    });//click .mvb_column_settings

    $(".mvb_submit_column_settings").live('click', function(){
        var thecolumn = $__xcolumn;
        thecolumn.attr('data-mvb-bgimage', $("#bshaper_tmp").find('.mvb_module_bgimage').val());
        thecolumn.attr('data-mvb-bgrepeat', $("#bshaper_tmp").find('.mvb_module_bgrepeat').val());
        thecolumn.attr('data-mvb-bgposition', $("#bshaper_tmp").find('.mvb_module_bgposition').val());
        thecolumn.attr('data-mvb-bgcolor', $("#bshaper_tmp").find('.mvb_module_bgcolor').val());
        thecolumn.attr('data-mvb-background_check', $("#bshaper_tmp").find('.mvb_module_background_check').val());
        thecolumn.attr('data-mvb-textcolor', $("#bshaper_tmp").find('.mvb_module_textcolor').val());
        thecolumn.attr('data-mvb-cssclass', $("#bshaper_tmp").find('.mvb_module_cssclass').val());
        thecolumn.attr('data-mvb-totop', $("#bshaper_tmp").find('.mvb_module_totop').val());
        thecolumn.attr('data-mvb-css', $("#bshaper_tmp").find('.mvb_module_css').val());
        thecolumn.attr('data-mvb-smallclass', $("#bshaper_tmp").find('.mvb_module_smallclass').val());
        thecolumn.attr('data-mvb-paddtop', $("#bshaper_tmp").find('.mvb_module_padding_top').val());
        thecolumn.attr('data-mvb-paddright', $("#bshaper_tmp").find('.mvb_module_padding_right').val());
        thecolumn.attr('data-mvb-paddbottom', $("#bshaper_tmp").find('.mvb_module_padding_bottom').val());
        thecolumn.attr('data-mvb-paddleft', $("#bshaper_tmp").find('.mvb_module_padding_left').val());

        $('#bshaper_tmp').dialog( "close" );

        bs_update_field_manual();

    });//end click .mvb_submit_column_settings

    $("a.mvb_clear_content").live('click', function(e){
        e.preventDefault();
        if( confirm( $(this).attr('data-confirm') ) )
        {
            $("#mvb_sortable_list").empty();
            bs_update_field_manual();
        }//endif;

    });

    $( "a.bshaper_add_section" ).click(function(e) {
        where_to_add = $(this).attr('data-where');
        $('#bshaper_tmp').html('');
        is_mvb_call = true;
        $('#bshaper_tmp').load('admin-ajax.php?action=getSectionTypes').dialog( {modal:false,height: 200,width: 700, 'title' : 'Add section', zIndex: 100, open : mvb_dialog_open, beforeClose : mvb_dialog_close } );

        e.preventDefault();
    });//end add_section click

    $("a.mvb_add_section_type").live('click', function(e){
        e.preventDefault();
        is_mvb_call = true;

        var $_html = '<li class="row bshaper_row">'+$($(this).attr("href")).html()+'</li>';

        if( where_to_add == 'bottom' )
        {
            $("#mvb_sortable_list").append($_html);
        }
        else
        {
            $("#mvb_sortable_list").prepend($_html);
        }

        $( ".columns" ).sortable({
              connectWith: ".columns",
              handle: '.mvb_module_handler',
              delay: 100,
              placeholder: "column_placeholder",
              dropOnEmpty: true,
              update : bs_update_field
            });

        $('#bshaper_tmp').dialog( "close" );

        bs_update_field_manual();
        return false;
    }); //end mvb_add_section_type click

    $( "a.bshaper_add_module" ).live('click', function(e) {
        $('#bshaper_tmp').html('');
        is_mvb_call = true;
        $('#bshaper_tmp').load('admin-ajax.php?action=bshaperGetModules').dialog( {modal:false,height: 600,width: 820, 'title' : 'Add a new module', zIndex: 100, open : mvb_dialog_open, beforeClose : mvb_dialog_close} );
        $__x = $(this);
        e.preventDefault();
    });//end bshaper_add_module click

    $(".bshaper_modules li a").live('click', function(e){
        e.preventDefault();
        is_mvb_call = true;
        $(".module_list").hide();
        $(".the_modules").slideDown();

         var data = {
              		action: 'bshaperShowModule',
              		module: $(this).attr("data-module")
              	 };
        $.post(ajaxurl, data, function(_html) {
            $('#bshaper_content_form_module')[0].innerHTML = _html;
            mvb_do_asm_select();
			
			jQuery('.shadow_ul textarea.mvb_textarea_with_editor').removeClass('mvb_textarea_with_editor').addClass('mvb_textarea_with_editor_');
			
            initTheEditor('mvb_textarea_with_editor');
            $('#bshaper_content_form_module').find('.mvb_color_field').each(function(i){
                var element_s = $('#bshaper_content_form_module').find('.mvb_color_field:eq('+i+')');

                if( !element_s.hasClass('mvb_repeater_field') )
                {
                    var c_id = element_s.attr('id');
                    bshaper_artist_color_picker("#"+c_id);
                    initialize_fields();
                }//endif;
            });
			
			//mvb_init_text_and_tinymce_field();

            $('.module_form').show();
      	});
    });

    $(".bshaper_back_to_module_list").live("click", function(e){
        e.preventDefault();
        $(".the_modules").hide();
        $('.module_form').hide();
        $(".module_list").slideDown();
        removeTinyMCE('mvb_textarea_with_editor');
        return false;
    });//end bshaper_back_to_module_list;

    $(".bshaper_add_module_html").live('click', function(e){
        e.preventDefault();
        is_mvb_call = true;
        $(this).after('<div class="bshaper_loading">saving...</div>');

        mvb_data = find_all_vars($(this));
        mvb_data.action = 'bshaperAddModule';

        mvb_data.module = $(this).parents('.module_form').find('.mvb_the_module').val();
        mvb_data.sc_action = $(this).parents('.module_form').find('.mvb_the_action').val();



        $.post(ajaxurl, mvb_data, function(_html) {
            if( mvb_data.sc_action == 'edit')
            {
                $__x.parents('.bshaper_module').replaceWith(_html);
            }
            else
            {
                $__x.parents('.columns').append(_html);
            }
            bs_update_field_manual();
      	});

        $('#bshaper_tmp').dialog( "close" );
        //dump(mvb_data);
        //alert(mvb_data.sc_action);
    });//bshaper_add_module_html click

    $( "a.bshaper_edit_module" ).live('click', function(e) {
        is_mvb_call = true;
        var shortcode = $(this).parents('.bshaper_module').find('.bshaper_sh').html();

        var data = {
              		action: 'bshaperEditModule',
              		shortcode: shortcode
              	 };
        $.post(ajaxurl, data, function(_html) {
            $('#bshaper_tmp').html(_html).dialog( {modal:false,height: 600, width: 700, position: { my: 'center', at: 'center', of: window},'title' : 'Edit module', zIndex: 100, open : mvb_dialog_open, beforeClose : mvb_dialog_close} );
            mvb_do_asm_select();
			//mvb_init_text_and_tinymce_field();
			initialize_fields();
			
            $('#bshaper_tmp').find('.mvb_color_field').each(function(i){
                var element_s = $('#bshaper_tmp').find('.mvb_color_field:eq('+i+')');
				var c_id = element_s.attr('id');
				bshaper_artist_color_picker("#"+c_id);
				initialize_color_pickers();
            });
      	});

        $__x = $(this);

        e.preventDefault();
    });//end bshaper_edit_module click
    //repeater field
    $(".bshaper_acc_add_section").live('click', function(e){
        e.preventDefault();
        var _what = $(this).attr('data-what');
		
        $("#"+_what).append($("."+_what+"_shadow_ul").html());
		$("#"+_what).find('textarea.mvb_textarea_with_editor_').removeClass('mvb_textarea_with_editor_').addClass('mvb_textarea_with_editor');

        //here
		initialize_fields();
        initialize_color_pickers();
		initTheEditor('mvb_textarea_with_editor');
    });

    $(".bshaper_hide_section").live('click', function(e){
        e.preventDefault();
        var $a = $(this);
        $a.parent('.bshaper_hide_section_h').next('.bshaper_section_holder').slideToggle('fast', function(){
            if( $a.parent('.bshaper_hide_section_h').hasClass('bshaper_active') )
            {
                $a.parent('.bshaper_hide_section_h').removeClass('bshaper_active');
            }
            else
            {
                $a.parent('.bshaper_hide_section_h').addClass('bshaper_active');
            }//endif;
        });
    });//end bshaper_hide_section click

    $(".repeater_sortable .mvb_st_section_title").live('change', function(){
        var $obj = $(this);

        $obj.parents('li').find('.bshaper_section_name').text($obj.val());
    });

    //end repeater field

});//document ready

function initialize_fields()
{
    var $ = jQuery;
    if( $(".repeater_sortable").length > 0 ) {
        $(".repeater_sortable").sortable({placeholder: "acc_placeholder", handle: ".bshaper_handler_acc", axis: 'y'});
    }//endif;
}//end initialize_fields

function initialize_color_pickers()
{
    var $ = jQuery;
    if( $(".repeater_sortable").length > 0 )
    {
        $('.repeater_sortable').find('.mvb_color_field').each(function(i){
                var element_t = $('#bshaper_tmp .repeater_sortable').find('.mvb_color_field:eq('+i+')');

                if( element_t.attr('data-hascp') != 'yes' )
                {
                    var c_id = element_t.attr('id');

                    var new_id = c_id+"_"+id_iterator;

                    element_t.attr('id', new_id);
                    element_t.attr('data-hascp', 'yes');
                    bshaper_artist_color_picker("#"+new_id);

                    id_iterator++;
                }//endif;
            });
    }//endif;
}//end initialize_color_pickers

function find_all_vars( cel )
{
    var $ = jQuery;
    var $_action = cel.parents('.module_form').find('.bshaper_artist_action').val();
    var obj_frm = cel.parents('.module_form');
    var mvb_data = {};
    var t = [];
    //simple fields

    obj_frm.find('.mvb_module_field').each(function(i){
        var field_tmp = obj_frm.find('.mvb_module_field:eq('+i+')');

        if( !field_tmp.hasClass('mvb_repeater_field') )
        {
            if( field_tmp.attr('type') == 'radio' )
            {
                var field_tmp = obj_frm.find('.mvb_module_field:eq('+i+')[checked="checked"]');
                mvb_data[field_tmp.attr('name')] = field_tmp.val();
            }
            else
            {
                if( !field_tmp.hasClass('mvb_textarea_with_editor') ) {
                    mvb_data[field_tmp.attr('name')] = field_tmp.val();
				} else {
                    mvb_data[field_tmp.attr('name')] = tinyMCE.activeEditor.getContent();
				}
            }//endif;
        }
    });

    if( $('.repeater_sortable').length > 0 )
    {
         var iterator = 0;
         var oname = '';

         $(".repeater_sortable li").each(function(){
            var tmp = {};
            var $frm = $(this);
            oname = $frm.parents('.repeater_sortable').attr('data-field');

            if( !$frm.find(".bshaper_remove_section_cbx").is(':checked') )
            {
                $frm.find('.mvb_module_field').each(function(the_index){
                    var repeater_field_tmp = $frm.find('.mvb_module_field:eq('+the_index+')');
					
					if (repeater_field_tmp.hasClass('mvb_textarea_with_editor')) {
						if (repeater_field_tmp.val() == '' && repeater_field_tmp.val() != tinyMCE.get(repeater_field_tmp.attr('id')).getContent()) {
							tmp[repeater_field_tmp.attr('name')] = tinyMCE.get(repeater_field_tmp.attr('id')).getContent();
						} else {
							tmp[repeater_field_tmp.attr('name')] = repeater_field_tmp.val();
						}
					} else {
						tmp[repeater_field_tmp.attr('name')] = repeater_field_tmp.val();
					}
                });

                t.push(tmp);
            }//endif;
         });

         mvb_data[oname] = t;
    }//endif repeater;

    return mvb_data;
}//end find_all_vars();

var bshaper_col_sortable = {
			connectWith: ".columns",
            handle: 'mvb_module_handler',
            delay: 300,
            placeholder: "column_placeholder",
            dropOnEmpty: true,
            update : bs_update_field
};

function bs_update_field(e, ui)
{
    var $ = jQuery;
    is_mvb_call = true;

    var bshaper_post_id = $(".bshaper_the_post_id").val();
    var bshaper_nonce = $(".bshaper_ajax_referrer").val();

    if (!ui.sender) {
        var _html = $("#mvb_sortable_list").html();
        var data = {
              		action: 'bshaperSaveMeta',
              		the_html: _html,
              		bshaper_metro_nonce: bshaper_nonce,
                    post_id: bshaper_post_id
              	 };
        $.post(
            ajaxurl,
            data,
            function(response) {
                $("#mvb_sortable_list").html(response);
                $("#bshaper_artist_content_html").text(response);
                $( ".columns" ).sortable({
                  connectWith: ".columns",
                  handle: '.mvb_module_handler',
                  delay: 100,
                  placeholder: "column_placeholder",
                  dropOnEmpty: true,
                  update : bs_update_field
                });
            }
        );
    }
}

/*misc functions*/

function bs_update_field_manual()
{
    var $ = jQuery;
    is_mvb_call = true;
    var bshaper_post_id = $(".bshaper_the_post_id").val();
    var bshaper_nonce = $(".bshaper_ajax_referrer").val();
	var bshaper_row_id = $('.bshaper_row_id').val();
    var _html = $("#mvb_sortable_list").html();
	
	//_html = _html.replace(/\\{1,}"/g, '\'');

    var data = {
          		action: 'bshaperSaveMeta',
          		the_html: _html,
                bshaper_metro_nonce: bshaper_nonce,
                post_id: bshaper_post_id,
				row_id: bshaper_row_id
          	 };

    $.post(
        ajaxurl,
        data,
        function(response) {
			$('.bshaper_row_id').val('-1');
            $("#mvb_sortable_list").html(response);
            $("#bshaper_artist_content_html").text(response);
            $( ".columns" ).sortable({
              connectWith: ".columns",
              handle: '.mvb_module_handler',
              delay: 100,
              placeholder: "column_placeholder",
              dropOnEmpty: true,
              update : bs_update_field
            });
        }
    );
}//end bs_update_field_manual()

var bshaper_col_sortable = {
			connectWith: ".columns",
            placeholder: "column_placeholder",
            dropOnEmpty: true,
            cancel: ".bshaper_add_module",
            update : bs_update_field
};

function bshaper_artist_color_picker(_what)
{	
  jQuery(_what).ColorPicker({
                        color: "#"+jQuery(_what).val(),
                        onChange: function (hsb, hex, rgb) {
                                		jQuery(_what).next('.bshaper_color_preview').css("backgroundColor", "#" + hex);
                                        jQuery(_what).val(hex);
                                	}
                     });
}//end bshaper_artist_color_picker()

function mvb_dialog_open()
{
    jQuery('body').addClass('mvb_load_dialog');
	jQuery('.shadow_ul textarea.mvb_textarea_with_editor').removeClass('mvb_textarea_with_editor').addClass('mvb_textarea_with_editor_');
	
    initTheEditor('mvb_textarea_with_editor');
}//end mvb_dialog_open()

function mvb_dialog_close()
{
    jQuery('body').removeClass('mvb_load_dialog');
    removeTinyMCE('mvb_textarea_with_editor');
}//end mvb_dialog_close()

function removeTinyMCE(inst) {
	
	var elements = jQuery('textarea.'+inst);
	
	jQuery.each(elements, function(key, value) {
		var el = jQuery(value);
		
		//el.siblings('.mvb-editor-tools').empty();
		
		if (el.attr('id') != '' && el.attr('id') != undefined) {
			if (tinyMCE.majorVersion == 4) {
				tinyMCE.execCommand('mceRemoveEditor', false, el.attr('id'));
			} else {
				tinyMCE.execCommand('mceRemoveControl', false, el.attr('id'));
			}
		} else {
			var id = 'mvb_twe_'+Math.random().toString(36).substring(7);
			el.attr('id', id);
			
			if (tinyMCE.majorVersion == 4) {
				tinyMCE.execCommand('mceRemoveEditor', false, id);
			} else {
				tinyMCE.execCommand('mceRemoveControl', false, id);
			}
		}
	});
	
}//removeTinyMce

function initTheEditor(element_class) {
	
	removeTinyMCE(element_class);
	
	var styled_button, load_plugins = '';
	if (styled_button_plugin != undefined) {
		tinyMCE.PluginManager.load('styled_button', styled_button_plugin);
		load_plugins = styled_button = ',styled_button';
	}
	
	if (tinyMCE.majorVersion == 4) {
		if (tinymce.PluginManager.get('code') != undefined) {
			load_plugins += ',code';
		} else {
			tinyMCE.PluginManager.load('code', mvb_support_params.tinymce_plugins_url+'code.min.js');
			load_plugins += ',code';
		}
	}
	
    tinyMCE.init({
		mode: 'specific_textareas',
        language: mvb_l_lang,
        theme: (tinyMCE.majorVersion == 3) ? "advanced" : "modern",
        skin: (tinyMCE.majorVersion == 3) ? "wp_theme" : "lightgray",
        plugins: (tinyMCE.majorVersion == 3) 
			? 'inlinepopups,spellchecker,tabfocus,paste,media,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpfullscreen'+load_plugins 
			: 'tabfocus,paste,media,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpfullscreen'+load_plugins,
        theme_advanced_buttons1: "formatselect,separator,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,table,separator,forecolor,backcolor,image,separator,pastetext,separator,link,unlink,separator,code"+styled_button,
        relative_urls: true,
        remove_script_host: false,
        convert_urls: false,
        forced_root_block : false,
        force_br_newlines : false,
        force_p_newlines : true,
        width: 650,
        height: 300,
		editor_selector: element_class,
		init_instance_callback: function(inst) {
			if (tinyMCE.majorVersion == 3) {
				var insert_image_button = jQuery('<a href="#" data-editor="'+inst.id+'" class="button mvb-editor-insert-image">Add image</a>');
				jQuery('#'+inst.id).siblings('.mvb-editor-tools').empty().append(insert_image_button);

				insert_image_button.bind('click', function() {
					var $this = jQuery(this);
					window.mvb_editor_id = $this.data('editor');	
					tb_show('', 'media-upload.php?type=image&cmb_force_send=true&cmb_send_label=Insert Image&TB_iframe=true');
					return false;
				});
			}
		}
    });
}//initTheEditor

window.send_to_editor_bk = window.send_to_editor;
window.send_to_editor = function(html) {
	if (window.mvb_editor_id != undefined && document.getElementById(window.mvb_editor_id) != null) {
		tinyMCE.execInstanceCommand(window.mvb_editor_id, 'mceInsertContent', false, html);
		window.mvb_editor_id = undefined;
		tb_remove();
		return false;
	} else {
		window.send_to_editor_bk(html);
	}
}

function dump(obj) {
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }

    alert(out);

    // or, if you wanted to avoid alerts...

    var pre = document.createElement('pre');
    pre.innerHTML = out;
    document.body.appendChild(pre)
}//dump

function mvb_do_asm_select()
{
    var $ = jQuery;
    $('#bshaper_tmp .mvb_asm_field').each(function(the_index){
        var the_field = $('#bshaper_tmp').find('.mvb_asm_field:eq('+the_index+')');

        $( "#"+the_field.attr('id') ).asmSelect({
                addItemTarget: 'top',
                sortable: the_field.attr('data-sortable')
            });
    });

}//end mvb_do_asm_select()

function customselectinput()
{
	var $ = jQuery;

	$('.autocomplite-block .autocomplite-pseudo-fild').click( function () {

		var $this = $(this);
		var $dropdown = $this.parent();

		$dropdown.toggleClass('open');
		$(document).click( function(event){
			if( $(event.target).closest($dropdown).length )
				return;
			$dropdown.removeClass("open");
			event.stopPropagation();
		});
	});

	$('.autocomplite-block .autocomplite-conteiner div').click( function() {
		var $this = $(this);
		var $val = $this.data('value');
		var $autocon = $this.parent();
		var $dropdown = $autocon.parent();
		$autocon.find('input').val($val);
		$autocon.find('.value').removeClass('checked');
		$this.addClass('checked');
		$dropdown.removeClass('open');
		$dropdown.find('.autocomplite-pseudo-fild').html($this.html()+'<b class="caret"></b>');
	});
	$('.autocomplite-block input').keyup( function(key) {
		var $this = $(this);
		var $dropdown = $this.parent().parent();
		var val = $this.val();

		if (key.keyCode == 13) {
			$dropdown.removeClass('open')
		} else {
			$dropdown.find('.autocomplite-pseudo-fild').html('Custom: '+val+' px '+'<b class="caret"></b>');
		}

	} );
}
