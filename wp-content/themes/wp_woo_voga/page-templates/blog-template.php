<?php
/**
 *	Template Name: Blog Template
 */	
get_header(); ?>

	<?php
		global $page_datas, $wd_data;
		$_layout_config = explode("-",$wd_data['wd_blog_layout']);
		$_left_sidebar = (int)$_layout_config[0];
		$_right_sidebar = (int)$_layout_config[2];
		$_main_class = ( $_left_sidebar + $_right_sidebar ) == 2 ? "col-sm-12" : ( ( $_left_sidebar + $_right_sidebar ) == 1 ? "col-sm-18" : "col-sm-24" );		
		$_left_sidebar_name = $wd_data['wd_blog_left_sidebar'];
		$_right_sidebar_name = $wd_data['wd_blog_right_sidebar'];
	?>
	<?php if( !is_home() && !is_front_page() ):?>
	<div class="top-page">
		<?php if( isset($page_datas['hide_breadcrumb']) && absint($page_datas['hide_breadcrumb']) == 0 ) dimox_breadcrumbs(); ?>
	</div>	
	<?php endif;?>	
	<div id="wd-container" class="page-template blog-template container">
		<?php if( (!is_home() && !is_front_page()) && absint($page_datas['hide_title']) == 0 ):?>
			<h1 class="heading-title page-title blog-title"><?php the_title();?></h1>
		<?php endif;?>
		
		<div id="content-inner" class="row">
			<?php if( $_left_sidebar ): ?>
					<div id="left-content" class="col-sm-6">
						<div class="sidebar-content">
							<?php
								if ( is_active_sidebar( $_left_sidebar_name ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( $_left_sidebar_name ); ?>
									</ul>
							<?php endif; ?>
						</div>
					</div>
			<?php endif;?>					
			
			<div id="main-content" class="<?php echo esc_attr($_main_class); ?>">
				<div class="main-content">				
					<div class="page-content">
						<div class="content-inner"><?php the_content();?></div>
					</div>
					
					<?php	
					$posts = new WP_Query(array('post_type'=> 'post', 'paged' => get_query_var('page')));
					if( $posts->have_posts() ):
						echo '<ul class="list-posts">';
						while( $posts->have_posts() ):
							$posts->the_post();
							get_template_part( 'content', get_post_format() );
						endwhile;
						echo '</ul>';
						?>
						<div class="page_navi">
							<div class="nav-content"><div class="wp-pagenavi"><?php ew_pagination(3, $posts);?></div></div>
						</div>
						<?php
						wp_reset_postdata(); 
					endif;
					?>
				</div>
			</div>
			
			
			<?php if( $_right_sidebar ): ?>
				<div id="right-content" class="col-sm-6">
					<div class="sidebar-content">
					<?php
						if ( is_active_sidebar( $_right_sidebar_name ) ) : ?>
							<ul class="xoxo">
								<?php dynamic_sidebar( $_right_sidebar_name ); ?>
							</ul>
					<?php endif; ?>
					</div>
				</div>
			<?php endif;?>		
	
		</div>
	</div>
<?php get_footer(); ?>