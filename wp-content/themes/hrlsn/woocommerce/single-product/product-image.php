<?php
/**
 * Single Product Image
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;
global $product;

// main image
echo $product->get_image('large');

// gallery images
$attachment_ids = $product->get_gallery_image_ids();
if ( $attachment_ids ) {
	foreach ( $attachment_ids as $attachment_id ) {
		echo wp_get_attachment_image( $attachment_id, 'large' );
	}
}