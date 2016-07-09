(function($) {
	"use strict";
	/* Add Click On Ipad */
	$(window).resize(function(){
		var $width = $(this).width();
		if( $width < 1199 ){
			$( '.primary-menu .nav .dropdown-toggle'  ).each(function(){
				$(this).attr('data-toggle', 'dropdown');
			});
		}
	});
	/* Responsive Menu */
	$(document).ready(function(){
		$( '.show-dropdown' ).each(function(){
			$(this).on('click', function(){
				var $parent = $(this).parent().attr('class');
				var $class = $parent.replace( /\s/g, '.' );
				var $element = $( '.' + $class + ' > ul' );
				$element.toggle( 300 );
			});
		});
	});
	jQuery(window).load(function() {
		/* Masonry Blog */
		$('body').find('.grid-blog').isotope({ 
			layoutMode : 'masonry'
		});
	});
    jQuery('.phone-icon-search').on('click', function(){
		/*alert("The paragraph was clicked.");*/
        jQuery('.top-search').toggle("slide");
    });
	jQuery('ul.orderby.order-dropdown li ul').hide(); 
    jQuery("ul.orderby.order-dropdown li span.current-li-content,ul.orderby.order-dropdown li ul").hover( function() {
        jQuery('ul.orderby.order-dropdown li ul').stop().fadeIn("fast");
    }, function() {
        jQuery('ul.orderby.order-dropdown li ul').stop().fadeOut("fast");
    });

    jQuery('.orderby-order-container ul.sort-count li ul').hide();
    jQuery('.sort-count.order-dropdown li span.current-li,.orderby-order-container ul.sort-count li ul').hover( function(){
        jQuery('.orderby-order-container ul.sort-count li ul').stop().fadeIn("fast");

    },function(){
        jQuery('.orderby-order-container ul.sort-count li ul').stop().fadeOut("fast");
    });

	$(document).ready(function(){
		/* Quickview */
		$('.fancybox').fancybox({
			'width'     : 850,
			'height'   : '500',
			'autoSize' : false,
			afterShow: function() {
				$(' .share ').on('click', function() {
					$(' .social-share ').toggle( "slow" );
				});
				$( '.product-images' ).each(function(){
					var $id = this.id;
					var $rtl = $('body').hasClass( 'rtl' );
					var $img_slider = $( '#' + $id + ' .product-responsive');
					var $thumb_slider = $( '#' + $id + ' .product-responsive-thumbnail' )
					$img_slider.slick({
						slidesToShow: 1,
						slidesToScroll: 1,
						fade: true,
						arrows: false,
						rtl: $rtl,
						asNavFor: $thumb_slider
					});
					$thumb_slider.slick({
						slidesToShow: 3,
						slidesToScroll: 1,
						asNavFor: $img_slider,
						arrows: true,
						focusOnSelect: true,
						rtl: $rtl,
						responsive: [				
							{
							  breakpoint: 360,
							  settings: {
								slidesToShow: 2    
							  }
							}
						  ]
					});

					$(".product-images").fadeIn(1000, function() {
						$(this).removeClass("loading");
					});
				});
			}
		});
		/* Slider Image */
		$( '.product-images' ).each(function(){
			var $id 			= this.id;
			var $rtl 			= $(this).data('rtl');
			var $vertical		= $(this).data('vertical');
			var $img_slider 	= $( '#' + $id + ' .product-responsive');
			var $thumb_slider 	= $( '#' + $id + ' .product-responsive-thumbnail' );
			$img_slider.slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				fade: true,
				arrows: false,
				rtl: $rtl,
				asNavFor: $thumb_slider
			});
			$thumb_slider.slick({
				slidesToShow: 4,
				slidesToScroll: 1,
				asNavFor: $img_slider,
				arrows: true,
				focusOnSelect: true,
				rtl: $rtl,
				vertical: $vertical,
				verticalSwiping: $vertical,
				responsive: [				
					{
					  breakpoint: 360,
					  settings: {
						slidesToShow: 2    
					  }
					}
				  ]
			});

			$(".product-images").fadeIn(300, function() {
				$(this).removeClass("loading");
			});
		});
	});

var mobileHover = function () {
    $('*').on('touchstart', function () {
        $(this).trigger('hover');
    }).on('touchend', function () {
        $(this).trigger('hover');
    });
};

