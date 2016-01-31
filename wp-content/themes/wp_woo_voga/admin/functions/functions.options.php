<?php
add_action('init','of_options');

/***********Instruction***************
** Begin : 177
** Styling options : 396 -> 1061 ==>  	THEME COLOR: 437,THEME PRIMARY:466, THEME BUTTON PRIMAR:524,THEME BUTTON SECONDARY: 580
**			THEME BUTTON TERTIARY:636, PRIMARY TAB: 680, PRIMARY ACCORDION:718, TOP HEADER: 762, VERTICAL MENU:782
**			HORIZONTAL MENU:844 + 20 =  864, SIDEBAR: 918 + 20, FOOTER:986 + 20, PRODUCT:1024 + 20
** Typography	1122 -> 1317	
** Mega Menu	1319 -> 1361
** Integration	1422 -> 1450
** Product Category 	1465 -> 1506
** Product Details		1507 -> 1793
** Blog Options
** Blog Details
** Backup Options
** Documentation
** End
*************************************/
if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories 		= array();  
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp 	= array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages 			= array();
		$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp 		= array_unshift($of_pages, "Select a page:");       
	
		//Testing 
		$of_options_select 	= array("one","two","three","four","five"); 
		$of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		
		//Sidebars
		$of_sidebars 	= array();
		global $default_sidebars;
		if($default_sidebars){
			foreach( $default_sidebars as $key => $_sidebar ){
				$of_sidebars[$_sidebar['id']] = $_sidebar['name'];
			}
		}

		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_one"		=> "Block One",
				"block_two"		=> "Block Two",
				"block_three"	=> "Block Three",
			), 
			"enabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_four"	=> "Block Four",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}
		
		//default value for logo and favor icon
		$df_logo_images_uri = get_template_directory_uri(). '/images/logo.png'; 
		$df_logo_coming_soon_images_uri = get_template_directory_uri(). '/images/logo-coming-soon.png'; 
		$df_icon_images_uri = get_template_directory_uri(). '/images/favicon.ico'; 
		
		$df_payment_images_1 = get_template_directory_uri(). '/images/media/payment_image_1.png';
		$df_payment_images_2 = get_template_directory_uri(). '/images/media/payment_image_2.png';
		$df_payment_images_3 = get_template_directory_uri(). '/images/media/payment_image_3.png';
		$df_payment_images_4 = get_template_directory_uri(). '/images/media/payment_image_4.png';
		$df_payment_images_5 = get_template_directory_uri(). '/images/media/payment_image_5.png'; 		
		
		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		            	natsort($bg_images); //Sorts the array into a natural order
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		$default_font_size = array(	
			"10px"
			,"11px"
			,"12px"
			,"13px"
			,"14px"
			,"15px"
			,"16px"
			,"17px"
			,"18px"
			,"19px"
			,"20px"
			,"21px"
			,"22px"
			,"23px"
			,"24px"
			,"25px"
			,"26px"
			,"27px"
			,"28px"
			,"29px"
			,"30px"		
			,"31px"
			,"32px"
			,"33px"
			,"34px"
			,"35px"
			,"36px"
			,"37px"
			,"38px"
			,"39px"	
			,"40px"	
			,"41px"
			,"42px"
			,"43px"
			,"44px"
			,"45px"
			,"46px"
			,"47px"
			,"48px"
			,"49px"	
			,"50px"		
		);
		
		$faces = array('arial'=>'Arial',
					'verdana'=>'Verdana, Geneva',
					'trebuchet'=>'Trebuchet',
					'georgia' =>'Georgia',
					'times'=>'Times New Roman',
					'tahoma, geneva'=>'Tahoma, Geneva',
					'palatino'=>'Palatino',
					'helvetica'=>'Helvetica' );
										
		$url =  ADMIN_DIR . 'assets/images/';	

		$default_font_size = array_combine($default_font_size, $default_font_size);
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 
		
		$df_logo2_images_uri = get_stylesheet_directory_uri(). '/images/logo_slider_template.png'; 
		$df_social_facebook_images_uri = get_stylesheet_directory_uri(). '/images/media/social_facebook.png'; 
		$df_social_pinterest_images_uri = get_stylesheet_directory_uri(). '/images/media/social_pinterest.png'; 
		$df_social_twitter_images_uri = get_stylesheet_directory_uri(). '/images/media/social_twitter.png';
		$df_social_google_images_uri = get_stylesheet_directory_uri(). '/images/media/social_google.png'; 		
		$df_social_rss_images_uri = get_stylesheet_directory_uri(). '/images/media/social_rss.png'; 		
		
		/* Shop banner */
		$df_prod_cat_banner = get_stylesheet_directory_uri(). '/images/prod_cat_banner.jpg'; 		
		
		//Get list menu
		$menus = wp_get_nav_menus();
		$arr_menu = array();
		if($menus) {
			foreach($menus as $menu) { 
				$arr_temp = array($menu->term_id => $menu->name);
				//array_push($arr_menu, $arr_temp);
				$arr_menu = array_merge($arr_menu, $arr_temp);
			}
		}

/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

/***************** TODO : GENERAL ****************/					


global $of_options,$wd_google_fonts;

$of_options = array();
					
$of_options[] = array( 	"name" 		=> "General Settings",
						"type" 		=> "heading"
				);						

$of_options[] = array( 	"name" 		=> "Logo image"
						,"desc" 	=> "Change your logo."
						,"id" 		=> "wd_logo"
						,"std"		=> $df_logo_images_uri
						,"type" 	=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Logo image on coming soon page"
						,"desc" 	=> "Change your logo."
						,"id" 		=> "wd_logo_coming_soon"
						,"std"		=> $df_logo_coming_soon_images_uri
						,"type" 	=> "upload"
				);

