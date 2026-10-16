<?php
/**
 * The template for displaying product content in the single-product.php template
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;
global $product;

$productTagsArr = [];
$productTags = get_the_terms( get_the_id(), 'product_tag' );
if( is_array( $productTags ) ){
	foreach( $productTags as $productTag ){
		$productTagsArr[] = '<a href="'. get_permalink( wc_get_page_id( 'shop' ) ) .'?product_tag='. $productTag->slug .'">'. $productTag->name .'</a>';
	}
}

$composition = get_post_meta( get_the_id(), '_composition', true );

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'product-page', $product ); ?>>
	<div class="product-page__left">
		<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
		?>
	</div>
	<div class="product-page__center">
		<div class="prod-info">
			<?php the_title( '<h1>', '</h1>' ); ?>
			<p class="prod-info__subtitle"><?php echo $product->get_price_html(); ?></p>
			<div class="prod-info__desc">
				<div class="cross-styled btm-margin-block">
					<?php the_excerpt(); ?>
					<?php if ($composition || is_array( $productTags )) { ?>
						<p>
							<?php if ($composition) { ?>
								<?php esc_html_e( 'Comp', 'hrlsn' ); ?>: <?php echo $composition; ?>
							<?php } ?>
							<?php if ($composition && is_array( $productTags )) { ?>
								<br>
							<?php } ?>
							<?php if (is_array( $productTags )) { ?>
								<?php esc_html_e( 'Drop', 'hrlsn' ); ?>: <?php echo implode(', ', $productTagsArr); ?>
							<?php } ?>
						</p>
					<?php } ?>
				</div>
				<p><?php echo get_post_meta( get_the_id(), '_model', true ); ?></p>
				<div class="prod-info__desc__chart">
					<?php $sizechart = get_post_meta( get_the_id(), '_sizechart', true );
					if ($sizechart) { ?>
						<p class="cross-styled">
							<span class="prod-info__desc__chartlink forward-link forward-link-btm"><i class="link"><?php esc_html_e( 'Size chart', 'hrlsn' ); ?></i></span>
						</p>
						<div class="prod-info__desc__chart__table">
							<?php // echo HRLSN_OPTIONS['hrlsn_product_sizechart']; ?>
							<?php echo $sizechart; ?>
							<span class="prod-info__desc__chart__table__close">[ <i class="link"><?php esc_html_e( 'Close', 'hrlsn' ); ?></i> ]</span>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="prod-info__form">
				<?php
				/**
				 * Hook: woocommerce_single_product_summary.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */
				do_action( 'woocommerce_single_product_summary' );
				?>
			</div>
			<div class="prod-info__links">
				<div class="cross-styled">
					<?php wp_nav_menu([
						'theme_location' => 'menu-additional',
						'menu_id'        => 'additional-menu',
						'container' 	 => false
					]); ?>
				</div>
				<p><a href="mailto:hello@hrlsn.co"><?php esc_html_e( 'Customer support', 'hrlsn' ); ?></a></p>
			</div>
			<div class="prod-info__back">
				<p><a class="back-link" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"><?php esc_html_e( 'Back to catalog', 'hrlsn' ); ?></a></p>
			</div>
		</div>
	</div>
	<div class="product-page__right">
		<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
		?>
	</div>
</div>

<?php
/**
 * Hook: woocommerce_after_single_product_summary.
 *
 * @hooked woocommerce_output_product_data_tabs - 10
 * @hooked woocommerce_upsell_display - 15
 * @hooked woocommerce_output_related_products - 20
 */
do_action( 'woocommerce_after_single_product_summary' );
?>

<?php do_action( 'woocommerce_after_single_product' ); ?>
