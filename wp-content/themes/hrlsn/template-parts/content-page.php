<?php
/**
 * Template part for displaying page content in page.php
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package agami_2021
 */

if (is_cart() || is_checkout()) 
{
    the_content();
} 
else 
{
    $content = get_the_content(); 
    $content_arr = preg_split('/<hr[^>]*>/', $content);
    $content_page_type = get_post_meta(get_the_ID(), 'content_page_type', true);
?>
    <div class="container">
        <article class="care-page text-page">
            <div class="text-page__left">
                <?php echo $content_arr[0]; ?>
            </div>
            <div class="text-page__right">
                <?php switch ($content_page_type) {
                    case 'care':
                    case 'care_ru': ?>
                        <p class="cross-styled">
                            <?php echo str_replace('and', '<br> and', str_replace('и', '<br> и', esc_html__( 'Collaborations, publications, shootings and customer support', 'hrlsn' ))); ?>: 
                            <?php echo getEmailLink(); ?>
                        </p>
                        <p class="cross-styled"><?php echo getWhatsappLink(); ?></p>
                    <?php break;

                    case 'terms': ?>
                        <p class="cross-styled">
                            <?php echo str_replace('and', '<br> and', esc_html__( 'Collaborations, publications, shootings and customer support', 'hrlsn' )); ?>: 
                            <?php echo getEmailLink(); ?>
                        </p>
                        <p class="cross-styled"><?php echo getWhatsappLink(); ?></p>
                        <div class="cross-styled paragraph">
                            <?php wp_nav_menu([
                                'theme_location' => 'menu-additional',
                                'menu_id'        => 'additional-menu',
                                'container' 	 => false,
                            ]); ?>
                        </div>
                    <?php break;
                    
                    default:
                        break;
                } ?>
                <?php if ($content_page_type == 'care_ru') { ?>
                    <div class="site-link-padd-block">
                        <?php echo $content_arr[1]; ?>
                        <div class="site-link">
                            <span><?php echo getSecondWebsiteLink(); ?></span>
                        </div>
                    </div>
                <?php } else { ?>
                    <?php echo $content_arr[1]; ?>
                <?php } ?>
            </div>
        </article>
    </div>

    <section class="prod-similaritems">
        <div class="container">
            <h3><?php esc_html_e( 'Random items', 'hrlsn' ); ?></h3>
            <div class="prod-similaritems__list">
                <?php echo do_shortcode('[recent_products per_page="4" columns="4" orderby="rand" order="rand"]'); ?>
            </div>
        </div>
    </section>
<?php
}
