(function() {	
	tinymce.PluginManager.add("Wd_shortcodes", function(editor, url) {
		function redender_window(title) {
			//[feature slug="" id="" title="yes" thumbnail="yes" excerpt="yes" content="yes"]
			editor.windowManager.open({
				title: title + " Shortcode",
				body: [
					{
						type: "textbox",
						name: "slug",
						label: "slug"
					},
					{
						type: "textbox",
						name: "id",
						label: "id"
					},
					{
						type: 'ListBox'
						, name: 'title'
						, label: 'Title'
						, values: [	{text: 'Yes', value: 'yes'},{text: 'No', value: 'no'}]
					},
					{
						type: 'ListBox'
						, name: 'thumbnail'
						, label: 'Thumbnail'
						, values: [	{text: 'Yes', value: 'yes'},{text: 'No', value: 'no'}]
					},
					{
						type: 'ListBox'
						, name: 'excerpt'
						, label: 'Excerpt'
						, values: [	{text: 'Yes', value: 'yes'},{text: 'No', value: 'no'}]
					},
					{
						type: 'ListBox'
						, name: 'content'
						, label: 'Content'
						, values: [	{text: 'Yes', value: 'yes'},{text: 'No', value: 'no'}]
					}					
				],
				width: 960,
				height: 440,
				onsubmit: function(e) {
					editor.insertContent('[feature slug="' + e.data.slug + '" id="" title="yes" thumbnail="yes" excerpt="yes" content="yes"]');
				}
			});
	    }
		function call_ajax(){
			//tb_show("WpDance Shortcodes", ajaxurl + "?action=wpdance_shortcodes&popup=" + popup + "&width=" + 800);
			tb_show("WpDance Shortcodes", ajaxurl + "?action=wpdance_shortcodes");
		}
        // Add a button that opens a window
        editor.addButton('wd_shortcodes_button', {
			icon: 'icon wd_shortcodes_button',
			tooltip: 'WPDance Shortcodes',
			classes: 'btn widget wpdance',
			onclick: function() {
				editor.windowManager.open({
					title: 'WPDance Shortcodes',
					body: [
						{
							type: 'ListBox'
							, name: 'WPDance'
							, label: 'Choose A Shortcode'
							, values: [							
								{text: 'Feature', value: 'feature'},
								{text: 'Testimonial', value: 'testimonial'},
								{text: '[WD]Custom product', value: 'wd_custom_product'},
								{text: '[WD]Custom products', value: 'wd_custom_products'},
								{text: '[WD]Custom products category', value: 'wd_custom_products_category'},
								{text: '[WD]Custom products category Grid image', value: 'wd_custom_products_category_grid_image'},
								{text: '[WD]Custom products category Grid no image', value: 'wd_custom_products_category_grid_noimage'},
								{text: '[WD]Custom products category list slider', value: 'wd_product_category_list_slider'},
								{text: '[WD]Popular product', value: 'wd_popular_product'},
								{text: '[WD]Feature product slider', value: 'featured_product_slider'},
								{text: '[WD]Popular product slider', value: 'popular_product_slider'},
								{text: '[WD]Recent product slider', value: 'recent_product_slider'},
								{text: '[WD]Best selling product slider', value: 'best_selling_product_slider'},
								{text: '[WD]Best selling product by categories slider', value: 'best_selling_product_by_category_slider'},
								{text: '[WD]Recent product by categories slider', value: 'recent_product_by_categories_slider'},
								
								{text: 'Add line', value: 'add_line'},
								{text: 'Align', value: 'align'},
								{text: 'Accordion', value: 'accordions'},
								{text: 'Alert', value: 'alert'},
								{text: 'Badges', value: 'badges'},
								{text: 'Banner', value: 'banner'},
								{text: 'Buttons', value: 'buttons'},
								{text: 'Checklist', value: 'checklist'},
								{text: 'Code', value: 'code'},
								{text:'Columns', 
									menu:[{
											text:'1/2',value:'one_half'
										},{
											text:'1/3',value:'one_third'
										},{
											text:'1/4',value:'one_fourth'
										},{
											text:'1/5',value:'one_fifth'
										},{
											text:'1/6',value:'one_sixth'
										},{
											text:'2/3',value:'two_third'
										},{
											text:'3/4',value:'three_fourth'
										},{
											text:'2/5',value:'two_fifth'
										},{
											text:'3/5',value:'three_fifth'
										},{
											text:'4/5',value:'four_fifth'
										},{
											text:'5/6',value:'five_sixth'
										},{
											text:'1/2 last',value:'one_half_last'
										},{
											text:'1/3 last',value:'one_third_last'
										},{
											text:'1/4 last',value:'one_fourth_last'
										},{
											text:'1/5 last',value:'one_fifth_last'
										},{
											text:'1/6 last',value:'one_sixth_last'
										},{
											text:'2/3 last',value:'two_third_last'
										},{
											text:'3/4 last',value:'three_fourth_last'
										},{
											text:'2/5 last',value:'two_fifth_last'
										},{
											text:'3/5 last',value:'three_fifth_last'
										},{
											text:'4/5 last',value:'four_fifth_last'
										},{
											text:'5/6 last',value:'five_sixth_last'
										}]},
								{text: 'Dropcap', value: 'dropcap'},
								{text: 'Faq', value: 'faq'},
								{text: 'Google Map', value: 'google_map'},
								{text: 'Heading', value: 'heading'},
								{text: 'Hidden phone', value: 'hidden_phone'},
								{text: 'Hr', value: 'hr'},
								{text: 'Icon', value: 'icon'},
								{text: 'Label', value: 'label'},
								{text: 'Listing', value: 'listing'},
								{text: 'Menu', value: 'menu'},
								{text: 'Progress bar', value: 'progress'},
								{text: 'Quote', value: 'Quote'},
								{text: 'Recent post', value: 'recent_post'},
								{text:'Tabs', menu:[{text:'Tabs style 1',value:'tabs_style_1'},{text:'Tabs style 2',value:'tabs_style_1'},{text:'Tab item',value:'tab_item'}]},
								{text: 'Tooltip', value: 'tooltip'}
							]
							,onselect: function(e) {
								console.log(this.value());
								editor.windowManager.close();
								if(this.value() == "feature"){
									call_ajax();
									//redender_window(this.text());
								}
                            }
						}
					],
                    width: 700,
                    height: 440,
					
				});			
			}
		});	
			
		
    });
})();