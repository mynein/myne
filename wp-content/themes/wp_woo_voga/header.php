<!DOCTYPE html>
<!--[if !(IE 7) | !(IE 8) ]><!-->
<?php 
global $is_IE;
$ie_id ='';
if($is_IE){
	$ie_id='id="wd_ie"';
}
?>
<html <?php echo esc_html($ie_id); ?> <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title> <?php wp_title( '|', true, 'right' ); ?> </title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php theme_icon();?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php 
		if ( is_singular() && get_option( 'thread_comments' ) ){
			wp_enqueue_script( 'comment-reply' );
		}
		wp_head(); 
	?>
</head>

<?php
	global $is_iphone,$wd_data,$page_datas;	
	$wd_layout_style = '';
	if($wd_data['wd_layout_style'] != '' && $wd_data['wd_layout_style'] == 'boxed'){
		$wd_layout_style = ' wd-'.$wd_data['wd_layout_style'];
	}
	
	$header_layout = 'v1';
	if( isset($wd_data['wd_header_layout']) ){
		$header_layout = $wd_data['wd_header_layout'];
	}
?>
<body <?php body_class($wd_layout_style); ?>>
<div id="template-wrapper" class="hfeed site <?php echo esc_attr($wd_layout_style); ?>">
	<?php if ( !is_page_template('page-templates/comming-soon.php') ) :?>
		<header id="header" class="header-<?php echo esc_attr($header_layout); ?>">
			<div class="header-main">
				<?php do_action( 'wd_header_init' ); ?>
			</div>
		</header><!-- #masthead -->
	<?php endif; ?>
	<?php do_action( 'wd_before_main_container' ); ?>
	<div id="main-module-container" class="site-main">
