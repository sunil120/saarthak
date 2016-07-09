jQuery(document).ready(function($){
	
	var bx1 = $('.woocs1');
	var bx2 = $('.woocs2');
	var bx3 = $('.woocs3');
	var bx4 = $('.woocs4');
	var bx5 = $('.woocs5');
	var wcs_items;
	
	if( bx1.length ){
		wcsvp = $('.woocs1').width();
		if( wcsvp <= 380 ){ wcs_items = 1;  }
		else if( wcsvp > 380 && wcsvp <= 500 ){ wcs_items = 2; }
		else if( wcsvp > 500 && wcsvp <= 600 ){ wcs_items = 3; }
		else if( wcsvp > 600 && wcsvp <= 750 ){ wcs_items = 4; }
		else if( wcsvp > 750 && wcsvp <= 900 ){ wcs_items = 5; }
		else if( wcsvp > 900 ){ wcs_items = 6; }
		else{ var wcs_items = 4; }
		
		bx1.bxSlider({
			minSlides: wcs_items,
			maxSlides: wcs_items,
			slideWidth: 320,
			slideMargin: 3,
			preloadImages: 'all',
			adapriveHeight: true,
			auto: parseInt(bx1.attr('autoslide')),
			speed: bx1.attr('speed'),
			pager: parseInt(bx1.attr('pager'))
		});
	}
	

	if( bx2.length ){
		wcsvp = $('.woocs2').width();
		if( wcsvp <= 380 ){ wcs_items = 1;  }
		else if( wcsvp > 380 && wcsvp <= 500 ){ wcs_items = 2; }
		else if( wcsvp > 500 && wcsvp <= 600 ){ wcs_items = 3; }
		else if( wcsvp > 600 && wcsvp <= 750 ){ wcs_items = 4; }
		else if( wcsvp > 750 && wcsvp <= 900 ){ wcs_items = 5; }
		else if( wcsvp > 900 ){ wcs_items = 6; }
		else{ var wcs_items = 4; }
		
		bx2.bxSlider({
			//mode: 'vertical',
			minSlides: wcs_items,
			maxSlides: wcs_items,
			slideWidth: 320,
			slideMargin: 3,
			preloadImages: 'all',
			adapriveHeight: true,
			auto: parseInt(bx2.attr('autoslide')),
			speed: bx2.attr('speed'),
			pager: parseInt(bx2.attr('pager'))
		});
		
		var cc = $(".woocs2 li").first().find('.woocs_container').length * 180;
		$(".woocs2 .wcs-viewport").attr('style', 'width: 100%; overflow: hidden; position: relative; height: ' + cc + 'px!important' );
	}

});