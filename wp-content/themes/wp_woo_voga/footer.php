		<?php do_action( 'wd_before_body_end' ); ?>
		</div><!-- #main -->
		<?php if ( !is_page_template('page-templates/comming-soon.php') ) :?>
			<footer id="footer" role="contentinfo">

				<div class="footer-container">
				
					<?php do_action( 'wd_footer_init' ); ?>
					
				</div>
				
			</footer><!-- #colophon -->
		<?php endif; ?>
		<?php do_action( 'wd_before_footer_end' ); ?>
		
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>