mobileHover();

    jQuery('.product-categories')
        .find('li:gt(5)') /*you want :gt(4) since index starts at 0 and H3 is not in LI */
        .hide()
        .end()
        .each(function(){
            if($(this).children('li').length > 5){ //iterates over each UL and if they have 5+ LIs then adds Show More...
                $(this).append(
                    $('<li><a>See more   +</a></li>')
                        .addClass('showMore')
                        .on('click',function(){
                            if($(this).siblings(':hidden').length > 0){
                                $(this).html('<a>See less   -</a>').siblings(':hidden').show(400);
                            }else{
                                $(this).html('<a>See more   +</a>').show().siblings('li:gt(5)').hide(400);
                            }
                        })
                );
            }
        });
    /*Form search iP*/




    jQuery('a.phone-icon-menu').on('click', function(){
       var temp = jQuery('.navbar-inner.navbar-inverse').toggle( "slide" );
	   $(this).toggleClass('active');
    });
	$('.ya-tooltip').tooltip();
	/* fix accordion heading state */
	$('.accordion-heading').each(function(){
		var $this = $(this), $body = $this.siblings('.accordion-body');
		if (!$body.hasClass('in')){
			$this.find('.accordion-toggle').addClass('collapsed');
		}
	});
	

	/* twice click */
	$(document).on('click.twice', '.open [data-toggle="dropdown"]', function(e){
		var $this = $(this), href = $this.attr('href');
		e.preventDefault();
		window.location.href = href;
		return false;
	});

    $('#cpanel').collapse();

    $('#cpanel-reset').on('click', function(e) {

    	if (document.cookie && document.cookie != '') {
    		var split = document.cookie.split(';');
    		for (var i = 0; i < split.length; i++) {
    			var name_value = split[i].split("=");
    			name_value[0] = name_value[0].replace(/^ /, '');

    			if (name_value[0].indexOf(cpanel_name)===0) {
    				$.cookie(name_value[0], 1, { path: '/', expires: -1 });
    			}
    		}
    	}

    	location.reload();
    });

	$('#cpanel-form').on('submit', function(e){
		var $this = $(this), data = $this.data(), values = $this.serializeArray();

		var checkbox = $this.find('input:checkbox');
		$.each(checkbox, function() {

			if( !$(this).is(':checked') ) {
				name = $(this).attr('name');
				name = name.replace(/([^\[]*)\[(.*)\]/g, '$1_$2');

				$.cookie( name , 0, { path: '/', expires: 7 });
			}

		})

		$.each(values, function(){
			var $nvp = this;
			var name = $nvp.name;
			var value = $nvp.value;

			if ( !(name.indexOf(cpanel_name + '[')===0) ) return ;

			name = name.replace(/([^\[]*)\[(.*)\]/g, '$1_$2');

			$.cookie( name , value, { path: '/', expires: 7 });

		});

		location.reload();

		return false;

	});

	$('a[href="#cpanel-form"]').on( 'click', function(e) {
		var parent = $('#cpanel-form'), right = parent.css('right'), width = parent.width();

		if ( parseFloat(right) < -10 ) {
			parent.animate({
				right: '0px',
			}, "slow");
		} else {
			parent.animate({
				right: '-' + width ,
			}, "slow");
		}

		if ( $(this).hasClass('active') ) {
			$(this).removeClass('active');
		} else $(this).addClass('active');

		e.preventDefault();
	});
/*Product listing select box*/
	jQuery('.catalog-ordering .orderby .current-li a').html(jQuery('.catalog-ordering .orderby ul li.current a').html());
	jQuery('.catalog-ordering .sort-count .current-li a').html(jQuery('.catalog-ordering .sort-count ul li.current a').html());
/*currency Selectbox*/
	$('.currency_switcher li a').on('click', function(){
		var $current = $(this).attr('data-currencycode');
		jQuery('.currency_w > li > a').html($current);
	});
/*language*/
	$("#lang_sel ul > li > a").on({
		mouseover: function () {
			$('#lang_sel ul > li ul').css('display', 'block');
		},
		mouseleave: function () {
			$('#lang_sel ul > li ul').css('display', 'none');
		}
	});
	var $current ='';
	$('#lang_sel ul > li > ul li a').on('click',function(){
	 //console.log($(this).html());
	 $current = $(this).html();
	 $('#lang_sel ul > li > a.lang_sel_sel').html($current);
	  $a = $.cookie('lang_select_atom', $current, { expires: 1, path: '/'}); 
	});
	if( $.cookie('lang_select_atom') && $.cookie('lang_select_atom').length > 0 ) {
	 $('#lang_sel ul > li > a.lang_sel_sel').html($.cookie('lang_select_atom'));
	}
/*Quickview*/
	jQuery('.fancybox').fancybox({
		'width'     : 997,
		'height'   : 'auto',
		'autoSize' : false
	});
/*lavalamp*/
	$.fn.lavalamp = function(options){
		var defaults = {
    			elm_class: 'active',
				durations: 400
 		    },
            settings = $.extend(defaults, options);
		this.each( function(){
			var elm = ('> li');
			var current_check = $(elm, this).hasClass( settings.elm_class );
			current = elm + '.' + settings.elm_class;
			if( current_check ){
				var $this=jQuery(this), left0 = $(this).offset().left, dleft0 = $(current, this).offset().left - left0, dwidth0 = $('>ul>li.active', this).width();
				$(this).append('<div class="floatr"></div>');
				var $lava = jQuery('.floatr', $this), move = function(l, w){
					$lava.stop().animate({
						left: l,
						width: w
					}, {
						duration: settings.durations,
						easing: 'linear'
					});
				};
				
				var $li = jQuery('>li', this);		
				
				move(dleft0, dwidth0);
				$lava.show();
				$li.hover(function(e){
					var dleft = $(this).offset().left - left0;
					var dwidth = $(this).width();
					move(dleft, dwidth);
				}, function(e){
					move(dleft0, dwidth0);
				});	
			}
		});
	}
	jQuery(document).ready(function(){
		var currency_show = jQuery('ul.currency_switcher li a.active').html();
		jQuery('.currency_to_show').html(currency_show);	
	}); 
/*end lavalamp*/
	jQuery(function($){
	// back to top
	$("#ya-totop").hide();
	$(function () {
		var wh = $(window).height();
		var whtml = $(document).height();
		$(window).scroll(function () {
			if ($(this).scrollTop() > whtml/10) {
					$('#ya-totop').fadeIn();
				} else {
					$('#ya-totop').fadeOut();
				}
			});
		$('#ya-totop').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
			});
	});
	/* end back to top */
	}); 
	jQuery(document).ready(function(){
  jQuery('.wpcf7-form-control-wrap').on('hover', function(){
   $(this).find('.wpcf7-not-valid-tip').css('display', 'none');
  });
 });
 
 $(".sw-woo-tab-style2").fadeIn(300, function() {
		$(this).removeClass("loading");
	});
  $(".sw-woo-tab-cat").fadeIn(300, function() {
		$(this).removeClass("loading");
	});
  $(".sw-woo-tab").fadeIn(300, function() {
		$(this).removeClass("loading");
	});
 $(".responsive-slider").fadeIn(300, function() {
		$(this).removeClass("loading");
	});
	$(".product-images").fadeIn(300, function() {
		$(this).removeClass("loading");
	});
 /*fix js */
 $('.wpb_map_wraper').on('click', function () {
    $('.wpb_map_wraper iframe').css("pointer-events", "auto");
});

