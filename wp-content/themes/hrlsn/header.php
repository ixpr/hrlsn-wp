<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<header>
		<?php echo get_template_part('inc/ticker'); ?>

        <div class="h-main <?php if (is_front_page()) { ?>h-main--mp<?php } ?>">
            <div class="h-logo">
                <a class="logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"></a>
            </div>
            <div class="h-mainmenu">
				<?php wp_nav_menu([
					'theme_location' => 'menu-header',
					'menu_id'        => 'primary-menu',
				]); ?>
            </div>
            <div class="h-breadcrumbs-filters">
                <div class="h-breadcrumbs <?php if (is_shop() || is_product()) { ?>h-breadcrumbs--catalog<?php } else if (is_front_page()) { ?>h-breadcrumbs--mp<?php } ?>">
                    <?php echo get_template_part('inc/breadcrumbs'); ?>
                </div>
				<?php if (is_shop()) { ?>
					<div class="h-filters">
						<ul>
							<li class="h-filters__filters">
                                <span><i><?php echo str_replace(' &amp; ', '</i> & <i>', esc_html__( 'Filters & sort', 'hrlsn' )); ?></i></span>
                            </li>
						</ul>
						<div class="h-filters__block hidden">
                            <?php echo get_template_part('inc/filters'); ?>
						</div>
					</div>
				<?php } ?>
            </div>
            <div class="h-mobmenu-link">
                <span><?php esc_html_e( 'Menu', 'hrlsn' ); ?></span>
            </div>
            <div class="h-links">
                <ul>
                    <li class="h-links__cart <?php if (is_cart()) {?>h-links__cart--active<?php } ?>"><a href="<?php echo get_permalink( wc_get_page_id( 'cart' ) ); ?>"><?php esc_html_e( 'Cart', 'hrlsn' ); ?> (<i><?php echo getCartQty(); ?></i>)</a></li>
                    <li class="h-links__search"><span><?php esc_html_e( 'Search', 'hrlsn' ); ?></span></li>
                    <li class="h-links__search-close"><span>[ <i class="link"><?php esc_html_e( 'Close', 'hrlsn' ); ?></i> ]</span></li>
                    <?php if (is_checkout() && empty( is_wc_endpoint_url('order-received') )): ?>
                        <li class="h-links__cart-link"><a href="<?php echo get_permalink( wc_get_page_id( 'cart' ) ); ?>">[<?php esc_html_e( 'Edit order', 'hrlsn' ); ?>]</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="h-search h-search--desktop">
            <p class="h-search__title"><?php esc_html_e( 'Shop search', 'hrlsn' ); ?></p>
            <div class="h-search__form">
                <form action="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" method="get">
                    <div class="h-search__form__input">
                        <input type="text" name="s" placeholder="<?php esc_html_e( 'Enter your request', 'hrlsn' ); ?>" value="<?php echo $_GET['s']; ?>">
                    </div>
                    <div class="h-search__form__submit">
                        <button type="submit">[ <i class="link"><?php esc_html_e( 'Search', 'hrlsn' ); ?></i> ]</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="h-mobmenu">
            <div class="h-mobmenu__wrapper">
                <div class="h-mobmenu__header">
                    <a class="h-mobmenu__header__logo" href="/"></a>
                    <span class="h-mobmenu__header__close">[<?php esc_html_e( 'Close menu', 'hrlsn' ); ?>]</span>
                </div>
                <div class="h-mobmenu__main">
					<?php wp_nav_menu([
						'theme_location' => 'menu-mobile-1',
						'menu_id'        => 'mobile-menu-1',
					]); ?>
                    <ul>
                        <li class="h-mobmenu__main__cart"><a href="<?php echo get_permalink( wc_get_page_id( 'cart' ) ); ?>"><?php esc_html_e( 'Cart', 'hrlsn' ); ?> (<i><?php echo getCartQty(); ?></i>)</a></li>
                    </ul>
                </div>
                <div class="h-mobmenu__footer">
                    <p class="cross-styled"><span class="link search-moblink"><?php esc_html_e( 'Search', 'hrlsn' ); ?></span></p>
					<?php wp_nav_menu([
						'theme_location' => 'menu-additional',
						'menu_id'        => 'additional-menu',
						'container' 	 => false
					]); ?>
                    <p><?php echo getWhatsappLink(); ?></p>
                </div>
                <div class="h-search h-search--mobile">
                    <p class="h-search__title"><?php esc_html_e( 'Shop search', 'hrlsn' ); ?></p>
                    <div class="h-search__form">
                        <form action="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" method="get">
                            <div class="h-search__form__input">
                                <input type="text" name="s" placeholder="<?php esc_html_e( 'Enter your request', 'hrlsn' ); ?>" value="<?php echo $_GET['s']; ?>">
                            </div>
                            <div class="h-search__form__submit">
                                <button type="submit">[ <i class="link"><?php esc_html_e( 'Search', 'hrlsn' ); ?></i> ]</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

		<?php if (is_front_page()) :
			echo get_template_part('inc/banners');
		endif; ?>
    </header>