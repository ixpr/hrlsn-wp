<?php
/**
 * Review order table
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div id="order_review" class="woocommerce-checkout-review-order shop_table woocommerce-checkout-review-order-table">

	<div class="checkout-page__right__cart">

		<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
		
			<ul class="h-cart">

				<?php 
				do_action( 'woocommerce_review_order_before_cart_contents' );

				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						$input_width = ($cart_item['quantity'] > 9) ? 20 : 10;
						?>
						<li class="h-cart__item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?><?php if ($cart_item['quantity'] == $_product->get_max_purchase_quantity()) echo ' max-quantity'; ?>">
							<div class="h-cart__item__image">
								<?php if ( empty( $product_permalink ) ) : ?>
									<?php echo $thumbnail; ?>
								<?php else : ?>
									<a href="<?php echo esc_url( $product_permalink ); ?>">
										<?php echo $thumbnail; ?>
									</a>
								<?php endif; ?>
							</div>
							<div class="h-cart__item__name">
								<?php if ( empty( $product_permalink ) ) : ?>
									<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
								<?php else : ?>
									<a href="<?php echo esc_url( $product_permalink ); ?>">
										<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
									</a>
								<?php endif; ?>
								<?php if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="h-cart__item__name__preorder">' . esc_html__( 'Preorder', 'woocommerce' ) . ' [<i data-link="backorder" data-type-link="notice" class="link highlighted">?</i>]</p>', $product_id ) );
								}
								?>
							</div>
							<div class="h-cart__item__params">
								<span><?php echo wc_get_formatted_cart_item_data( $cart_item ); ?></span>
							</div>
							<div class="h-cart__item__price">
								<span><?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?></span>
							</div>
							<div class="h-cart__item__qty">
								<span><?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', $cart_item['quantity'], $cart_item, $cart_item_key ); ?></span>
							</div>
							<div class="h-cart__item__total">
								<span><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></span>
							</div>
							<div class="h-cart__item__total__mobile">
								<div class="h-cart__item__total__mobile__wrapper">
									<div class="h-cart__item__total__mobile__name">
										<?php if ( empty( $product_permalink ) ) : ?>
											<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
										<?php else : ?>
											<a href="<?php echo esc_url( $product_permalink ); ?>">
												<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
											</a>
										<?php endif; ?>
									</div>
									<div class="h-cart__item__total__mobile__params">
										<span><?php echo wc_get_formatted_cart_item_data( $cart_item ); ?></span>
									</div>
									<div class="h-cart__item__total__mobile__qty">
										<span><?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', $cart_item['quantity'], $cart_item, $cart_item_key ); ?></span>
									</div>
								</div>
								<div class="h-cart__item__total__mobile__wrapper">
									<div class="h-cart__item__total__mobile__total">
										<span><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></span>
									</div>
									<div class="h-cart__item__total__mobile__remove remove_from_cart_button_ch">
										<span>[<?php esc_html_e('Remove', 'hrlsn'); ?>]</span>
									</div>
								</div>
							</div>
						</li>
						<?php
					}
				}

				do_action( 'woocommerce_review_order_after_cart_contents' );
				?>

				<li class="h-cart__totals h-cart__totals--subtotal hidden">
					<span><?php echo wc_price(WC()->cart->subtotal); ?></span>
				</li>

				<li id="h-cart__totals--json" class="h-cart__totals" style="display: none;">
					<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
						<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
						<?php wc_cart_totals_shipping_html(); ?>
						<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
					<?php endif; ?>
				</li>

			</ul>

			<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
			<input type="hidden" class="button" name="update_cart" value="1">

		</form>


		<div class="h-coupon">

			<div class="h-coupon__desc h-cart__totals h-cart__totals--delivery hidden hidden-i">

				<div class="h-coupon__desc__name h-cart__totals__name">
				 	<?php esc_html_e( 'Delivery by', 'hrlsn' ); ?>&nbsp;<span></span>
					<i style="display: none !important;"><br>(<?php esc_html_e( 'The shipping will be recalculated once you\'ve entered your city and postal code', 'hrlsn' ); ?>)</i>
				</div>
				<div class="h-coupon__desc__price h-cart__totals__value"></div>
				
				<input type="hidden" name="ch-delivery-session-id" value="<?php echo WC()->session->get( 'chosen_shipping_methods' )[0]; ?>">
				<script>
					if (typeof activateDeliveryNotice === "function")  {
						activateDeliveryNotice();
					}
					if (typeof showDeliveryMethodInOrderReview === "function")  {
						showDeliveryMethodInOrderReview();
					}
					if (typeof updateTotalsOnLastStep === "function")  {
						updateTotalsOnLastStep();
					}
				</script>

			</div>

			<?php if ( wc_coupons_enabled() ) { ?>
				<?php if (WC()->cart->get_coupons()) { ?>
					
					<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
						<div class="h-coupon__applied cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
							<span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
							<span data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
						</div>
					<?php endforeach; ?>

				<?php } else { ?>

					<p class="h-coupon__have">
						<span class="link"><?php esc_html_e( 'Have a discount coupon?', 'hrlsn' ); ?></span>
					</p>
					<p class="h-coupon__submit hidden">
						<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Enter your code', 'hrlsn' ); ?>" />

						<span class="h-coupon__submit__trigger h-coupon__submit__trigger--checkout">[<?php esc_attr_e( 'Proceed', 'hrlsn' ); ?>]</span>

						<span class="h-coupon__submit__error"></span>
						
						<input type="hidden" name="coupon_nonce" value="<?php echo wp_create_nonce( 'apply-coupon' ); ?>">
						<input type="hidden" name="coupon_endpoint" value="<?php echo WC_AJAX::get_endpoint( '%%endpoint%%' );?>">

						<button class="hidden" type="submit" name="apply_coupon" value="[<?php esc_attr_e( 'Proceed', 'hrlsn' ); ?>]">[<?php esc_attr_e( 'Proceed', 'hrlsn' ); ?>]</button>
					</p>

				<?php } ?>

				<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

			<?php } ?>

		</div>

	</div>

	<div class="checkout-page__right__totals">
		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
        <span class="checkout-page__right__totals__btn"><?php esc_html_e( 'Total amount', 'hrlsn' ); ?> (<?php trim(wc_cart_totals_order_total_html()); ?>)</span>
    </div>

</div>