$of_options[] = array( 	"name" 		=> "Favor icon image"
						,"desc" 	=> "Accept ICO files"
						,"id" 		=> "wd_icon"
						,"std" 		=> $df_icon_images_uri
						,"type" 		=> "media"
				);
				
$of_options[] = array( 	"name" 		=> "Text Logo"
						,"desc" 	=> "Text Logo"
						,"id" 		=> "wd_text_logo"
						,"std" 		=> "Your logo"
						,"type" 	=> "text"
				);	

$of_options[] = array( 	"name" 		=> "Layout"
						,"desc" 	=> ""
						,"id" 		=> "wd_layout_styles"
						,"std" 		=> "Wide"
						,"type" 	=> "select"
						,"options"	=> array("wide","boxed")
				);					

$of_options[] = array( 	"name" 		=> "Enable Nice Scroll"
						,"desc" 	=> "Enable Nice Scroll Bar on the right browsers"
						,"id" 		=> "wd_nicescroll"
						,"std" 		=> 0
						,"type" 	=> "switch"
				);
				
$of_options[] = array( 	"name" 		=> "Enable To Top Button"
						,"desc" 	=> "Enable/Disable To top Button on site"
						,"id" 		=> "wd_totop"
						,"on"		=> "Enable"
						,"off"		=> "Disable"
						,"std" 		=> 1
						,"type" 	=> "switch"
				);	
				
$of_options[] = array( 	"name" 		=> "Catalog Mod"
						,"desc" 	=> "Enable/Disable all Add To Cart Buttons on site"
						,"id" 		=> "wd_catelog_mod"
						,"on"		=> "Enable"
						,"off"		=> "Disable"
						,"std" 		=> 0
						,"type" 	=> "switch"
				);							
			
/***************** TODO : Header ****************/					
				
$of_options[] = array( 	"name" 		=> "Header"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-slider.png"
				);	
				
$of_options[] = array( 	"name" 		=> "Header Layout"
						,"id" 		=> "wd_header_layout"
						,"std" 		=> "v1"
						,"type" 	=> "images"
						,"options" 	=> array(
							'v1' 	=> ADMIN_IMAGES . 'header/header_v1.jpg'
							,'v2' 	=> ADMIN_IMAGES . 'header/header_v2.jpg'
							,'v3' 	=> ADMIN_IMAGES . 'header/header_v3.jpg'
						)
				);

$of_options[] = array( 	"name" 		=> "Enable WooCommerce Header"
						,"desc" 	=> "Display WooCommerce Currency Convertor, WooCommerce Shopping Cart instead of Easycart"
						,"id" 		=> "wd_woo_header"
						,"on"		=> "Enable"
						,"off"		=> "Disable"
						,"std" 		=> 1
						,"type" 	=> "switch"
				);				
				
$of_options[] = array( 	"name" 		=> "Enable Sticky Menu"
						,"desc" 	=> "Using Sticky Menu on site"
						,"id" 		=> "wd_sticky_menu"
						,"on"		=> "Enable"
						,"off"		=> "Disable"
						,"std" 		=> 1
						,"type" 	=> "switch"
				);
				
if( class_exists('WooCommerce_Widget_Currency_Converter') ){				
$of_options[] = array( 	"name" 		=> "Currency Converter"
						,"desc" 	=> "Currency Codes(1 per line)"
						,"id" 		=> "wd_currency_codes"
						,"std" 		=> 'USD'.chr(10).'EUR'.chr(10).'JPY'
						,"type" 	=> "textarea"
				);	
}

$of_options[] = array( 	"name" 		=> "Bottom Header Content"
						,"desc" 	=> "You can use the shortcodes, html tags"
						,"id" 		=> "wd_bottom_header_content"
						,"std" 		=> '<div class="header-bottom-left"><a href="#"><i class="fa fa-phone-square"></i>do you have any question? <strong>call (01) 123 456 WooVoga</strong></a></div><div class="header-bottom-right"><a href="#" ><i class="fa fa-flag"></i>nearest stores location</a><a href="#" ><i class="fa fa-upload"></i>get this theme</a></div>'
						,"type" 	=> "textarea"
				);	

/***************** TODO : Footer ****************/					
$of_options[] = array( 	"name" 		=> "Footer"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-slider.png"
					);

$of_options[] = array( 	"name" 		=> "Copyright Section"
						,"desc" 	=> ""
						,"id" 		=> "introduction_custom_copyright"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Copyright Section</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);				
				
$of_options[] = array( 	"name" 		=> "Footer Copyright"
						,"desc" 	=> "You can use the following shortcodes in your footer text: [wp-link] [theme-link] [loginout-link] [blog-title] [blog-link] [the-year]"
						,"id" 		=> "footer_text"
						,"std" 		=> '&copy; 2014 woovoga wordpress theme. All Rights Reserved.'
						,"type" 	=> "textarea"
				);					
					
$of_options[] = array( 	"name" 		=> "Payment Image"
						,"desc" 	=> ""
						,"id" 		=> "payment_image"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Payment Image</h3>"
						,"icon" 	=> true
						,"type" 	=> "info"
				);
					
$of_options[] = array( 	"name" 		=> "Payment image 1"
						,"desc" 	=> "Change your image."
						,"id" 		=> "wd_payment_image_1"
						,"std"		=> $df_payment_images_1
						,"type" 	=> "upload"
				);	
				
$of_options[] = array( 	"name" 		=> "Payment image 2"
						,"desc" 	=> "Change your image."
						,"id" 		=> "wd_payment_image_2"
						,"std"		=> $df_payment_images_2
						,"type" 	=> "upload"
				);
				
