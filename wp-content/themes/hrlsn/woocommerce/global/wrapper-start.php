<?php
/**
 * Content wrappers
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$template = wc_get_theme_slug_for_templates();
$classMain = '';
if (!is_product()) $classMain = 'class="container"';
$class = '';
if (is_shop()) $class = 'catalog-page';

switch ( $template ) {
	default:
		echo '<main id="main" '.$classMain.' role="main"><div id="primary" class="content-area '.$class.'">';
		break;
}
