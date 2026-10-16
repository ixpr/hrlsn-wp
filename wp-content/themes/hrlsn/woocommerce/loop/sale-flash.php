<?php
/**
 * Product loop sale flash
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$new = get_post_meta( get_the_id(), '_new', true );
$restock = get_post_meta( get_the_id(), '_restock', true );
$exclusive = get_post_meta( get_the_id(), '_exclusive', true );
$preorder = get_post_meta( get_the_id(), '_preorder', true );
$bestseller = get_post_meta( get_the_id(), '_bestseller', true );
?>
<?php if ( ( ! $product->is_type('variable') && ! $product->is_in_stock()  ) 
    || ( $product->is_type('variable') && is_variable_product_out_of_stock( $product ) ) ) : ?>

	<div class="prod-list__item__label">
		<?php esc_html_e( 'Sold out', 'hrlsn' ); ?>
	</div>

	<?php

elseif ( $product->is_on_backorder() || $preorder == 'yes' ) : ?>

	<div class="prod-list__item__label">
		<?php esc_html_e( 'Preorder', 'hrlsn' ); ?>
	</div>

	<?php

elseif ( $product->is_on_sale() ) : ?>

	<div class="prod-list__item__label">
		<?php echo apply_filters( 'woocommerce_sale_flash', '<span>' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>
	</div>

	<?php

elseif ( $new == 'yes' ) : ?>

	<div class="prod-list__item__label">
		<span><?php esc_html_e( 'New', 'hrlsn' ); ?></span>
	</div>

	<?php

elseif ( $restock == 'yes' ) : ?>

	<div class="prod-list__item__label">
		<span><?php esc_html_e( 'Restock', 'hrlsn' ); ?></span>
	</div>

	<?php

elseif ( $exclusive == 'yes' ) : ?>

	<div class="prod-list__item__label">
		<span><?php esc_html_e( 'Exclusive', 'hrlsn' ); ?></span>
	</div>

	<?php

elseif ( $bestseller == 'yes' ) : ?>

	<div class="prod-list__item__label">
		<span><?php esc_html_e( 'Bestseller', 'hrlsn' ); ?></span>
	</div>

	<?php
endif;
