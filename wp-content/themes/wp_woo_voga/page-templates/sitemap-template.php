<?php
/*
*	Template Name: Sitemap Template
*/
get_header(); ?>

<?php global $page_datas;?>
<?php if( isset($page_datas['hide_breadcrumb']) && absint($page_datas['hide_breadcrumb']) == 0 ) :?>
	<div class="top-page">
		<?php dimox_breadcrumbs(); ?>
	</div>
<?php endif;?>
		<div id="wd-container" class="content-wrapper page-template container">
			<?php if( (!is_home() && !is_front_page()) && absint($page_datas['hide_title']) == 0 ):?>
				<h1 class="heading-title page-title sitemap-title"><?php the_title();?></h1>
			<?php endif;?>
			<div id="content-inner" class="row" role="main">
				<div class="col-main" id="main-content">
					<div class="sitemap-content entry-content">
						<div class="col-sm-24">
							<?php the_content();?>
						</div>
						<!--Page-->
						<div class="col-sm-6">  
							<h5 class="heading-title"><?php _e( 'Pages', 'wpdance' ); ?></h5>
							<ul class='sitemap-archive'>
								<?php wp_list_pages( 'depth=0&sort_column=menu_order&title_li=' ); ?>
							</ul>
						</div>
		
						<!--Categories-->
						<div class="col-sm-6">
							<h5 class="heading-title"><?php _e('Categories', 'wpdance'); ?></h5>
							<ul class='sitemap-archive'>
								<?php wp_list_categories('title_li=&show_count=true'); ?>
							</ul>
						</div>
						
						<!--Posts per category-->
						<div class="col-sm-12">
							<h5 class="heading-title"><?php _e( 'Posts per category', 'wpdance' ); ?></h5>
							<div class="list-posts">
							<?php
					
								$cats = get_categories();
								foreach ( $cats as $cat ) {
									$post_cat = new WP_Query( 'cat=' . $cat->cat_ID );
							?>
							<h4 class="cat-title"><?php echo esc_html($cat->cat_name); ?></h4>
							<ul class='sitemap-archive'>
								<?php while ( $post_cat->have_posts() ) { $post_cat->the_post(); ?>
								 <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <span class="comment"><i class="fa fa-comments"></i> <?php echo esc_html($post->comment_count); ?> <?php _e( 'comments', 'wpdance' ); ?></span></li>
								 <?php } wp_reset_postdata(); ?>
							</ul>
							<?php } ?>
							</div>
						</div>			
					</div>
				</div>
			</div><!-- #content -->
		</div><!-- #container -->
<?php get_footer(); ?>