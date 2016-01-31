<?php get_header(); ?>
<?php
if(isset($page_datas['page_slider']) && $page_datas['page_slider'] != 'none'):
?>
<div class="slideshow-wrapper main-slideshow">
	<div class="slideshow-sub-wrapper">
		<?php
			global $page_datas,$post;
			show_page_slider();		
		?>
	</div>
</div>
<?php
endif;
?>

<?php if( isset($page_datas['hide_breadcrumb']) && absint($page_datas['hide_breadcrumb']) == 0 ) :?>
	<div class="top-page">
		<?php dimox_breadcrumbs(); ?>
	</div>
<?php endif;?>
<?php
	global $page_datas;
	//show_page_slider();
	$_layout_config = explode("-",$page_datas['page_column']);
	$_left_sidebar = (int)$_layout_config[0];
	$_right_sidebar = (int)$_layout_config[2];
	$_main_class = ( $_left_sidebar + $_right_sidebar ) == 2 ? "col-sm-12" : ( ( $_left_sidebar + $_right_sidebar ) == 1 ? "col-sm-18" : "col-sm-24" );		
?>

<div id="wd-container" class="content-wrapper page-template container">
	<?php if( (!is_home() && !is_front_page()) && absint($page_datas['hide_title']) == 0 ):?>
		<h1 class="heading-title page-title"><?php the_title();?></h1>
	<?php endif;?>
	<div id="content-inner" class="row">
		<!-- Top Content Widget Area -->
		<?php if( $page_datas['hide_top_content_widget_area'] == 0 && is_active_sidebar('top-content-widget-area') ): ?>
			<div class="top-content-widget">
				<ul>
					<?php dynamic_sidebar( 'top-content-widget-area' ); ?>
				</ul>
			</div>
		<?php endif; ?>
	
		<?php if( $_left_sidebar ): ?>
			<div id="left-content" class="col-sm-6">
				<div class="sidebar-content">
					<?php
						if ( is_active_sidebar( $page_datas['left_sidebar'] ) ) : ?>
							<ul class="xoxo">
								<?php dynamic_sidebar( $page_datas['left_sidebar'] ); ?>
							</ul>
					<?php endif; ?>
				</div>
			</div><!-- end left sidebar -->		
		<?php endif;?>	
		<div id="main-content" class="<?php echo esc_attr($_main_class); ?>">
			<?php
				$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
				if( in_array( "woocommerce/woocommerce.php", $_actived ) ){
					wc_print_notices();
				}
				// Start the Loop.
				if( have_posts() ) : the_post();
					get_template_part( 'content', 'page' );	
				endif;
				
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>
		</div><!-- end content -->
		<?php if( $_right_sidebar ): ?>
			<div id="right-content" class="col-sm-6">
				<div class="sidebar-content">
				<?php
					if ( is_active_sidebar( $page_datas['right_sidebar'] ) ) : ?>
						<ul class="xoxo">
							<?php dynamic_sidebar( $page_datas['right_sidebar'] ); ?>
						</ul>
				<?php endif; ?>
				</div>
			</div><!-- end right sidebar -->
		<?php endif;?>
	</div><!-- end container -->
</div><!-- #main-content -->

<?php
get_footer();
