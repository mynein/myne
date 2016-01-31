function generate_horizontal_slide(slider_data, row, object_selector , margin ){
	if( typeof margin == 'undefined' ){
		margin = 40;
	}
	var _slider_datas =	{
		item 			: 4
		,margin			: margin
		,loop			: true
		,slideBy		: 'page'
		,nav			: true
		,navText		: [ '<', '>' ]
		,dots			: true
		,lazyload		: true
		,autoplay		: true
		,rtl			: jQuery('body').hasClass('rtl')
		,responsiveBaseElement: jQuery(object_selector)
		,responsive		: {
			0:{
				items:1
			},
			300:{
				items: 2
			},
			600:{
				items: 3
			},
			900:{
				items: 4
			},
			1160:{
				items: 5
			}
		}
		,onInitialized: function(){
			jQuery(object_selector).parent().addClass('loaded').removeClass('loading');
		}
	}
	
	jQuery.extend(_slider_datas, slider_data);
	
	if(row >= 1)
	{
		_slider_datas.pagination = true;
		var owl = jQuery(object_selector);
		
		if(row > 1){
			owl.on('resize.owl.carousel', function(e) {
				jQuery(object_selector).find('.product').css('height','auto');
			});
			owl.on('initialized.owl.carousel resized.owl.carousel', function(e) {
				setTimeout(function(){
					var max_height = 0;
					jQuery(object_selector).find('.product').each(function(index,value){
						if(jQuery(value).outerHeight() > max_height){
							max_height = jQuery(value).outerHeight();
						}
					});
					jQuery(object_selector).find('.product').outerHeight(max_height);
				}, 0);
			});
			
		}
		owl.owlCarousel(_slider_datas);	

	} else {
		var tag_name = jQuery(object_selector).prop("tagName");
		var class_ob = jQuery(object_selector).attr('class');
		var pre_text = "wd_foo" + Math.floor((Math.random() * 10000) + 1) + "__";
		if(jQuery(object_selector).attr("id") == "" || jQuery(object_selector).attr("id") == undefined){
			jQuery(object_selector).attr("id",pre_text+"0");
		}
		
		for(i=row-1;i>=1;i--){
			var new_element = document.createElement(tag_name);
			jQuery(new_element).attr("id",pre_text+i);
			jQuery(new_element).addClass(class_ob);
			jQuery(new_element).html(jQuery("#"+pre_text+"0").clone().html());
			
			var temp = (i%row) + 1;
			jQuery(new_element).children('.product').filter(':not(.product:nth-child('+row+'n+'+temp+'))').remove();
		
			jQuery("#"+pre_text+"0").after(new_element);
			delete new_element; 
		}
		jQuery("#"+pre_text+"0").children('.product').filter(':not(.product:nth-child('+row+'n+'+1+'))').remove();
		
		//call slider
		jQuery("#"+pre_text+"0").owlCarousel(_slider_datas);
		//_slider_datas.synchronise = ['#foo0', true, true];
		for(i=1;i<row;i++){
			jQuery("#"+pre_text+i).owlCarousel(_slider_datas);
		}
		
		
		jQuery(_prev).click(function(event) {
			event.preventDefault();
			for(i=0;i<row;i++){
				jQuery("#"+pre_text+i).trigger("prev.owl.carousel");
			}
		});	
		jQuery(_next).click(function(event) {
			event.preventDefault();
			for(i=0;i<row;i++){
				jQuery("#"+pre_text+i).trigger("next.owl.carousel");
			}
		});
	}
}

jQuery(document).ready(function($){
	$('.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab').bind('click', function(){
		wd_update_tab_content_min_height();
	});
	
	$(window).bind('load resize', function(){
		if( $(this).width() > 767 ){
			wd_update_tab_content_min_height();
		}
		else{
			$('.vc_tta-tabs .vc_tta-panels .vc_tta-panel').css('min-height', 0);
		}
	});
	
	function wd_update_tab_content_min_height(){
		setTimeout(function(){
			$('.vc_tta-tabs .vc_tta-panels').each(function(){
				$(this).find('.vc_tta-panel').css('min-height', 0);
				var min_height = $(this).find('.vc_tta-panel.vc_active').height();
				$(this).find('.vc_tta-panel').css('min-height', min_height);
			});
		}, 1000);
	}
	
	/* Shortcode Milestone */
	if( typeof $.fn.waypoint == 'function' && typeof $.fn.countTo == 'function' ){
		$('.wd_milestone').waypoint(function(){
			this.disable();
			var end_num = $(this.element).find('.number').data('num');
			$(this.element).find('.number').countTo({
							from: 0
							,to: end_num
							,speed: 1500
							,refreshInterval: 30
						});
		}, {offset: '105%'});
	}
	
	/* Fix Blog Slider Nav Position */
	jQuery(window).load(function(){
		jQuery('.shortcode-recent-blogs > .blog-wrapper').each(function(){
			var blog_wrapper = jQuery(this);
			setTimeout(function(){
				reposition_blog_slider_navigation( blog_wrapper.attr('id') );
			}, 300);
		});
	});
	
	jQuery('ul.vc_tta-tabs-list li a').bind('click', function(){
		var tab_id = jQuery(this).attr('href');
		var tab_panel = jQuery(tab_id);
		var blog_wrapper = tab_panel.find('.shortcode-recent-blogs .blog-wrapper');
		if( blog_wrapper.length > 0 ){
			setTimeout(function(){
				reposition_blog_slider_navigation( blog_wrapper.attr('id') );
			}, 400);
		}
	});
	
	
	function reposition_blog_slider_navigation( object_id ){
		var object_wrapper = jQuery('#' + object_id);
		var slider_control = object_wrapper.find('.owl-controls .owl-nav > div');
		var image_height = 0;
		var image_first = object_wrapper.find('.header-wrapper:first');
		if( image_first.length > 0 && slider_control.length > 0 ){
			var image_height = image_first.height();
			if( image_height > 0 ){
				slider_control.css('top', image_height/2 - slider_control.height() / 2);
			}
		}
	}
	
});