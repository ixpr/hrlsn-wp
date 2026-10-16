<?php

/**
 * Empty cart page
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );

if (wc_get_page_id('shop') > 0) : ?>

	<div class="cart-page cart-page--empty">
		<div class="cart-page__left">
			<div class="cart-page__left__bottom">
				<a class="back-link" href="<?php echo get_permalink(wc_get_page_id('shop')); ?>"><?php esc_html_e('Back to catalog', 'hrlsn'); ?></a>
				<span class="cart-page__left__bottom__free"><?php esc_html_e('Free shipping', 'hrlsn'); ?> ><?php echo getFreeShippingAmount(); ?></span>
			</div>
		</div>
		<div class="cart-page__right">
			<div class="cart-page__right__cart">
				<div class="h-cart">
					<h1><?php esc_html_e('Cart_is_empty', 'hrlsn'); ?></h1>
				</div>
			</div>
			<div class="cart-page__right__checkout">
				<div class="cart_totals">
					<a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="cart-page__right__checkout__btn"><?php esc_html_e('Go shopping', 'hrlsn'); ?></a>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>