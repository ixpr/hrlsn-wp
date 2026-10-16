<?php /* Template Name: Brand Template */ ?>
<?php get_header();

$content = get_the_content(); 
$requisites = nl2p(HRLSN_OPTIONS['hrlsn_contacts_requisites']);

if (has_post_thumbnail( $post->ID ) ) {
    $imageArr = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
    $image = '<img src="'. $imageArr[0] .'" width="'. $imageArr[1] .'" height="'. $imageArr[2] .'" alt="'. get_the_title() .'">';
}
?>
    <main class="container">
        <article class="brand-page">
            <div class="brand-page__content">
                <?php the_title( '<h1>', '</h1>' ); ?>
                <div class="brand-page__content__main">
                    <?php echo $content; ?>
                </div>
                <div class="brand-page__content__image">
                    <?php echo $image; ?>
                </div>
                <div class="brand-page__content__links">
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
                <div class="brand-page__content__req">
                    <div class="cross-styled">
                        <?php echo $requisites; ?>
                    </div>
                </div>
            </div>
            <div class="brand-page__image">
                <?php echo $image; ?>
            </div>
        </article>
    </main>
<?php
get_footer(); ?>