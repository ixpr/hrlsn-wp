<?php
$instagramLink = HRLSN_OPTIONS['hrlsn_social_instagram'];
$youtubeLink = HRLSN_OPTIONS['hrlsn_social_youtube'];
?>
    <footer>
        <div class="container">
            <div class="f-wrapper">
                <div class="f-copyright">
                    <p>© harlson, 2022–<?php echo date('Y'); ?></p>
                    <p>all rights reserved</p>
                </div>
                <div class="f-menu">
                    <?php wp_nav_menu([
                        'theme_location' => 'menu-footer',
                        'menu_id'        => 'footer-menu',
                    ]); ?>
                </div>
                <div class="f-social">
                    <ul class="f-social__links">
                        <li class="f-social__links__icon f-social__links__icon--instagram"><a href="<?php echo $instagramLink; ?>" target="_blank" rel="nofollow"></a></li>
                        <li class="f-social__links__icon f-social__links__icon--youtube"><a href="<?php echo $youtubeLink; ?>" target="_blank" rel="nofollow"></a></li>
                    </ul>
                </div>
            </div>
            <div class="f-logo">
                <a class="logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"></a>
            </div>
        </div>

        <?php echo get_template_part('inc/popups'); ?>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>