<?php
/**
 * Versatile functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Versatile
 */

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function versatile_setup() {
    /*
     * Make theme available for translation.
     */
    load_theme_textdomain('versatile', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in multiple locations.
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'versatile'),
            'footer-menu' => esc_html__('Footer Menu', 'versatile'),
            'footer-legal-menu' => esc_html__('Footer Legal Menu', 'versatile'),
        )
    );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
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

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'versatilecustom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
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

    // Add support for Block Styles.
    add_theme_support('wp-block-styles');

    // Add support for full and wide align images.
    add_theme_support('align-wide');

    // Add support for editor styles.
    add_theme_support('editor-styles');

    // Enqueue editor styles.
    add_editor_style('style-editor.css');

    // Add custom editor font sizes.
    add_theme_support(
        'editor-font-sizes',
        array(
            array(
                'name'      => esc_html__('Small', 'versatile'),
                'shortName' => esc_html__('S', 'versatile'),
                'size'      => 14,
                'slug'      => 'small',
            ),
            array(
                'name'      => esc_html__('Normal', 'versatile'),
                'shortName' => esc_html__('M', 'versatile'),
                'size'      => 16,
                'slug'      => 'normal',
            ),
            array(
                'name'      => esc_html__('Large', 'versatile'),
                'shortName' => esc_html__('L', 'versatile'),
                'size'      => 24,
                'slug'      => 'large',
            ),
            array(
                'name'      => esc_html__('Huge', 'versatile'),
                'shortName' => esc_html__('XL', 'versatile'),
                'size'      => 32,
                'slug'      => 'huge',
            ),
        )
    );

    // Add support for responsive embedded content.
    add_theme_support('responsive-embeds');

    // Add support for custom line height controls.
    add_theme_support('custom-line-height');

    // Add support for custom units.
    add_theme_support('custom-units');

    // Remove support for custom colors.
    add_theme_support('disable-custom-colors');

    // Add support for custom spacing.
    add_theme_support('custom-spacing');

    // Add support for custom padding.
    add_theme_support('custom-padding');

    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'versatile_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function versatile_content_width() {
    $GLOBALS['content_width'] = apply_filters('versatile_content_width', 640);
}
add_action('after_setup_theme', 'versatile_content_width', 0);

/**
 * Register widget area.
 */
