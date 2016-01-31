<?php global $product; ?>
<li>
	<a class="product-thumbnail" href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		<?php echo $product->get_image(); ?>
	</a>
	<div class="product-meta">
	<?php echo $product->get_categories( ', ', '<div class="wd-categories">', '</div>' ); ?>
	<a class="link-wrapper" href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		<?php echo $product->get_title(); ?>
	</a>
	<?php if ( ! empty( $show_rating ) ) echo $product->get_rating_html(); ?>
	<?php echo $product->get_price_html(); ?>
	</div>
</li>