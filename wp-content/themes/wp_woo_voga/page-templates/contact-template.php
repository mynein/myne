<?php
/*
*	Template Name: Contact Template
*/
get_header(); ?>
	<div class="top-page">
		<div class="wd_map"><?php echo do_shortcode(get_post_meta( get_the_ID(), 'google_map', true )); ?></div>
		<?php if( isset($page_datas['hide_breadcrumb']) && absint($page_datas['hide_breadcrumb']) == 0 ) dimox_breadcrumbs(); ?>
	</div>		
	<div id="wd-container" class="content-wrapper page-template container">
		<?php if( (!is_home() && !is_front_page()) && absint($page_datas['hide_title']) == 0 ):?>
			<div class="heading-title page-title">
				<h1 class="heading-title page-title"><?php the_title();?></h1>
			</div>
		<?php endif;?>
		<div id="content-inner" class="row" >
				<div id="main-content" class="col-sm-24">
					<div class="main-content">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="entry-content-post">
								<?php the_content(); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'wpdance' ), 'after' => '</div>' ) ); ?>
							</div>
						</article><!-- #post -->					
					</div>
				</div><!-- end content -->
		</div><!-- #content -->
	</div><!-- #container -->
<?php get_footer(); ?>