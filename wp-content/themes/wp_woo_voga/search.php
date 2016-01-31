<?php
get_header(); ?>

	<section id="wd-container" class="content-wrapper page-template container">
		<div id="content-inner" class="row">
			<div id="main-content" class="site-content col-sm-24" role="main">

				<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'wpdance' ), get_search_query() ); ?></h1>
				</header><!-- .page-header -->
					<ul class="list-posts">
					<?php
						while ( have_posts() ) : the_post();

							/*
							 * Include the post format-specific template for the content. If you want to
							 * use this in a child theme, then include a file called called content-___.php
							 * (where ___ is the post format) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );

						endwhile;
					?>
					</ul>
					<div class="page_navi">
						<div class="nav-content"><div class="wp-pagenavi"><?php ew_pagination();?></div></div>
					</div>
					<?php

					else :
						// If no content, include the "No posts found" template.
						get_template_part( 'content', 'none' );

					endif;
				?>

			</div><!-- #content -->
		</div>
	</section><!-- #primary -->

<?php
get_footer();
