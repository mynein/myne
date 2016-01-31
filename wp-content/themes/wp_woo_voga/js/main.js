function em_search_bar(){
	var search_form = jQuery('.searchform');
	var search_input = search_form.find('.search-input');
	var text_default = search_input.attr('data-default');
	
	search_input.bind('click focus', function(){
		if( jQuery(this).val() === text_default ){
			jQuery(this).val("");
		}
	});
	search_input.bind('blur', function(){
		if( jQuery(this).val() === "" ){
			jQuery(this).val(text_default);
		}
	});
	
	search_input.trigger('blur');
}

function wd_show_header_search_bar(){
	if( jQuery(window).width() >= 1230 ){
		jQuery('.header-v2 .header_search').hover(
			function(){
				jQuery(this).find('input[name="s"]').show().focus();
			},
			function(){
				jQuery(this).find('input[name="s"]').hide();
			}
		);
	}
}
// **********************************************************************// 
// ! Full width section
// **********************************************************************//
function em_sections(){ 
	jQuery('.em_section, .stripe-style-full').each(function(){
		
		if( !jQuery('body').hasClass('rtl') ){
			jQuery(this).css({'left': ''});
			jQuery(this).css({
				'width': jQuery('body').width(),
				'left': - (jQuery(this).offset().left),
				'visibility': 'visible',
				'position': 'relative'
			});
		}
		else{
			jQuery(this).css({'left': 'auto'});
			jQuery(this).css({'right': 'auto'});
			var rt = (jQuery(window).width() - (jQuery(this).offset().left + jQuery(this).outerWidth()));
			jQuery(this).css({
				'right': - (rt),
				'width': jQuery(window).width(),
				'visibility': 'visible',
				'position': 'relative'
			});
		}
		
		var videoTag = jQuery(this).find('.section-back-video video');
		videoTag.css({
			'width': jQuery(window).width()
		});
	});
}
function dataAnimate(){
  jQuery('[data-animate]').each(function(){
    
    var $toAnimateElement = jQuery(this);
    
    var toAnimateDelay = jQuery(this).attr('data-delay');
    
    var toAnimateDelayTime = 0;
    
    if( toAnimateDelay ) { toAnimateDelayTime = Number( toAnimateDelay ); } else { toAnimateDelayTime = 200; }
    
    if( !$toAnimateElement.hasClass('animated') ) {
      
      $toAnimateElement.addClass('not-animated');
      
      var elementAnimation = $toAnimateElement.attr('data-animate');
      
      $toAnimateElement.appear(function () {
        
        setTimeout(function() {
          $toAnimateElement.removeClass('not-animated').addClass( elementAnimation + ' animated');
        }, toAnimateDelayTime);
        
      },{accX: 0, accY: -80},'easeInCubic');
      
    }
    
  });
}

if (typeof checkIfTouchDevice != 'function') { 
    function checkIfTouchDevice(){
        touchDevice = !!("ontouchstart" in window) ? 1 : 0; 
		if( jQuery.browser.wd_mobile ) {
			touchDevice = 1;
		}
		return touchDevice;      
    }
}

function number_animate(val_){
	var	text	= jQuery(val_),endVal	= 0,currVal	= 0,obj	= {};
	var value = jQuery(val_).text();
	obj.getTextVal = function() {
		return parseInt(currVal, 10);
	};

	obj.setTextVal = function(val) {
		currVal = parseInt(val, 10);
		text.text(currVal);
	};

	obj.setTextVal(0);
	currVal = 0; // Reset this every time
	endVal = value;

	TweenLite.to(obj, 2, {setTextVal: endVal, ease: Power2.easeInOut});
}

function sticky_main_menu( on_touch ){
		var _topSpacing = 0;
		var _topBegin = jQuery('#header').height();
		if( jQuery('body').hasClass('logged-in') && jQuery('body').hasClass('admin-bar') && jQuery('#wpadminbar').length > 0 ){
			_topSpacing = jQuery('#wpadminbar').height();
		}
		if( !on_touch && jQuery(window).width() > 1024 ){
			jQuery("#header").sticky({topSpacing:_topSpacing,topBegin:_topBegin});
		}
}




function hexToRgb(hex) {
    // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
        return r + r + g + g + b + b;
    });

    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