$( ".wpb_map_wraper" ).on('mouseleave', function() {
  $('.wpb_map_wraper iframe').css("pointer-events", "none"); 
});
/*Remove tag p colections*/
$( ".collections .tab-content .tab-pane" ).find('p:first-child').remove();

//toggle share product detail
$(' .share ').on('click', function() {
  $(' .social-share ').toggle( "slow" );
});

/*remove tag p*/
$( ".collections .tab-pane " ).find( "p" ).remove();

}(jQuery));

(function($){		
	  $('[data-toggle="tooltip"]').tooltip();
	/*Verticle Menu*/
    jQuery('.page .vertical-megamenu')
        .find(' > li:gt(4) ') 
        .hide()
        .end()
        .each(function(){
            if($(this).children('li').length > 4){ 
                $(this).append(
                    $('<li><a class="open-more-cat">View More Categories  </a></li>')
                        .addClass('showMore')
                        .on('click', function(){
                            if($(this).siblings(':hidden').length > 0){
                                $(this).html('<a class="close-more-cat">View Less Categories</a>').siblings(':hidden').show(400);
                            }else{
                                $(this).html('<a class="open-more-cat">View More Categories</a>').show().siblings('li:gt(4)').hide(400);
                            }
                        })
                );
            }
        });
	
})(jQuery);
(function($) {
	fakewaffle.responsiveTabs(['xs']);
})(jQuery);


