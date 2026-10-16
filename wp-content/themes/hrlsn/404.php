<?php
get_header();

$requisites = nl2p(HRLSN_OPTIONS['hrlsn_contacts_requisites']);
?>

	<main class="page-404">
        <div class="page-404__wrapper">
            <h1><?php esc_html_e( '404_some error happened_sorry', 'agami_2021' ); ?></h1>
            <h2><?php echo str_replace('sorry', ' sorry', esc_html__( '404_some error happened_sorry', 'agami_2021' )); ?></h2>
            <p class="page-404__shoplink"><a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"><?php esc_html_e( 'Shop', 'agami_2021' ); ?></a></p>
            <div class="page-404__content">
                <div class="page-404__content__links">
                    <div class="cross-styled">
                        <?php wp_nav_menu([
                            'theme_location' => 'menu-additional',
                            'menu_id'        => 'additional-menu',
                            'container' 	 => false
                        ]); ?>
                    </div>
                    <p><?php echo getEmailLink(esc_html__( 'Customer support', 'hrlsn' )); ?></p>
                    <p><?php echo getWhatsappLink(); ?></p>
                </div>
                <div class="page-404__content__req">
                    <div class="cross-styled">
                        <?php echo $requisites; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
		
<?php
get_footer();