function set_header_bottom(){
    var header_height = jQuery(window).innerHeight();
	var temp = 1;
    
	if(jQuery(".wd_fullwidth_slider_wrapper").length > 0 ){
		if(jQuery("div#wpadminbar").length > 0) {
			jQuery("div#template-wrapper").css("margin-top","-32px");
		}
		jQuery(".wd_fullwidth_slider_wrapper").height(header_height - temp +"px");
		
	}
}

function set_cloud_zoom(){
	var clz_width = jQuery('#qs-zoom,.wd-qs-cloud-zoom,.cloud-zoom, .cloud-zoom-gallery').width();
	var clz_img_width = jQuery('#qs-zoom,.wd-qs-cloud-zoom,.cloud-zoom, .cloud-zoom-gallery').children('img').width();
	var cl_zoom = jQuery('#qs-zoom,.wd-qs-cloud-zoom,.cloud-zoom, .cloud-zoom-gallery').not('.on_pc');
	var temp = (clz_width-clz_img_width)/2;
	if(cl_zoom.length > 0 ){
		cl_zoom.data('zoom',null).siblings('.mousetrap').unbind().remove();
		cl_zoom.CloudZoom({ 
			adjustX:temp	
		});
	}
}
function onSizeChange(windowWidth){
	if( windowWidth >= 768 ) {
			jQuery('a.block-control').removeClass('active').hide();
			jQuery('a.block-control').parent().siblings().show();
	}
	if( windowWidth < 768 ) {
			jQuery('a.block-control').removeClass('active').show();
			jQuery('a.block-control').parent().siblings().hide();
	}		
}
function tab_slider(windowWidth){
	var on_touch = checkIfTouchDevice();
	var _bind = 'click';
	if(on_touch & windowWidth >= 768 && windowWidth <= 1024){  // event for ipad
		_bind = 'mouseenter';
	}
	/*mouseenter click.tab.data-api mousedown*/
	jQuery('.wpb_tabs > div > ul.wpb_tabs_nav > li > a').bind(_bind,function(e){
		if(jQuery(this).parent('li').hasClass('active'))	
			return;
		var temp = jQuery(this).attr('href'); //tab select content
		if(jQuery(this).closest('.wpb_tabs').hasClass('has_slider')){
			var doc = jQuery(temp).find('.featured_product_slider_wrapper');
			if(doc.length > 0 ) {	
				var id_shortcode =  doc.attr('id');
				setTimeout(function(){
					jQuery('.wpb_tabs.has_slider #' + id_shortcode).find("div.products").trigger('destroy',true);
					jQuery('.wpb_tabs.has_slider').trigger('tabs_change',[id_shortcode]);
				},200);
			}	
		}
	});
}

function change_cart_items_mobile(){
	var _cart_items = parseInt(jQuery( ".wd_tini_cart_wrapper .cart_size .number:first" ).text());
	_cart_items = isNaN(_cart_items) ? 0 : _cart_items;
	jQuery('.mobile_cart_container > .mobile_cart_number').text(_cart_items);
}

function wd_custom_yith_compare(){
	if( typeof yith_woocompare !== "object" )
		return;
	jQuery("#cboxOverlay, #cboxClose").live("click",function(){
		jQuery('body').trigger('added_to_cart');
	});
}

