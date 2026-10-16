<?php /* cookies - on all pages */ ?>
<div class="notice-popup cookie-notice hidden">
    <p><?php echo nl2br(HRLSN_OPTIONS['hrlsn_popups_cookies_text']); ?></p>
    <span class="cookie-notice__close">[ <span class="link" data-action="close" data-type="cookies"><?php esc_html_e( 'Accept & close', 'hrlsn' ); ?></span> ]</span>
</div>

<?php /* select location - on all pages except product */
if (ICL_LANGUAGE_CODE == 'en') 
{ 
    $countries = [];
    $countries_in = explode(',', HRLSN_OPTIONS['hrlsn_popups_location_countries_in']);
    foreach ($countries_in as $country_in) {
        $countries[trim($country_in)] = "";
    }
    $countries_out = explode(',', HRLSN_OPTIONS['hrlsn_popups_location_countries_out']);
    foreach ($countries_out as $country_out) {
        $countries[trim($country_out)] = 'https://' . HRLSN_OPTIONS['hrlsn_system_second_website'] . $_SERVER["REQUEST_URI"];
    }
    $countries[esc_html__( 'Rest of the World', 'hrlsn' )] = "";

    if (!is_product()) { ?>
        <div class="notice-popup location-notice hidden">
            <p class="notice-popup__title"><?php esc_html_e( 'Select location', 'hrlsn' ); ?></p>
            <p class="notice-popup__text"><?php echo nl2br(HRLSN_OPTIONS['hrlsn_popups_location_text']); ?></p>
            <div class="notice-popup__form">
                <form id="select-location-form" method="post">
                    <select id="select-location-url">
                        <option value=""><?php esc_html_e( 'Choose country', 'hrlsn' ); ?></option>
                        <?php foreach ($countries as $title => $value) { ?>
                            <option value="<?php echo $value; ?>"><?php echo $title; ?></option>
                        <?php } ?>
                    </select>
                    <button class="inline" type="submit">[ <span class="link"><?php esc_html_e( 'Proceed', 'hrlsn' ); ?></span> ]</button>
                </form>
            </div>
            <span class="notice-popup__close" data-action="close" data-type="location"></span>
        </div>
    <?php } 
} ?>

<?php /* subscription - on product pages */
if (is_product()) { ?>
    <div class="notice-popup subscribe-notice hidden">
        <p class="notice-popup__title"><?php esc_html_e( 'Subscription', 'hrlsn' ); ?></p>
        <p class="notice-popup__text"><?php echo nl2br(HRLSN_OPTIONS['hrlsn_popups_subscription_text']); ?></p>
        <div class="notice-popup__form">
            <?php echo do_shortcode('[newsletter_form type="minimal"]'); ?>
            <?php /*
            <form id="subscription-form">
                <input type="email" id="subscription-email" placeholder="<?php esc_html_e( 'Enter email', 'hrlsn' ); ?>">
                <button class="inline" type="submit">[ <span class="link"><?php esc_html_e( 'Subscribe', 'hrlsn' ); ?></span> ]</button>
            </form>
            */?>
        </div>
        <p class="notice-popup__note"><?php esc_html_e( 'Proceeding here you agree to the use a personal data', 'hrlsn' ); ?></p>
        <span class="notice-popup__close" data-action="close" data-type="subscribe"></span>
    </div>
<?php } ?>

<?php /* backorder description */ ?>
<div class="notice-popup backorder-notice hidden">
    <p class="notice-popup__title"><?php esc_html_e( 'Pre-order', 'hrlsn' ); ?></p>
    <p class="notice-popup__text notice-popup__text--short"><?php esc_html_e( 'A pre-order function is available for this product, which means that the product is out of stock, but we are ready to make it especially for you and ship it within 30 days from the date of order.', 'hrlsn' ); ?></p>
    <span class="backorder-notice__close">[ <span class="link" data-action="close" data-type="backorder"><?php esc_html_e( 'Close', 'hrlsn' ); ?></span> ]</span>
</div>

<?php /* backorder description CHECKOUT */ ?>
<div class="notice-popup backorder-notice-checkout hidden">
    <p class="notice-popup__title"><?php esc_html_e( 'Pre-order', 'hrlsn' ); ?></p>
    <p class="notice-popup__text notice-popup__text--short"><?php esc_html_e( 'A pre-order function is available for at least one of the products in the cart, which means that it is out of stock, but we are ready to make it especially for you and ship it within 30 days from the date of order.', 'hrlsn' ); ?></p>
    <span class="backorder-notice__close">[ <span class="link" data-action="place-order"><?php esc_html_e( 'Place order', 'hrlsn' ); ?></span> ]</span>
</div>

<?php /* added to cart */ ?>
<div class="added-to-cart-popup hidden">
    <div class="added-to-cart-popup__desc">
        <p>
            <?php esc_html_e( 'Thanks! Item added to cart.', 'hrlsn' ); ?><br>
            <?php esc_html_e( 'You can finish the order or continue shopping', 'hrlsn' ); ?>
        </p>
    </div>
    <div class="added-to-cart-popup__link">
        <a class="hidden-link" href="<?php echo get_permalink( wc_get_page_id( 'cart' ) ); ?>">[ <span class="link"><?php esc_html_e( 'Check cart', 'hrlsn' ); ?></span> ]</a>
    </div>
    <span class="added-to-cart-popup__close"></span>
</div>

<?php /* welcome */ ?>
<?php if (HRLSN_OPTIONS['hrlsn_popups_welcome_enable']) { ?>
    <div class="notice-popup welcome-notice hidden">
        <p class="notice-popup__title"><?php echo HRLSN_OPTIONS['hrlsn_popups_welcome_heading']; ?></p>
        <div class="notice-popup__text"><?php echo nl2br(HRLSN_OPTIONS['hrlsn_popups_welcome_text']); ?></div>
        <span class="welcome-notice__close">[ <span class="link" data-action="close" data-type="welcome"><?php esc_html_e( 'Okay', 'hrlsn' ); ?></span> ]</span>
        <span class="welcome-notice__close_top" data-action="close" data-type="welcome"></span>
    </div>
<?php } ?>