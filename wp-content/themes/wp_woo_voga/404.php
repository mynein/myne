<?php get_header(); ?>
		<div class="top-page">
			<?php dimox_breadcrumbs();?>
		</div>	
		<div id="wd-container" class="content-wrapper container-404 container">
			<h1 class="heading-title page-title"><?php _e( 'Page not found', 'wpdance'); ?></h1>
			<div id="content-inner" class="row">		
				<div id="main-content" class="col-sm-24">
					<div class="entry-content">
						<div class="">
							<div class="alert_404 bold">
								<?php _e('You may have stumbled here by accident or the post you are looking for is no longer here.', 'wpdance');?><br/>
								<?php _e('Please try one of the following:', 'wpdance' ); ?>
								<ul class="bold">
									<li><?php _e('Hit the "Back" button on your browser.','wpdance')?></li>
									<li><?php _e('Return to the Usability.','wpdance')?></li>
									<li><?php _e('Use the navigation menu at the top of the page','wpdance')?></li>
								</ul>
							</div>
							<div class="search-404">
								<h4><?php _e('Or try to search something else', 'wpdance'); ?></h4>
								<?php get_search_form(); ?>
							</div>
						</div>
					</div>
				</div>
			</div><!-- #content -->
		</div><!-- #container -->
<?php get_footer(); ?>