function wd_woocommerce_increase_quantity($){
	// Quantity buttons
	$( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<input type="button" value="+" class="plus" />' ).prepend( '<input type="button" value="-" class="minus" />' );

	$( document ).on( 'click', '.plus, .minus', function() {

		// Get values
		var $qty		= $( this ).closest( '.quantity' ).find( '.qty' ),
			currentVal	= parseFloat( $qty.val() ),
			max			= parseFloat( $qty.attr( 'max' ) ),
			min			= parseFloat( $qty.attr( 'min' ) ),
			step		= $qty.attr( 'step' );

		// Format values
		if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
		if ( max === '' || max === 'NaN' ) max = '';
		if ( min === '' || min === 'NaN' ) min = 0;
		if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

		// Change the value
		if ( $( this ).is( '.plus' ) ) {

			if ( max && ( max == currentVal || currentVal > max ) ) {
				$qty.val( max );
			} else {
				$qty.val( currentVal + parseFloat( step ) );
			}

		} else {

			if ( min && ( min == currentVal || currentVal < min ) ) {
				$qty.val( min );
			} else if ( currentVal > 0 ) {
				$qty.val( currentVal - parseFloat( step ) );
			}

		}

		// Trigger change event
		$qty.trigger( 'change' );

	});
}

jQuery(document).ready(function($) {
		"use strict";
		var on_touch = checkIfTouchDevice();
		if (jQuery.browser.msie && jQuery.browser.version <= 10) {
			jQuery("html").addClass('ie' + parseInt(jQuery.browser.version) + " ie");
		} else {
			if (jQuery("html").attr('id') == 'wd_ie' && jQuery.browser.version == 11) {
				jQuery("html").addClass("ie11 ie");
			}
		}

		/*************** Start Woo Add On *****************/
		jQuery('body').bind( 'adding_to_cart', function() {
			jQuery('.cart_dropdown').addClass('disabled working');
		} );		
        
        
        //social
        jQuery("ul.social-share > li > a > span").css("position","relative").css('display', 'inline-block').css("left","500px").css("visibility","0");
		jQuery("ul.social-share > li > a > span").each(function(index,value){
			TweenMax.to( jQuery(value),0.0, { css:{left:"0px",opacity:1 },  ease:Power2.easeInOut ,delay:index*0.9});
		});
		      
        
		jQuery('.add_to_cart_button').live('click',function(event){
			var _li_prod = jQuery(this).parent().parent().parent().parent();
			_li_prod.trigger('wd_adding_to_cart');
		});
		
		jQuery('div.product').bind('wd_adding_to_cart', function() {
			jQuery(this).addClass('adding_to_cart').append('<div class="loading-mark-up"><div class="loading-image"></div></div>');
			var _loading_mark_up = jQuery(this).find('.loading-mark-up').css({'width' : jQuery(this).width()+'px','height' : jQuery(this).height()+'px'}).show();
		});
		jQuery('li.product').each(function(index,value){
			jQuery(value).bind('wd_added_to_cart', function() {
				var _loading_mark_up = jQuery(value).find('.loading-mark-up').remove();
				jQuery(value).removeClass('adding_to_cart').addClass('added_to_cart').append('<span class="loading-text"></span>');//Successfully added to your shopping cart
				var _load_text = jQuery(value).find('.loading-text').css({'width' : jQuery(value).width()+'px','height' : jQuery(value).height()+'px'}).delay(1500).fadeOut();
				setTimeout(function(){
					_load_text.hide().remove();
				},1500);
				//delete view cart		
				jQuery('.list_add_to_cart .added_to_cart').remove();
				
				var _current_currency = jQuery.cookie('woocommerce_current_currency');

				//switch_currency( _current_currency );
			});	
		});	
		
		
		jQuery('body').bind( 'added_to_cart', function(event) {
			if( typeof _ajax_uri == "undefined" )
				return;
			var _added_btn = jQuery('.product').find('.add_to_cart_button.added');
			var _added_li = _added_btn.parent().parent().parent().parent();
			_added_li.each(function(index,value){
				jQuery(value).trigger('wd_added_to_cart');
			});
			
			jQuery('.wd_tini_cart_wrapper').addClass('loading');
			
			if( typeof _is_ec_page == 'undefined' ){
				_is_ec_page = 0;
			}
			
			jQuery.ajax({
				type : 'POST'
				,url : _ajax_uri	
				,data : {action : 'update_tini_cart', is_ec_page: _is_ec_page}
				,success : function(respones){
					if( jQuery('.shopping-cart-wrapper').length > 0 ){
						jQuery('.shopping-cart-wrapper').html(respones);
						jQuery('.cart_dropdown,.form_drop_down').hide();
						jQuery('body').trigger('mini_cart_change');
						change_cart_items_mobile();
						setTimeout(function(){
							jQuery('.wd_tini_cart_wrapper').removeClass('loading');
						},1000);
						jQuery('body').trigger('cart_widget_refreshed');
						jQuery('body').trigger('cart_page_refreshed');
					}
				}
			});			
		} );	

		jQuery('.cart_dropdown .ec_remove_item').live('click', function(){
			if( typeof _ajax_uri == "undefined" )
				return;
			
			var remove_button = jQuery(this);
			remove_button.parents('li').addClass('loading');
			
			jQuery.ajax({
				type : 'POST'
				,url : _ajax_uri	
				,data : {action : 'ec_ajax_cartitem_delete', ec_v3_24: 'true', cartitem_id: remove_button.data('cartitem_id')}
				,success : function(respones){
					location.reload();
				}
			});
			
			return false;
		});
		
		jQuery('.cart_dropdown,.form_drop_down').hide();
		change_cart_items_mobile();
		
		jQuery('.wd_tini_cart_wrapper,.wd_tini_account_wrapper, .header-currency').hoverIntent(
			function(){
				jQuery(this).children('.drop_down_container').slideDown(200);
			}
			,function(){
				jQuery(this).children('.drop_down_container').slideUp(200);
			}
		
		);

		jQuery('body').live('mini_cart_change',function(){
			jQuery('.wd_tini_cart_wrapper,.wd_tini_account_wrapper').hoverIntent(
				function(){
					jQuery(this).children('.drop_down_container').slideDown(200);
				}
				,function(){
					jQuery(this).children('.drop_down_container').slideUp(200);
				}
			
			);
		});	
		
		/** Currency active **/
		jQuery('ul.currency_switcher li a').click(function() {
			var currency_code = jQuery(this).attr('data-currencycode');
			var current_currency_name = '';
			var current_currency_symbol = '';
			jQuery('ul.currency_switcher a').removeClass('active');
			jQuery('ul.currency_switcher a').each(function(index, element){
				if( jQuery(element).attr('data-currencycode') == currency_code ){
					jQuery(element).addClass('active');
					if( jQuery(element).find('.name').length > 0 ){
						current_currency_name = jQuery(element).find('.name').text();
						current_currency_symbol = jQuery(element).find('.symbol').text();
					}
				}
			});
			jQuery('.header-currency .currency_control .current_currency').text(current_currency_name);
			jQuery('.header-currency .currency_control .symbol').text(current_currency_symbol);
		});
		if( typeof wc_currency_converter_params != 'undefined' && !jQuery('.header-currency .currency_dropdown').hasClass('ec_currency') ){
			var current_currency  = wc_currency_converter_params.current_currency;
			jQuery('.header-currency ul.currency_switcher a').each(function(index, element){
				if( jQuery(element).attr('data-currencycode') == current_currency || current_currency == '' ){
					jQuery('.header-currency .currency_control .current_currency').text(jQuery(element).find('.name').text());
					jQuery('.header-currency .currency_control .symbol').text(jQuery(element).find('.symbol').text());
					return false;
				}
			});
		}
		
		/* Easycart currency */
		if( jQuery('.currency_dropdown').hasClass('ec_currency') ){
			jQuery('ul.currency_switcher li a').unbind('click');
		}
		jQuery('.currency_dropdown.ec_currency ul.currency_switcher li a').bind('click',function(){
			var code = jQuery(this).attr('data-currencycode');
			var form = jQuery(this).closest('form');
			form.find('input[name="ec_currency_conversion"]').val(code);
			form.submit();
			return false;
		});

		
		setTimeout(function () {
			jQuery("div.shipping-calculator-form").show(400);
		}, 1500);
		
		
		/*jQuery("select.wd_search_product").select2();*/
		jQuery('.header_search, .wd_hot_product').addClass("show");
        
        /***** W3 Total Cache & Wp Super Cache Fix *****/
        jQuery('body').trigger('added_to_cart');
        /***** End Fix *****/
		
		jQuery('.ec_product_addtocart, .ec_cartitem_update_button, .ec_cartitem_delete, .ec_product_quickview_content_add_to_cart_container input[type="button"]:not(.ec_minus, .ec_plus)').bind('click', function(){
			var is_delete = false;
			if( jQuery(this).hasClass('ec_product_addtocart') ){
				var loading_wrapper = jQuery(this).parent().siblings('.ec_product_loader_container');
			}
			if( jQuery(this).hasClass('ec_cartitem_update_button') ){
				var loading_wrapper = jQuery(this).parents('.ec_cartitem_quantity_table').siblings('.ec_cartitem_updating');
			}
			if( jQuery(this).hasClass('ec_cartitem_delete') ){
				var loading_wrapper = jQuery(this).siblings('.ec_cartitem_deleting');
				is_delete = true;
			}
			if( jQuery(this).parents('.ec_product_quickview_container').length > 0 ){
				var quickview_id = jQuery(this).parents('.ec_product_quickview_container').attr('id');
				var arr_id = quickview_id.split('_');
				var product_model = arr_id[arr_id.length - 1];
				var loading_wrapper = jQuery('#ec_product_loader_' + product_model);
			}
			
			if( loading_wrapper.length > 0 ){
				var count = 1;
				if( is_delete ){
					var _this = jQuery(this).parents('tbody').find('tr');
					var current_row = _this.parents('tbody').find('tr').length;
				}
				var interval = setInterval(function(){
					if( loading_wrapper.css('display') == 'none' || ( is_delete && _this.parents('tbody').find('tr').length != current_row ) || count == 100 ){
						jQuery('body').trigger('added_to_cart');
						clearInterval(interval);
					}
					count++;
				}, 100);
			}
		});
        
		/***** Start Re-init Cloudzoom on Variation Product  *****/
		jQuery('form.variations_form').live('found_variation',function( event, variation ){
			jQuery('#qs-zoom,.wd-qs-cloud-zoom,.cloud-zoom, .cloud-zoom-gallery').CloudZoom({}); 
		}).live('reset_image',function(){
			jQuery('#qs-zoom,.wd-qs-cloud-zoom,.cloud-zoom, .cloud-zoom-gallery').CloudZoom({}); 
		});
		/***** End Re-init Cloudzoom on Variation Product  *****/        
        
        /*************** End Woo Add On *****************/
        
        /*************** Disable QS in Main Menu *****************/
        jQuery('ul.menu').find('ul.products').addClass('no_quickshop');
        /*************** Disable QS in Main Menu *****************/
		
		
		if (jQuery.browser.msie && ( parseInt( jQuery.browser.version, 10 ) == 7 )){
			alert("Your browser is too old to view this interactive experience. You should take the next 30 seconds or so and upgrade your browser! We promise you'll thank us after doing so in having a much better and safer web browsing experience! ");
		}

		
		em_sections();
		em_search_bar();
		wd_show_header_search_bar();
		jQuery(window).bind('resize', function(){
			wd_show_header_search_bar();
		});
		var windowWidth = jQuery(window).width();
		
		setTimeout(function () {
			  onSizeChange(windowWidth);
		}, 1000);	
		
        jQuery('a.block-control').click(function(){
            jQuery(this).parent().siblings().slideToggle(300);
            jQuery(this).toggleClass('active');
            return false;
        });
		
		jQuery('li.shortcode').hover(function(){
			jQuery(this).addClass('shortcode_hover')},function(){jQuery(this).removeClass('shortcode_hover');});
		

		//call review form
		jQuery('.wd-review-link').click(function(){
			if(jQuery('.woocommerce-tabs').length > 0){
				jQuery('.woocommerce-tabs li.reviews_tab').children('a').trigger('click');
			}
		}).trigger('click');
		
		////////// Generate Tab System /////////
		if(jQuery('.tabs-style').length > 0){
			jQuery('.tabs-style').each(function(){
				var ul = jQuery('<ul></ul>');
				var divPanel = jQuery('<div></div>');
				var liChildren = jQuery(this).find('li.tab-item');
				var length = liChildren.length;
				divPanel.addClass('panel');
				jQuery(this).find('li.tab-item').each(function(index){
					jQuery(this).children('div').appendTo(divPanel);
					if(index == 0)
						jQuery(this).addClass('first');
					if(index == length - 1)
						jQuery(this).addClass('last');
					jQuery(this).appendTo(ul);
					
				});
				jQuery(this).append(ul);
				jQuery(this).append(divPanel);
				
					jQuery( this ).tabs({ fx: { opacity: 'toggle', duration:'slow'} }).addClass( 'ui-tabs-vertical ui-helper-clearfix' );
				
			});		
		}
		
		// Toggle effect for ew_toggle shortcode
		jQuery( '.toggle_container a.toggle_control' ).click(function(){
			if(jQuery(this).parent().parent().parent().hasClass('show')){
				jQuery(this).parent().parent().parent().removeClass('show');
				jQuery(this).parent().parent().parent().addClass('hide');
				jQuery(this).parent().parent().children('.toggle_content ').hide('slow');
			}
			else{
				jQuery(this).parent().parent().parent().addClass('show');
				jQuery(this).parent().parent().parent().removeClass('hide');
				jQuery(this).parent().parent().children('.toggle_content ').show('slow');
			}
				
		});
		
        
        // **********************************************************************// 
		// ! Parallax
		// **********************************************************************// 
		
		if(on_touch == 0){
			jQuery(window).load(function(){
				$('.stripe-parallax-bg, .fancy-parallax-bg').each(function(){
					var $_this = $(this),
						fixed_prl = $_this.data("prlx-fixed"),
						speed_prl = $_this.data("prlx-speed");
					
					if(fixed_prl == "true"){
						$_this.css({
							'background-position': '50% 0px',
							'background-repeat': 'no-repeat',
							'background-attachment': 'fixed'
						});
					}
					else{
						$(this).parallax("50%", speed_prl);
						$('.stripe-parallax-bg').addClass("parallax-bg-done");
					}
				});
			});
		}
		
        //fancy box
        var fancy_wd = jQuery("a.fancybox").fancybox({
			// 'openEffect'	: 'elastic'
			// ,'closeEffect'	: 'elastic'
			// ,'openEasing'   : 'easeOutBack'
			// ,'closeEasing'  : 'easeOutBack'
			// ,'nextEasing'   : 'easeOutBack'
			// ,'prevEasing'	: 'easeOutBack'		
			// 'openSpeed'    : 500
			// ,'openSpeed'	: 500
			// ,'nextSpeed'	: 1000
			// ,'prevSpeed'    : 1000
			'scrolling'	: 'no'
			,'mouseWheel'	: false

			,beforeLoad  : function(){
					tmp_href = this.href;
					if( this.href.indexOf('youtube.com') >= 0 || this.href.indexOf('youtu.be') >= 0 ){
						this.type = 'iframe';
						this.scrolling = 'no';
						//&html5=1&wmode=opaque
						this.href = this.href.replace(new RegExp("watch\\?v=", "i"), 'embed/') + '?autoplay=1';
					}
					else if( this.href.indexOf('vimeo.com') >= 0 ){
						this.type = 'iframe';
						this.scrolling = 'no';					
						//this.href = this.href.replace(new RegExp("([0-9])","i"),'moogaloop.swf?clip_id=$1') + '&autoplay=1';
						var regExp = /http:\/\/(www\.)?vimeo.com\/(\d+)($|\/)/;
						var match = this.href.match(regExp);
						this.href = 'http://player.vimeo.com/video/' + match[2] + '?portrait=0&color=ffffff';
					}
					else{
						//this.type = null;
					}
					
					
			}
			,afterClose : function(){
					this.href = tmp_href;
			}		
			,afterShow  : function(){
				jQuery('.fancybox-wrap').wipetouch({
					tapToClick: true, // if user taps the screen, triggers a click event
					wipeLeft: function(result) { 
						jQuery.fancybox.next();
					},
					wipeRight: function(result) {
						jQuery.fancybox.prev();
					}
				});					
				if( jQuery('.fancybox-prev-clone').length <= 0 )
					jQuery('.fancybox-prev').clone().removeClass('fancybox-nav fancybox-prev').addClass('fancybox-prev-clone').appendTo(".fancybox-overlay");
				
				if( jQuery('.fancybox-next-clone').length <= 0 )
					jQuery('.fancybox-next').clone().removeClass('fancybox-nav fancybox-next').addClass('fancybox-next-clone').appendTo(".fancybox-overlay");
				
				if( jQuery('.fancybox-close-clone').length <= 0 )
					jQuery('.fancybox-close').clone().removeClass('fancybox-item fancybox-close').addClass('fancybox-close-clone').appendTo(".fancybox-overlay");
			
				if( jQuery('.fancybox-title-clone').length <= 0 )
					jQuery('.fancybox-title').clone().addClass('fancybox-title-clone').appendTo(".fancybox-overlay");
				else{
					jQuery('.fancybox-title-clone').html( jQuery('.fancybox-wrap').find('.fancybox-title').html() );
				}	
				jQuery('.fancybox-wrap').find('.fancybox-title').hide();				
				
				jQuery('.fancybox-wrap').find('.fancybox-prev').hide();
				jQuery('.fancybox-wrap').find('.fancybox-next').hide();
				jQuery('.fancybox-wrap').find('.fancybox-close').hide();
				
			}			
			
		}); 
        
        jQuery('.fancybox-prev-clone').live('click',function(){
			jQuery('.fancybox-wrap').find('.fancybox-prev').trigger('click');
		});
		jQuery('.fancybox-next-clone').live('click',function(){
			jQuery('.fancybox-wrap').find('.fancybox-next').trigger('click');
		});
		jQuery('.fancybox-close-clone').live('click',function(){
			jQuery('.fancybox-wrap').find('.fancybox-close').trigger('click');
		});
        
        

		jQuery('p:empty').remove();
		
		// button state demo
		jQuery('.btn-loading')
		  .click(function () {
			var btn = jQuery(this)
			btn.button('loading')
			setTimeout(function () {
			  btn.button('reset')
			}, 3000)
		  });
		
		// tooltip 
		jQuery('body').tooltip({
		  selector: "a[rel=tooltip]"
		});
	 
		jQuery('.view_full a').click(function(event){	
			event.preventDefault();
			jQuery('meta[name="viewport"]').remove();
		});
		
		if( jQuery('html').offset().top < 100 ){
			jQuery("#to-top").hide();
		}
		jQuery(window).scroll(function () {
			
			if (jQuery(this).scrollTop() > 100) {
				jQuery("#to-top").fadeIn();
			} else {
				jQuery("#to-top").fadeOut();
			}
		});
		jQuery('.scroll-button').click(function(){
			jQuery('body,html').animate({
			scrollTop: '0px'
			}, 1000);
			return false;
		});			

		
		jQuery('#myTab a').click(function (e) {
			e.preventDefault();
			jQuery(this).tab('show');
		});
	
		
		//sticker block
		if(jQuery('.wd_sticker').length){		
			jQuery('.wd_sticker').csTicker({
				tickerTitle: 'Hot News',
				tickerMode:'mini',
				speed: 600,
				autoAnimate: true
			});	
		}	

		
		var touch = false;
		  /* DETECT PLATFORM */
		  jQuery.support.touch = 'ontouchend' in document;
		  
		  if (jQuery.support.touch) {
			touch = true;
			jQuery('body').addClass('touch');
		  }
		  else{
			jQuery('body').addClass('notouch');
		  }
		  
		  if(touch == false){
			dataAnimate();
		  }	
		
		
		jQuery('.carousel').each(function(index,value){
			jQuery(value).wipetouch({
				tapToClick: false, // if user taps the screen, triggers a click event
				wipeLeft: function(result) { 
					jQuery(value).find('a.carousel-control.right').trigger('click');
					//jQuery(value).carousel('next');
				},
				wipeRight: function(result) {
					jQuery(value).find('a.carousel-control.left').trigger('click');
					//jQuery(value).carousel('prev');
				}
			});	
		});
		
        set_cloud_zoom();
		set_header_bottom();
		// Set menu on top
		if(typeof(_enable_sticky_menu) != "undefined"){
			if(_enable_sticky_menu==1)
				sticky_main_menu( on_touch );
		}
		else{
			sticky_main_menu( on_touch );
		}
		if( on_touch == 0 ){
			jQuery(window).bind('resize',jQuery.throttle( 250, 
				function(){
					if( !( jQuery.browser.msie &&  parseInt( jQuery.browser.version, 10 ) <= 7 ) ){
						onSizeChange( jQuery(window).width() );
                        set_header_bottom();
						em_sections();
						set_cloud_zoom();
						menu_change_state( jQuery('body').innerWidth() );	
						tab_slider(jQuery(window).width());
					}
				})
			);
		}else{
			jQuery(window).bind('orientationchange',function(event) {	
					onSizeChange( jQuery(window).width() );
					set_header_bottom();
					em_sections();
					set_cloud_zoom();
					menu_change_state( jQuery('body').innerWidth() );
					tab_slider(jQuery(window).width());					
			});
		}
		
		/* Mobile menu */
		jQuery('.wd_mobile_menu_wrapper > .menu-icon').bind('click', function(){
			jQuery('.wd_mobile_menu_content').slideToggle();
			jQuery(this).toggleClass('active');
		});
        
		jQuery(".right-sidebar-content > ul > li:first").addClass('first');
		jQuery(".right-sidebar-content > ul > li:last").addClass('last');
		
		
		jQuery(".product_upsells > ul").each(function( index,value ){
			jQuery(value).children("li:last").addClass('last');
		});
		

		jQuery("ul.product_list_widget").each(function(index,value){
			jQuery(value).children("li:first").addClass('first');
			jQuery(value).children("li:last").addClass('last');
		});
		jQuery(".related.products > ul > li:last").addClass('last');
		
		jQuery(document).on('click','div.wd_cart_buttons a.wd_update_button_visible',function(event){
			event.preventDefault();
			jQuery('.woocommerce form.wd_form_cart .wd_update_button_invisible').trigger('click');	
		});
		jQuery(document).on('click','.cart_totals_wrapper .checkout-button-visible',function(event){
			event.preventDefault();
			jQuery('.checkout-button').trigger('click');	
		});

		jQuery("a.wd-prettyPhoto").prettyPhoto({
			social_tools: false,
			theme: 'pp_default wd_feedback',
			horizontal_padding: 30,
			opacity: 0.9,
			deeplinking: false
		});

		wd_custom_yith_compare();
		
		/* Custom Orderby Shop page*/
		jQuery('.woocommerce-ordering ul.orderby ul a').bind('click', function(e){
			e.preventDefault();
			if( jQuery(this).hasClass('current') ){
				return;
			}
			var form = jQuery(this).closest('form.woocommerce-ordering');
			var selected = jQuery(this).attr('data-orderby');
			form.find('select.orderby').val(selected);
			form.submit();
		});
		
		/* Custom form login */
		jQuery('#customer_login #wd_login').bind('click',function(e){
			e.preventDefault();
			if(jQuery('.customer_login.login').hasClass('active')){
				jQuery('.customer_login.login').removeClass('active');
			}
			if(jQuery('.customer_login.register').hasClass('active')== false){
				jQuery('.customer_login.register').addClass('active');
			}
		});
		jQuery('#customer_login #wd_register').bind('click',function(e){
			e.preventDefault();
			if(jQuery('.customer_login.register').hasClass('active')){
				jQuery('.customer_login.register').removeClass('active');
			}
			if(jQuery('.customer_login.login').hasClass('active')==false){
				jQuery('.customer_login.login').addClass('active');
			}
		});
		
		/* Add class has-rating, has-categories */
		jQuery('section.product .loop-rating').parents('section.product').addClass('has-rating');
		jQuery('section.product .wd_product_categories').parents('section.product').addClass('has-categories');
		
		/* Visual Composer -  Accordion active */
		setTimeout(function(){
			jQuery('.wpb_accordion_wrapper .ui-state-active').parent('.wpb_accordion_section').addClass('active');
		}, 100);
		
		jQuery('.wpb_accordion_header').bind('click', function(){
			if( !jQuery(this).hasClass('ui-state-active') ){
				var _this = jQuery(this);
				setTimeout(function(){
					_this.parents('.wpb_accordion_wrapper').find('.wpb_accordion_section').removeClass('active');
					_this.parent('.wpb_accordion_section').addClass('active');
				}, 350);
			}
		});
		/* WISHLIST LOADING */
		jQuery('.yith-wcwl-add-button').bind('click', function(){
			var _this = jQuery(this);
			setTimeout(function(){
				if(_this.find('img.ajax-loading').css('visibility') == 'visible'){
					_this.addClass('loading-ajax');
				}
			},50);
		});
		
		/* Fix Wishlist Label */
		if( jQuery('.woocommerce-message').length > 0 && typeof yith_wcwl_l10n != 'undefined' ){
			yith_wcwl_l10n.labels.added_to_cart_message = '<div class="woocommerce-message">' + jQuery('.woocommerce-message').html() + '</div>';
		}
		
		/* Fix WooCommerce Increase Button*/
		wd_woocommerce_increase_quantity($);
		
		/* EasyCart slider */
		$('.wd_ec_slider').each(function(index, ele){
			var _this = $(ele);
			if( _this.find('.ec_productlist_ul .ec_product_li').length > 1 ){
				var _slider_data =	{
					item 			: 4
					,margin			: 40
					,loop			: true
					,slideBy		: 'page'
					,nav			: true
					,navText		: [ '<', '>' ]
					,dots			: false
					,lazyload		: true
					,autoplay		: true
					,rtl			: jQuery('body').hasClass('rtl')
					,responsiveBaseElement: _this
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
						1210:{
							items: 5
						}
					}
					,onInitialized: function(){
						
					}
				}
				_this.find('.ec_productlist_ul').owlCarousel(_slider_data);
			}
		});
});