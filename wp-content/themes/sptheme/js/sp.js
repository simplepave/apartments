/**
 * SimplePAVE
 * info@simplepave.ru
 */

jQuery(document).ready(function($){

    /**
     * Testimonials
     */

    var testimonialOffset = 0;

    function testimonialsMore(t) {
        if(t.hasClass('working')) return;
        var href = t.attr('href');
        var loop = t.attr('data-loop');

        $.ajax({
            type: 'post',
            data: {offset: (+loop + testimonialOffset)},
            url: href,
            dataType: 'json',
            beforeSend: function() {
                t.addClass('working');
                t.css({'filter': 'grayscale(100%) contrast(90%)'});
            },
            complete: function() {
                t.removeClass('working');
                t.css({'filter': 'none'});
            },
            success: function(json) {
                if (json.success) {
                    testimonialOffset += +loop;
                    if (!json.next) t.hide();

                    $('#reviews').append(json.review);
            }},
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    $('#more-reviews').click(function(e){
        e.preventDefault();
        testimonialsMore($(this));
    });

    /**
     * Products
     */

    function productsMore(t) {
        if(t.hasClass('working')) return;
        var paged = t.attr('data-page');
        var catId = t.attr('id').split('-')[2];

        var ajaxdata = {
            action     : 'more-products',
            nonce_code : spAjax.nonce,
            paged      : paged,
            cat_id     : catId,
        };

        $.ajax({
            type: 'post',
            data: ajaxdata,
            url: spAjax.url,
            dataType: 'json',
            beforeSend: function() {
                t.addClass('working');
                t.css({'filter': 'grayscale(100%) contrast(90%)'});
            },
            complete: function() {
                t.removeClass('working');
                t.css({'filter': 'none'});
            },
            success: function(json) {
                if (json.success) {
                    if (!json.next) t.hide();
                    t.attr('data-page', ++paged);
                    t.closest('.take_off')
                        .find('.products-block')
                        .append(json.products);
            }},
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    $('[id^="more-products"]').click(function(e){
        e.preventDefault();
        productsMore($(this));
    });

    /**
     * News
     */

    function newsMore(t) {
        if(t.hasClass('working')) return;
        var paged = t.attr('data-page');

        var ajaxdata = {
            action     : 'more-contents',
            nonce_code : spAjax.nonce,
            paged      : paged,
        };

        $.ajax({
            type: 'post',
            data: ajaxdata,
            url: spAjax.url,
            dataType: 'json',
            beforeSend: function() {
                t.addClass('working');
                t.css({'filter': 'grayscale(100%) contrast(90%)'});
            },
            complete: function() {
                t.removeClass('working');
                t.css({'filter': 'none'});
            },
            success: function(json) {
                if (json.success) {
                    if (!json.next) t.hide();
                    t.attr('data-page', ++paged);
                    t.closest('.news_block')
                        .find('.contents-block')
                        .append(json.contents);
            }},
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    $('#more-contents').click(function(e){
        e.preventDefault();
        newsMore($(this));
    });

    /**
     * Reservation
     */

     $('body').on('submit', '#reservation-form', function(e){
        e.preventDefault();
        var t = $(this);
        var btn = t.find('input[type="submit"]');
        if(btn.hasClass('working')) return;

        $.ajax({
            type: 'post',
            data: t.serialize(),
            url: t.attr('action'),
            dataType: 'json',
            beforeSend: function() {
                btn.addClass('working')
                .css({'filter': 'grayscale(100%) contrast(90%)'});
            },
            complete: function() {
                btn.removeClass('working')
                .css({'filter': 'none'});
            },
            success: function(json) {
                if (json.response) {
                    t.prev().css('color', 'green').text(json.message);
                    t.remove();
            }},
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    /**
     * Mail form
     */

     $('body').on('submit', '#rent-form, #feedback-form', function(e){
        e.preventDefault();
        var t = $(this);
        var btn = t.find('input[type="submit"]');
        if(btn.hasClass('working')) return;

        $.ajax({
            type: 'post',
            data: t.serialize() + '&action=feedback&nonce_code=' + spAjax.nonce,
            url: spAjax.url,
            dataType: 'json',
            beforeSend: function() {
                btn.addClass('working')
                .css({'filter': 'grayscale(100%) contrast(90%)'});
            },
            complete: function() {
                btn.removeClass('working')
                .css({'filter': 'none'});
            },
            success: function(json) {
                if (json.response)
                    t.prev().css('color', 'green').text(json.message);
                else
                    t.prev().css('color', 'red').text(json.message);

                t.remove();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    /**
     * DatePicker
     */

    $('#arrival-date, #departure-date, #from-data, #to-data').datepicker({
        // format: "mm/dd/yyyy",
        startDate: "-d",
        todayBtn: "linked",
        language: "ru",
        daysOfWeekHighlighted: "0",
        autoclose: true,
        todayHighlight: true
    });

    /**
     * Phone
     */

    $('#phone-mask, #rent-phone-mask, #feedback-phone-mask').inputmask({
        mask: '+7 (999) 999 99 99',
        clearMaskOnLostFocus: true,
        clearIncomplete: true
    });
});