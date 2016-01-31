<?php
/*
*	Template Name: Fullwidth Template
*/

get_header();
global $page_datas;
?>

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

<div id="wd-container" class="content-wrapper page-template fullwidth-template container">
	<?php if( (!is_home() && !is_front_page()) && absint($page_datas['hide_title']) == 0 ): ?>
		<h1 class="heading-title page-title"><?php the_title();?></h1>
	<?php endif;?>
	<div id="content-inner">	
		<div id="main-content">
			<?php
				// Start the Loop.
				if( have_posts() ) : the_post();
					get_template_part( 'content', 'page' );	
				endif;
			?>
		</div><!-- end content -->
	</div><!-- end container -->
</div><!-- #main-content -->

<?php
get_footer();

