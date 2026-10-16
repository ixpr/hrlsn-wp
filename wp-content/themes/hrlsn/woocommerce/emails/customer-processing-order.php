<?php
/**
 * Customer processing order email
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<table cellspacing="0" cellpadding="0" style="width: 100%;" border="0">
	<tbody>
		<tr>
			<td valign="top">
				<p><?php esc_html_e( 'Your order is being processed and will be sent for delivery as soon as possible.', 'hrlsn' ); ?></p>
				<p><?php printf( esc_html__( 'Order #%s from %s', 'hrlsn' ), esc_html( $order->get_order_number() ), esc_html( wc_format_datetime( $order->get_date_created() ) ) ); ?></p>
			</td>
		</tr>
	</tbody>
</table>


<table id="order_table" cellspacing="0" cellpadding="0" style="width: 100%;" border="0">
	<tbody>
		<tr>
			<td valign="top">
				<?php
				/*
				* @hooked WC_Emails::order_details() Shows the order details table.
				* @hooked WC_Structured_Data::generate_order_data() Generates structured data.
				* @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
				* @since 2.5.0
				*/
				do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

				/*
				* @hooked WC_Emails::order_meta() Shows order meta data.
				*/
				// do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

				/*
				* @hooked WC_Emails::customer_details() Shows customer details
				* @hooked WC_Emails::email_address() Shows email address
				*/
				do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );
				?>
			</td>
		</tr>
	</tbody>
</table>


<?php
/**
 * Show user-defined additional content - this is set in each email's settings.
 */
/*
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}
*/

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
