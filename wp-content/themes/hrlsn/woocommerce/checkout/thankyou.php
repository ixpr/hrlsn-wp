<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="checkout-success-page">
	<div class="checkout-success-page__wrapper">

		<?php if ( $order ) : 
			$shipping_methods_titles = array();
			foreach ( $order->get_shipping_methods() as $shipping_method ) {
				$shipping_methods_titles[] = $shipping_method->get_method_id();
			}
			$shipping_method_type = $shipping_methods_titles[0]; 
			?>

			<?php if ( $order->has_status( 'failed' ) ) : ?>

				<h1><?php esc_html_e( 'Payment_was_not_successful', 'hrlsn' ); ?></h1>
				<p><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<?php else : ?>

				<h1><?php esc_html_e( 'Payment_was_successful', 'hrlsn' ); ?></h1>
				<p><?php esc_html_e( 'Thank you for your order!', 'hrlsn' ); ?></p><br>
				<p><?php esc_html_e( 'You will receive a confirmation email with a tracking number when we process your order', 'hrlsn' ); ?></p>

			<?php endif; ?>

		<?php else : ?>

			<h1><?php esc_html_e( 'Payment_was_successful', 'hrlsn' ); ?></h1>
			<p><?php esc_html_e( 'Thank you for your order!', 'hrlsn' ); ?></p><br>
			<p><?php esc_html_e( 'You will receive a confirmation email with a tracking number when we process your order', 'hrlsn' ); ?></p>

		<?php endif; ?>

		<div class="checkout-success-page__content">
			<div class="checkout-success-page__content__links">
				<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="back-link"><?php esc_html_e( 'Back to catalog', 'hrlsn' ); ?></a>
			</div>
		</div>
	</div>
</div>