$of_options[] = array( 	"name" 		=> "Payment image 3"
						,"desc" 	=> "Change your image."
						,"id" 		=> "wd_payment_image_3"
						,"std"		=> $df_payment_images_3
						,"type" 	=> "upload"
				);
				
$of_options[] = array( 	"name" 		=> "Payment image 4"
						,"desc" 	=> "Change your image."
						,"id" 		=> "wd_payment_image_4"
						,"std"		=> $df_payment_images_4
						,"type" 	=> "upload"
				);
				
$of_options[] = array( 	"name" 		=> "Payment image 5"
						,"desc" 	=> "Change your image."
						,"id" 		=> "wd_payment_image_5"
						,"std"		=> $df_payment_images_5
						,"type" 	=> "upload"
				);
						
/***************** TODO : STYLE ****************/					
/***************** DON'T ADD MORE ANY ELEMENTS HERE ****************/				
$of_options[] = array( 	"name" 		=> "Styling Options"
						,"type" 	=> "heading"
				);
global $xml_arr_file;			
$url =  ADMIN_DIR . 'assets/images/';
$color_image_options = array();
foreach($xml_arr_file as $xml){
	$color_image_options[$xml] = $url . $xml .'.jpg';
}
$of_options[] = array( 	"name" 		=> "Theme Scheme",
						"desc" 		=> "Select a color.",
						"id" 		=> "wd_color_scheme",
						"std" 		=> "color_default",
						"type" 		=> "images",
						"options" 	=> $color_image_options
				);
$xml_file = get_option(THEME_SLUG.'color_select');			
$xml_file = isset($xml_file) && strlen(trim($xml_file)) > 0 ? $xml_file : 'color_default';
$url_xml_file = THEME_DIR."/config_xml/".$xml_file.".xml";
if (file_exists($url_xml_file)) {
	$objXML_color = simplexml_load_file($url_xml_file);
	foreach ($objXML_color->children() as $child) {	//group
		$group_name = (string)$child->text;
		$of_options[] = array( 	"name" 		=> $group_name." Scheme"
				,"id" 		=> "introduction_".$group_name
				,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".$group_name." Scheme</h3>"
				,"icon" 	=> true
				,"type" 	=> "info"
		);	

		foreach ($child->items->children() as $childofchild) { //items => item
		
			$name =  (string)$childofchild->name;
			$slug =  (string)$childofchild->slug; 
			$std =  (string)$childofchild->std; 
			//$class_name =  (string)$childofchild->class_name;		
			
			if($childofchild->getName()=='background_item'){
				$of_options[] = array( 	"name" 		=> "Background Image"
						,"id" 		=> "wd_".$slug.'_image'
						,"type" 	=> "upload"
				);
				$of_options[] = array( 	"name" 		=> "Repeat Image"
						,"id" 		=> "wd_".$slug.'_repeat'
						,"std" 		=> "repeat"
						,"type" 	=> "select"
						,"options"	=> array("repeat","no-repeat","repeat-x","repeat-y")
				);
				$of_options[] = array( 	"name" 		=> "Position Image"
						,"id" 		=> "wd_".$slug.'_position'
						,"std" 		=> "left top"
						,"type" 	=> "select"
						,"options"	=> array("left top","right top","center top","center center")
				);
			}
			
			
			$of_options[] = array( 	"name" 		=> trim($name)
					,"id" 		=> "wd_".$slug
					,"std" 		=> $std
					,"type" 	=> "color"
			);
		}
	}	
}
/***************** TODO : TYPO ****************/		

$of_options[] = array( 	"name" 		=> "Typography"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-typography.gif"
				);
