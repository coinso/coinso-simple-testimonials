(function ($) {


    console.log('cts-scripts ok');

    function cts_testimonials_slider( em ) {
        var autoplay    = $( em ).data('autoplay'),
            speed       = $( em ).data('speed'),
            infinite    = $( em ).data('infinite'),
            count       = $( em ).data('count');
        $( em ).slick(

            {
                centerMode: false,
                dots: true,
                infinite: infinite,
                slidesToShow: count,
                slidesToScroll: 1,
                accessibility: true,
                // rtl:true,
                // prevArrow: '<button type="button" class="fa fa-angle-right fa-2x" aria-label="Prev" role="button"><span class="sr-only">click to see previous slide</span></button>',
                // nextArrow: '<button type="button" class="fa fa-angle-left fa-2x" aria-label="Next" role="button"><span class="sr-only">click to see next slide</span></button>',
                autoplay: autoplay,
                autoplaySpeed: speed,
                pauseOnHover: true,
                pauseOnDotsHover: true,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            dots: true,
                            centerMode: true,
                            centerPadding: '0',
                            slidesToShow: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            arrows: false,
                            dots: true,
                            centerMode: true,
                            centerPadding: '0',
                            slidesToShow: 1
                        }
                    }
                ]
            }
        );
    }
    cts_testimonials_slider('#cts-testimonials');

    var cts_play = $('.cts-testimonial .cts-testimonial__thumbnail-wrap i');
    var vidDefer = $('.cts-testimonial__vid');
    $( cts_play ).click( function () {
        $(this).toggleClass('none');
        $(this).parent().toggleClass('active');
        $(this).next('.cts-testimonial__img-wrap').hide();
        $(this).next('.cts-testimonial__vid-wrap').show();
        console.log($(this).parent().find( vidDefer ).attr('data-src'));
        if ( $(this).parent().find( vidDefer ) ){
            for ( var i=0; i < vidDefer.length; i++) {
                        if( vidDefer[i].getAttribute( 'data-src' ) ) {
                            vidDefer[i].setAttribute( 'src', vidDefer[i].getAttribute( 'data-src' ));
                        }
                    }
        }
    });

})(jQuery);