<?php
$tax_query[] = array(
    'taxonomy' => 'product_visibility',
    'field'    => 'name',
    'terms'    => 'featured',
    'operator' => 'IN',
);

$query = new WP_Query( array(
    'post_type'           => 'product',
    'post_status'         => 'publish',
    'ignore_sticky_posts' => 1,
    'posts_per_page'      => 5,
    'orderby'             => 'date',
    'order'               => 'desc',
    'tax_query'           => $tax_query
) );

$randomIds = [];
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
        $randomIds[] = get_the_ID();
	}
}

wp_reset_postdata();
?>
<section class="mp-randomitems">
    <h3><?php esc_html_e( 'Random items', 'hrlsn' ); ?></h3>
    <div class="mp-randomitems__list">
        <ul class="prod-list prod-list--mp">
            <?php foreach ($randomIds as $randomId) { 
                $product = wc_get_product( $randomId ); ?>
                <li class="prod-list__item">
                    <div class="prod-list__item__image">
                        <a href="<?php echo $product->get_permalink(); ?>">
                            <?php echo $product->get_image('thumbnail'); ?>
                        </a>
                    </div>
                    <div class="prod-list__item__name">
                        <a href="<?php echo $product->get_permalink(); ?>"><?php echo $product->get_name(); ?></a>
                    </div>
                    <div class="prod-list__item__form">
                        <div class="prod-list__item__form__price">
                            <?php echo $product->get_price_html(); ?>
                        </div>
                    </div>
                </li>
            <?php } ?>
            <li class="prod-list__item mp-randomitems__list__all">
                <div class="prod-list__item__image">
                    <a class="forward-link" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
                        <div class="prod-list__item__form__price">
                            <span><?php esc_html_e( 'Shop all', 'hrlsn' ); ?></span>
                        </div>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</section>