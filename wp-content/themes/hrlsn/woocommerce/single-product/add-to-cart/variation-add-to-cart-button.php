<?php
/**
 * Single variation cart button
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

?>
<div class="woocommerce-variation-add-to-cart">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<div class="prod-info__form__qty hidden">
		<?php
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), 
			)
		);

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>
	</div>

	<div class="prod-info__form__submit">
		<button type="submit" class="single_add_to_cart_button"><?php echo $product->single_add_to_cart_text(); ?></button>
		<p class="prod-info__form__submit__desc highlighted hidden"><?php echo str_replace('[', '<i class="link highlighted" data-link="backorder" data-type-link="notice">', str_replace(']', '</i>', __( 'The item is out of stock but you can [pre-order] it', 'hrlsn' ))); ?></p>
		<span class="prod-info__form__submit__added hidden"><?php echo esc_html__( 'Added to cart', 'hrlsn' ); ?></span>

		<?php 
		// check if is in cart
		$items = WC()->cart->get_cart();
		if ($items) {
			$variation_ids_in_cart = [];
			foreach($items as $item => $values) { 
				$variation_ids_in_cart[] = $values['variation_id'];
			} 
		}

		$added_to_cart = null;
		$variations = $product->get_available_variations(); 
		$variations_id = wp_list_pluck( $variations, 'variation_id' );
		if (is_array($variations_id) && is_array($variation_ids_in_cart)) {
			foreach ($variations_id as $variation_id ) {
				if (in_array($variation_id, $variation_ids_in_cart)) {
					echo '<span class="prod-info__form__submit__variation hidden" data-id="'.$variation_id.'"></span>';
				}
			}
		}
		?>
	</div>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />

	<span class="out-of-stock-text hidden"><?php echo esc_html__( 'Out of stock', 'hrlsn' ); ?></span>
	<span class="backorder-text hidden"><?php echo esc_html__( 'Pre-order', 'hrlsn' ); ?><i>*</i></span>
	<span class="in-stock-text hidden"><?php echo $product->single_add_to_cart_text(); ?></span>
</div>
