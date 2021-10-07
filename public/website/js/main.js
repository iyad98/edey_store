$(document).on("click", ".dropdown-menu", function (e) {
    e.stopPropagation();
});

$(document).ready(function () {
    $(".closeBnr").click(function(){
        $('.header-bnr').slideToggle();
    });
    $(".dropdown-submenu a.test").on("click", function (e) {
        $(this).next("ul").toggle();
        e.stopPropagation();
        e.preventDefault();
    });
});

//Reference:
//https://www.onextrapixel.com/2012/12/10/how-to-create-a-custom-file-input-with-jquery-css3-and-php/
;(function($) {

    // Browser supports HTML5 multiple file?
    var multipleSupport = typeof $('<input/>')[0].multiple !== 'undefined',
        isIE = /msie/i.test( navigator.userAgent );

    $.fn.customFile = function() {

        return this.each(function() {

            var $file = $(this).addClass('custom-file-upload-hidden'), // the original file input
                $wrap = $('<div class="file-upload-wrapper">'),
                $input = $('<input type="text" class="file-upload-input" />'),
                // Button that will be used in non-IE browsers
                $button = $('<button type="button" class="file-upload-button">أرفق ملف</button>'),
                // Hack for IE
                $label = $('<label class="file-upload-button" for="'+ $file[0].id +'">أرفق ملف</label>');

            // Hide by shifting to the left so we
            // can still trigger events
            $file.css({
                position: 'absolute',
                left: '-9999px'
            });

            $wrap.insertAfter( $file )
                .append( $file, $input, ( isIE ? $label : $button ) );

            // Prevent focus
            $file.attr('tabIndex', -1);
            $button.attr('tabIndex', -1);

            $button.click(function () {
                $file.focus().click(); // Open dialog
            });

            $file.change(function() {

                var files = [], fileArr, filename;

                // If multiple is supported then extract
                // all filenames from the file array
                if ( multipleSupport ) {
                    fileArr = $file[0].files;
                    for ( var i = 0, len = fileArr.length; i < len; i++ ) {
                        files.push( fileArr[i].name );
                    }
                    filename = files.join(', ');

                    // If not supported then just take the value
                    // and remove the path to just show the filename
                } else {
                    filename = $file.val().split('\\').pop();
                }

                $input.val( filename ) // Set the value
                    .attr('title', filename) // Show filename in title tootlip
                    .focus(); // Regain focus

            });

            $input.on({
                blur: function() { $file.trigger('blur'); },
                keydown: function( e ) {
                    if ( e.which === 13 ) { // Enter
                        if ( !isIE ) { $file.trigger('click'); }
                    } else if ( e.which === 8 || e.which === 46 ) { // Backspace & Del
                        // On some browsers the value is read-only
                        // with this trick we remove the old input and add
                        // a clean clone with all the original events attached
                        $file.replaceWith( $file = $file.clone( true ) );
                        $file.trigger('change');
                        $input.val('');
                    } else if ( e.which === 9 ){ // TAB
                        return;
                    } else { // All other keys
                        return false;
                    }
                }
            });

        });

    };

    // Old browser fallback
    if ( !multipleSupport ) {
        $( document ).on('change', 'input.customfile', function() {

            var $this = $(this),
                // Create a unique ID so we
                // can attach the label to the input
                uniqId = 'customfile_'+ (new Date()).getTime(),
                $wrap = $this.parent(),

                // Filter empty input
                $inputs = $wrap.siblings().find('.file-upload-input')
                    .filter(function(){ return !this.value }),

                $file = $('<input type="file" id="'+ uniqId +'" name="'+ $this.attr('name') +'"/>');

            // 1ms timeout so it runs after all other events
            // that modify the value have triggered
            setTimeout(function() {
                // Add a new input
                if ( $this.val() ) {
                    // Check for empty fields to prevent
                    // creating new inputs when changing files
                    if ( !$inputs.length ) {
                        $wrap.after( $file );
                        $file.customFile();
                    }
                    // Remove and reorganize inputs
                } else {
                    $inputs.parent().remove();
                    // Move the input so it's always last on the list
                    $wrap.appendTo( $wrap.parent() );
                    $wrap.find('input').focus();
                }
            }, 1);

        });
    }

}(jQuery));

$('input[type=file]').customFile();

$(function () {
    $("#slider-range , #slider-range2").slider({
        range: true,
        min: 0,
        max: 500,
        values: [75, 300],
        slide: function (event, ui) {
            $("#amount , #amount1").val("$" + ui.values[0] + " - $" + ui.values[1]);
        },
    });
    $("#amount , #amount1").val(
        "$" +
        $("#slider-range , #slider-range2").slider("values", 0) +
        " - $" +
        $("#slider-range , #slider-range2").slider("values", 1)
    );
});

$(".navbar .navbar-toggler").on("click", function (e) {
    e.preventDefault();
    $(this).siblings(".navbar-collapse").children("ul").slideToggle();
});

$(document).ready(function () {
    var quantitiy = 0;
    $(".quantity-right-plus").click(function (e) {
        e.preventDefault();
        var quantity = parseInt($(this).siblings(".quantity").val());

        $(this)
            .siblings(".quantity")
            .val(quantity + 1);
    });

    $(".quantity-left-minus").click(function (e) {
        e.preventDefault();
        var quantity = parseInt($(this).siblings(".quantity").val());

        // Increment
        if (quantity > 0) {
            $(this)
                .siblings(".quantity")
                .val(quantity - 1);
        }
    });
});


$(".navbar-toggler").on("click", function (e) {
    e.stopPropagation();
    $(".navbar #main_nav").addClass("active");
    $("body").addClass("sidebar-open");
});
$(window).on("click", function () {
    $(".navbar #main_nav").removeClass("active");
    $("body").removeClass("sidebar-open");
});

$("#main_nav").on("click", function (e) {
    // e.stopPropagation();
});

$(".owl-carousel.m").owlCarousel({
    items: 4,
    nav: true,
    rtl: true,
    margin: 10,
    responsiveClass: true,
    responsive: {
        0: {
            items: 1,
            nav: true,
            autoWidth: true,
        },
        540: {
            items: 2,
            nav: true,
            margin: 20,
        },
        992: {
            items: 3,
        },
        1200: {
            items: 3,
        },
    },
});

$(".owl-carousel").owlCarousel({
    items: 4,
    nav: true,
    rtl: true,
    margin: 10,
    responsiveClass: true,
    responsive: {
        0: {
            items: 1,
            nav: true,
            autoWidth: true,
        },
        540: {
            items: 2,
            nav: true,
            margin: 20,
        },
        992: {
            items: 3,
        },
        1200: {
            items: 4,
        },
    },
});