if (file_exists(THEME_DIR."/config_xml/font_config.xml")) {				
	$objXML = simplexml_load_file(THEME_DIR."/config_xml/font_config.xml");
	foreach ($objXML->children() as $child) {	//items
		$name =  $child->name;
		$slug =  $child->slug; 
		$type =  $child->type; 
		$std =  $child->std; 

		$default_family_font = 'arial';
		$default_google_font = 'Roboto';
		$std_slect = ($type == 'google_font') ? 0 : 1;
		if($type == 'family_font') { $default_family_font = in_array($std,$faces) ? strtolower($std) : 'arial';}
		if($type == 'google_font') { $default_google_font = in_array($std,$wd_google_fonts) ? $std : 'Roboto';}
		
		$of_options[] = array( 	"name" 		=> $name
				,"desc" 	=> ""
				,"id" 		=> "introduction_".$slug
				,"std" 		=> '<h3 style=\"margin: 0 0 10px;\">'.$name.' Options.</h3>'
				,"icon" 	=> true
				,"type" 	=> "info"
		);
		$of_options[] = array( 	"name" 		=> ""
				,"id" 		=> "wd_".$slug."_googlefont_enable"
				,"std" 		=> $std_slect
				,"folds"	=> 1
				,"on" 		=> "Family Font"
				,"off" 		=> "Google Font"
				,"type" 	=> "switchs"
		);
		$of_options[] = array( 	"name" 		=> ""//ucwords($name)." Family"
				,"id" 		=> "wd_".$slug."_family"
				,"position"	=> "left"
				,"fold"		=> "wd_".$slug."_googlefont_enable"
				,"std" 		=> trim($default_family_font)
				,"type" 	=> "select"
				,"options"	=> $faces
		);
		$of_options[] = array( 	"name" 		=> ""//ucwords($name)." Google"
				,"id" 		=> "wd_".$slug."_googlefont"
				,"position"	=> "right"
				,"std" 		=> trim($default_google_font)
				,"type" 	=> "select_google_font"
				,"fold"		=> "wd_".$slug."_googlefont_enable"
				,"preview" 	=> array(
								"text" => "This is my ".strtolower($name)." preview!"
								,"size" => "30px"
				)
				,"options" 	=> $wd_google_fonts
		);
	}		
}				
/***************** TODO : Forum ****************/		
if( class_exists('bbPress') ){
	$of_options[] = array( 	"name" 		=> "Forum"
							,"type" 	=> "heading"
							,"icon"		=> ADMIN_IMAGES . "slider-control.png"
					);
	$of_options[] = array( 	"name" 		=> "Forum Archive"
							,"desc" 	=> ""
							,"id" 		=> "introduction_forum_menufont"
							,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Forum Archive Options.</h3>"
							,"icon" 	=> true
							,"type" 	=> "info"
					);				
	$of_options[] = array( 	"name" 		=> "Forum Layout"
							,"desc" 	=> "Select main content and sidebar alignment. Choose between 1, 2 column layout."
							,"id" 		=> "wd_forum_layout"
							,"std" 		=> "0-1-0"
							,"type" 	=> "images"
							,"options" 	=> array(
								'0-1-0' 	=> $url . '1col.png'
								,'0-1-1' 	=> $url . '2cr.png'
								,'1-1-0' 	=> $url . '2cl.png'
								,'1-1-1' 	=> $url . '3cm.png'
							)
					);				
	$of_options[] = array( 	"name" 		=> "Forum Left Sidebar"
							,"id" 		=> "wd_forum_left_sidebar"
							,"std" 		=> "category-widget-area"
							,"type" 	=> "select"
							//,"mod"		=> "mini"
							,"options" 	=> $of_sidebars
					);
	$of_options[] = array( 	"name" 		=> "Forum Right Sidebar"
							,"id" 		=> "wd_forum_rigth_sidebar"
							,"std" 		=> "category-widget-area"
							,"type" 	=> "select"
							//,"mod"		=> "mini"
							,"options" 	=> $of_sidebars
					);
}  		
/***************** TODO : Mega Menu ****************/		

$of_options[] = array( 	"name" 		=> "Mega Menu"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "slider-control.png"
				);		

$of_options[] = array( 	"name" 		=> "Menu Thumbnail Size"
						,"desc" 	=> "Thumbnail width.<br /> Min: 5, max: 48, step: 1, default value: 20"
						,"id" 		=> "wd_menu_thumb_width"
						,"std" 		=> "20"
						,"min" 		=> "5"
						,"step"		=> "1"
						,"max" 		=> "48"
						,"type" 	=> "sliderui" 
				);
				
$of_options[] = array( 	"name" 		=> ""
						,"desc" 	=> "Thumbnail height.<br /> Min: 5, max: 48, step: 1, default value: 20"
						,"id" 		=> "wd_menu_thumb_height"
						,"std" 		=> "20"
						,"min" 		=> "5"
						,"step"		=> "1"
						,"max" 		=> "48"
						,"type" 	=> "sliderui" 
				);		

$of_options[] = array( 	"name" 		=> "Mega Menu Widget Area"
						,"desc" 	=> "Number Widget Area Available.<br /> Min: 1, max: 30, step: 1, default value: 5"
						,"id" 		=> "wd_menu_num_widget"
						,"std" 		=> "5"
						,"min" 		=> "1"
						,"step"		=> "1"
						,"max" 		=> "30"
						,"type" 	=> "sliderui" 
				);				

		
			
								
/***************** TODO : Product Category Options ****************/							
$of_options[] = array( 	"name" 		=> "Product Category"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-slider.png"
				);

$of_options[] = array( 	"name" 		=> "Top banner on the category page"
						,"desc" 	=> "Change your image"
						,"id" 		=> "wd_prod_cat_banner"
						,"std"		=> $df_prod_cat_banner
						,"type" 	=> "upload"
				);				

$of_options[] = array( 	"name" 		=> "Category Columns"
						,"id" 		=> "wd_prod_cat_column"
						,"std" 		=> "3"
						,"type" 	=> "select"
						,"mod"		=> "mini"
						,"options" 	=> array(3,4,5,6)
				);

$of_options[] = array( 	"name" 		=> "Number Of Products Per Page"
                        ,"desc" 	=> ""
                        ,"id" 		=> "wd_prod_cat_per_page"
                        ,"std" 		=> 16
                        ,"type" 	=> "text"
        );				

$of_options[] = array( 	"name" 		=> "Category Layout"
						,"desc" 	=> "Select main content and sidebar alignment. Choose between 1, 2 column layout."
						,"id" 		=> "wd_prod_cat_layout"
						,"std" 		=> "0-1-1"
						,"type" 	=> "images"
						,"options" 	=> array(
							'0-1-0' 	=> $url . '1col.png'
							,'0-1-1' 	=> $url . '2cr.png'
							,'1-1-0' 	=> $url . '2cl.png'
							,'1-1-1' 	=> $url . '3cm.png'
						)
				);								

$of_options[] = array( 	"name" 		=> "Left Sidebar"
						,"id" 		=> "wd_prod_cat_left_sidebar"
						,"std" 		=> "category-widget-area"
						,"type" 	=> "select"
						,"options" 	=> $of_sidebars
				);

$of_options[] = array( 	"name" 		=> "Right Sidebar"
						,"id" 		=> "wd_prod_cat_right_sidebar"
						,"std" 		=> "category-widget-area"
						,"type" 	=> "select"
						,"options" 	=> $of_sidebars
				);
				
