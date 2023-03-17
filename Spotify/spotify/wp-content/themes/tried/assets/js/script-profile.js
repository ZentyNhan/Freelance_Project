(function ($) {
    "use strict";
    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var current = 1;
    var stepsform = $('.step-form');
    var steps = stepsform.find('fieldset').length;
    var enable_submit = false;

    setProgressBar(current);
    stepsform.find('.next').on( 'click', function() {
        current_fs = $(this).closest('fieldset');
        next_fs = $(this).closest('fieldset').next();
        //Add Class Active
        $(".progressbar-bar li").eq($("fieldset").index(next_fs)).addClass("active");
        $("fieldset.active").removeClass("active");
        $("fieldset").eq($("fieldset").index(next_fs)).addClass("active");
        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({'opacity': opacity});
            },
            duration: 500
        });
        setProgressBar(++current);
        if ($(this).attr('type') == 'submit') {
            enable_submit = true;
        }
    });
    stepsform.find('.ask-choose').on( 'click', function() {
        var wrapper = $(this).closest('fieldset');
        if ( $(this).attr('roll') == 'N' ) {
            wrapper.find('input, textarea').val('');
        }
        wrapper.find('.ask-popup').fadeOut('slow');
    });

    stepsform.find('.previous').on( 'click', function(){
        current_fs = $(this).closest('fieldset');
        previous_fs = $(this).closest('fieldset').prev();
        //Remove class active
        $(".progressbar-bar li").eq($("fieldset").index(current_fs)).removeClass("active");
        $("fieldset.active").removeClass("active");
        $("fieldset").eq($("fieldset").index(previous_fs)).addClass("active");
        //show the previous fieldset
        previous_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
            },
            duration: 500
        });
        setProgressBar(--current);
    });

    function setProgressBar(curStep) {
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar").css("width", percent+"%");
    }

    stepsform.find('input[name="type"]').on( 'change', function() {
        var wrapper = $(this).closest('.step-form');
        if ($(this).val() == 'bank') {
            wrapper.find('.col-field.khoanno-name_bank').slideDown('slow');
        } else {
            wrapper.find('.col-field.khoanno-name_bank').slideUp('slow');
        }
    });

    stepsform.find('input[name="value"], input[name="value_interest"]').on( 'input', function() {
        var wrapper = $(this).closest('.step-form'),
            khoanno_value = wrapper.find('#user-khoanno-value'),
            khoanno_value_interest = wrapper.find('#user-khoanno-value_interest'),
            khoanno_total_value = wrapper.find('#user-khoanno-total-value');
        khoanno_total_value.find('span.currency').text((
            parseInt( khoanno_value.val() ) + parseInt( khoanno_value_interest.val() )).toLocaleString(
                'it-IT', {
                    style : 'currency',
                    currency : 'VND'
                }
            )
        );
    });

    $(document).on( 'submit', '.step-form', function(e) {
		e.preventDefault();
        if (enable_submit) {
            $(this)[0].submit();
        }
        return false;
    });

    var avatar = $('.avatar-upload');
    if (avatar.length > 0) {
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    avatar.find('.avatar-preview').css('background-image', 'url('+e.target.result+')');
                    avatar.find('.avatar-preview').hide();
                    avatar.find('.avatar-preview').fadeIn(650);
                    $('img.avatar').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        avatar.find('input[name="avatar_url"]').on('change', function(e) {
            var wrapper = $(this).closest('.avatar-upload'),
                avatar_url = $(this).val().toLowerCase(),
                attachment = $(this).attr('data-attachment');
            $.ajax({
                type : "get", 
                url : tried_script.ajax_url, 
                data : {
                    action: 'avatar_upload',
                    avatar_url: avatar_url,
                    attachment: attachment
                },
                beforeSend: function() {
                    wrapper.addClass('proccessing');
                },
                success: function(res) {
                    if ( res.code == 200 ) {
                    } else {
                        console.log('Có lỗi xảy ra!');
                    }
                },
                complete: function() {
                    wrapper.removeClass('proccessing');
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                    console.log( 'The following error occured: ' + textStatus, errorThrown );
                }
            });
            // readURL(this);
        });
    }
})(jQuery);
