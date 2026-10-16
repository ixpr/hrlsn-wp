<?php
/**
 * Related Products
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="prod-similaritems">
		<div class="container">
			<h3><?php esc_html_e( 'Similar items', 'hrlsn' ); ?></h3>
			<div class="prod-similaritems__list">

				<?php woocommerce_product_loop_start_related(); ?>

					<?php foreach ( $related_products as $related_product ) : ?>

							<?php
							$post_object = get_post( $related_product->get_id() );
							setup_postdata( $GLOBALS['post'] =& $post_object ); 
							wc_get_template_part( 'content', 'product' );
							?>

					<?php endforeach; ?>

				<?php woocommerce_product_loop_end_related(); ?>
				
			</div>
		</div>
	</section>
	<?php
endif;

wp_reset_postdata();
