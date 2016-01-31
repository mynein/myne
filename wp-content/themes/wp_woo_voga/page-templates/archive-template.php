<?php
/*
*	Template Name: Archive Template
*/
get_header(); ?>

<?php global $page_datas;?>
		<div class="slideshow-wrapper main-slideshow <?php echo strcmp($page_datas['page_layout'],'wide') == 0 ? "wide" : "container"; ?>">
			<div class="slideshow-sub-wrapper <?php echo strcmp($page_datas['page_layout'],'wide') == 0 ? "wide-wrapper" : "col-sm-24"; ?>">
				<?php show_page_slider(); ?>
			</div>
		</div>
		<div class="top-page">
			<?php if( isset($page_datas['hide_breadcrumb']) && absint($page_datas['hide_breadcrumb']) == 0 ) dimox_breadcrumbs(); ?>
		</div>
		<div id="wd-container" class="content-wrapper page-template container">
			<?php if( (!is_home() && !is_front_page()) && absint($page_datas['hide_title']) == 0 ):?>
				<h1 class="heading-title page-title archive-title"><?php the_title();?></h1>
			<?php endif;?>
			<div id="content-inner" class="row" role="main">
				<div class="col-main" id="main-content">
					<div class="sitemap-content entry-content">
						<div class="main-content" id="main">
							<div class="archive-content entry-content">		
								<div class='col-sm-24'>
									<?php the_content();?>
								</div>				
									<div class="col-sm-12">
										<h5 class="heading-title"><?php _e('The Latest 30 Posts', 'wpdance'); ?></h5>
										<ul class="sitemap-archive">
											<?php $recent_posts = new WP_Query( array('posts_per_page'=>30) ); ?>
											<?php while ( $recent_posts->have_posts() ) { $recent_posts->the_post(); ?>
												<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><span class="comment"><i class="fa fa-comments"></i> <?php echo esc_html($post->comment_count); ?> <?php _e( 'comments', 'wpdance' ); ?></span><span class="time">(<?php the_time('d/m/y'); ?>)</span></li>
											<?php } wp_reset_postdata(); ?>            
										</ul><!-- Latest Posts -->
									</div>
									
									<div class="col-sm-6">
										<h5 class="heading-title"><?php _e('Categories', 'wpdance'); ?></h5>
										<ul class='sitemap-archive'>
											<?php wp_list_categories('title_li=&show_count=true'); ?>
										</ul>
									</div><!-- Categories -->
									
									<div class="col-sm-6">
										<h5 class="heading-title"><?php _e('Monthly Archives', 'wpdance'); ?></h5>
										<ul class='sitemap-archive'>
											<?php wp_get_archives('type=monthly&show_post_count=true'); ?>
										</ul>
									</div><!-- Monthly Archives -->	
							</div>
						</div>
					</div>
				</div>
			</div><!-- #content -->
		</div><!-- #container -->


<?php get_footer(); ?>
