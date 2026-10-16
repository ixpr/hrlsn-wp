<form id="filters-form" action="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" method="get">
    <div class="h-filters__block__params">
        <div class="h-filters__block__params__item">
            <p><?php esc_html_e( 'Categories', 'hrlsn' ); ?></p> 
            <label><input type="checkbox" data-filter-type="all" data-clear-type="category" name="cat_0" <?php if (!isset($_GET['cats']) && !$_GET['cats']) { ?>checked<?php } ?>><i>x</i><span><?php esc_html_e( 'Everything', 'hrlsn' ); ?></span></label>  
            <?php 
                if (isset($_GET['cats']) && $_GET['cats']) $getCats = explode('-', $_GET['cats']); else $getCats = [];
                $product_categories = get_terms( 'product_cat', 'hide_empty=1' );
                if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
                    foreach ( $product_categories as $category ) {
                        ?>
                        <label><input type="checkbox" data-filter-type="category" data-filter-value="<?php echo $category->term_id; ?>" name="cat_<?php echo $category->term_id; ?>" <?php if (in_array($category->term_id, $getCats)) { ?>checked<?php } ?>><i>x</i><span><?php echo esc_html( $category->name ); ?></span></label>
                        <?php
                    }
                }
            ?>
        </div>
        <div class="h-filters__block__params__item">
            <p><?php esc_html_e( 'Sort', 'hrlsn' ); ?></p>
            <?php woocommerce_catalog_ordering(); ?>
        </div>
        <?php if (HRLSN_OPTIONS['hrlsn_shop_filter_drops']) { ?>
            <div class="h-filters__block__params__item">
                <p><?php esc_html_e( 'Drops', 'hrlsn' ); ?></p> 
                <?php 
                    if (isset($_GET['tags']) && $_GET['tags']) $getTags = explode('-', $_GET['tags']); else $getTags = [];
                    $product_tags = get_terms( 'product_tag', 'hide_empty=1' );
                    if ( ! empty( $product_tags ) && ! is_wp_error( $product_tags ) ) {
                        foreach ( $product_tags as $tag ) {
                            ?>
                            <label><input type="checkbox" data-filter-type="tag" data-filter-value="<?php echo $tag->term_id; ?>" name="tag_<?php echo $tag->term_id; ?>" <?php if (in_array($tag->term_id, $getTags)) { ?>checked<?php } ?>><i>x</i><span><?php echo esc_html( $tag->name ); ?></span></label>
                            <?php
                        }
                    }
                ?>
            </div>
        <?php } ?>
    </div>
    <div class="h-filters__block__apply">
        <span>[ <i><?php esc_html_e( 'Save & close', 'hrlsn' ); ?></i> ]</span>
    </div>
    <span class="h-filters__block__close"></span>
</form>