<?php
/**
 * Cart totals
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
