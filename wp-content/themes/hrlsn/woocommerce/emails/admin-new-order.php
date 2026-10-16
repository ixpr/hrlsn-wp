<?php
/**
 * Admin new order email
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails\HTML
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<table cellspacing="0" cellpadding="0" style="width: 100%;" border="0">
	<tbody>
		<tr>
			<td valign="top">
			<p><?php printf( esc_html__( 'You’ve received the following order from %s:', 'woocommerce' ), $order->get_formatted_billing_full_name() ); ?></p>
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
/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
