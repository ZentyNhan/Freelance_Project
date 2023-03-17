(function ($) {
    'use strict';

    $(document).on('click', '.tried-media-button', function(e){
        e.preventDefault();
        const wrapper = $(this).closest('.tried-media-wrapper');
        let aw_uploader = wp.media({
            title: 'Custom image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = aw_uploader.state().get('selection').first().toJSON();
            wrapper.find('.tried-media-input').val(attachment.url);
            wrapper.find('.tried-media-result').attr('src', attachment.url);
        }).open();
    });

    $( document ).on('submit', '.tried-admin-page', function(e) {
        e.preventDefault();
        $.ajax({
            type : "get", 
            url : ajaxurl, 
            data : { 
                action: 'tried_general_form',
                nonce: 'a'
            },
            beforeSend: function() {
                $(this).addClass('processing');
            },
            success: function(response) {
            },
            complete: function(response) {
                $(this).removeClass('processing');
            },
            error: function( jqXHR, textStatus, errorThrown ) {
                console.log( 'The following error occured: ' + textStatus, errorThrown );
            }
        });
    });

    $( document ).on( 'change', 'select.slct-provinces', function(e) {
		e.preventDefault();
        var wrapper = $(this).closest('.slct-position'),
            province_service = $('option:selected', this).attr('data-service'),
            province_id = $(this).val();
        if ( province_id ) {
            $.ajax({
                type : "get", 
                url : ajaxurl, 
                data : {
                    action: 'render_districts',
                    province: province_service
                },
                beforeSend: function() {
                    wrapper.find('.slct-provinces').attr('disabled', 'disabled');
                    wrapper.find('.slct-districts').attr('disabled', 'disabled');
                },
                success: function(res) {
                    if ( res.code == 200 ) {
                        wrapper.find('.slct-districts').html('<option value="">Chọn huyện</option>');
                        res.response.forEach(function(item) {
                            wrapper.find('.slct-districts').append(`<option value="${item.district_service_order}-${item.district_service_key}" data-type="${item.type}" data-service="${item.district_service_key}">${item.name}</option>`);
                        });
                    } else {
                        console.log('Có lỗi xảy ra!');
                    }
                },
                complete: function() {
                    wrapper.find('.slct-provinces').removeAttr('disabled');
                    wrapper.find('.slct-districts').removeAttr('disabled');
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                    console.log( 'The following error occured: ' + textStatus, errorThrown );
                }
            });
        }
	} );

    /** Custom User's avatar */
    // Uploading files
    var file_frame;
    $('.tried_wpmu_button').on('click', function( event ){
        event.preventDefault();
        // If the media frame already exists, reopen it.
        if ( file_frame ) {
            file_frame.open();
            return;
        }
        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: $( this ).data( 'uploader_title' ),
            button: {
                text: $( this ).data( 'uploader_button_text' ),
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });
        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            let attachment = file_frame.state().get('selection').first().toJSON();
            // Do something with attachment.id and/or attachment.url here
            // write the selected image url to the value of the #tried_meta text field
            $('#tried_meta').val('');
            $('#tried_upload_meta').val(attachment.url);
            $('#tried_upload_edit_meta').val('/wp-admin/post.php?post='+attachment.id+'&action=edit&image-editor');
            $('.tried-current-img').attr('src', attachment.url).removeClass('placeholder');
        });
        // Finally, open the modal
        file_frame.open();
    });
        
    // Toggle Image Type
    $('input[name=img_option]').on('click', function( event ){
        var imgOption = $(this).val();
        if (imgOption == 'external'){
            $('#tried_upload').hide();
            $('#tried_external').show();
        } else if (imgOption == 'upload'){
            $('#tried_external').hide();
            $('#tried_upload').show();
        }
    });
          
    if ( '' !== $('#tried_meta').val() ) {
        $('#external_option').attr('checked', 'checked');
        $('#tried_external').show();
        $('#tried_upload').hide();
    } else {
        $('#upload_option').attr('checked', 'checked');
    }
        
    // Update hidden field meta when external option url is entered
    $('#tried_meta').blur(function(event) {
        if( '' !== $(this).val() ) {
            $('#tried_upload_meta').val('');
            $('.tried-current-img').attr('src', $(this).val()).removeClass('placeholder');
        }
    });
        
    // Remove Image Function
    $('.edit_options').hover(function() {
        $(this).stop(true, true).animate({opacity: 1}, 100);
    }, function(){
        $(this).stop(true, true).animate({opacity: 0}, 100);
    });
        
    $( '.remove_img' ).on('click', function( event ) {
        var placeholder = $('#tried_placeholder_meta').val();
        $(this).parent().fadeOut('fast', function(){
            $(this).remove();
            $('.tried-current-img').addClass('placeholder').attr('src', placeholder);
        });
        $('#tried_upload_meta, #tried_upload_edit_meta, #tried_meta').val('');
    });


    // Bảo hành
    $( 'body.post-type-bao-hanh table.wp-list-table tbody td[data-colname="Trạng thái"]').each(function() {
        var status = $(this).text();
        if (status == 1) {
            $(this).text('Đã duyệt');
        } else {
            $(this).text('Chưa duyệt');
        }
    });
})(jQuery);
