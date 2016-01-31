<?php
global $xml_arr_file;
$xml_arr_file = array('color_default','color_red','color_blue','color_pink','color_deeppink','color_gray','color_green','color_deepblue','color_darkblue','color_brightred');

function wd_get_tab_html_content(){
	global $wd_of_options,$xml_arr_file;
	
	$nonce=$_POST['security'];
	
	if (! wp_verify_nonce($nonce, 'of_ajax_nonce') ) die('-1'); 
	
	$wd_of_options = array();
	
	$xml_file = $_POST['file'];
	
	$url =  ADMIN_DIR . 'assets/images/';
	$color_image_options = array();
	foreach($xml_arr_file as $xml){
		$color_image_options[$xml] = $url . $xml .'.jpg';
	}
	$wd_of_options[] = array( 	"name" 		=> "Theme Scheme",
							"desc" 		=> "Select a color.",
							"id" 		=> "wd_color_scheme",
							"std" 		=> $xml_file,
							"type" 		=> "images",
							"update"	=> "1",
							"options" 	=> $color_image_options
					);				
				
	
	$url_xml_file = THEME_DIR."/config_xml/".$xml_file.".xml";
	if (file_exists($url_xml_file)) {
		$objXML_color = simplexml_load_file($url_xml_file);
		foreach ($objXML_color->children() as $child) {	//group
			$group_name = (string)$child->text;
			$wd_of_options[] = array( 	"name" 		=> $group_name." Scheme"
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
					$wd_of_options[] = array( 	"name" 		=> "Background Image"
							,"id" 		=> "wd_".$slug.'_image'
							,"type" 	=> "upload"
					);
					$wd_of_options[] = array( 	"name" 		=> "Repeat Image"
							,"id" 		=> "wd_".$slug.'_repeat'
							,"std" 		=> "repeat"
							,"type" 	=> "select"
							,"options"	=> array("repeat","no-repeat","repeat-x","repeat-y")
					);
					$wd_of_options[] = array( 	"name" 		=> "Position Image"
							,"id" 		=> "wd_".$slug.'_position'
							,"std" 		=> "left top"
							,"type" 	=> "select"
							,"options"	=> array("left top","right top","center top","center center")
					);
				}
				
				
				$wd_of_options[] = array( 	"name" 		=> trim($name)
						,"id" 		=> "wd_".$slug
						,"std" 		=> $std
						,"type" 	=> "color-update"
				);
			}
		}	
	}	
	$rs_arr = array();
	$wd_options_machine = new Options_Machine($wd_of_options);
	$rs_arr = $wd_options_machine->Inputs;
	echo json_encode( $rs_arr );
	die(1);
}
add_action('wp_ajax_tab_refesh','wd_get_tab_html_content',10);

