<?php
/**
 * Checkout Form
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' )) {
	exit;
}



$all_items_are_virtual = all_items_are_virtual();

$billing_fields = $checkout->get_checkout_fields( 'billing' );

$billing_fields_active = array( 'billing_email', 'billing_first_name', 'billing_last_name', 'billing_phone', 'billing_postcode', 'billing_address_1', 'billing_address_2');

$billing_fields['billing_email']['label'] = $billing_fields['billing_first_name']['label'] = $billing_fields['billing_last_name']['label'] = $billing_fields['billing_phone']['label'] = $billing_fields['billing_postcode']['label'] = $billing_fields['billing_address_1']['label'] = $billing_fields['billing_address_2']['label']  = $billing_fields['billing_street_name']['label']  = $billing_fields['billing_house_number']['label'] = false;

$billing_fields['billing_email']['placeholder'] = esc_html__( 'E-mail', 'hrlsn' );
$billing_fields['billing_first_name']['placeholder'] = esc_html__( 'First name', 'hrlsn' );
$billing_fields['billing_last_name']['placeholder'] = esc_html__( 'Last name', 'hrlsn' );
$billing_fields['billing_phone']['placeholder'] = esc_html__( 'Mobile phone', 'hrlsn' );
$billing_fields['billing_postcode']['placeholder'] = esc_html__( 'Enter postal code', 'hrlsn' );
$billing_fields['billing_address_1']['placeholder'] = esc_html__( 'Street and house number', 'hrlsn' );
$billing_fields['billing_address_2']['placeholder'] = esc_html__( 'Apartment, suite, unit, etc.', 'hrlsn' );
$billing_fields['billing_street_name']['placeholder'] = esc_html__( 'Street', 'hrlsn' );
$billing_fields['billing_house_number']['placeholder'] = esc_html__( 'House No.', 'hrlsn' );

$billing_fields['billing_house_number']['type'] = 'text';

$order_fields = $checkout->get_checkout_fields( 'order' );
$order_fields_active = array( 'order_comments' );
$order_fields['order_comments']['label'] = false;
$order_fields['order_comments']['placeholder'] = esc_html__( 'Comment', 'hrlsn' );

$order_fields['billing_postcode']['required'] = false;

// validation
$billing_fields['billing_first_name']['description'] = '<span data-error="first_name" class="ch-stage__body__error hidden">'.esc_html__( 'First name is not filled', 'hrlsn' ).'</span><span class="clear"></span>';
$billing_fields['billing_last_name']['description'] = '<span data-error="last_name" class="ch-stage__body__error hidden">'.esc_html__( 'Last name is not filled', 'hrlsn' ).'</span><span class="clear"></span>';
$billing_fields['billing_email']['description'] = '<span data-error="email" class="ch-stage__body__error hidden">'.esc_html__( 'Email is not filled', 'hrlsn' ).'</span><span data-error="email_format" class="ch-stage__body__error hidden">'.esc_html__( 'Wrong email format', 'hrlsn' ).'</span><span class="clear"></span>';
$billing_fields['billing_phone']['description'] = '<span data-error="phone" class="ch-stage__body__error hidden">'.esc_html__( 'Phone is not filled', 'hrlsn' ).'</span><span data-error="phone_format" class="ch-stage__body__error hidden">'.esc_html__( 'The phone must contain at least 9 digits', 'hrlsn' ).'</span><span class="clear"></span>';
$billing_fields['billing_address_1']['description'] = '<span data-error="address" class="ch-stage__body__error hidden">'.esc_html__( 'Address is not filled', 'hrlsn' ).'</span><span class="clear"></span>';
$billing_fields['billing_street_name']['description'] = '<span data-error="street" class="ch-stage__body__error hidden">'.esc_html__( 'Street is not filled', 'hrlsn' ).'</span><span class="clear"></span>';
$billing_fields['billing_house_number']['description'] = '<span data-error="house" class="ch-stage__body__error hidden">'.esc_html__( 'House No. is not filled', 'hrlsn' ).'</span><span class="clear"></span>';

if (ICL_LANGUAGE_CODE == 'en') {
	$stage_overall_number = 5;
	$stage_city_number = 1;
	$stage_delivery_number = 2;
	$stage_details_number = 3;
	$stage_confirmation_number = 4;
	$stage_payment_number = 5;
	// for virtual
	if ($all_items_are_virtual) {
		$stage_overall_number = 3;
		$stage_details_number = 1;
		$stage_confirmation_number = 2;
		$stage_payment_number = 3;
	}
} else {
	$stage_overall_number = 4;
	$stage_city_number = 1;
	$stage_delivery_number = 2;
	$stage_details_number = 3;
	$stage_payment_number = 4;
	// for virtual
	if ($all_items_are_virtual) {
		$stage_overall_number = 2;
		$stage_details_number = 1;
		$stage_payment_number = 2;
	}
}
?>

<div class="checkout-page">
	<div class="checkout-page__left">
		<div class="ch-sequence">

			<form name="checkout" method="post" class="checkout woocommerce-checkout <?php if ($all_items_are_virtual) { ?>virtual-checkout<?php } ?>" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

				<input type="hidden" name="ch-language" value="<?php echo ICL_LANGUAGE_CODE; ?>">

				<?php if (!$all_items_are_virtual) { ?>
					
					<div class="ch-stage ch-stage--active" data-stage="city">
						<div class="ch-stage__stage"><?php echo $stage_city_number; ?>/<?php echo $stage_overall_number; ?> <?php esc_html_e( 'Delivery city', 'hrlsn' ); ?></div>
						<div class="ch-stage__body">
							<input name="hrlsn_checkout_city_field" type="text" placeholder="<?php esc_html_e( 'Enter city', 'hrlsn' ); ?>" value="" autocomplete="nofill">
							
							<?php if (ICL_LANGUAGE_CODE == 'ru') echo "<div class='hidden'>";  ?>
							<?php woocommerce_form_field( 'billing_postcode', $billing_fields['billing_postcode'], '' ); ?>
							<?php if (ICL_LANGUAGE_CODE == 'ru') echo "</div>";  ?>

							<div class="ch-stage__body__errors">
								<span class="hrlsn-error"></span>
								<span data-error="city" class="ch-stage__body__error hidden">
									<?php esc_html_e( 'Delivery city is not selected.', 'hrlsn' ); ?><br>
									<?php echo str_replace('[', '<a class="red" href="mailto:'. HRLSN_OPTIONS['hrlsn_contacts_email'] .'">', str_replace(']', '</a>', esc_html__( 'Please check the address or [email us]', 'hrlsn' ))); ?>
								</span>
								<span data-error="postcode" class="ch-stage__body__error hidden"><?php esc_html_e( 'Postal code length is less that 5 digits', 'hrlsn' ); ?></span>
							</div>

							<div class="ch-stage__body__note">
								<?php echo str_replace('[', '<a href="mailto:'. HRLSN_OPTIONS['hrlsn_contacts_email'] .'">', str_replace(']', '</a>', str_replace('{', '<a href="https://'. HRLSN_OPTIONS['hrlsn_system_second_website'] .'">', str_replace('}', '</a>', esc_html__( 'If you have not found the possibility of shipping to your region, try placing an order on the international website {hrlsn.co} or [contact us]', 'hrlsn' ))))); ?>
							</div>
						</div>
					</div>

					<div class="ch-stage" data-stage="delivery">
						<div class="ch-stage__stage"><?php echo $stage_delivery_number; ?>/<?php echo $stage_overall_number; ?> <?php esc_html_e( 'Delivery method', 'hrlsn' ); ?></div>	
						<div id="delivery-methods-copy"></div>

						<ul id="shipping_method_new" class="woocommerce-shipping-methods">
							<?php $delivery_zones = WC_Shipping_Zones::get_zones();
							$index = 0;
							// add "rest of the world" zone --> start
							$zone_0 = new WC_Shipping_Zone( '0' );
							$zone_0_data = $zone_0->get_data();
							$zone_0_data['zone_id'] = $zone_0->get_id();
							$zone_0_data['formatted_zone_location'] = $zone_0->get_formatted_location();
							$zone_0_data['shipping_methods']        = $zone_0->get_shipping_methods( false );
							$delivery_zones[] = $zone_0_data;
							// add "rest of the world" zone --> end
							foreach ((array) $delivery_zones as $key => $the_zone) {
								foreach ($the_zone['shipping_methods'] as $method) {
									if ($method->enabled == 'no') continue; 
									$method->id = $method->id . ":" . $method->instance_id; ?>
									<li class="shipping_list_<?php echo esc_attr( sanitize_title( $method->id ) ); ?>">
										<label for="shipping_method_<?php echo $index; ?>_<?php echo esc_attr( sanitize_title( $method->id ) ); ?>" class="ch-stage__body__radio-lg">
											<input type="radio" name="shipping_method[<?php echo $index; ?>]" data-index="<?php echo $index; ?>" id="shipping_method_<?php echo $index; ?>_<?php echo esc_attr( sanitize_title( $method->id ) ); ?>" value="<?php echo esc_attr( $method->id ); ?>" class="shipping_method" />
											<span><?php echo $method->title; ?> <b>€0</b></span>
										</label>
										<div></div>
									</li>
								<?php }
							} ?>
						</ul>

						<div class="ch-delivery-error hidden"></div>

						<input type="hidden" name="ch-delivery-id" value="">
						<input type="hidden" name="ch-delivery-label" value="<?php esc_html_e( 'Delivery method is not selected', 'hrlsn' ); ?>">
						<input type="hidden" name="ch-delivery-price" value="">

						<div class="ch-stage__info ch-stage__info--deliverydesc">
							<span class="ch-stage__info__free_shipping hidden"><?php esc_html_e( 'You will receive an SMS from Boxberry service with the delivery interval, then a courier will call you an hour in advance.', 'hrlsn' ); ?></span>
							<span class="ch-stage__info__local_pickup hidden"><?php esc_html_e( 'This option is available only on weekdays from 11:00 to 18:00 by appointment. The order can be picked up after receiving a letter confirming it has been processed and packed. After receiving this letter please let us know about the time of your visit via email or WhatsApp.', 'hrlsn' ); ?></span>
							<span class="ch-stage__info__boxberry_self hidden"><?php esc_html_e( 'You will receive an SMS when your order is ready for pickup.', 'hrlsn' ); ?></span>
							<span class="ch-stage__info__boxberry_courier hidden"><?php esc_html_e( 'You will receive an SMS from Boxberry service with the delivery interval, then a courier will call you an hour in advance.', 'hrlsn' ); ?></span>
							<span class="ch-stage__info__bxb hidden">
								<?php esc_html_e( 'Duties and taxes applied in the country of destination are included in the price only for EU countries.', 'hrlsn' ); ?>
								<br><br>
								<?php esc_html_e( 'Delivery takes 15-20 business days on average but may take longer due to unforeseeable delays on the courier\'s end (weather, cargo loads, traffic, etc).', 'hrlsn' ); ?>
							</span>

							<span data-error="boxberry" class="ch-stage__body__error hidden"><?php esc_html_e( 'Point of issue is not selected', 'hrlsn' ); ?></span>
						</div>
					</div>

				<?php } ?>

				<div class="ch-stage <?php if ($all_items_are_virtual) { ?>ch-stage--active<?php } ?>" data-stage="details">
					<div class="ch-stage__stage"><?php echo $stage_details_number; ?>/<?php echo $stage_overall_number; ?> <?php if ($all_items_are_virtual) { esc_html_e( 'Contact data', 'hrlsn' ); } else { esc_html_e( 'Delivery details', 'hrlsn' ); } ?></div>
					<div class="ch-stage__body">
						<div class="ch-stage__body__required">
							<?php woocommerce_form_field( 'billing_first_name', $billing_fields['billing_first_name'], $checkout->get_value( 'billing_first_name' ) ); ?>
							<?php woocommerce_form_field( 'billing_last_name', $billing_fields['billing_last_name'], $checkout->get_value( 'billing_last_name' ) ); ?>
							<p class="clear"></p>
						</div>
						<div class="ch-stage__body__required">
							<?php woocommerce_form_field( 'billing_email', $billing_fields['billing_email'], $checkout->get_value( 'billing_email' ) ); ?>
						</div>
						<div class="ch-stage__body__required">
							<?php woocommerce_form_field( 'billing_phone', $billing_fields['billing_phone'], $checkout->get_value( 'billing_phone' ) ); ?>
						</div>

						<div class="ch-stage__body__required <?php if ($all_items_are_virtual) { ?>hidden<?php } ?>">
							<?php woocommerce_form_field( 'billing_address_1', $billing_fields['billing_address_1'], $checkout->get_value( 'billing_address_1' ) ); ?>
						</div>

						<div class="ch-stage__body__notrequired <?php if ($all_items_are_virtual) { ?>hidden<?php } ?>">
							<?php woocommerce_form_field( 'billing_address_2', $billing_fields['billing_address_2'], $checkout->get_value( 'billing_address_2' ) ); ?>
						</div>

						<div class="ch-stage__body__required <?php if ($all_items_are_virtual || ICL_LANGUAGE_CODE !== 'ru') { ?>hidden<?php } ?>">
							<p class="form-row form-row-wide">
								<span class="woocommerce-input-wrapper">
									<input class="suggestions-input input-text" type="text" name="hrlsn_checkout_address_field" placeholder="<?php esc_html_e( 'Enter delivery address', 'hrlsn' ); ?>" value="" autocomplete="off">
									<span class="description" id="billing_address-description" aria-hidden="true" style="display: none;">
										<span data-error="address" class="ch-stage__body__error hidden"><?php esc_html_e( 'Address is not filled', 'hrlsn' ); ?></span><span class="clear"></span>
									</span>
								</span>
							</p>
						</div>
						<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>
							<div class="ch-stage__body__not-required">
								<?php woocommerce_form_field( 'order_comments', $order_fields['order_comments'], $checkout->get_value( 'order_comments' ) ); ?>
								<span class="link link--round link--notreq"><?php esc_html_e( 'not required', 'hrlsn' ); ?></span>
							</div>
						<?php endif; ?>
						<div class="ch-stage__body__systemfields hidden">
							<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
								<div id="customer_details">
									<?php /************ billing fields ************* */ ?>
										<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>
										<div class="woocommerce-billing-fields__field-wrapper">
											<?php
											foreach ( $billing_fields as $key => $field ) {
												if (!in_array($key, $billing_fields_active)) {
													woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
												}
											}
											?>
										</div>
										<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
									<?php /********** registration ************* */ ?>
										<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
											<?php if ( ! $checkout->is_registration_required() ) : ?>
												<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?> type="checkbox" name="createaccount" value="1" />
											<?php endif; ?>
											<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>
											<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>
													<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
														<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
													<?php endforeach; ?>
											<?php endif; ?>
											<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
										<?php endif; ?>
									<?php /********** shipping fields ************* */ ?>
										<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>
											<h3 id="ship-to-different-address">
												<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
													<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php esc_html_e( 'Ship to a different address?', 'woocommerce' ); ?></span>
												</label>
											</h3>
											<div class="shipping_address">
												<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>
												<div class="woocommerce-shipping-fields__field-wrapper">
													<?php
													$fields = $checkout->get_checkout_fields( 'shipping' );
													foreach ( $fields as $key => $field ) {
														woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
													}
													?>
												</div>
												<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>
											</div>
										<?php endif; ?>
									<?php /************ before_order_notes ***********/ ?>
										<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>
										<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>
											<div class="woocommerce-additional-fields__field-wrapper">
												<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) :
													if (!in_array($key, $order_fields_active)) {
														woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
													}
												endforeach; ?>
											</div>
										<?php endif; ?>
										<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
								</div>
							<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
						</div>
					</div>
					<div class="ch-stage__info"></div>
				</div>

				<?php if (ICL_LANGUAGE_CODE == 'en') { ?>

					<div class="ch-stage" data-stage="confirmation">
						<div class="ch-stage__stage"><?php echo $stage_confirmation_number; ?>/<?php echo $stage_overall_number; ?> <?php esc_html_e( 'Confirmation', 'hrlsn' ); ?></div>
						<div class="ch-stage__body">
							<dl class="ch-stage__body__overview">
								<dt><?php esc_html_e( 'Name', 'hrlsn' ); ?></dt>
									<dd class="ch-review-name"></dd>
								<dt><?php esc_html_e( 'E-mail', 'hrlsn' ); ?></dt>
									<dd class="ch-review-email"></dd>
								<dt><?php esc_html_e( 'Phone', 'hrlsn' ); ?></dt>
									<dd class="ch-review-phone"></dd>
								<dt class="ch-review-address-title"><?php esc_html_e( 'Delivery address', 'hrlsn' ); ?></dt>
									<dd class="ch-review-address"></dd>
								<dt class="ch-review-order-cost-name hidden-desktop"><?php esc_html_e( 'Order cost', 'hrlsn' ); ?></dt>
									<dd class="ch-review-order-cost hidden-desktop"></dd>
								<dt class="ch-review-shipping-name hidden-desktop"></dt>
									<dd class="ch-review-shipping-cost hidden-desktop"></dd>
								<dt class="ch-review-coupon-name hidden-desktop hidden"></dt>
									<dd class="ch-review-coupon-cost hidden-desktop hidden"></dd>
							</dl>
						</div>
						<div class="ch-stage__info ch-stage__info--coupon hidden-desktop" style="display: none !important;">
							<div class="ch-coupon-block">
								<span class="ch-coupon-block--apply link"><?php esc_html_e( 'Do you have a coupon?', 'hrlsn' ); ?></span>
								<span class="ch-coupon-block--remove link hidden"><?php esc_html_e( 'Remove coupon', 'hrlsn' ); ?></span>
							</div>
						</div>
					</div>

					<div class="ch-stage" data-stage="payment">
						<div class="ch-stage__stage"><?php echo $stage_payment_number; ?>/<?php echo $stage_overall_number; ?> <?php esc_html_e( 'Payment', 'hrlsn' ); ?></div>
						<div class="ch-stage__info ch-stage__info--payment">
							<div class="ch-payment-block">
								<?php do_action( 'woocommerce_checkout_payment_hrlsn' ); ?>
							</div>
						</div>
					</div>

				<?php } else { ?>

					<div class="ch-stage" data-stage="payment">
						<div class="ch-stage__stage"><?php echo $stage_payment_number; ?>/<?php echo $stage_overall_number; ?> <?php esc_html_e( 'Confirmation and payment', 'hrlsn' ); ?></div>
						<div class="ch-stage__body">
							<dl class="ch-stage__body__overview">
								<dt><?php esc_html_e( 'Name', 'hrlsn' ); ?></dt>
									<dd class="ch-review-name"></dd>
								<dt><?php esc_html_e( 'E-mail', 'hrlsn' ); ?></dt>
									<dd class="ch-review-email"></dd>
								<dt><?php esc_html_e( 'Phone', 'hrlsn' ); ?></dt>
									<dd class="ch-review-phone"></dd>
								<dt class="ch-review-address-title"><?php esc_html_e( 'Delivery address', 'hrlsn' ); ?></dt>
									<dd class="ch-review-address"></dd>
								<dt class="ch-review-order-cost-name hidden-desktop"><?php esc_html_e( 'Order cost', 'hrlsn' ); ?></dt>
									<dd class="ch-review-order-cost hidden-desktop"></dd>
								<dt class="ch-review-shipping-name hidden-desktop"></dt>
									<dd class="ch-review-shipping-cost hidden-desktop"></dd>
								<dt class="ch-review-coupon-name hidden-desktop hidden"></dt>
									<dd class="ch-review-coupon-cost hidden-desktop hidden"></dd>
							</dl>
						</div>
						<div class="ch-stage__info ch-stage__info--coupon hidden-desktop">
							<div class="ch-coupon-block">
								<span class="ch-coupon-block--apply link"><?php esc_html_e( 'Do you have a coupon?', 'hrlsn' ); ?></span>
								<span class="ch-coupon-block--remove link hidden"><?php esc_html_e( 'Remove coupon', 'hrlsn' ); ?></span>
							</div>
						</div>
						<div class="ch-stage__info ch-stage__info--payment">
							<div class="ch-payment-block">
								<?php do_action( 'woocommerce_checkout_payment_hrlsn' ); ?>
							</div>
						</div>
					</div>

				<?php } ?>

				<div class="ch-sequence__nav">
					<span class="ch-sequence__nav__prev disabled">
						<i class="back-link link"><?php esc_html_e( 'Step back', 'hrlsn' ); ?></i>
					</span>
				</div>
				<div class="ch-sequence__action">
					<span class="ch-sequence__action__btn disabled">
						<i class="continue"><?php esc_html_e( 'Proceed', 'hrlsn' ); ?></i>
						<i class="register hidden"></i>
						<i class="login hidden"></i>
						<i class="choose hidden"><?php esc_html_e( 'Choose payment method', 'hrlsn' ); ?></i>
						<i class="overview hidden"><?php esc_html_e( 'Order overview', 'hrlsn' ); ?></i>
						<i class="pay hidden"><?php esc_html_e( 'Pay', 'hrlsn' ); ?> <b></b></i>
						<i class="confirm hidden"><?php esc_html_e( 'Confirm order', 'hrlsn' ); ?></i>
					</span>
				</div>

				<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

			</form>

		</div>
	</div>

	<div class="checkout-page__right">

		<?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>
		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
		<?php $checkout = WC()->checkout(); do_action( 'woocommerce_checkout_order_review' ); ?>
		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

	</div>
</div>


