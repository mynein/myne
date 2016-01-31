/**
 * WD QuickShop
 *
 * @license commercial software
 * @copyright (c) 2013 Codespot Software JSC - WPDance.com. (http://www.wpdance.com)
 */


var wd_qs_prettyPhoto = null;
var qs = null;
(function($) {
	"use strict";
	
	// disable QuickShop:
	//if(jQuery('body').innerWidth() < 768)
		//EM_QUICKSHOP_DISABLED = true;
	
	jQuery.noConflict();
	jQuery(function ($) {
		//insert quickshop popup
		function qs_prettyPhoto(){
			 $('.wd_quickshop_handler').prettyPhoto({
				deeplinking: false
				,opacity: 0.9
				,social_tools: false
				,default_width: jQuery('body').innerWidth()/8*5
				,default_height: "innerHeight" in window ? ( window.innerHeight - 150 ) : (document.documentElement.offsetHeight - 150)
				//,default_height: window.innerHeight - 150
				,theme: 'pp_woocommerce'
				,changepicturecallback : function(){
				
					$("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").addClass('buttons_added').append('<input type="button" value="+" id="add1" class="plus" />').prepend('<input type="button" value="-" id="minus1" class="minus" />');
					$('.pp_inline').find('form.variations_form').wc_variation_form();
					$('.pp_inline').find('form.variations_form .variations select').change();	
					
					var $_this = jQuery('.wd_quickshop');
						
					var owl = $_this.find('.product_thumbnails').owlCarousel({
							items : 4
							,loop : true
							,nav : true
							,navText: [ '<', '>' ]
							,dots : false
							,navSpeed : 1000
							,slideBy: 1
							,margin:10
							,navRewind: false
							,autoplay: false
							,autoplayTimeout: 5000
							,autoplayHoverPause: false
							,autoplaySpeed: false
							,mouseDrag: true
							,touchDrag: true
							,responsiveBaseElement: $_this
							,responsiveRefreshRate: 400
							,onInitialized: function(){
								$_this.find('.product_thumbnails').addClass('loaded').removeClass('loading');
							}
						});
				}
			});
		}
		qs_prettyPhoto();
		wd_qs_prettyPhoto = qs_prettyPhoto;
		
		// quickshop init
		function _qsJnit() {		
			//var qsHandlerImg = $('#em_quickshop_handler img');
			var qsHandler = $('.wd_quickshop_handler');
			
			/*qsHandler.live('click', function (event) {		
				_qs_window(this);
				event.preventDefault();
			});*/
			
			$('.wd_quickshop.product').live('mouseover',function(){
				if( !$(this).hasClass('active') ){
					$(this).addClass('active');
					$('#qs-zoom,.wd-qs-cloud-zoom,.cloud-zoom, .cloud-zoom-gallery').CloudZoom({});							
				}
			});
			
		}

		if (typeof EM_QUICKSHOP_DISABLED == 'undefined' || !EM_QUICKSHOP_DISABLED)
		
			/*************** Disable QS in Main Menu *****************/
			jQuery('ul.menu').find('div.products').addClass('no_quickshop');
			jQuery('.wd_product_category_list_shortcode').find('div.products').addClass('no_quickshop');
			jQuery('div.custom_category_shortcode_style2 .bottom_content').find('div.products').addClass('no_quickshop');
			/*************** Disable QS in Main Menu *****************/		
		
			_qsJnit({
				itemClass		: 'div.products div.product.type-product.status-publish .product_thumbnail_wrapper' //selector for each items in catalog product list,use to insert quickshop image
				,inputClass		: 'input.hidden_product_id' //selector for each a tag in product items,give us href for one product
			});
			qs = _qsJnit;
	});
})(jQuery);

