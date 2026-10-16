<?php
defined( 'ABSPATH' ) || exit;

$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = '';

print_r($available_methods, true);
?>

<?php if ( $available_methods ) : 
	$methods_arr = [];
	$boxberry_self = '';
	$currency = get_woocommerce_currency();
	foreach ( $available_methods as $method ) : 
		if (strpos($method->id, 'shipping_shiptimize') !== false) {
			$method->id = 'shipping_shiptimize_30_weight' . $method->instance_id;
		}
		$methods_arr[] = array("id" => esc_attr( sanitize_title( $method->id ) ), "name" => $method->label, "price" => strip_tags(wc_price( $method->cost, array('currency' => $currency) )), "instance_id" => $method->instance_id, "selected" => ($method->id == $chosen_method) ? "1" : "0" ); ?>		
	<?php endforeach; 
	echo '<i class="hidden">'.json_encode($methods_arr).'</i>';
	?>

	<?php if ( is_cart() ) : ?>
		<p class="woocommerce-shipping-destination">
			<?php
			if ( $formatted_destination ) {
				// Translators: $s shipping destination.
				printf( esc_html__( 'Shipping to %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' );
				$calculator_text = esc_html__( 'Change address', 'woocommerce' );
			} else {
				echo wp_kses_post( apply_filters( 'woocommerce_shipping_estimate_html', __( 'Shipping options will be updated during checkout.', 'woocommerce' ) ) );
			}
			?>
		</p>
	<?php endif; ?>
	<?php
elseif ( ! $has_calculated_shipping || ! $formatted_destination ) :
	if ( is_cart() && 'no' === get_option( 'woocommerce_enable_shipping_calc' ) ) {
		echo wp_kses_post( apply_filters( 'woocommerce_shipping_not_enabled_on_cart_html', __( 'Shipping costs are calculated during checkout.', 'woocommerce' ) ) );
	} else {
		echo wp_kses_post( apply_filters( 'woocommerce_shipping_may_be_available_html', __( 'Enter your address to view shipping options.', 'woocommerce' ) ) );
	}
elseif ( ! is_cart() ) :
	echo wp_kses_post( apply_filters( 'woocommerce_no_shipping_available_html', __( 'There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce' ) ) );
else :
	// Translators: $s shipping destination.
	echo wp_kses_post( apply_filters( 'woocommerce_cart_no_shipping_available_html', sprintf( esc_html__( 'No shipping options were found for %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ) ) );
	$calculator_text = esc_html__( 'Enter a different address', 'woocommerce' );
endif;
?>

<?php if ( $show_package_details ) : ?>
	<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>'; ?>
<?php endif; ?>

<?php if ( $show_shipping_calculator ) : ?>
	<?php woocommerce_shipping_calculator( $calculator_text ); ?>
<?php endif; ?>
