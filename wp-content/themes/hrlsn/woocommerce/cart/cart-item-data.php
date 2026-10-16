<?php
/**
 * Cart item data (when outputting non-flat)
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<span>
	<?php foreach ( $item_data as $item_data_item ) : 
		foreach ($item_data_item as $key => $value) :
			if ($key == 'slug') echo $value;
		endforeach;
	endforeach; ?>
</span>