$of_options[] = array( 	"name" 		=> "Product Discription on Grid Mode"
						,"desc" 	=> "Show/hide Discription on Grid Mode"
						,"id" 		=> "wd_prod_cat_disc_grid"
						,"std" 		=> 0
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
				
$of_options[] = array( 	"name" 		=> "Number of Words in Discription on Grid Mode"
						,"desc" 	=> "It is also used by product shortcode. Input -1 to show all"
						,"id" 		=> "wd_prod_cat_word_disc_grid"
						,"std" 		=> "8"
						,"type" 	=> "text"
					);
					
$of_options[] = array( 	"name" 		=> "Product Discription on List Mode"
						,"desc" 	=> "Show/hide Product Discription on List Mode"
						,"id" 		=> "wd_prod_cat_disc_list"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Number of Words in Discription on List Mode"
						,"desc" 	=> "Input -1 to show all"
						,"id" 		=> "wd_prod_cat_word_disc_list"
						,"std" 		=> "60"
						,"type" 	=> "text"
					);
					
$of_options[] = array( 	"name" 		=> "Product Label"
						,"desc" 	=> "Show/hide Product Label"
						,"id" 		=> "wd_prod_cat_label"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Product Rating"
						,"desc" 	=> "Show/hide Product Rating"
						,"id" 		=> "wd_prod_cat_rating"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Product Categories"
						,"desc" 	=> "Show/hide Product Categories"
						,"id" 		=> "wd_prod_cat_categories"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Product Title"
						,"desc" 	=> "Show/hide Product Title"
						,"id" 		=> "wd_prod_cat_title"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Product Sku"
						,"desc" 	=> "Show/hide Product Sku"
						,"id" 		=> "wd_prod_cat_sku"
						,"std" 		=> 0
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
				
$of_options[] = array( 	"name" 		=> "Product Price"
						,"desc" 	=> "Show/hide Product Price"
						,"id" 		=> "wd_prod_cat_price"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
				
$of_options[] = array( 	"name" 		=> "Product Add To Cart"
						,"desc" 	=> "Show/hide Product Add To Cart Button"
						,"id" 		=> "wd_prod_cat_add_to_cart"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
				
/***************** TODO : Product Details Options ****************/	
$of_options[] = array( 	"name" 		=> "Product Details"
						,"type" 		=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-slider.png"
				);		

$of_options[] = array( 	"name" 		=> "Product Image"
						,"desc" 	=> "Show/hide Product Image"
						,"id" 		=> "wd_prod_image"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Product Cloud-zoom"
						,"desc" 	=> "Show/hide Product Cloud-zoom"
						,"id" 		=> "wd_prod_cloudzoom"
						,"std" 		=> 1
						,"on" 		=> "Enable"
						,"off" 		=> "Disable"
						,"type" 	=> "switch"
				);	

$of_options[] = array( 	"name" 		=> "Product Label"
						,"desc" 	=> "Show/hide Product Label"
						,"id" 		=> "wd_prod_label"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
	

$of_options[] = array( 	"name" 		=> "Product Title"
						,"desc" 	=> "Show/hide Product Title"
						,"id" 		=> "wd_prod_title"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Product Sku"
						,"desc" 	=> "Show/hide Product Sku"
						,"id" 		=> "wd_prod_sku"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
							
$of_options[] = array( 	"name" 		=> "Product Rating & Review"
						,"desc" 	=> "Show/hide Product Rating & Review"
						,"id" 		=> "wd_prod_review"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
	

$of_options[] = array( 	"name" 		=> "Product Availability"
						,"desc" 	=> "Show/hide Product Availability"
						,"id" 		=> "wd_prod_availability"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
	

$of_options[] = array( 	"name" 		=> "Product Add To Cart Button"
						,"desc" 	=> "Show/hide Product AddToCart Button"
						,"id" 		=> "wd_prod_cart"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);


$of_options[] = array( 	"name" 		=> "Product Price"
						,"desc" 	=> "Show/hide Product Price"
						,"id" 		=> "wd_prod_price"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);


$of_options[] = array( 	"name" 		=> "Product Short Desc"
						,"desc" 	=> "Show/hide Product Short Desc"
						,"id" 		=> "wd_prod_shortdesc"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);



$of_options[] = array( 	"name" 		=> "Product Meta(Tags,Categories) "
						,"desc" 	=> "Show/hide Product Meta(Tags,Categories) "
						,"id" 		=> "wd_prod_meta"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"type" 	=> "switch"
				);
	

$of_options[] = array( 	"name" 		=> "Product Related Products"
						,"desc" 	=> "Show/hide Product Related Products"
						,"id" 		=> "wd_prod_related"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"
				);
	
$of_options[] = array( 	"name" 		=> "Related Product Title"
						,"id" 		=> "wd_prod_related_title"
						,"std" 		=> __('Related products','wpdance')
						,"fold" 	=> "wd_prod_related"
						,"type" 	=> "text"
				);			
	
$of_options[] = array( 	"name" 		=> "Product Upsell"
						,"desc" 	=> "Show/hide Product Upsell"
						,"id" 		=> "wd_prod_upsell"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"
				);			
$of_options[] = array( 	"name" 		=> "Upsell Product Title"
						,"id" 		=> "wd_prod_upsell_title"
						,"std" 		=> __('YOU MAY ALSO LIKE','wpdance')
						,"fold" 	=> "wd_prod_upsell"
						,"type" 	=> "text"
				);			
			
$of_options[] = array( 	"name" 		=> "Product Share"
						,"desc" 	=> "Show/hide Product Social Sharing"
						,"id" 		=> "wd_prod_share"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Product Share"
						,"id" 		=> "wd_prod_share_title"
						,"std" 		=> __('Share this','wpdance')
						,"fold" 	=> "wd_prod_share"
						,"type" 	=> "text"
				);	

$of_options[] = array( 	"name" 		=> "Ship & Return Box"
						,"desc" 	=> "Show/hide Ship & Return Box"
						,"id" 		=> "wd_prod_ship_return"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds" 	=> 1
						,"type" 	=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Show Ship & Return Box Title"
						,"id" 		=> "wd_prod_ship_return_title"
						,"std" 		=> "FREE SHIPPING & RETURN"
						,"fold" 	=> "wd_prod_ship_return"
						,"type" 	=> "text"
				);

$of_options[] = array( 	"name" 		=> "Show Ship & Return Box Content"
						,"id" 		=> "wd_prod_ship_return_content"
						,"std" 		=> '<a class="fa fa-truck" href="#"></a>
										Vivamus nec libero gravida, semper est sed. Integer et iaculis eros.'
						,"fold" 	=> "wd_prod_ship_return"
						,"type" 	=> "textarea"
				);

$of_options[] = array( 	"name" 		=> "Ads banner"
						,"desc" 	=> "Show/hide Banner Box Before Image"
						,"id" 		=> "wd_prod_detail_banner"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds" 	=> 1
						,"type" 	=> "switch"
				);
				
$of_options[] = array( 	"name" 		=> "Ads banner content"
						,"id" 		=> "wd_prod_detail_banner_content"
						,"std" 		=> '<a class="wd-effect-mirror" href="#" title="voga"><img title="voga" alt="voga" src="http://demo2.wpdance.com/imgs/WP_Woo_VoGa/pro_detail_banner.png" /></a>'
						,"fold" 	=> "wd_prod_detail_banner"
						,"type" 	=> "textarea"
				);				
								
$of_options[] = array( 	"name" 		=> "Product Tabs"
						,"desc" 	=> "Show/hide Product Tabs"
						,"id" 		=> "wd_prod_tabs"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"
				);	
	
$of_options[] = array( 	"name" 		=> "Product Custom Tab"
						,"desc" 	=> "Show/hide Product Custom Tab"
						,"id" 		=> "wd_prod_customtab"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"fold"		=> "wd_prod_tabs"
						,"type" 	=> "switch"
				);			
		
$of_options[] = array( 	"name" 		=> "Product Custom Tab Title"
						,"id" 		=> "wd_prod_customtab_title"
						,"std" 		=> "Custom Tab"
						,"fold" 	=> "wd_prod_customtab"
						,"type" 	=> "text"
				);

$of_options[] = array( 	"name" 		=> "Product Custom Tab Content"
						,"id" 		=> "wd_prod_customtab_content"
						,"std" 		=> "custom contents goes here"
						,"fold" 	=> "wd_prod_customtab"
						,"type" 	=> "textarea"
				);		

$of_options[] = array( 	"name" 		=> "Product Layout"
						,"desc" 	=> "Select main content and sidebar alignment. Choose between 1, 2 column layout."
						,"id" 		=> "wd_prod_layout"
						,"std" 		=> "0-1-0"
						,"type" 	=> "images"
						,"options" 	=> array(
							'0-1-0' 	=> $url . '1col.png'
							,'0-1-1' 	=> $url . '2cr.png'
							,'1-1-0' 	=> $url . '2cl.png'
							,'1-1-1' 	=> $url . '3cm.png'
						)
				);
$of_options[] = array( 	"name" 		=> "Left Sidebar"
						,"id" 		=> "wd_prod_left_sidebar"
						,"std" 		=> "category-widget-area"
						,"type" 	=> "select"
						//,"mod"		=> "mini"
						,"options" 	=> $of_sidebars
				);	
$of_options[] = array( 	"name" 		=> "Right Sidebar"
						,"id" 		=> "wd_prod_right_sidebar"
						,"std" 		=> "category-widget-area"
						,"type" 	=> "select"
						//,"mod"		=> "mini"
						,"options" 	=> $of_sidebars
				);				
/***************** TODO : Blog Options ****************/	
$of_options[] = array( 	"name" 		=> "Blog Options"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-slider.png"
				);

$of_options[] = array( 	"name" 		=> "Blog Layout"
						,"desc" 	=> "Select main content and sidebar alignment. Choose between 1, 2 column layout."
						,"id" 		=> "wd_blog_layout"
						,"std" 		=> "0-1-1"
						,"type" 	=> "images"
						,"options" 	=> array(
							'0-1-0' 	=> $url . '1col.png'
							,'0-1-1' 	=> $url . '2cr.png'
							,'1-1-0' 	=> $url . '2cl.png'
							,'1-1-1' 	=> $url . '3cm.png'
						)
				);
$of_options[] = array( 	"name" 		=> "Left Sidebar"
						,"id" 		=> "wd_blog_left_sidebar"
						,"std" 		=> "blog-widget-area"
						,"type" 	=> "select"
						,"options" 	=> $of_sidebars
				);	
$of_options[] = array( 	"name" 		=> "Right Sidebar"
						,"id" 		=> "wd_blog_right_sidebar"
						,"std" 		=> "blog-widget-area"
						,"type" 	=> "select"
						,"options" 	=> $of_sidebars
				);	
				
$of_options[] = array( 	"name" 		=> "Blog Categories"
						,"desc" 	=> "Show/hide Categories"
						,"id" 		=> "wd_blog_categories"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
				
$of_options[] = array( 	"name" 		=> "Blog Author"
						,"desc" 	=> "Show/hide Author"
						,"id" 		=> "wd_blog_author"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);	

$of_options[] = array( 	"name" 		=> "Blog View"
						,"desc" 	=> "Show/hide View"
						,"id" 		=> "wd_blog_views"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);					

$of_options[] = array( 	"name" 		=> "Blog Time"
						,"desc" 	=> "Show/hide Time"
						,"id" 		=> "wd_blog_time"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);	
$of_options[] = array( 	"name" 		=> "Blog Read more"
						,"desc" 	=> "Show/hide Tags"
						,"id" 		=> "wd_blog_readmore"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);	
	

				
$of_options[] = array( 	"name" 		=> "Blog Comment Number"
						,"desc" 	=> "Show/hide Comment Number"
						,"id" 		=> "wd_blog_comment_number"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
$of_options[] = array( 	"name" 		=> "Blog Excerpt"
						,"desc" 	=> "Show/hide Excerpt"
						,"id" 		=> "wd_blog_excerpt"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
$of_options[] = array( 	"name" 		=> "Blog Thumbnail"
						,"desc" 	=> "Show/hide Thumbnail"
						,"id" 		=> "wd_blog_thumbnail"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);									

/***************** TODO : Blog Details ****************/
	
$of_options[] = array( 	"name" 		=> "Blog Details"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-slider.png"
				);
$of_options[] = array( 	"name" 		=> "Blog Layout"
						,"desc" 	=> "Select main content and sidebar alignment. Choose between 1, 2 column layout."
						,"id" 		=> "wd_post_layout"
						,"std" 		=> "0-1-1"
						,"type" 	=> "images"
						,"options" 	=> array(
							'0-1-0' 	=> $url . '1col.png'
							,'0-1-1' 	=> $url . '2cr.png'
							,'1-1-0' 	=> $url . '2cl.png'
							,'1-1-1' 	=> $url . '3cm.png'
						)
				);
$of_options[] = array( 	"name" 		=> "Left Sidebar"
						,"id" 		=> "wd_post_left_sidebar"
						,"std" 		=> "blog-widget-area"
						,"type" 	=> "select"
						//,"mod"		=> "mini"
						,"options" 	=> $of_sidebars
				);	
$of_options[] = array( 	"name" 		=> "Right Sidebar"
						,"id" 		=> "wd_post_right_sidebar"
						,"std" 		=> "blog-widget-area"
						,"type" 	=> "select"
						//,"mod"		=> "mini"
						,"options" 	=> $of_sidebars
				);				
$of_options[] = array( 	"name" 		=> "Blog Categories"
						,"desc" 	=> "Show/hide Categories"
						,"id" 		=> "wd_blog_details_categories"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
				
$of_options[] = array( 	"name" 		=> "Blog Author"
						,"desc" 	=> "Show/hide Author"
						,"id" 		=> "wd_blog_details_author"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		

$of_options[] = array( 	"name" 		=> "Blog Time"
						,"desc" 	=> "Show/hide Time"
						,"id" 		=> "wd_blog_details_time"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
$of_options[] = array( 	"name" 		=> "Blog Tags"
						,"desc" 	=> "Show/hide Tags"
						,"id" 		=> "wd_blog_details_tags"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);
					
$of_options[] = array( 	"name" 		=> "Blog Thumbnail"
						,"desc" 	=> "Show/hide Thumbnail"
						,"id" 		=> "wd_blog_details_thumbnail"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
					
$of_options[] = array( 	"name" 		=> "Blog Comment"
						,"desc" 	=> "Show/hide Comment"
						,"id" 		=> "wd_blog_details_comment"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);
$of_options[] = array( 	"name" 		=> "Blog View"
						,"desc" 	=> "Show/hide View"
						,"id" 		=> "wd_blog_details_views"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);					
$of_options[] = array( 	"name" 		=> "Blog Social Sharing"
						,"desc" 	=> "Show/hide Social Sharing"
						,"id" 		=> "wd_blog_details_socialsharing"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
$of_options[] = array( 	"name" 		=> "Blog Author Box"
						,"desc" 	=> "Show/hide Author Box"
						,"id" 		=> "wd_blog_details_authorbox"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);		
$of_options[] = array( 	"name" 		=> "Blog Related Posts"
						,"desc" 	=> "Show/hide Related Posts"
						,"id" 		=> "wd_blog_details_related"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);			

$of_options[] = array( 	"name" 		=> "Blog Related Label"
						,"desc" 	=> "Related Label"
						,"id" 		=> "wd_blog_details_relatedlabel"
						,"std" 		=> __("Related Posts","wpdance")
						,"fold"		=> "wd_blog_details_related"
						,"type" 	=> "text"		
					);	
$of_options[] = array( 	"name" 		=> "Blog Related Number"
						,"desc" 	=> "Related Number"
						,"id" 		=> "wd_blog_details_relatednumber"
						,"std" 		=> "6"
						,"mod"		=> "mini"
						,"fold"		=> "wd_blog_details_related"
						,"type" 	=> "select"	
						,"options"	=> array(4,5,6,7,8,9,10)
					);					
$of_options[] = array( 	"name" 		=> "Blog Comment List"
						,"desc" 	=> "Show/hide Comment List"
						,"id" 		=> "wd_blog_details_commentlist"
						,"std" 		=> 1
						,"on" 		=> "Show"
						,"off" 		=> "Hide"
						,"folds"	=> 1
						,"type" 	=> "switch"		
					);						
				
$of_options[] = array( 	"name" 		=> "Blog Comment List Label"
						,"desc" 	=> "Comment List Label"
						,"id" 		=> "wd_blog_details_commentlabel"
						,"std" 		=> __("Comment(s)","wpdance")
						,"fold"		=> "wd_blog_details_commentlist"
						,"type" 	=> "text"		
					);	

/***************** TODO : Custom CSS ****************/
$of_options[] = array( 	"name" 		=> "Custom JS/CSS"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-slider.png"
				);
$of_options[] = array( 	"name" 		=> "CSS Code",
						"desc" 		=> "Quickly add some CSS to your theme by adding it to this block.",
						"id" 		=> "wd_custom_css",
						"std" 		=> "",
						"type" 		=> "textarea"
				);

$of_options[] = array( 	"name" 		=> "Javascript Code",
						"desc" 		=> "Quickly add some Javascripts to your theme by adding it to this block.",
						"id" 		=> "wd_custom_js",
						"std" 		=> "",
						"type" 		=> "textarea"
				);					
/***************** TODO : Backup Options ****************/

$of_options[] = array( 	"name" 		=> "Backup Options"
						,"type" 	=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-backup.png"
				);
				
$of_options[] = array( 	"name" 		=> "Backup and Restore Options"
						,"id" 		=> "of_backup"
						,"std" 		=> ""
						,"type" 	=> "backup"
						,"desc" 	=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.'
				);
				
$of_options[] = array( 	"name" 		=> "Transfer Theme Options Data"
						,"id" 		=> "of_transfer"
						,"std" 		=> ""
						,"type" 	=> "transfer"
						,"desc" 	=> 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".'
				);
				
/***************** TODO : Documentation ****************/				
				
$of_options[] = array( 	"name" 		=> "Documentation"
						,"type" 		=> "heading"
						,"icon"		=> ADMIN_IMAGES . "icon-docs.png"
				);
				
$of_options[] = array( 	"name" 		=> "Docs #1"
						,"desc" 		=> ""
						,"id" 		=> "introduction"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Welcome to the Options Framework demo.</h3>
							This is a slightly modified version of the original options framework by Devin Price with a couple of aesthetical improvements on the interface and some cool additional features. If you want to learn how to setup these options or just need general help on using it feel free to visit my blog at <a href=\"http://aquagraphite.com/2011/09/29/slightly-modded-options-framework/\">AquaGraphite.com</a>"
						,"icon" 		=> true
						,"type" 		=> "info"
				);	

$of_options[] = array( 	"name" 		=> "Docs #2"
						,"desc" 		=> ""
						,"id" 		=> "introduction"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Welcome to the Options Framework demo.</h3>
							This is a slightly modified version of the original options framework by Devin Price with a couple of aesthetical improvements on the interface and some cool additional features. If you want to learn how to setup these options or just need general help on using it feel free to visit my blog at <a href=\"http://aquagraphite.com/2011/09/29/slightly-modded-options-framework/\">AquaGraphite.com</a>"
						,"icon" 		=> true
						,"type" 		=> "info"
				);	


$of_options[] = array( 	"name" 		=> "Docs #3"
						,"desc" 		=> ""
						,"id" 		=> "introduction"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Welcome to the Options Framework demo.</h3>
							This is a slightly modified version of the original options framework by Devin Price with a couple of aesthetical improvements on the interface and some cool additional features. If you want to learn how to setup these options or just need general help on using it feel free to visit my blog at <a href=\"http://aquagraphite.com/2011/09/29/slightly-modded-options-framework/\">AquaGraphite.com</a>"
						,"icon" 		=> true
						,"type" 		=> "info"
				);	

$of_options[] = array( 	"name" 		=> "Docs #4"
						,"desc" 		=> ""
						,"id" 		=> "introduction"
						,"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Welcome to the Options Framework demo.</h3>
							This is a slightly modified version of the original options framework by Devin Price with a couple of aesthetical improvements on the interface and some cool additional features. If you want to learn how to setup these options or just need general help on using it feel free to visit my blog at <a href=\"http://aquagraphite.com/2011/09/29/slightly-modded-options-framework/\">AquaGraphite.com</a>"
						,"icon" 		=> true
						,"type" 		=> "info"
				);			
				
/* Import demo content */					
$of_options[] = array( 	"name" 		=> "Import Demo",
						"type" 		=> "heading"
				);	
				
$of_options[] = array( "name" 	=> "",
					"desc" 		=> "Please make sure you already installed and activated Visual Composer, Revolution Slider and WooCommerce plugins.<br/>It can also take a minute to complete. <strong>Please don't close your browser when importing</strong>",
					"id" 		=> "wd_import_button",
					"std" 		=> 'Click To Import',
					"type" 		=> "button"
				);	

$of_options[] = array( 	"name" 		=> "Import Pages - Posts - Menu"
						,"desc" 	=> ""
						,"id" 		=> "wd_import_pages_posts"
						,"std"		=> "yes"
						,"options"	=> array(
									'yes'	=> 'Yes'
									,'no'	=> 'No'
									)
						,"type" 	=> "select"
				);
				
$of_options[] = array( 	"name" 		=> "Import Revolution Slider"
						,"desc" 	=> ""
						,"id" 		=> "wd_import_revsliders"
						,"std"		=> "yes"
						,"options"	=> array(
									'yes'	=> 'Yes'
									,'no'	=> 'No'
									)
						,"type" 	=> "select"
				);
				
$of_options[] = array( 	"name" 		=> "Import Widget Content"
						,"desc" 	=> ""
						,"id" 		=> "wd_import_widgets"
						,"std"		=> "override"
						,"options"	=> array(
									'override'	=> 'Override'
									,'append'	=> 'Append'
									,'no'		=> 'No'
									)
						,"type" 	=> "select"
				);
				
	}//End function: of_options()
}//End chack if function exists: of_options()

function get_google_font(){
	//$url = "https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha";
	$url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAP4SsyBZEIrh0kc_cO9s90__r2oCJ8Rds&sort=alpha";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_REFERER, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($ch);
	curl_close($ch);
	return ($result);
}
?>
