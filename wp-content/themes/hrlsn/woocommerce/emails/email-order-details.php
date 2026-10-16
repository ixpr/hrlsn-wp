<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$text_align = is_rtl() ? 'right' : 'left';

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

<table class="order_details" cellspacing="0" cellpadding="0" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;border-collapse: separate;	border-spacing: 0 10px; " border="0">
	<tbody>
		<?php
		echo wc_get_email_order_items(
			$order,
			array(
				'show_sku'      => false,
				'show_image'    => true,
				'image_size'    => array( 106, 78 ),
				'plain_text'    => $plain_text,
				'sent_to_admin' => $sent_to_admin,
			)
		);
		?>
	</tbody>
</table>

<div id="between_tables">&nbsp;</div>

<table class="order_totals" cellspacing="0" cellpadding="0" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border-collapse: collapse; table-layout: fixed;" border="0">
	<tbody>
		<?php
		$item_totals = $order->get_order_item_totals();

		if ( $item_totals ) {
			$i = 0;
			foreach ( $item_totals as $key => $total ) {
				if (in_array($key, ['payment_method', 'order_total'])) continue;
				if ($key == 'shipping') {
					$total['label'] = str_replace('(', '<br>(', esc_html__( 'Delivery by', 'hrlsn' ) . ' ' . $order->get_shipping_method());
					// $total['label'] = 'Доставка Boxberry до ПВЗ';
					$total['value'] = wc_price( $order->get_shipping_total(), array( 'currency' => $order->get_currency() ) );
				}
				$i++;
				?>
				<tr class="totals_row <?php if (1 === $i) echo 'totals_row_first'; ?>">
					<td style="width: 10%;"></td>
					<td class="totals_label" style="width: 50%; text-align: left;"><?php echo str_replace(':', '', wp_kses_post( $total['label'] )); ?></td>
					<td style="text-align: right;"><div style="padding-right: 15px; text-align: right; white-space: nowrap;"><?php echo wp_kses_post( $total['value'] ); ?></div></td>
				</tr>
				<?php
			}
		}
		?>
	</tbody>
</table>

<div id="totals_sum">
	<?php foreach ( $item_totals as $key => $total ) {
			if ($key == 'order_total') {
				echo esc_html__( 'Total paid', 'hrlsn' ). ' (' . wp_kses_post( $total['value'] ) . ')';
			} 
		}
	?>
</div>

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
