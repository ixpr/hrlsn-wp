<?php
/**
 * Email Styles
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 8.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load colors.
$bg        		= '#DFDDDD';
$body      		= '#FFFFFF';
$header_base    = '#E4DC32';
$text      		= '#0A0A0A';
$link_color 	= '#0A0A0A';

// !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
// body{padding: 0;} ensures proper scale/positioning of the email in the iOS native email app.
?>
body {
	background-color: <?php echo esc_attr( $bg ); ?>;
	padding: 0;
	text-align: center;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}

#outer_wrapper {
	background-color: <?php echo esc_attr( $bg ); ?>;
}

#wrapper {
	margin: 0 auto;
	padding: 70px 0;
	-webkit-text-size-adjust: none !important;
	width: 100%;
	max-width: 1024px;
}

#template_container {
	background-color: <?php echo esc_attr( $body ); ?>;
}

#template_header {
	background-color: <?php echo esc_attr( $header_base ); ?>;
	color: <?php echo esc_attr( $text ); ?>;
	border-bottom: 0;
	line-height: 100%;
	vertical-align: middle;
}

#template_header h1,
#template_header h1 a {
	color: <?php echo esc_attr( $text ); ?>;
	background-color: inherit;
	font-size: 20px;
	font-weight: 400;
	line-height: 28px;
}

#template_header_image img {
	margin-left: 0;
	margin-right: 0;
}

#template_footer {
	position: relative;
}

#template_footer td {
	padding: 0;
}

#template_footer #credit {
	padding-bottom: 40px;
	border: 0;
	color: <?php echo esc_attr( $text ); ?>;
	font-size: 12px;
	line-height: 20px;
}

#template_footer #credit p {
	max-width: 515px;
	margin: 40px 0 0;
}

#template_footer .cross_1 {
	display: block;
	width: 30px;
	height: 30px;
	margin-left: -10px;
	background-size: contain;
	background-repeat: no-repeat;
	background-position: center center;
	background-image: url("https://hrlsn.studio/wp-content/themes/hrlsn/assets/img/email_cross.png");
}

#template_footer .cross_2 {
	display: block;
	width: 30px;
	height: 30px;
	margin-right: -10px;
	background-size: contain;
	background-repeat: no-repeat;
	background-position: center center;
	background-image: url("https://hrlsn.studio/wp-content/themes/hrlsn/assets/img/email_cross.png");
}

#template_footer #credit p.social {
	margin: 10px 0 0 0;
}

#template_footer #credit .social a {
	display: inline-block;
	width: 22px;
	height: 22px;
	margin-right: 37px;
	background-size: contain;
	background-repeat: no-repeat;
	background-position: center center;
}

#template_footer #credit .social a.instagram {
	background-image: url("https://hrlsn.studio/wp-content/themes/hrlsn/assets/img/email_instagram.png");
}

#template_footer #credit .social a.youtube {
	background-image: url("https://hrlsn.studio/wp-content/themes/hrlsn/assets/img/email_youtube.png");
}

#template_footer #credit p.upper {
	text-transform: uppercase;
}

#body_content {
	background-color: <?php echo esc_attr( $body ); ?>;
}

#body_content table td {
	padding: 0 3% 0 5%;
}

#body_content table td.top_cell {
	padding-bottom: 0;
}

#body_content table td.bottom_cell {
	padding-top: 0;
}

#body_content table td td {
	padding: 0;
}

#body_content table td th {
	padding: 0;
}

#body_content td ul.wc-item-meta {
	font-size: small;
	margin: 1em 0 0;
	padding: 0;
	list-style: none;
}

#body_content td ul.wc-item-meta li {
	margin: 0.5em 0 0;
	padding: 0;
}

#body_content td ul.wc-item-meta li p {
	margin: 0;
}

#body_content p {
	margin: 0 0 18px;
}

#body_content_inner {
	color: <?php echo esc_attr( $text ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 20px;
	font-weight: 400;
	line-height: 28px;
	text-align: left;
}

.td {
	color: <?php echo esc_attr( $text ); ?>;
	border: 1px solid <?php echo esc_attr( $body ); ?>;
	vertical-align: middle;
}

.additional-fields {
	padding: 12px 12px 0;
	color: <?php echo esc_attr( $text ); ?>;
	border: 1px solid <?php echo esc_attr( $body ); ?>;
	list-style: none outside;
}

.additional-fields li {
	margin: 0 0 12px 0;
}

.text {
	color: <?php echo esc_attr( $text ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}

.link {
	color: <?php echo esc_attr( $link_color ); ?>;
}

#header_wrapper {
	padding: 24px 5%;
	display: block;
}

h1 {
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 20px;
	font-weight: 400;
	line-height: 28px;
	text-align: left;
	margin: 0;
	padding: 0;
}

h2 {
	display: block;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 20px;
	font-weight: 400;
	line-height: 28px;
	text-align: left;
	margin: 0 0 16px;
	padding: 0;
}

h3 {
	display: block;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 20px;
	font-weight: 400;
	line-height: 28px;
	text-align: left;
	margin: 0;
	padding: 0;
}

a {
	color: <?php echo esc_attr( $link_color ); ?>;
	font-weight: normal;
	text-decoration: underline;
}

img {
	border: none;
	display: inline-block;
	font-size: 14px;
	font-weight: bold;
	height: auto;
	outline: none;
	text-decoration: none;
	text-transform: capitalize;
	vertical-align: middle;
	margin: 0;
	max-width: 100%;
}

.logo-link {
    display: block;
}

#header_table {
	margin-bottom: 30px;
}

#order_details {
	/*border-bottom: 1px solid #CCC;
	border-collapse: separate;
  	border-spacing: 0 20px;*/
}

td.order_item {
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 12px;
	font-weight: 400;
	line-height: 20px;
	text-align: left;
	text-transform: uppercase;
	color: <?php echo esc_attr( $text ); ?>;
}

td.order_item a.image-link {
	width: 78px;
	max-width: 85%;
}

td.order_item img {
	width: 78px;
	height: auto;
}

td.order_item_even {
	background-color: #DFDDDD;
}

tr.totals_row_first td,
tr.totals_row td {
	font-size: 13px;
	font-weight: 400;
	line-height: 15px;
}

#body_content table td tr.totals_row_first td,
#body_content table td tr.totals_row td {
	padding-bottom: 10px;
}

#between_tables {
	border-top: 1px solid #DFDDDD; 
	height: 18px; 
	color: #FFF;
}

#totals_sum {
	margin: 20px 0 24px;
	background: #DFDDDD;
	height: 106px;
	line-height: 106px;
	font-size: 20px;
	font-weight: 400;
	text-align: center;
}

#addresses td {
	font-size: 13px;
	font-weight: 400;
	line-height: 20px;
	text-align: left;
}

address {
	font-style: normal;
}


/**
 * Media queries are not supported by all email clients, however they do work on modern mobile
 * Gmail clients and can help us achieve better consistency there.
 */
@media screen and (max-width: 1024px) {
	/*#body_content table > tbody > tr > td {
		padding-left: 10px !important;
		padding-right: 10px !important;
	}*/ 
}
<?php
