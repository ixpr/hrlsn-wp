<?php
/**
 * Hrlsn functions and definitions
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package hrlsn
 */

if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0' );
}

define( 'HRLSN_OPTIONS', get_option( 'hrlsn_options' ) );

if ( ! function_exists( 'hrlsn_setup' ) ) :
	function hrlsn_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'hrlsn', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-header' => esc_html__( 'Primary', 'hrlsn' ),
				'menu-mobile-1' => esc_html__( 'Mobile', 'hrlsn' ),
				'menu-additional' => esc_html__( 'Additonal', 'hrlsn' ),
				'menu-footer' => esc_html__( 'Footer', 'hrlsn' ),
			)
		);

		// register post types
		add_action( 'init', 'register_hrlsn_post_types' );
		function register_hrlsn_post_types() {
			// mp-banners
			register_post_type( 'mp-banners', [
				'label'               => esc_html__( 'Banners', 'hrlsn' ),
				'labels'              => array(
					'name'          => esc_html__( 'Banners', 'hrlsn' ),
					'singular_name' => esc_html__( 'Banner', 'hrlsn' ),
					'menu_name'     => esc_html__( 'Banners', 'hrlsn' ),
					'all_items'     => esc_html__( 'All banners', 'hrlsn' ),
					'add_new'       => esc_html__( 'Add banner', 'hrlsn' ),
					'add_new_item'  => esc_html__( 'Add new banner', 'hrlsn' ),
					'edit'          => esc_html__( 'Edit', 'hrlsn' ),
					'edit_item'     => esc_html__( 'Edit banner', 'hrlsn' ),
					'new_item'      => esc_html__( 'New banner', 'hrlsn' ),
				),
				'public'              => true,
				'has_archive'         => false,
				'menu_icon' 		  => 'dashicons-format-video',
				'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
			] );
			// collections
			register_post_type( 'ticker', [
				'label'               => esc_html__( 'Ticker', 'hrlsn' ),
				'labels'              => array(
					'name'          => esc_html__( 'Ticker', 'hrlsn' ),
					'singular_name' => esc_html__( 'Ticker', 'hrlsn' ),
					'menu_name'     => esc_html__( 'Ticker', 'hrlsn' )
				),
				'public'              => true,
				'has_archive'         => false,
				'show_in_menu'        => true,
				'hierarchical'        => false,
				'rewrite'             => array( 'with_front'=>false, 'pages'=>false, 'feeds'=>false, 'feed'=>false ),
				'has_archive'         => 'collections',
				'menu_icon' 		  => 'dashicons-controls-volumeon',
				'show_in_rest' 		  => true,
				'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			] );
		}

		// add metaboxes
		add_action('add_meta_boxes', 'banners_videos_add_custom_box');
		function banners_videos_add_custom_box(){
			$screens = array( 'mp-banners' );
			add_meta_box( 'banners_videos', esc_html__( 'Video', 'hrlsn' ), 'banners_videos_meta_box_callback', $screens );
		}

		function banners_videos_meta_box_callback( $post, $meta ){
			$screens = $meta['args'];
			wp_nonce_field( plugin_basename(__FILE__), 'banners_videos_noncename' );
			$value = get_post_meta( $post->ID, 'banners_video_file', 1 );
			echo '<label for="banners_video_field">' . esc_html__( 'Link to video file', 'hrlsn' ) . ':</label> ';
			echo '<input type="text" id="banners_video_file" name="banners_video_file" value="'. $value .'" size="80" />';
		}

		add_action( 'save_post', 'banners_videos_save_postdata' );
		function banners_videos_save_postdata( $post_id ) {
			if ( ! isset( $_POST['banners_video_file'] ) )
				return;
			if ( ! wp_verify_nonce( $_POST['banners_videos_noncename'], plugin_basename(__FILE__) ) )
				return;
			if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
				return;
			if( ! current_user_can( 'edit_post', $post_id ) )
				return;
			$video_data = sanitize_text_field( $_POST['banners_video_file'] );
			update_post_meta( $post_id, 'banners_video_file', $video_data );
		}

		/*
		 * Switch default core markup for search form, comment form, and comments to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		add_theme_support('woocommerce');

		add_theme_support('category-thumbnails');
	}
endif;
add_action( 'after_setup_theme', 'hrlsn_setup' );

/**
 * Register widget area.
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hrlsn_widgets_init() {
	register_sidebar( 
		array(
			'name'          => esc_html__( 'Subscription', 'hrlsn' ),
			'id'            => 'subscription-area',
			'description'   => esc_html__( 'Subscription Area', 'hrlsn' ),
			'class'         => '',
			'before_widget' => '<div id="%1$s" class="widget widget-filter %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) 
	);
}
add_action( 'widgets_init', 'hrlsn_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function hrlsn_scripts() {
	$new_version = mt_rand(100, 150000);
	// styles
	wp_enqueue_style( 'hrlsn-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'hrlsn-mainstyles', get_template_directory_uri() . '/assets/css/styles.min.css', array(), $new_version );
	// scripts
	wp_enqueue_script( 'hrlsn-slick', get_template_directory_uri() . '/assets/js/slick.min.js', array(), _S_VERSION, true );
	// wp_enqueue_script( 'hrlsn-cookies', get_template_directory_uri() . '/assets/js/cookie.min.js' , array(),  _S_VERSION, true);
	wp_enqueue_script( 'hrlsn-mainscripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), $new_version, true );
	wp_localize_script( 'hrlsn-mainscripts', 'myajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'hrlsn_scripts' );

/**
 * Add classes to body
 */
function hrlsn_body_classes( $classes ) {
	if (is_front_page()) {
		$classes[] = 'mainpage';
	}
	if (is_shop() || is_product()) {
		$classes[] = 'catalog';
	}
	if (is_search()) {
		$classes[] = 'search';
	}
	if (is_cart()) {
		$classes[] = 'cart';
	}
	if (is_checkout() && empty( is_wc_endpoint_url('order-received'))) {
		$classes[] = 'checkout';
	}
    return $classes;
}
add_filter( 'body_class','hrlsn_body_classes' );

/**
 * custom option and settings
 */
function hrlsn_settings_init() {
	register_setting( 'hrlsn', 'hrlsn_options' );

	// contacts section
	add_settings_section(
		'hrlsn_section_contacts',
		__( 'Contacts', 'hrlsn' ), 'hrlsn_section_callback',
		'hrlsn'
	);

	add_settings_field(
		'hrlsn_contacts_email',
		__( 'Email', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_contacts',
		array(
			'label_for'         => 'hrlsn_contacts_email',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field(
		'hrlsn_contacts_whatsapp',
		__( 'Whatsapp', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_contacts',
		array(
			'label_for'         => 'hrlsn_contacts_whatsapp',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field( 
		'hrlsn_contacts_requisites',
		__( 'Requisites', 'hrlsn' ),
		'hrlsn_section_cb_textarea_requisites', 
		'hrlsn', 
		'hrlsn_section_contacts',
		array(
			'label_for'         => 'hrlsn_contacts_requisites',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);

	// social section
	add_settings_section(
		'hrlsn_section_social',
		__( 'Social', 'hrlsn' ), 'hrlsn_section_callback',
		'hrlsn'
	);

	add_settings_field(
		'hrlsn_social_instagram',
		__( 'Instagram', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_social',
		array(
			'label_for'         => 'hrlsn_social_instagram',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field(
		'hrlsn_social_youtube',
		__( 'Youtube', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_social',
		array(
			'label_for'         => 'hrlsn_social_youtube',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);

	// banners section
	add_settings_section(
		'hrlsn_section_mp_banners',
		__( 'Banners on mainpage', 'hrlsn' ), 'hrlsn_section_callback',
		'hrlsn'
	);

	add_settings_field(
		'hrlsn_field_heading_line_1',
		__( 'Heading Line 1', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_mp_banners',
		array(
			'label_for'         => 'hrlsn_field_heading_line_1',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field(
		'hrlsn_field_heading_line_2',
		__( 'Heading Line 2', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_mp_banners',
		array(
			'label_for'         => 'hrlsn_field_heading_line_2',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field(
		'hrlsn_field_text_line_1_item_1',
		__( 'Text Line 1 Item 1', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_mp_banners',
		array(
			'label_for'         => 'hrlsn_field_text_line_1_item_1',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field(
		'hrlsn_field_text_line_1_item_2',
		__( 'Text Line 1 Item 2', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_mp_banners',
		array(
			'label_for'         => 'hrlsn_field_text_line_1_item_2',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field(
		'hrlsn_field_text_line_1_item_3',
		__( 'Text Line 1 Item 3', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_mp_banners',
		array(
			'label_for'         => 'hrlsn_field_text_line_1_item_3',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field(
		'hrlsn_field_text_line_1_item_4',
		__( 'Text Line 1 Item 4', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_mp_banners',
		array(
			'label_for'         => 'hrlsn_field_text_line_1_item_4',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field(
		'hrlsn_field_text_line_2_item_1',
		__( 'Text Line 2 Item 1', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_mp_banners',
		array(
			'label_for'         => 'hrlsn_field_text_line_2_item_1',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field(
		'hrlsn_field_text_line_2_item_2',
		__( 'Text Line 2 Item 2', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_mp_banners',
		array(
			'label_for'         => 'hrlsn_field_text_line_2_item_2',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field(
		'hrlsn_field_text_line_2_item_2_link',
		__( 'Text Line 2 Item 2 Link', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_mp_banners',
		array(
			'label_for'         => 'hrlsn_field_text_line_2_item_2_link',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);

	//  shop section
	add_settings_section(
		'hrlsn_section_shop',
		__( 'Shop', 'hrlsn' ), 'hrlsn_section_callback',
		'hrlsn'
	);

	add_settings_field(
		'hrlsn_shop_filter_drops',
		__( 'Drops in filter', 'hrlsn' ),
		'hrlsn_section_cb_checkbox',
		'hrlsn',
		'hrlsn_section_shop',
		array(
			'label_for'         => 'hrlsn_shop_filter_drops',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);

	add_settings_field(
		'hrlsn_shop_free_shipping_from',
		__( 'Free shipping from (EUR)', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_shop',
		array(
			'label_for'         => 'hrlsn_shop_free_shipping_from',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);

	// product section
	/*add_settings_section(
		'hrlsn_section_product',
		__( 'Product', 'hrlsn' ), 'hrlsn_section_callback',
		'hrlsn'
	);

	add_settings_field( 
		'hrlsn_product_sizechart',
		__( 'Size chart', 'hrlsn' ),
		'hrlsn_section_cb_textarea_sizechart', 
		'hrlsn', 
		'hrlsn_section_product',
		array(
			'label_for'         => 'hrlsn_product_sizechart',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);*/

	// popups section
	add_settings_section(
		'hrlsn_section_popups',
		__( 'Popups', 'hrlsn' ), 'hrlsn_section_callback',
		'hrlsn'
	);

	add_settings_field(
		'hrlsn_popups_welcome_enable',
		__( 'Enable Welcome announcement', 'hrlsn' ),
		'hrlsn_section_cb_checkbox',
		'hrlsn',
		'hrlsn_section_popups',
		array(
			'label_for'         => 'hrlsn_popups_welcome_enable',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field(
		'hrlsn_popups_welcome_heading',
		__( 'Welcome announcement heading', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_popups',
		array(
			'label_for'         => 'hrlsn_popups_welcome_heading',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field( 
		'hrlsn_popups_welcome_text',
		__( 'Welcome announcement text', 'hrlsn' ),
		'hrlsn_section_cb_textarea_welcome', 
		'hrlsn', 
		'hrlsn_section_popups',
		array(
			'label_for'         => 'hrlsn_popups_welcome_text',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);

	add_settings_field( 
		'hrlsn_popups_cookies_text',
		__( 'Cookies text', 'hrlsn' ),
		'hrlsn_section_cb_textarea_cookies', 
		'hrlsn', 
		'hrlsn_section_popups',
		array(
			'label_for'         => 'hrlsn_popups_cookies_text',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field( 
		'hrlsn_popups_location_text',
		__( 'Select location text', 'hrlsn' ),
		'hrlsn_section_cb_textarea_location', 
		'hrlsn', 
		'hrlsn_section_popups',
		array(
			'label_for'         => 'hrlsn_popups_location_text',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field(
		'hrlsn_popups_location_countries_in',
		__( 'Location countries - leading to THIS website (comma sep.)', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_popups',
		array(
			'label_for'         => 'hrlsn_popups_location_countries_in',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field(
		'hrlsn_popups_location_countries_out',
		__( 'Location countries - leading to the 2ND website (comma sep.)', 'hrlsn' ),
		'hrlsn_section_cb',
		'hrlsn',
		'hrlsn_section_popups',
		array(
			'label_for'         => 'hrlsn_popups_location_countries_out',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	add_settings_field( 
		'hrlsn_popups_subscription_text',
		__( 'Subscription text', 'hrlsn' ),
		'hrlsn_section_cb_textarea_subscription', 
		'hrlsn', 
		'hrlsn_section_popups',
		array(
			'label_for'         => 'hrlsn_popups_subscription_text',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
	
	// system section
	add_settings_section(
		'hrlsn_section_system',
		__( 'System', 'hrlsn' ), 'hrlsn_section_callback',
		'hrlsn'
	);

	add_settings_field( 
		'hrlsn_system_second_website',
		__( 'Second website', 'hrlsn' ),
		'hrlsn_section_cb', 
		'hrlsn', 
		'hrlsn_section_system',
		array(
			'label_for'         => 'hrlsn_system_second_website',
			'class'             => 'hrlsn_row',
			'hrlsn_custom_data' => 'custom',
		)
	);
}

/**
 * Register our hrlsn_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'hrlsn_settings_init' );


/**
 * Custom option and settings:
 *  - callback functions
 */

function hrlsn_section_callback( $args ) {
}

function hrlsn_section_cb( $args ) {
	$options = get_option( 'hrlsn_options' );
	?>
	<input type="text" size="50" name="hrlsn_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr($options[ $args['label_for'] ]); ?>">
	<?php
}

function hrlsn_section_cb_checkbox( $args ) {
	$options = get_option( 'hrlsn_options' );
	?>
	<input type="checkbox" id="hrlsn_options[<?php echo esc_attr( $args['label_for'] ); ?>]" name="hrlsn_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="1" <?php echo checked( 1, esc_attr($options[ $args['label_for'] ]), false ); ?>>
	<?php
}

function hrlsn_section_cb_textarea_requisites() {
    $options = get_option( 'hrlsn_options', array() );
    $content = isset( $options['hrlsn_contacts_requisites'] ) ?  $options['hrlsn_contacts_requisites'] : false;
    wp_editor( $content, 'hrlsn_contacts_requisites', array( 
        'textarea_name' => 'hrlsn_options[hrlsn_contacts_requisites]',
        'media_buttons' => false,
    ) );
}

/*function hrlsn_section_cb_textarea_sizechart() {
    $options = get_option( 'hrlsn_options', array() );
    $content = isset( $options['hrlsn_product_sizechart'] ) ?  $options['hrlsn_product_sizechart'] : false;
    wp_editor( $content, 'hrlsn_product_sizechart', array( 
        'textarea_name' => 'hrlsn_options[hrlsn_product_sizechart]',
        'media_buttons' => false,
    ) );
}*/

function hrlsn_section_cb_textarea_welcome() {
    $options = get_option( 'hrlsn_options', array() );
    $content = isset( $options['hrlsn_popups_welcome_text'] ) ?  $options['hrlsn_popups_welcome_text'] : false;
    wp_editor( $content, 'hrlsn_popups_welcome_text', array( 
        'textarea_name' => 'hrlsn_options[hrlsn_popups_welcome_text]',
        'media_buttons' => false,
    ) );
}

function hrlsn_section_cb_textarea_cookies() {
    $options = get_option( 'hrlsn_options', array() );
    $content = isset( $options['hrlsn_popups_cookies_text'] ) ?  $options['hrlsn_popups_cookies_text'] : false;
    wp_editor( $content, 'hrlsn_popups_cookies_text', array( 
        'textarea_name' => 'hrlsn_options[hrlsn_popups_cookies_text]',
        'media_buttons' => false,
    ) );
}

function hrlsn_section_cb_textarea_location() {
    $options = get_option( 'hrlsn_options', array() );
    $content = isset( $options['hrlsn_popups_location_text'] ) ?  $options['hrlsn_popups_location_text'] : false;
    wp_editor( $content, 'hrlsn_popups_location_text', array( 
        'textarea_name' => 'hrlsn_options[hrlsn_popups_location_text]',
        'media_buttons' => false,
    ) );
}

function hrlsn_section_cb_textarea_subscription() {
    $options = get_option( 'hrlsn_options', array() );
    $content = isset( $options['hrlsn_popups_subscription_text'] ) ?  $options['hrlsn_popups_subscription_text'] : false;
    wp_editor( $content, 'hrlsn_popups_subscription_text', array( 
        'textarea_name' => 'hrlsn_options[hrlsn_popups_subscription_text]',
        'media_buttons' => false,
    ) );
}

/**
 * Add the top level menu page.
 */
function hrlsn_options_page() {
	add_menu_page(
		'HRLSN',
		__( 'HRLSN Options', 'hrlsn' ),
		'manage_options',
		'hrlsn',
		'hrlsn_options_page_html',
		false,
		85
	);
}

/**
 * Register our hrlsn_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'hrlsn_options_page' );

/**
 * Top level menu callback function
 */
function hrlsn_options_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// add error/update messages

	// check if the user have submitted the settings
	// WordPress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'hrlsn_messages', 'hrlsn_message', __( 'Settings Saved', 'hrlsn' ), 'updated' );
	}

	// show error/update messages
	settings_errors( 'hrlsn_messages' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			// output security fields for the registered setting "hrlsn"
			settings_fields( 'hrlsn' );
			// output setting sections and their fields
			// (sections are registered for "hrlsn", each field is registered to a specific section)
			do_settings_sections( 'hrlsn' );
			// output save settings button
			submit_button( __( 'Save Settings', 'hrlsn' ) );
			?>
		</form>
	</div>
	<?php
}

/**
 * Shortcode functions
 */

function getWhatsappLink() {
	$code = '<a href="https://wa.me/'. HRLSN_OPTIONS['hrlsn_contacts_whatsapp'] .'" target="_blank" rel="nofollow">'. esc_html__( 'Online chat (whatsapp)', 'hrlsn' ) .'</a>';

	return $code;
}

function getEmailLink($linkTitle = false) {
	if (!$linkTitle) $linkTitle = HRLSN_OPTIONS['hrlsn_contacts_email'];
	$code = '<a href="mailto:'. HRLSN_OPTIONS['hrlsn_contacts_email'] .'">'. $linkTitle .'</a>';

	return $code;
}

function getSecondWebsiteLink() {
	$code = '<a href="https://'. HRLSN_OPTIONS['hrlsn_system_second_website'] .'" target="_blank" rel="nofollow">'. HRLSN_OPTIONS['hrlsn_system_second_website'] .'</a>';

	return $code;
}

/**
 * WC Custom currency symbol
 */
function hrlsn_currency_symbol( $currency_symbol, $currency ) {
	switch( $currency ) {
		case 'RUB': $currency_symbol = 'RUB'; break;
	}
	return $currency_symbol;
}
add_filter('woocommerce_currency_symbol', 'hrlsn_currency_symbol', 10, 2);

/**
 * WC loop class
 */
add_filter('post_class', function($classes, $class, $product_id) {
    if(is_shop() || is_product_category()) {
        //only add these classes if we're on a product category page.
        $classes = array_merge(['prod-list__item'], $classes);
    }
    return $classes;
},10,3);

/**
 * WC markup
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
// remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 60 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

/**
 * WC sorting
 */
function hrlsn_catalog_sorting( $array ){
	$newArray = [
		'menu_order' => __( 'Trending', 'hrlsn' ),
		'date'       => __( 'Latest arrivals', 'hrlsn' ),
		'on_sale' 	 => __( 'Sale first', 'hrlsn' ),
		'price-desc' => __( 'Price high to low', 'hrlsn' ),
		'price'      => __( 'Price low to high', 'hrlsn' )
	];
	return $newArray;
}
add_filter( 'woocommerce_catalog_orderby', 'hrlsn_catalog_sorting' );
add_filter( 'woocommerce_default_catalog_orderby_options', 'hrlsn_catalog_sorting' );

function wcs_get_catalog_ordering_args( $args ) {
    $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
     
    if ( 'on_sale' == $orderby_value ) {
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
        $args['meta_key'] = '_sale_price'; 
    }
    return $args;
}
add_filter( 'woocommerce_get_catalog_ordering_args', 'wcs_get_catalog_ordering_args' );

function hrlsn_save_variation_discount_price( $product ) {
	if ($product->is_type( 'variable' )) 
	{
		$discount_price = 0;

		$prices = $product->get_variation_prices();
		if (count($prices)) {
			foreach( $prices['price'] as $key => $price ){
				if( $prices['regular_price'][$key] !== $price ){
					$sale_prices[] = $prices['sale_price'][$key];
				}
			}
			if ($sale_prices) {
				$discount_price = max($sale_prices);
			}
		}
	
		$product->update_meta_data( '_sale_price', $discount_price );
	}
}
add_action( 'woocommerce_admin_process_product_object', 'hrlsn_save_variation_discount_price' );

/**
 * WC filtering
 */
function hrlsn_filter_main_query($query) {
	if ($query && is_array($query->query) && isset($query->query['post_type'])) {
		$queryType = $query->query['post_type'];
		if ($queryType == 'product' && (is_tax('product_cat') || is_post_type_archive('product'))) 
		{
			// categories
			if (isset($_GET['cats']) && $_GET['cats']) 
			{
				$explodedCats = explode('-', $_GET['cats']);
				$query->set('tax_query', array(
					array(
						'taxonomy'      => 'product_cat',
						'field' 		=> 'term_id',
						'terms'         => $explodedCats
					)
				));
			}
			// tags
			if (isset($_GET['tags']) && $_GET['tags']) 
			{
				$explodedTags = explode('-', $_GET['tags']);
				$query->set('tax_query', array(
					array(
						'taxonomy'      => 'product_tag',
						'field' 		=> 'term_id',
						'terms'         => $explodedTags
					)
				));
			}
		}
	}
}
add_filter( 'pre_get_posts', 'hrlsn_filter_main_query' );

/**
 * WC Sale percentage
 */

 add_filter( 'woocommerce_sale_flash', 'add_percentage_to_sale_badge', 20, 3 );
function add_percentage_to_sale_badge( $html, $post, $product ) {

  if( $product->is_type('variable')){
      $percentages = array();

      // Get all variation prices
      $prices = $product->get_variation_prices();

      // Loop through variation prices
      foreach( $prices['price'] as $key => $price ){
          // Only on sale variations
          if( $prices['regular_price'][$key] !== $price ){
              // Calculate and set in the array the percentage for each variation on sale
              $percentages[] = round( 100 - ( floatval($prices['sale_price'][$key]) / floatval($prices['regular_price'][$key]) * 100 ) );
          }
      }
      // We keep the highest value
	  if ($percentages) {
		$percentage = max($percentages) . '%';
	  }

  } elseif( $product->is_type('grouped') ){
      $percentages = array();

      // Get all variation prices
      $children_ids = $product->get_children();

      // Loop through variation prices
      foreach( $children_ids as $child_id ){
          $child_product = wc_get_product($child_id);

          $regular_price = (float) $child_product->get_regular_price();
          $sale_price    = (float) $child_product->get_sale_price();

          if ( $sale_price != 0 || ! empty($sale_price) ) {
              // Calculate and set in the array the percentage for each child on sale
              $percentages[] = round(100 - ($sale_price / $regular_price * 100));
          }
      }
      // We keep the highest value
      if ($percentages) {
		$percentage = max($percentages) . '%';
	  }

  } else {
      $regular_price = (float) $product->get_regular_price();
      $sale_price    = (float) $product->get_sale_price();

      if ( $sale_price != 0 || ! empty($sale_price) ) {
          $percentage    = round(100 - ($sale_price / $regular_price * 100)) . '%';
      } else {
          return $html;
      }
  }
  return '<span>' . $percentage . ' ' . esc_html__( 'Off', 'hrlsn' ) . '</span>';
}

/**
 * WC product custom fields
 */

 function hrlsn_product_options_advanced_product_data() {
    woocommerce_wp_text_input( array(
        'id'            => '_composition',
        'label'         => __( 'Composition', 'hrlsn' ),
        'desc_tip'      => 'false',
        'placeholder'   => '',
    ) );
	woocommerce_wp_text_input( array(
        'id'            => '_model',
        'label'         => __( 'Model', 'hrlsn' ),
        'desc_tip'      => 'false',
        'placeholder'   => '',
    ) );
	woocommerce_wp_checkbox( array(
        'id'            => '_new',
        'label'         => __( 'New', 'hrlsn' ),
        'desc_tip'      => 'false',
        'placeholder'   => '',
    ) );
	woocommerce_wp_checkbox( array(
        'id'            => '_restock',
        'label'         => __( 'Restock', 'hrlsn' ),
        'desc_tip'      => 'false',
        'placeholder'   => '',
    ) );
	woocommerce_wp_checkbox( array(
        'id'            => '_exclusive',
        'label'         => __( 'Exclusive', 'hrlsn' ),
        'desc_tip'      => 'false',
        'placeholder'   => '',
    ) );
	woocommerce_wp_checkbox( array(
        'id'            => '_preorder',
        'label'         => __( 'Preorder', 'hrlsn' ),
        'desc_tip'      => 'false',
        'placeholder'   => '',
    ) );
	woocommerce_wp_checkbox( array(
        'id'            => '_bestseller',
        'label'         => __( 'Bestseller', 'hrlsn' ),
        'desc_tip'      => 'false',
        'placeholder'   => '',
    ) );
}
add_action( 'woocommerce_product_options_advanced', 'hrlsn_product_options_advanced_product_data' );

function hrlsn_add_product_custom_wysiwyg_field() {
    global $product_object;

    echo '<div class="form-field _sizechart_field " style="padding: 5px 20px 5px 162px!important;">
    <label>' . __( 'Size chart', 'hrlsn' ) . '</label>
    <div style="padding:9px; margin: 4px 0!important; vertical-align: middle; float: left;">';

    $content  = $product_object->get_meta( '_sizechart' );

    wp_editor( $content, '_sizechart', [
		'media_buttons' => false,
		'textarea_rows' => 20,
		'editor_height' => 200,
		'tabindex' => 4,
		'tinymce' => array(
			'theme_advanced_buttons1' => 'bold, italic, ul, min_size, max_size',
			'theme_advanced_buttons2' => '',
			'theme_advanced_buttons3' => '',
			'theme_advanced_buttons4' => '',
		)
	]);

    echo '</div></div>';
}
add_action( 'woocommerce_product_options_advanced', 'hrlsn_add_product_custom_wysiwyg_field' );

function hrlsn_admin_process_product_object( $product ) {
    if ( isset( $_POST['_composition'] ) ) {        
        $product->update_meta_data( '_composition', sanitize_text_field( $_POST['_composition'] ) );
    }
	if ( isset( $_POST['_model'] ) ) {        
        $product->update_meta_data( '_model', sanitize_text_field( $_POST['_model'] ) );
    }

	$product->update_meta_data( '_new', isset($_POST['_new']) ? 'yes' : 'no');
	$product->update_meta_data( '_restock', isset($_POST['_restock']) ? 'yes' : 'no');
	$product->update_meta_data( '_exclusive', isset($_POST['_exclusive']) ? 'yes' : 'no');
	$product->update_meta_data( '_preorder', isset($_POST['_preorder']) ? 'yes' : 'no');
	$product->update_meta_data( '_bestseller', isset($_POST['_bestseller']) ? 'yes' : 'no');

	if ( isset( $_POST['_sizechart'] ) ) {        
        $product->update_meta_data( '_sizechart', $_POST['_sizechart'] );
    }
}
add_action( 'woocommerce_admin_process_product_object', 'hrlsn_admin_process_product_object', 10, 1 );

/**
 * WC Related etc. products
 */

function hrlsn_save_product_views() {
    $product_id = get_the_ID();
    $increment = 1;
    $current_visit_count = get_post_meta( $product_id, 'product_visit_count', true );

    $total_visit_count = (int)$current_visit_count + $increment;
    update_post_meta( $product_id, 'product_visit_count', $total_visit_count );
}
add_action( 'woocommerce_before_single_product', 'hrlsn_save_product_views' );

function hrlsn_order_related_products( $args ) {
	$args['posts_per_page'] = 4;
	$args['meta_key'] = 'product_visit_count';
	$args['orderby'] = 'meta_value_num';
	$args['order'] = 'desc';

    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'hrlsn_order_related_products', 999 );

function woocommerce_product_loop_start_related( $echo = true ) {
	ob_start();
	wc_set_loop_prop( 'loop', 0 );
	wc_get_template( 'loop/loop-start-related.php' );
	$loop_start = apply_filters( 'woocommerce_product_loop_start', ob_get_clean() );
	if ( $echo ) {
		echo $loop_start;
	} else {
		return $loop_start;
	}
}

function woocommerce_product_loop_end_related( $echo = true ) {
	ob_start();
	wc_get_template( 'loop/loop-end-related.php' );
	$loop_end = apply_filters( 'woocommerce_product_loop_end', ob_get_clean() );
	if ( $echo ) {
		echo $loop_end;
	} else {
		return $loop_end;
	}
}

/*
function hrlsn_related_products_args( $args ) {
	$args['posts_per_page'] = 4;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'hrlsn_related_products_args', 999 );
*/

function is_variable_product_out_of_stock( $product ) {
    $children_count = 0; // initializing
    $variation_ids  = $product->get_visible_children();
        
    // Loop through children variations of the parent variable product
    foreach( $variation_ids as $variation_id ) {
        $variation = wc_get_product($variation_id); // Get the product variation Object
            
        if( ! $variation->is_in_stock() ) {
            $children_count++; // count out of stock children
        }
    }
    // Compare counts and return a boolean
    return count($variation_ids) == $children_count ? true : false;
}

/**
 * WC Cart
 */

function getCartQty() {
	return WC()->cart->get_cart_contents_count();
}

function getFreeShippingAmount() {
	$min_amount = (int)HRLSN_OPTIONS['hrlsn_shop_free_shipping_from'];

	return wc_price($min_amount);
}

function hrlsn_variation_title_not_include_attributes( $boolean ){
    if ( ! is_cart() )
        $boolean = false;
    return $boolean;
}
add_filter( 'woocommerce_product_variation_title_include_attributes', 'hrlsn_variation_title_not_include_attributes' );

function hrlsn_remove_attribute_in_product_name( $boolean){
    if ( ! is_cart() )
        $boolean = false;
    return $boolean;
}
add_filter( 'woocommerce_is_attribute_in_product_name', 'hrlsn_remove_attribute_in_product_name' );

function hrlsn_cart_get_item_data( $item_data, $cart_item  ){
    
	foreach ($item_data as $key => $item_data_item) {
		foreach ($cart_item['variation'] as $value) {
			$item_data[$key]['slug'] = $value;
		};
	}

    return $item_data;
}
add_filter( 'woocommerce_get_item_data', 'hrlsn_cart_get_item_data', 10, 2 );

function hrlsn_cart_totals_order_total_html( $value ) {
	// get total without shipping cos
	if (is_cart()) {
		$cart_total = WC()->cart->total;
		$current_shipping_method_cost = WC()->cart->get_shipping_total();
		$value = (float)$cart_total - (float)$current_shipping_method_cost;
		$value = wc_price($value);
	}

	$value = str_replace('<strong>', '', $value);
	$value = str_replace('</strong> ', '', $value);
	$value = str_replace('</strong>', '', $value);

    return $value;
}
add_filter( 'woocommerce_cart_totals_order_total_html', 'hrlsn_cart_totals_order_total_html', 10, 1 );



function nl2p($string = '') {
	$array = explode("\r\n", $string);
	$content = '';
	foreach ($array as $str) {
		$content .= "<p>" . $str . "</p>";
	}
	return str_replace("<p></p>", "", $content);
}

/**
 * Change the placeholder image
 */
function hrlsn_woocommerce_placeholder_img_src( $src ) {
	$src = get_template_directory_uri() . '/assets/img/placeholder.png';
	 
	return $src;
}
add_filter('woocommerce_placeholder_img_src', 'hrlsn_woocommerce_placeholder_img_src');

/**
 * Add to cart button
 */
function hrlsn_change_addtocart_button( $text, $product ){
	if ( $product->is_on_backorder( 1 ) ) {
		$text = __( 'Pre-Order', 'hrlsn' ) . '<i>*</i>';
	}
	return $text;
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'hrlsn_change_addtocart_button', 10, 2 );

/**
 * CHECKOUT
 */

remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

add_action( 'woocommerce_checkout_payment_hrlsn', 'woocommerce_checkout_payment', 10 );

// if virtual order
function all_items_are_virtual() {
	foreach (WC()->cart->get_cart() as $cart_element) {
		$item = wc_get_product($cart_element['product_id']);
		if (!$item->is_virtual()) {
			return false;
		}
	}
	return true;
}

// Make billing fields not required in checkout
function filter_checkout_fields($fields)
{

	unset($fields['billing']['billing_company']);
	$fields['billing']['billing_phone']['priority'] = 22;
	$fields['billing']['billing_email']['priority'] = 24;
	$fields['billing']['billing_postcode']['required'] = false;
	$fields['billing']['billing_address_1']['required'] = true;
	$fields['billing']['billing_address_2']['required'] = false;
	$fields['billing']['billing_city']['required'] = false;
	$fields['billing']['billing_state']['required'] = false;

	return $fields;
}

add_filter('woocommerce_checkout_fields', 'filter_checkout_fields', 10, 1);


/**
 * @snippet       Disable Shipping Fields for Local Pickup
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=72660
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.0.7
 */

add_action('woocommerce_after_checkout_form', 'bbloomer_disable_shipping_local_pickup');

function bbloomer_disable_shipping_local_pickup($available_gateways)
{
	global $woocommerce;
?>

	<style>
		.blockUI.blockOverlay {
			background-color: #FFF !important;
		}
		.woocommerce-input-wrapper .suggestions-constraints {
			display: none;
		}
		.woocommerce-input-wrapper input[name="hrlsn_checkout_address_field"] {
			padding-left: 0 !important;
		}
	</style>

	<?php
	if (ICL_LANGUAGE_CODE == 'ru') {
		$constraints = '[{
				locations: {
					city_type_full: "город",
					country: "Россия"
				},
			},
			{
				locations: {
					city_type_full: "город",
					country: "Беларусь"
				},
			},
			{
				locations: {
					city_type_full: "город",
					country: "Казахстан"
				},
			},
			{
				locations: {
					city_type_full: "город",
					country: "Армения"
				},
			},
			{
				locations: {
					city_type_full: "город",
					country: "Киргизия"
				},
			}
		]';
	} else {
		$constraints = '[{
				locations: {
					country: "*"
				},
			}]';
	}
	?>

	<script type="text/javascript">
		(function($) {

			<?php /*if (ICL_LANGUAGE_CODE == 'en') { ?>

				$(".ch-stage input[name='hrlsn_checkout_address_field']").on('input', function(e) {
					let element = $(e.target);
					let element_value = element.val();
					$(".ch-stage input[name='billing_address_1']").val(element_value);
				});

			<?php }*/ ?>

			var $hrlsn_shipping_address = jQuery(
				'#billing_city_field, ' +
				'#billing_state_field, ' +
				'#billing_postcode_field'
			);

			var $hrlsn_kz_address_fields = $('#billing_address_1_field');

			var defaultFormatResult = $.Suggestions.prototype.formatResult;

			// limit
			function removeCountries(suggestions) {
				return suggestions.filter(function(suggestion) {
					return suggestion.data.country_iso_code !== "RU";
				});
			}

			$('[name="hrlsn_checkout_city_field"]').suggestions({
				serviceUrl: "https://suggestions.dadata.ru/suggestions/api/4_1/rs",
				token: '94a63c0f28cf1f1da422f2056011d0e504e10916',
				type: "ADDRESS",
				count: 5,
				bounds: "city",
				language: "<?php echo ICL_LANGUAGE_CODE; ?>",
				scrollOnFocus: false,
				constraints: <?php echo $constraints; ?>,
				onSuggestionsFetch: removeCountries,
				formatResult: function(value, currentValue, suggestion, options) {
					var newValue = suggestion.data.city + ', ' + suggestion.data.country;
					suggestion.value = newValue;
					return defaultFormatResult.call(this, newValue, currentValue, suggestion, options);
				},
				formatSelected: function(suggestion) {
					return suggestion.data.city + ', ' + suggestion.data.country;
				},
				beforeRender: function(suggestion) {
					$('[data-error="city"]').addClass('hidden');
				},
				onSelect: function(suggestion) {

					console.log(suggestion);

					selected_address = suggestion.value;

					selected_city = suggestion.data.city_kladr_id;
					selected_city_name = suggestion.data.city;
					selected_country_name = suggestion.data.country;

					$('.hrlsn-checkout-select-city .hrlsn-error').text('');

					if (suggestion.data.city === 'Москва123') {
						//$('.hrlsn-moscow-shippin-methods').show();

						//$('.hrlsn-checkout-address').hide();

						$hrlsn_shipping_address.fadeOut();
						$hrlsn_kz_address_fields.fadeOut();

						// обновить регион
						$('#billing_state').val(suggestion.data.region);
						// обновить страну
						$('#billing_country').val(suggestion.data.country_iso_code);

					} else {
						$('.hrlsn-moscow-shippin-methods').hide();

						// проверка на страну
						if (suggestion.data.country_iso_code == 'RU') {

							$hrlsn_kz_address_fields.fadeOut();

							// обновить регион
							$('#billing_state').val(suggestion.data.region);
							// обновить страну
							$('#billing_country').val(suggestion.data.country_iso_code);

							init_address_field(suggestion.data.city_kladr_id);

						} else if (suggestion.data.country_iso_code == 'BY') {

							$hrlsn_kz_address_fields.fadeOut();

							// обновить регион
							$('#billing_state').val(suggestion.data.region);
							// обновить страну
							$('#billing_country').val(suggestion.data.country_iso_code);

							init_address_field(suggestion.data.city, suggestion.data.country);

						} else if (suggestion.data.country_iso_code == 'KZ') {

							$('.hrlsn-checkout-address').hide();

							$hrlsn_kz_address_fields.fadeIn();
							$hrlsn_shipping_address.fadeIn();

							$('#billing_address_1').val(suggestion.value);
							//$('#billing_postcode').val(suggestion.data.postal_code);
							// обновить регион
							$('#billing_state').val(suggestion.data.region);
							// обновить страну
							$('#billing_country').val(suggestion.data.country_iso_code);

							show_hide_shipping_block(true);

							//$('body').trigger('update_checkout');

						} else {

							// для мира
							//$('#billing_address_1').val(suggestion.value);
							//$('#billing_postcode').val(suggestion.data.postal_code);
							$('#billing_city').val(suggestion.data.city);
							$('#billing_country').val(suggestion.data.country_iso_code).trigger('change');

							setTimeout(function() {
								if( $('#billing_state').is('select') ) {
									let region_iso_code = suggestion.data.region_iso_code;
									if ($('#billing_state option[value="'+region_iso_code+'"]').length > 0) {
										$('#billing_state').val(region_iso_code).trigger('change');
									} else {
										let region_iso_code_short = region_iso_code.substr(region_iso_code.indexOf("-") + 1);
										if ($('#billing_state option[value="'+region_iso_code_short+'"]').length > 0) {
											$('#billing_state').val(region_iso_code_short).trigger('change');
										} else {
											$('#billing_state').val(suggestion.data.region);
										}
									}
								} else {
									$('#billing_state').val(suggestion.data.region);
								}
							}, 1000);
						}

						if (selected_address !== null) {

							//console.log('address not null');
							$('body').addClass('update_process').trigger('update_checkout');

							$row = $('.woocommerce-checkout');
							$row.block({
								message: null,
								overlayCSS: {
									opacity: 0.8
								}
							});

						}

						// $('body').trigger('update_checkout');
					}


					$('body').trigger('update_checkout');

					// если Королёв
					if (suggestion.data.city === 'Королёв') suggestion.data.city = 'Королев';

					$('#billing_city').val(suggestion.data.city).trigger('change');

					// checkStageStatus
					$(".ch-sequence__action__btn").removeClass('disabled');
					$(".ch-sequence__nav__next").removeClass('disabled');
				},
				onSelectNothing: function(query) {
					// checkStageStatus
					$(".ch-sequence__action__btn").addClass('disabled');
					$(".ch-sequence__nav__next").addClass('disabled');

					$('.hrlsn-checkout-select-city .hrlsn-error').text('Пожалуйста, выберите город в России');
				}
			});


			$('[name="hrlsn_payment_method"]').on('change', function() {

				if ($(this).val() === 'samovivoz') {

					$('[name="hrlsn_shipping_selected"]').val('1');

					$hrlsn_shipping_address.fadeOut();
					$('.hrlsn-checkout-address').hide();
					$('#place_order').prop('disabled', false);

					shipping_type = 'samo';

					//show_shipping_methods('samo');
					$('body').trigger('update_checkout');
					show_hide_shipping_block(true);

				} else {

					//$hrlsn_shipping_address.fadeIn();

					console.log(selected_address);
					if (selected_address === null) {
						console.log('null');
						show_hide_shipping_block(false);
					}
					if (selected_address !== null) {

						console.log('not null');
						$('body').trigger('update_checkout');
					}

					// проверка на КЛАДР
					if (selected_city) {
						init_address_field(selected_city);
					} else {
						init_address_field(selected_city_name, selected_country_name);
					}

					//show_shipping_methods('dost');

					shipping_type = 'dost';
				}

			});

			$('body').on('update_checkout', function(e) {
				//console.log('update_checkout');
			});

			$('body').on('change', '.shipping_method__radio', function(e) {

				$('[name="hrlsn_shipping_selected"]').val('1');
				$('#place_order').prop('disabled', false);

				var $this = $(this);
				console.log($this.closest('li').find('[data-boxberry-open]'));
				if ($this.closest('li').find('[data-boxberry-open]').length) {
					$this.closest('li').find('[data-boxberry-open]').show();
				}

			});

			$('body').on('click', '.place-order', function(e) {
				console.log($('#place_order').is(':disabled'));

				if ($(this).find('#place_order').is(':disabled')) {
					$('[name="hrlsn_checkout_address_field"]').addClass('field-error');
				}

			});

			function init_address_field(city, country = false) {
				//console.log(kladr_id);
				$('.hrlsn-checkout-address').show();

				// проверка на КЛАДР через страну
				let locationsObj = {};
				if (country) {
					locationsObj = {
						country: country,
						city: city
					};
				} else {
					locationsObj = {
						kladr_id: city
					};
				}

				$('[name="hrlsn_checkout_address_field"]').suggestions({
					serviceUrl: "https://suggestions.dadata.ru/suggestions/api/4_1/rs",
					token: '94a63c0f28cf1f1da422f2056011d0e504e10916',
					type: "ADDRESS",
					count: 5,
					scrollOnFocus: false,
					constraints: {
						// ограничиваем поиск городом
						locations: locationsObj,
					},
					restrict_value: true,
					onSelect: function(suggestion) {

						console.log(suggestion);

						selected_address = suggestion.value;

						$hrlsn_shipping_address.fadeIn();
						$hrlsn_kz_address_fields.fadeOut();

						$('#billing_address_1').val(suggestion.value);
						//$('#billing_postcode').val(suggestion.data.postal_code);
						// обновить регион
						$('#billing_state').val(suggestion.data.region);
						// обновить страну
						$('#billing_country').val(suggestion.data.country_iso_code);

						show_hide_shipping_block(true);

						// checkStageStatus
						checkStageStatus('details');
						$('[data-error="address"]').addClass('hidden');
					},
					onSelectNothing: function(query) {
						selected_address = null;
						//$('.hrlsn-checkout-select-city .hrlsn-error').text('Пожалуйста, выберите город в России');
					}
				});

				$('.hrlsn-checkout-address .suggestions-input').css('padding-left', parseInt($('.hrlsn-checkout-address .suggestions-input').css('padding-left')) + 5 + 'px');

			}


			function show_shipping_methods(type) {

				if (!type) return false;

				var $shipping_method_list = $('body').find('#shipping_method');
				console.log($shipping_method_list);
				$shipping_method_list.find('.shipping_method').show();

				$shipping_method_list.find('input').each(function() {
					var $this = $(this);

					if (type === 'samo') {

						switch ($this.attr('id')) {

							case 'shipping_method_0_wbs-8-0b9f3d4b':
							case 'shipping_method_0_wbs-15-59bb7894_boxberry':
							case 'shipping_method_0_boxberry_courier-12':
								$this.closest('li').hide();

								break;

						}

					} else if (type === 'dost') {

						switch ($this.attr('id')) {

							case 'shipping_method_0_local_pickup-2':
							case 'shipping_method_0_local_pickup-3':
								$this.closest('li').hide();

								break;

						}
					}

				});

				//$('.hrlsn-shipping-methods').show();

				$shipping_method_list.find('.shipping_method:visible').eq(0).find('input').prop('checked', true).trigger('change');

			}

			function show_hide_shipping_block(show) {
				console.log('shipping block show: ', show);

				if (show) {

					$('#hrlsn-inline-style').html('.hrlsn-shipping-methods {display: block;}')
				} else {

					$('#hrlsn-inline-style').html('.hrlsn-shipping-methods {display: none;}')
				}

			}

			function checkStageStatus(stage, error = false) {
				switch (stage) {
					case 'details':
						let name = $(".ch-stage input[name='billing_first_name']").val();
						let surname = $(".ch-stage input[name='billing_last_name']").val();
						let email = $(".ch-stage input[type='email']").val();
						let phone = $(".ch-stage input[name='billing_phone']").val();
						if (validateField(name) && validateField(surname) && validateEmail(email) && validatePhone(phone) && validateAddress()) {
							$('[data-error="first_name"], [data-error="last_name"], [data-error="email"], [data-error="email_format"], [data-error="phone"], [data-error="phone_format"], [data-error="address"]').addClass('hidden');
							activateStage();
						} else {
							deactivateStage();
							if (validateField(name)) {
								$('[data-error="first_name"]').addClass('hidden');
							}
							if (validateField(surname)) {
								$('[data-error="last_name"]').addClass('hidden');
							}
							if (validateField(email)) {
								$('[data-error="email"]').addClass('hidden');
							}
							if (validateEmail(email)) {
								$('[data-error="email_format"]').addClass('hidden');
							}
							if (validateField(phone)) {
								$('[data-error="phone"]').addClass('hidden');
							}
							if (validatePhone(phone)) {
								$('[data-error="phone_format"]').addClass('hidden');
							}
							if (validateAddress()) {
								$('[data-error="address"]').addClass('hidden');
							}
							if (error) {
								$('[data-error="first_name"], [data-error="last_name"], [data-error="email"], [data-error="email_format"], [data-error="phone"], [data-error="phone_format"], [data-error="address"]').addClass('hidden');
								if (!validateField(name)) {
									$('[data-error="first_name"]').removeClass('hidden');
								}
								if (!validateField(surname)) {
									$('[data-error="last_name"]').removeClass('hidden');
								}
								if (!validateField(email)) {
									$('[data-error="email"]').removeClass('hidden');
									$('[data-error="email_format"]').addClass('hidden');
								}
								if (validateField(email) && !validateEmail(email)) {
									$('[data-error="email"]').addClass('hidden');
									$('[data-error="email_format"]').removeClass('hidden');
								}
								if (!validateField(phone)) {
									$('[data-error="phone"]').removeClass('hidden');
									$('[data-error="phone_format"]').addClass('hidden');
								}
								if (validateField(phone) && !validatePhone(phone)) {
									$('[data-error="phone"]').addClass('hidden');
									$('[data-error="phone_format"]').removeClass('hidden');
								}
								if (!validateAddress()) {
									$('[data-error="address"]').removeClass('hidden');
								}
							}
						}
						break;
					default:
						break;
				}
			}

			function activateStage() {
				$(".ch-sequence__action__btn").removeClass('disabled');
			}

			function activateStageBtn() {
				$(".ch-sequence__action__btn").removeClass('disabled');
			}

			function deactivateStage() {
				$(".ch-sequence__action__btn").addClass('disabled');
			}

			function validateEmail(value) {
				var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				return regex.test(value);
			}

			function validatePassword(value) {
				if (value.length > 5) {
					return true;
				} else {
					return false;
				}
			}

			function validateCity(value) {
				if (value == 'true') {
					return true;
				} else {
					return false;
				}
			}

			function validateAddress() {
				let address_1 = $(".ch-stage input[name='hrlsn_checkout_address_field']");
				let address_2 = $(".ch-stage input[name='billing_address_1']");
				if (address_1.is(':visible')) {
					if (address_1.val().length && address_2.val().length) {
						return true;
					} else {
						return false;
					}
				} else if (address_2.is(':visible')) {
					if (address_2.val().length) {
						return true;
					} else {
						return false;
					}
				} else {
					return true;
				}
			}

			function validateDelivery(length, selected) {
				if (length > 0) {
					let boxberry_link = $(".shipping_list_boxberry_self-11 a").text();
					if (selected.indexOf("boxberry_self") >= 0) {
						if (boxberry_link.indexOf("(") >= 0) {
							return true;
						} else {
							return false;
						}
					} else {
						return true;
					}
				} else {
					return false;
				}
			}

			function validateField(value) {
				if (value.length > 1) {
					return true;
				} else {
					return false;
				}
			}

			function validatePhone(value) {
				if (value.length > 10) {
					return true;
				} else {
					return false;
				}
			}


		})(jQuery);
	</script>

	<?php

	// Part 1: Hide shipping based on the static choice @ Cart
	// Note: "#customer_details .col-2" strictly depends on your theme

	$chosen_methods = WC()->session->get('chosen_shipping_methods');
	$chosen_shipping_no_ajax = $chosen_methods[0];
	if (0 === strpos($chosen_shipping_no_ajax, 'local_pickup')) {

	?>
		<script type="text/javascript">
			//$hrlsn_shipping_address.fadeOut();
		</script>
<?php

	}
}

function hrlsn_woocommerce_package_rates( $rates, $package ) {
	$free_shipping = false;
	
    // Cart total amount (integer)
    $cart_total = WC()->cart->cart_contents_total;
	$min_amount = (int)HRLSN_OPTIONS['hrlsn_shop_free_shipping_from'];
	if ($cart_total >= $min_amount) $free_shipping = true;

	// coupon with free shipping
	$applied_coupons = WC()->cart->get_applied_coupons();
    foreach ( $applied_coupons as $coupon_code ) 
	{
		$coupon = new WC_Coupon($coupon_code);
		if ($coupon->get_free_shipping()) $free_shipping = true;
	}

    // Greater than or equal to
    if ( $free_shipping ) {
        foreach ( $rates as $rate_key => $rate ) {
            // For "free shipping" method (enabled), remove it
            if ( $rate->method_id == 'free_shipping' ) {
                unset( $rates[$rate_key] );
            // For other shipping methods
            } else {
                // Append rate label titles (free)
                $rates[$rate_key]->label .= ' ' . __( '(free)', 'woocommerce' );

                // Set rate cost
                $rates[$rate_key]->cost = 0;

                // Set taxes rate cost (if enabled)
                $taxes = array();

                foreach ( $rates[$rate_key]->taxes as $key => $tax ) {
                    if ( $rates[$rate_key]->taxes[$key] > 0 ) {
                        $taxes[$key] = 0;
                    }
                }

                $rates[$rate_key]->taxes = $taxes;
            }
        }
    }

    return $rates;
}
add_filter( 'woocommerce_package_rates','hrlsn_woocommerce_package_rates', 10, 2 );

/**
 * Change Add to cart text (for simple products)
 */

 function productIsInCart($productId) {
	if( WC()->cart->find_product_in_cart( WC()->cart->generate_cart_id( $productId ) ) ) {
		return true;
	}

	return false;
}

function hrlsn_product_single_add_to_cart_text($title) {
	global $product;

	if ( is_product() && $product->is_type( 'simple' ) && productIsInCart($product->get_id())) 
	{
		$title = esc_html__( 'Added to cart', 'hrlsn' );
	}

	return $title;
}
add_filter( 'woocommerce_product_single_add_to_cart_text','hrlsn_product_single_add_to_cart_text', 10, 1 );

/**
 * New Email classes
 */

add_filter( 'woocommerce_email_classes', 'hrlsn_woocommerce_email_classes' );
function hrlsn_woocommerce_email_classes( $email_classes ) {
	require( get_stylesheet_directory() . '/inc/wc-emails/class-wc-email-customer-ctt.php' );
	$email_classes['WC_Email_Customer_Ctt'] = new WC_Email_Customer_Ctt();

	return $email_classes;
}
 
add_filter( 'woocommerce_email_actions', 'hrlsn_add_another_email_action' );
function hrlsn_add_another_email_action( $array ) {
	$array[]='woocommerce_order_status_processing_to_ctt';
	$array[]='woocommerce_order_status_ctt_to_cancelled';
	return $array;
}
 
add_action( 'woocommerce_email', 'hook_another_email_cancelled' );
function hook_another_email_cancelled( $email_class ) {
	add_action( 'woocommerce_order_status_ctt_to_cancelled_notification', array( $email_class->emails['WC_Email_Cancelled_Order'], 'trigger' ) );
}
 
// Add a custom CTT email template
 
add_action( 'woocommerce_order_status_wc-ctt', array( WC(), 'send_transactional_email' ), 10, 1 );
  
add_action('woocommerce_order_status_ctt', 'backorder_status_custom_notification_ctt', 20, 2);
function backorder_status_custom_notification_ctt( $order_id ) {
	$mailer = WC()->mailer()->get_emails();
	$mailer['WC_Email_Customer_Ctt']->trigger( $order_id );
}
 
 // subject|heading for new emails
 
 /*add_filter( 'woocommerce_email_subject_customer_processing_order', 'customizing_processing_email_subject', 20, 2 );
 function customizing_processing_email_subject( $formated_subject, $order ){
	 return sprintf( esc_html__( 'Thank you for your purchase!', 'hrlsn' ), $order->get_id());
 }
 
 add_filter( 'woocommerce_email_subject_cancelled_order', 'customizing_cancelled_email_subject', 20, 2 );
 function customizing_cancelled_email_subject( $formated_subject, $order ){
	 return sprintf( esc_html__( 'Your order has been cancelled', 'hrlsn' ), $order->get_id());
 }*/
 
add_filter( 'woocommerce_email_heading_customer_processing_order', 'customizing_processing_email_heading', 20, 2 );
function customizing_processing_email_heading( $formated_subject, $order ){
	return esc_html__( 'Thank you for your purchase!', 'hrlsn' );
}
 
add_filter( 'woocommerce_email_heading_cancelled_order', 'customizing_cancelled_email_heading', 20, 2 );
function customizing_cancelled_email_heading( $formated_subject, $order ){
	return esc_html__( 'Your order has been cancelled', 'hrlsn' );
}
 

add_filter( 'woocommerce_email_recipient_cancelled_order', 'hrlsn_cancelled_order_email_to_customer', 9999, 3 );
function hrlsn_cancelled_order_email_to_customer( $email_recipient, $email_object, $email ) {
   // if ( is_admin() ) return $email_recipient;
   if ( is_admin() ) return $email_object->get_billing_email();
   $email_recipient .= ', ' . $email_object->get_billing_email();
   return $email_recipient;
}


// Disable plugins auto-update email notifications .
add_filter( 'auto_plugin_update_send_email', '__return_false' );
 
// Disable themes auto-update email notifications.
add_filter( 'auto_theme_update_send_email', '__return_false' );

// Set Title for tags pages
add_filter('document_title_parts', 'custom_woocommerce_tag_document_title');
function custom_woocommerce_tag_document_title($title_parts) {
    if (is_shop() && isset($_GET['product_tag'])) {
        $tag_slug = sanitize_text_field($_GET['product_tag']);
        $term = get_term_by('slug', $tag_slug, 'product_tag');
        
        if ($term && !is_wp_error($term)) {
            $title_parts['title'] = $term->name;
        }
    }
    return $title_parts;
}
