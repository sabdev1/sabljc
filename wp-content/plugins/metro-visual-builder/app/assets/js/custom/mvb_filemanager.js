jQuery(document).ready(function($){
    //img upload
   $(".bshaper_metro_delete_btn").live('click', function(e){
        e.preventDefault();

        if(  confirm('Are you sure you want to delete this item?') )
        {
            var _alink = $(this);
            var _parent = _alink.parents('.bshaper_metro_photo_holder');

            _alink.hide();
            _parent.find('.bshaper_metro_image_holder').removeClass('bshaper_metro_no_bg');
            _parent.find('.bshaper_metro_image_holder').find('img').remove();
            _parent.find('.bshaper_module_image').val('');
        }//endif;
     });

/*
      var _custom_media = true,
      _orig_send_attachment = wp.media.editor.send.attachment;
*/

      $('.bshaper_metro_upload_file').live('click', function(e) {
          e.preventDefault();

          var send_attachment_bkp = wp.media.editor.send.attachment;
          var _alink = $(this);
          var _delete_link = _alink.next('.bshaper_metro_delete_btn');
          var _parent = _alink.parents('.bshaper_metro_photo_holder');
          var _field = _parent.find('.bshaper_module_image');

          _custom_media = true;
          wp.media.editor.send.attachment = function(props, attachment){
            if ( _custom_media ) {
              _field.val(attachment.id);
              var _img = $('<img />').attr({ 'src': attachment.url });
              //alert(attachment.url);

              _parent.find('.bshaper_metro_image_holder').addClass('bshaper_metro_no_bg');
              _parent.find('.bshaper_metro_image_holder').find('img').remove();
              _parent.find('.bshaper_metro_image_holder').show().append(_img);

              _delete_link.show();
            } else {
              return _orig_send_attachment.apply( this, [props, attachment] );
            };
          }

          wp.media.editor.open(_alink);
          return false;
        });

        $('.add_media').on('click', function(){
          _custom_media = false;
        });

        $('.metro_document_upload').live('click', function(e) {
          e.preventDefault();

          var send_attachment_bkp = wp.media.editor.send.attachment;
          var _alink = $(this);
          var _field = _alink.prev('.'+_alink.attr('rel'));

          _custom_media = true;
          wp.media.editor.send.attachment = function(props, attachment){
            if ( _custom_media ) {
              _field.val(attachment.url);
            } else {
              return _orig_send_attachment.apply( this, [props, attachment] );
            };
          }

          wp.media.editor.open(_alink);
          return false;
        });

        $('.add_media').on('click', function(){
          _custom_media = false;
        });
   //img upload
});//document ready