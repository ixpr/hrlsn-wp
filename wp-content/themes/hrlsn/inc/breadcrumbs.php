<?php 
$breadcrumbs = [
    'hrlsn' => esc_url( home_url( '/' ) )
];
// mainpage
if (is_front_page()) {
    $breadcrumbs[esc_html__( 'Index', 'hrlsn' )] = '';
// shop
} else if (is_shop()) {
    $breadcrumbs[esc_html__( 'Shop', 'hrlsn' )] = '';
// product | cart | checkout
} else if (is_product() || is_cart() || is_checkout()) {
    $breadcrumbs[esc_html__( 'Shop', 'hrlsn' )] = get_permalink( wc_get_page_id( 'shop' ) );
    $breadcrumbs[get_the_title()] = '';
// 404
} else if (is_404()) {
    $breadcrumbs[esc_html__( '404', 'hrlsn' )] = '';
// all other cases
} else {
    $breadcrumbs[get_the_title()] = '';
}

$qty = count($breadcrumbs);
$i = 0;
?>
<ul>
    <?php foreach ($breadcrumbs as $title => $link) { 
        if ($link && $qty > $i) { ?>
            <li><a href="<?php echo $link; ?>"><?php echo $title; ?></a></li>
        <?php } else { ?>
            <li><span><?php echo $title; ?></span></li>
        <?php } 
        $i++; ?>
    <?php } ?>
</ul>

<?php // dynamic_sidebar( 'breadcrumbs-area' ); ?>