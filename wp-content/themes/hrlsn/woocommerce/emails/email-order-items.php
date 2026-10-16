<?php
/**
 * Email Order Items
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$text_align  = is_rtl() ? 'right' : 'left';
$margin_side = is_rtl() ? 'left' : 'right';
$i = 0;

foreach ( $items as $item_id => $item ) :
	$product       = $item->get_product();
	$sku           = '';
	$purchase_note = '';
	$image         = '';
	$i++;

	if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
		continue;
	}

	if ( is_object( $product ) ) {
		$sku           = $product->get_sku();
		$purchase_note = $product->get_purchase_note();
		$image         = $product->get_image( 'woocommerce_thumbnail' );
		$link		   = get_permalink( $product->get_id() );
	}

	?>
	<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?> order_item_row">

		<td class="order_item order_item_first <?php if ($i % 2 == 0) echo 'order_item_even'; ?>" style="text-align: left; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; width: 10%;">
			<div>
				<a class="image-link" href="<?php echo $link; ?>" target="_blank" style="display: block;">
					<?php
					// Show title/image etc.
					echo wp_kses_post( apply_filters( 'woocommerce_order_item_thumbnail', $image, $item ) );
					?>
				</a>
			</div>
		</td>

		<td class="order_item <?php if ($i % 2 == 0) echo 'order_item_even'; ?>" style="text-align: left; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word;  hyphens: auto; width: 35%;">
			<div style="max-width: 90%;">
				<a href="<?php echo $link; ?>" target="_blank">
					<?php
					// Product name.
					echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) );
					?>
				</a>
			</div>
		</td>

		<td class="order_item <?php if ($i % 2 == 0) echo 'order_item_even'; ?>" style="text-align: left; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word;  hyphens: auto; width: 35%;">
			<div style="max-width: 85%;">
				<?php
				// allow other plugins to add additional product information here.
				//do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, $plain_text );

				foreach ( $item->get_all_formatted_meta_data() as $meta_id => $meta ) {
					echo $meta->value;
				}

				// allow other plugins to add additional product information here.
				//do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, $plain_text );
				?>
			</div>
		</td>

		<td class="order_item <?php if ($i % 2 == 0) echo 'order_item_even'; ?>" style="text-align: left; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; width: 7%;">
			<div style="">
				<?php
				$qty          = $item->get_quantity();
				$qty_display = esc_html( $qty );

				echo '['. wp_kses_post( apply_filters( 'woocommerce_email_order_item_quantity', $qty_display, $item ) ) . ']';
				?>
			</div>
		</td>

		<td class="order_item <?php if ($i % 2 == 0) echo 'order_item_even'; ?>" style="text-align: right; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; width: 7%;">
			<div style="white-space: nowrap; padding: 0 15px 0 10px;">
				<?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?>
			</div>
		</td>
	</tr>

<?php endforeach; ?>
