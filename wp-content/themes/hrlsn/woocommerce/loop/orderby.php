<?php
/**
 * Show options for ordering
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
	<label><input type="radio" name="orderby" value="<?php echo esc_attr( $id ); ?>" <?php checked( $orderby, $id ); ?>><i>x</i><span><?php echo esc_html( $name ); ?></span></label>
<?php endforeach; ?>
<input type="hidden" name="paged" value="1" />
<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>