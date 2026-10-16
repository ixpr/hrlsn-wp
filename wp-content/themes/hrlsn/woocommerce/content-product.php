<?php

/**
 * The template for displaying product content within loops
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
	return;
}

// get 1st gallery image
$attachment_ids = $product->get_gallery_image_ids();
if ( is_array( $attachment_ids ) && ! empty( $attachment_ids ) ) {
	$first_gallery_image = wp_get_attachment_image( $attachment_ids[0], 'thumbnail' );
}
else {
    $first_gallery_image = $product->get_image('thumbnail');
}

?>
<li <?php wc_product_class('prod-list__item', $product); ?>>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 */
	do_action('woocommerce_before_shop_loop_item_title');
	?>
	<div class="prod-list__item__image">
		<a href="<?php echo $product->get_permalink(); ?>">
			<?php echo $product->get_image('thumbnail'); ?>
			<?php echo $first_gallery_image; ?>
		</a>
	</div>
	<div class="prod-list__item__name">
		<a href="<?php echo $product->get_permalink(); ?>"><?php echo $product->get_name(); ?></a>
	</div>
	<div class="prod-list__item__form">
		<div class="prod-list__item__form__sizes">
			<?php 
				do_action('woocommerce_after_shop_loop_item_title');
				do_action('woocommerce_after_shop_loop_item'); 
			?>
		</div>
		
		<div class="prod-list__item__form__price">
			<?php echo $product->get_price_html(); ?>
		</div>
	</div>
</li>