(function ($) {
    "use strict";

    var enable_submit = true,
        search_baohanh_form = $('#tried_search-baohanh-form');

    if (search_baohanh_form.length > 0) {
        search_baohanh_form.find('form.form-baohanh').on('submit', function(e) {
            e.preventDefault();
            if (enable_submit) {
                $.ajax({
                    type : "get", 
                    url : tried_script.ajax_url, 
                    data : {
                        action: 'tried_search_baohanh',
                        seri: $(this).find('input[name="seri"]').val()
                    },
                    beforeSend: function() {
                        search_baohanh_form.addClass('loading');
                        enable_submit = false;
                    },
                    success: function(res) {
                        if (res.code == 200) {
                            search_baohanh_form.find('.result-block').html('');
                            search_baohanh_form.find('.result-block').html(res.content);
                            submit_update_baohanh_form();
                        } else {
                            search_baohanh_form.find('.result-block').html('');
                            search_baohanh_form.find('.result-block').html(`<div class="message-wrapper">
                                <h4>Số series chưa đúng hoặc sản phẩm chưa được đăng ký</h4>
                                <p>Vui lòng xem hướng dẫn đăng ký trên phiếu <u>BẢO HÀNH</u> hoặc gọi 1900 55 88 84 để được hỗ trợ</p>
                            </div>`);
                            console.log('Có lỗi xảy ra!');
                        }
                    },
                    complete: function() {
                        search_baohanh_form.removeClass('loading');
                        enable_submit = true;
                    },
                    error: function( jqXHR, textStatus, errorThrown ) {
                        console.log( 'The following error occured: ' + textStatus, errorThrown );
                    }
                });
            }
        });

        function submit_update_baohanh_form() {
            search_baohanh_form.find('form.form-update-baohanh').on('submit', function(e) {
                e.preventDefault();
                if (enable_submit) {
                    $.ajax({
                        type : "get", 
                        url : tried_script.ajax_url, 
                        data : {
                            action: 'tried_search_update_baohanh',
                            seri: $(this).find('input[name="seri"]').val(),
                            info_datebuy: $(this).find('input[name="info_datebuy"]').val(),
                            client_name: $(this).find('input[name="client_name"]').val(),
                            client_address: $(this).find('input[name="client_address"]').val(),
                            client_email: $(this).find('input[name="client_email"]').val(),
                            client_phone: $(this).find('input[name="client_phone"]').val(),
                        },
                        beforeSend: function() {
                            search_baohanh_form.addClass('loading');
                            enable_submit = false;
                        },
                        success: function(res) {
                            search_baohanh_form.find('form.form-update-baohanh .col-field.message').html(`<p class="${res.notify}">${res.content}</p>`);
                        },
                        complete: function() {
                            search_baohanh_form.removeClass('loading');
                            enable_submit = true;
                        },
                        error: function( jqXHR, textStatus, errorThrown ) {
                            console.log( 'The following error occured: ' + textStatus, errorThrown );
                        }
                    });
                }
            });
        }
    }
})(jQuery);
