jQuery(function($){
	var modal_fupload = $('#modal-file-up-load');
	var attach_link_or_browse = $('#attach_link_or_browse');
	var opened = false;
    var fileupload_browses = [];

	if (attach_link_or_browse.find('input[name="fileupload_browses"]').val() != '') {
		fileupload_browses = attach_link_or_browse.find('input[name="fileupload_browses"]').val().split('-');
	}

	$(document).on('click', '#file-browse, #modal-file-up-load .modal-fclose', function(e) {
		e.preventDefault();
		modal_fupload.toggleClass('opened');
		modal_fupload.attr('data-key', $(this).attr('data-order'));
		$('body').toggleClass('modal-tried-opened');
		if (e.target.id == 'file-browse' && !opened) {
            $('#my_media_list').attr('src', fileupload_url+'/fileupload/');
		}
	});
	// function isValidUrl(url){
	// 	if (/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(url)) return 1;
	// 	return -1;
	// }
	$(document).on('click', '.fileupload-list .item .delete', function(e) {
		e.preventDefault();
		var fileupload_block = $(this).closest('.fileupload-block');
        if (index =  fileupload_browses.indexOf($(this).closest('.item').attr('data-value')) > -1) {
            fileupload_browses.splice(index, 1);
        }
        fileupload_block.find('input[name="fileupload_browses"]').val(fileupload_browses.join("-"));
		$(this).parent().parent().remove();
	});
	$('#my_media_list').on("load", function() {
		opened = true;
		var child_frame = window.frames['my_media_list'].document;
		$(child_frame).on('click', '.template-download .select', function(e) {
			var template_download = $(this).closest('.template-download');
			var attachment_id = template_download.attr('data-id');
			var file_preview = template_download.find('.preview img').attr('src');
			var file_title = template_download.find('.name').attr('title');
			var file_size = template_download.find('.size').text();
			var key = modal_fupload.attr('data-key');
			e.preventDefault();
            var fileupload_block = $('.fileupload-block.'+key);
			var fileupload_list = fileupload_block.find('.fileupload-list');
			if (fileupload_list.length > 0) {
				var preview = '';
				if (file_preview) {
					preview = '<img src="'+file_preview+'" alt="'+file_title+'" width="80">';
				}
				html = '';
				html += '<div class="item" data-type="file" data-value="'+attachment_id+'">';
				html += '<div class="content">'+preview;
				html += '<p class="title">'+file_title+'</p>';
				html += '<span class="size">'+file_size+'</span></div>';
				html += '<div class="action"><button class="delete">Delete</button></div>';
				html += '</div>';
				fileupload_list.append(html);
                fileupload_browses.push(attachment_id);
                fileupload_block.find('input[name="fileupload_browses"]').val(fileupload_browses.join("-"));
				modal_fupload.toggleClass('opened');
				modal_fupload.attr('data-item', '');
				$('body').toggleClass('modal-tried-opened');
			}

            var avatar_upload = $('.avatar-upload.'+key);
			if (avatar_upload.length > 0) {
                avatar_upload.find('input[name="avatar_url"]').val(file_preview).attr('data-attachment', attachment_id).trigger('change');
                avatar_upload.find('.avatar-preview').css('background-image', 'url('+file_preview+')');
                $('img.avatar').attr('src', file_preview);
                
				modal_fupload.toggleClass('opened');
				modal_fupload.attr('data-item', '');
				$('body').toggleClass('modal-tried-opened');
			}
			
			var attach_link_or_browse = fileupload_list.closest('.attach_link_or_browse');
			attach_link_or_browse.find('#btn-update_attachment').addClass('updated');
		});
	});
	// var is_editting = false;
	// $(document).on('click', '.fileupload-list .item .edit', function(e) {
	// 	var parent = $(this).parent().parent();
	// 	if (parent.attr('data-type') == 'link') {
	// 		if (!is_editting) {
	// 			parent.find('.edit-link-attach').val(parent.find('.title').text());
	// 			parent.addClass('editting');
	// 			$(this).text('Save');
	// 			is_editting = true;
	// 		} else {
	// 			if (isValidUrl(parent.find('.edit-link-attach').val()) != 1){
	// 				parent.find('.errors').fadeIn();
	// 				return;
	// 			} else {
	// 				parent.attr('data-value', (parent.find('.edit-link-attach').val()));
	// 				parent.find('.title').text(parent.find('.edit-link-attach').val());
	// 				parent.find('.errors').fadeOut();
	// 			}
	// 			var attach_link_or_browse = $(this).closest('.attach_link_or_browse');
	// 			attach_link_or_browse.find('#btn-update_attachment').addClass('updated');
	// 			parent.removeClass('editting');
	// 			$(this).text('Edit');
	// 			is_editting = false;
	// 		}
	// 	}
	// });
	// $(document).on('click', '.attach_link_or_browse #btn-update_attachment.updated', function(e) {
	// 	e.preventDefault();
	// 	var attach_link_or_browse = $(this).closest('.attach_link_or_browse');
	// 	var attach_list = [];
	// 	var current = $(this).attr('data-current');
	// 	var orderid = $(this).attr('data-orderid');
	// 	var item_id = $(this).attr('data-item_id');
	// 	var redirect = $(this).attr('data-redirect');
	// 	$('#error-update-status').text('');
	// 	$('#error-update-status').slideUp();
	// 	if (attach_link_or_browse.find('.fileupload-list .item').length < 1) {
	// 		$('#error-update-status').text($('#error-update-status').attr('data-message-upload-least-fileupload'));
	// 		$('#error-update-status').slideDown();
	// 		$("html, body").animate({ scrollTop: 0 }, "slow");
	// 		return;
	// 	}

	// 	attach_link_or_browse.find('.fileupload-list .item').each(function() {
	// 		attach_list.push({
	// 			'type': $(this).attr('data-type'),
	// 			'value': $(this).attr('data-value')
	// 		});
	// 	});
	// 	$.ajax({
	// 		type : "post", 
	// 		url : wc_add_to_cart_params.ajax_url, 
	// 		data : {
	// 			action: 'update_attach_link_or_browse',
	// 			current: current,
	// 			orderid: orderid,
	// 			item_id: item_id,
	// 			redirect: redirect,
	// 			attach_list: attach_list,
	// 		},
	// 		beforeSend: function() {
	// 			attach_link_or_browse.addClass('proccessing');
	// 		},
	// 		success: function(response) {
	// 			if (response.notification) {
	// 				if (response.redirect != '') {
	// 					window.location.href = response.redirect;
	// 				}
	// 			} else {
	// 				if (response.code === 'timeup') {
	// 					modal_message_order.find('#error-message-order').text(response.message);
	// 					modal_message_order.toggleClass('opened');
	// 					$('body').toggleClass('modal-tried-opened');
	// 				}
	// 			}
	// 		},
	// 		complete: function() {
	// 			attach_link_or_browse.removeClass('proccessing');
	// 		},
	// 		error: function( jqXHR, textStatus, errorThrown ) {
	// 			console.log( 'The following error occured: ' + textStatus, errorThrown );
	// 		}
	// 	});
	// });
});
