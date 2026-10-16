<?php
/**
 * Ctt order email
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$delivery_service = 'CTT';

/*$days_estimated = 3; // default
$shipping_method = $order->get_shipping_method();
$shipping_method_arr_1 = explode('(', $shipping_method);
if ($shipping_method_arr_1[1]) {
	$shipping_method_arr_2 = explode(' ', $shipping_method_arr_1[1]);
	$days_estimated = $shipping_method_arr_2[0];
}*/

$tracking_code = get_post_meta( $order->get_id(), 'shiptimize_trackingid', true );
$tracking_link = get_post_meta( $order->get_id(), 'shiptimize_trackingurl', true );


/*
 * @hooked WC_Emails::email_header() Output the email header
*/
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<table cellspacing="0" cellpadding="0" style="width: 100%;" border="0">
	<tbody>
		<tr>
			<td valign="top">
				<p><?php printf( esc_html__( 'Your order #%s has been dispatched from our warehouse. Order tracking is possible through the %s service using tracking number %s.', 'hrlsn' ), esc_html( $order->get_order_number() ), esc_html( $delivery_service ), esc_html( $tracking_code ) ); ?></p>
				<p><a href="<?php echo $tracking_link; ?>" target="_blank"><?php esc_html_e( 'Track your order', 'hrlsn' ); ?></a></p>
		</tr>
	</tbody>
</table>

<?php
/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
//do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
//do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
//do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
/*if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}*/

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
