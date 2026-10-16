<?php
/**
 * Product Loop Start
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$class = "prod-list--catalog";
if (!is_shop()) $class = "prod-list--similar";

?>
<ul class="prod-list <?php echo $class; ?>">
