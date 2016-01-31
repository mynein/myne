<?php
/**
 *	Template Name: Comming Soon
 */	
 
get_header();
?>
<div id="wd-container" class="blank-template content-wrapper container">
	<div id="content-inner" class="row">	
		<div id="main-content" class="col-sm-24">
			<div class="entry-content">	
				<?php theme_logo_coming();?>
				<?php
					// Start the Loop.
					if( have_posts() ) : the_post();
						get_template_part( 'content', 'page' );	
					endif;
				?>
				<div class="blank_copyright">
				<?php 
					global $wd_data; 
					echo stripslashes($wd_data['footer_text']);
				?>
				</div>
			</div>
		</div>
	</div>	
</div><!-- #container -->
<?php get_footer(); ?>