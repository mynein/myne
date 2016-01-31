<?php get_header(); ?>
<?php	
global $wd_data;
$_layout_config = explode("-",$wd_data['wd_forum_layout']);
$_left_sidebar = (int)$_layout_config[0];
$_right_sidebar = (int)$_layout_config[2];
$_main_class = ( $_left_sidebar + $_right_sidebar ) == 2 ? "col-sm-12" : ( ( $_left_sidebar + $_right_sidebar ) == 1 ? "col-sm-18" : "col-sm-24" );		
?>
<div class="top-page">
<?php wd_bbp_breadcrumb(); ?>
</div>
<div id="wd-container" class="forum-template content-wrapper container">	
	<div id="content-inner" class="row">
	<?php if( $_left_sidebar == 1 ): ?>
		<div id="left-content" class="col-sm-6">
			<div class="sidebar-content">
				<?php
					if ( is_active_sidebar( $wd_data['wd_forum_left_sidebar'] ) ) : ?>
						<ul class="xoxo">
							<?php dynamic_sidebar( $wd_data['wd_forum_left_sidebar'] ); ?>
						</ul>
				<?php endif; ?>
			</div>
		</div><!-- end left sidebar -->		
	<?php endif;?>	
		<div id="main-content" class="<?php echo esc_attr($_main_class); ?>">					
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content-post">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="forum-links">' . __( 'Forums:', 'wpdance' ), 'after' => '</div>' ) ); ?>
				</div><!-- .entry-content -->
			</div><!-- #post -->					
		</div><!-- end content -->
		
	<?php if( $_right_sidebar == 1): ?>
		<div id="right-content" class="col-sm-6">
			<div class="sidebar-content">
			<?php
				if ( is_active_sidebar( $wd_data['wd_forum_rigth_sidebar']) ) : ?>
					<ul class="xoxo">
						<?php dynamic_sidebar( $wd_data['wd_forum_rigth_sidebar'] ); ?>
					</ul>
			<?php endif; ?>
			</div>
		</div><!-- end right sidebar -->
	<?php endif;?>	
		
	</div>	
</div><!-- #container -->
<?php get_footer(); ?>