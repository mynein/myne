<?php get_header(); ?>

<div id="wd-container" class="page-template blog-template container">

	<div id="content-inner" class="row">
		<div id="main-content">

		<?php
			if ( have_posts() ) :
				// Start the Loop.
				/*
				 * Include the post format-specific template for the content. If you want to
				 * use this in a child theme, then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				echo '<ul class="list-posts">';
				
				while( have_posts() ){
					the_post();
					get_template_part( 'content', get_post_format() );
				}
				
				echo '</ul>';
			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );

			endif;
		?>
		
			<div class="page_navi">
				<div class="nav-content"><div class="wp-pagenavi"><?php ew_pagination(); ?></div></div>
			</div>

		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_footer();
