<?php
/**
 * Cart Page
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<div class="cart-page">
		<div class="cart-page__left">
			<div class="cart-page__left__bottom">
				<a class="back-link" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"><?php esc_html_e( 'Back to catalog', 'hrlsn' ); ?></a>
				<span class="cart-page__left__bottom__free"><?php esc_html_e( 'Free shipping', 'hrlsn' ); ?> ><?php echo getFreeShippingAmount(); ?></span>
			</div>
		</div>
		<div class="cart-page__right">
			<div class="cart-page__right__cart">

				<div class="cart woocommerce-cart-form__contents">

					<?php do_action( 'woocommerce_before_cart_contents' ); ?>

					<ul class="h-cart">

						<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
							/**
							 * Filter the product name.
							 *
							 * @since 2.1.0
							 * @param string $product_name Name of the product in the cart.
							 * @param array $cart_item The product in the cart.
							 * @param string $cart_item_key Key for the product in the cart.
							 */
							$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
								?>

								<li class="h-cart__item woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

									<div class="h-cart__item__image">
										<?php
										$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

										if ( ! $product_permalink ) {
											echo $thumbnail;
										} else {
											printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
										}
										?>
									</div>

									<div class="h-cart__item__name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
										<?php
										if ( ! $product_permalink ) {
											echo wp_kses_post( $product_name . '&nbsp;' );
										} else {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
										}

										do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

										if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="h-cart__item__name__preorder">' . esc_html__( 'Preorder', 'woocommerce' ) . ' [<i data-link="backorder" data-type-link="notice" class="link highlighted">?</i>]</p>', $product_id ) );
										}
										?>
									</div>

									<div class="h-cart__item__params">
										<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
									</div>

									<div class="h-cart__item__price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
										<?php
											echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
										?>
									</div>

									<div class="h-cart__item__qty" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
										<span><i class="minus">–</i><b class="qty-number">[<?php echo $cart_item['quantity']; ?>]</b><i class="plus">+</i></span>
										<?php
											if ( $_product->is_sold_individually() ) {
												$min_quantity = 1;
												$max_quantity = 1;
											} else {
												$min_quantity = 0;
												$max_quantity = $_product->get_max_purchase_quantity();
											}

											$product_quantity = woocommerce_quantity_input(
												array(
													'input_name'   => "cart[{$cart_item_key}][qty]",
													'input_value'  => $cart_item['quantity'],
													'max_value'    => $max_quantity,
													'min_value'    => $min_quantity,
													'product_name' => $product_name,
												),
												$_product,
												false
											);

											echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
										?>
									</div>

									<div class="h-cart__item__total" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
										<?php
											echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
										?>
									</div>

									<div class="h-cart__item__total__mobile">
										<div class="h-cart__item__total__mobile__wrapper">

											<div class="h-cart__item__total__mobile__name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
												<?php
													if ( ! $product_permalink ) {
														echo wp_kses_post( $product_name . '&nbsp;' );
													} else {
														echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
													}

													do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

													if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
														echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="h-cart__item__total__mobile__name__preorder">' . esc_html__( 'Preorder', 'woocommerce' ) . ' [<i data-link="backorder" data-type-link="notice" class="link highlighted">?</i>]</p>', $product_id ) );
													}
												?>
											</div>

											<div class="h-cart__item__total__mobile__params">
												<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
											</div>

											<div class="h-cart__item__total__mobile__qty">
												<span><b class="qty-number">[<?php echo $cart_item['quantity']; ?>]</b><i class="minus">–</i><i class="plus">+</i></span>
											</div>

										</div>
										<div class="h-cart__item__total__mobile__wrapper">

											<div class="h-cart__item__total__mobile__total">
												<?php
													echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
												?>
											</div>

											<div class="h-cart__item__total__mobile__remove">
												<div class="product-remove">
													<?php
														echo apply_filters(
															'woocommerce_cart_item_remove_link',
															sprintf(
																'<a href="%s" aria-label="%s" data-product_id="%s" data-product_sku="%s">['.esc_html__( 'Remove', 'hrlsn' ).']</a>',
																esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
																esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
																esc_attr( $product_id ),
																esc_attr( $_product->get_sku() )
															),
															$cart_item_key
														);
													?>
												</div>
											</div>
										</div>
									</div>
								</li>

								<?php
							}
						}
						?>

					</ul>

					<?php do_action( 'woocommerce_cart_contents' ); ?>

					<div class="h-coupon">

						<p class="h-coupon__desc"><?php esc_html_e( 'Delivery will be counted on the next step', 'hrlsn' ); ?></p>

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

									<span class="h-coupon__submit__trigger">[<?php esc_attr_e( 'Proceed', 'hrlsn' ); ?>]</span>

									<span class="h-coupon__submit__error"></span>
									
									<button class="hidden" type="submit" name="apply_coupon" value="[<?php esc_attr_e( 'Proceed', 'hrlsn' ); ?>]">[<?php esc_attr_e( 'Proceed', 'hrlsn' ); ?>]</button>

									<?php do_action( 'woocommerce_cart_coupon' ); ?>
								</p>

							<?php } ?>
						<?php } ?>

						<input type="hidden" class="cart-total-qty" value="<?php echo WC()->cart->get_cart_contents_count(); ?>">

						<button type="submit" class="hidden" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

						<?php do_action( 'woocommerce_cart_actions' ); ?>

						<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
						
					</div>

					<?php do_action( 'woocommerce_after_cart_contents' ); ?>

				</div>
				<?php do_action( 'woocommerce_after_cart_table' ); ?>


			</div>
			
			<div class="cart-page__right__checkout">
				<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
				<?php
					/**
					 * Cart collaterals hook.
					 *
					 * @hooked woocommerce_cross_sell_display
					 * @hooked woocommerce_cart_totals - 10
					 */
					do_action( 'woocommerce_cart_collaterals' );
				?>
			</div>
		</div>
	</div>
	
</form>

<?php do_action( 'woocommerce_after_cart' ); ?>