function versatile_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'versatile'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'versatile'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    // Footer widget areas
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(
            array(
                'name'          => sprintf(esc_html__('Footer %d', 'versatile'), $i),
                'id'            => 'footer-' . $i,
                'description'   => sprintf(esc_html__('Add widgets here to appear in footer column %d.', 'versatile'), $i),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            )
        );
    }

    // Shop sidebar for WooCommerce
    if (class_exists('WooCommerce')) {
        register_sidebar(
            array(
                'name'          => esc_html__('Shop Sidebar', 'versatile'),
                'id'            => 'sidebar-shop',
                'description'   => esc_html__('Add widgets here to appear in the shop sidebar.', 'versatile'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            )
        );
    }
}
add_action('widgets_init', 'versatile_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function versatile_scripts() {
    wp_enqueue_style('versatile-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_style_add_data('versatile-style', 'rtl', 'replace');

    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0');

    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), null);

    // Header & Footer CSS
    wp_enqueue_style('versatile-header-footer', get_template_directory_uri() . '/css/header-footer.css', array('versatile-style'), _S_VERSION);

    // Check if JS files exist before enqueueing
    if (file_exists(get_template_directory() . '/js/navigation.js')) {
        wp_enqueue_script('versatile-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
    }

    if (file_exists(get_template_directory() . '/js/main.js')) {
        wp_enqueue_script('versatile-main', get_template_directory_uri() . '/js/main.js', array('jquery'), _S_VERSION, true);
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Localize script for AJAX
    if (file_exists(get_template_directory() . '/js/main.js')) {
        wp_localize_script('versatile-main', 'versatile_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('versatile_nonce'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'versatile_scripts');

/**
 * Social Links Function
 */
if (!function_exists('versatilesocial_links')) {
    function versatile_social_links() {
        $social_links = array(
            'facebook' => get_theme_mod('versatile_facebook_url', ''),
            'twitter' => get_theme_mod('versatile_twitter_url', ''),
            'instagram' => get_theme_mod('versatile_instagram_url', ''),
            'linkedin' => get_theme_mod('versatile_linkedin_url', ''),
            'youtube' => get_theme_mod('versatile_youtube_url', ''),
        );
        
        $social_icons = array(
            'facebook' => 'fab fa-facebook-f',
            'twitter' => 'fab fa-twitter',
            'instagram' => 'fab fa-instagram',
            'linkedin' => 'fab fa-linkedin-in',
            'youtube' => 'fab fa-youtube',
        );
        
        foreach ($social_links as $platform => $url) {
            if ($url) {
                echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener" class="social-link social-' . esc_attr($platform) . '">';
                echo '<i class="' . esc_attr($social_icons[$platform]) . '"></i>';
                echo '<span class="screen-reader-text">' . esc_html(ucfirst($platform)) . '</span>';
                echo '</a>';
            }
        }
    }
}

/**
 * Fallback Menu Function
 */
if (!function_exists('versatilefallback_menu')) {
    function versatile_fallback_menu() {
        echo '<ul id="primary-menu" class="primary-menu">';
        echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'versatile') . '</a></li>';
        
        // Add some default pages
        $pages = get_pages(array('sort_column' => 'menu_order', 'number' => 5));
        foreach ($pages as $page) {
            echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
        }
        
        if (current_user_can('manage_options')) {
            echo '<li><a href="' . esc_url(admin_url('nav-menus.php')) . '">' . esc_html__('Add Menu', 'versatile') . '</a></li>';
        }
        echo '</ul>';
    }
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Detect site type and apply appropriate settings
 */
function versatile_detect_site_type() {
    $site_type = 'personal'; // default
    
    // Check for WooCommerce
    if (class_exists('WooCommerce')) {
        $site_type = 'ecommerce';
    }
    // Check for business indicators
    elseif (get_option('show_on_front') == 'page' && get_option('page_on_front')) {
        $site_type = 'business';
    }
    // Check for blog
    elseif (get_option('show_on_front') == 'posts') {
        $site_type = 'blog';
    }
    
    return apply_filters('versatilesite_type', $site_type);
}

/**
 * Add body classes based on site type
 */
function versatile_body_classes($classes) {
    $site_type = versatile_detect_site_type();
    $classes[] = 'site-type-' . $site_type;
    
    // Add class for sidebar
    if (is_active_sidebar('sidebar-1') && !is_page_template('page-landing.php')) {
        $classes[] = 'has-sidebar';
    } else {
        $classes[] = 'no-sidebar';
    }
    
    return $classes;
}
add_filter('body_class', 'versatile_body_classes');

/**
 * Add theme support for WooCommerce
 */
function versatile_woocommerce_support() {
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width'    => 600,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ));
}
add_action('after_setup_theme', 'versatile_woocommerce_support');

/**
 * Disable WooCommerce block styles (optional)
 */
function versatile_disable_woocommerce_block_styles() {
    wp_dequeue_style('wc-blocks-style');
}
add_action('wp_enqueue_scripts', 'versatile_disable_woocommerce_block_styles', 100);

/**
 * Custom excerpt length
 */
function versatile_excerpt_length($length) {
    return $length ?? 25;
}
add_filter('excerpt_length', 'versatile_excerpt_length', 999);

/**
 * Custom excerpt more string
 */
function versatile_excerpt_more($more) {
    return $more ?? '...';
}
add_filter('excerpt_more', 'versatile_excerpt_more');

/**
 * Add custom image sizes
 */
function versatile_custom_image_sizes() {
    add_image_size('versatile-featured', 800, 400, true);
    add_image_size('versatile-portfolio', 600, 400, true);
    add_image_size('versatile-testimonial', 100, 100, true);
}
add_action('after_setup_theme', 'versatile_custom_image_sizes');

/**
 * Register block styles
 */
function versatile_register_block_styles() {
    // Register custom block styles here if needed
}
add_action('init', 'versatile_register_block_styles');

/**
 * Add preload for Google Fonts
 */
function versatile_resource_hints($urls, $relation_type) {
    if (wp_style_is('google-fonts', 'queue') && 'preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }
    return $urls;
}
add_filter('wp_resource_hints', 'versatile_resource_hints', 10, 2);

/**
 * Improve site performance
 */
function versatile_performance_optimizations() {
    // Remove unnecessary WordPress features
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    
    // Remove WordPress version from head
    remove_action('wp_head', 'wp_generator');
    
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove wlwmanifest link
    remove_action('wp_head', 'wlwmanifest_link');
}
add_action('init', 'versatile_performance_optimizations');

/**
 * Security enhancements
 */
function versatile_security_headers() {
    if (!is_admin()) {
        header('X-Frame-Options: SAMEORIGIN');
        header('X-Content-Type-Options: nosniff');
        header('X-XSS-Protection: 1; mode=block');
    }
}
add_action('send_headers', 'versatile_security_headers');

/**
 * Output custom CSS for color schemes
 */
function versatile_color_scheme_css() {
    $colors = versatile_get_current_color_scheme();
    
    $css = "
    :root {
        --primary-color: {$colors['primary']};
        --primary-hover: {$colors['primary_hover']};
        --secondary-color: {$colors['secondary']};
        --accent-color: {$colors['accent']};
    }
    
    /* Update button styles */
    .btn-primary,
    .wp-block-button__link,
    button[type='submit'],
    input[type='submit'],
    .woocommerce a.button.alt,
    .woocommerce button.button.alt {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
    }
    
    .btn-primary:hover,
    .wp-block-button__link:hover,
    button[type='submit']:hover,
    input[type='submit']:hover,
    .woocommerce a.button.alt:hover,
    .woocommerce button.button.alt:hover {
        background-color: var(--primary-hover) !important;
        border-color: var(--primary-hover) !important;
    }
    
    /* Update post button styles */
    .read-more,
    .more-link,
    .continue-reading {
        color: var(--primary-color) !important;
        white-space: normal;
        overflow-wrap: break-word;
        word-break: break-word;
    }
    
    .read-more:hover,
    .more-link:hover,
    .continue-reading:hover {
        color: var(--primary-hover) !important;
        white-space: normal;
        overflow-wrap: break-word;
        word-break: break-word;
    }
    
    /* Update read more button styles */
    .read-more-btn {
        background: var(--primary-color) !important;
        color: white !important;
        border-color: var(--primary-color) !important;
    }
    
    .read-more-btn:hover {
        background: var(--primary-hover) !important;
        color: white !important;
        border-color: var(--primary-hover) !important;
    }
    
    .entry-footer a,
    .post-navigation a,
    .nav-links a,
    .page-numbers .current,
    .widget-title {
        white-space: normal;
        overflow-wrap: break-word;
        word-break: break-word;
    }
    
    .entry-footer a:hover,
    .post-navigation a:hover,
    .nav-links a:hover {
        white-space: normal;
        overflow-wrap: break-word;
        word-break: break-word;
    }
    
    /* Update pagination and widget borders */
    .page-numbers a:hover,
    .page-numbers .current,
    .widget-title {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
    }
    
    .widget-title {
        border-bottom-color: var(--primary-color) !important;
    }
    
    /* Update link colors */
    a {
        color: var(--primary-color);
    }
    
    a:hover {
        color: var(--primary-hover);
    }
    
    /* Update navigation active states */
    .main-navigation .current_page_item > a,
    .main-navigation .current-menu-item > a,
    .main-navigation a:hover {
        color: var(--primary-color) !important;
    }
    
    /* Update form focus states */
    input[type='text']:focus,
    input[type='email']:focus,
    input[type='url']:focus,
    input[type='password']:focus,
    input[type='search']:focus,
    textarea:focus,
    select:focus {
        border-color: var(--primary-color) !important;
    }
    
    /* Update secondary backgrounds */
    .secondary-bg,
    .widget-area,
    .site-footer .widget {
        background-color: var(--secondary-color);
    }
    
    /* Update header footer overrides to use dynamic colors */
    .main-navigation a:hover,
    .main-navigation .current_page_item > a,
    .main-navigation .current-menu-item > a {
        color: var(--primary-color) !important;
    }
    
    .cta-button,
    .header-cta-button {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
    }
    
    .cta-button:hover,
    .header-cta-button:hover {
        background-color: var(--primary-hover) !important;
        border-color: var(--primary-hover) !important;
    }
    
    .footer-menu a:hover,
    .social-link:hover {
        color: var(--primary-color) !important;
    }
    ";
    
    return $css;
}

/**
 * Add custom CSS to head (only for non-customizer preview)
 */
function versatile_custom_css() {
    if (!is_customize_preview()) {
        $css = versatile_color_scheme_css();
        echo '<style type="text/css" id="versatile-color-scheme">' . $css . '</style>';
    }
}
add_action('wp_head', 'versatile_custom_css');