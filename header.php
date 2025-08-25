<?php
/**
 * The header template file
 * This template part displays the HTML head and opening body tag
 * Versatile WordPress Theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'versatile'); ?></a>

    <!-- Header -->
    <header id="masthead" class="site-header">
        <div class="header-wrapper">
            <div class="container">
                <div class="header-content">
                    
                    <!-- Site Branding -->
                    <div class="site-branding">
                        <?php
                        the_custom_logo();
                        if (is_front_page() && is_home()) :
                            ?>
                            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                            <?php
                        else :
                            ?>
                            <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
                            <?php
                        endif;
                        $versatile_description = get_bloginfo('description', 'display');
                        if ($versatile_description || is_customize_preview()) :
                            ?>
                            <p class="site-description"><?php echo $versatile_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                        <?php endif; ?>
                    </div><!-- .site-branding -->

                    <!-- Primary Navigation -->
                    <nav id="site-navigation" class="main-navigation">
                        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                            <span class="menu-toggle-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                            <span class="menu-toggle-text"><?php esc_html_e('Menu', 'versatile'); ?></span>
                        </button>
                        
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'menu-1',
                                'menu_id'        => 'primary-menu',
                                'menu_class'     => 'primary-menu',
                                'container'      => false,
                                'fallback_cb'    => 'versatilefallback_menu',
                            )
                        );
                        ?>
                    </nav><!-- #site-navigation -->

                    <!-- Header Actions -->
                    <div class="header-actions">
                        
                        <!-- Search Toggle -->
                        <button class="search-toggle" aria-expanded="false">
                            <i class="fas fa-search"></i>
                            <span class="screen-reader-text"><?php esc_html_e('Search', 'versatile'); ?></span>
                        </button>
                        
                        <!-- WooCommerce Cart -->
                        <?php if (class_exists('WooCommerce')) : ?>
                            <div class="header-cart">
                                <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'versatile'); ?>">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                </a>
                                
                                <!-- Mini Cart -->
                                <div class="mini-cart-wrapper">
                                    <?php if (!WC()->cart->is_empty()) : ?>
                                        <div class="widget_shopping_cart_content">
                                            <?php woocommerce_mini_cart(); ?>
                                        </div>
                                    <?php else : ?>
                                        <p class="empty-cart"><?php esc_html_e('Your cart is empty', 'versatile'); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Social Media Links -->
                        <?php if (get_theme_mod('versatile_social_links_header', false)) : ?>
                            <div class="header-social">
                                <?php versatile_social_links(); ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- CTA Button -->
                        <?php
                        $cta_text = get_theme_mod('versatile_header_cta_text', '');
                        $cta_url = get_theme_mod('versatile_header_cta_url', '');
                        if ($cta_text && $cta_url) :
                        ?>
                            <div class="header-cta">
                                <a href="<?php echo esc_url($cta_url); ?>" class="cta-button">
                                    <?php echo esc_html($cta_text); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div><!-- .header-actions -->
                </div><!-- .header-content -->
            </div><!-- .container -->
        </div><!-- .header-wrapper -->
        
        <!-- Search Overlay -->
        <div class="search-overlay">
            <div class="search-overlay-content">
                <button class="search-close">
                    <i class="fas fa-times"></i>
                    <span class="screen-reader-text"><?php esc_html_e('Close search', 'versatile'); ?></span>
                </button>
                <div class="search-form-wrapper">
                    <h3><?php esc_html_e('Search the site', 'versatile'); ?></h3>
                    <?php get_search_form(); ?>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu Overlay -->
        <div class="mobile-menu-overlay">
            <div class="mobile-menu-content">
                <div class="mobile-menu-header">
                    <div class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
                    </div>
                    <button class="mobile-menu-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <nav class="mobile-navigation">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'menu-1',
                            'menu_class'     => 'mobile-menu',
                            'container'      => false,
                            'fallback_cb'    => 'versatilefallback_menu',
                        )
                    );
                    ?>
                </nav>
                
                <!-- Mobile Search -->
                <div class="mobile-search">
                    <?php get_search_form(); ?>
                </div>
                
                <!-- Mobile Social Links -->
                <?php if (get_theme_mod('versatile_social_links_mobile', true)) : ?>
                    <div class="mobile-social">
                        <?php versatile_social_links(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header><!-- #masthead -->

    <!-- Page Content Start -->
    <div id="content" class="site-content">

<style>
/* Critical CSS - Search Overlay Hidden by Default */
.search-overlay {
    position: fixed !important;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(45, 55, 72, 0.95);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0 !important;
    visibility: hidden !important;
    transition: all 0.3s ease;
}

.search-overlay.active {
    opacity: 1 !important;
    visibility: visible !important;
}

.mobile-menu-overlay {
    position: fixed !important;
    opacity: 0 !important;
    visibility: hidden !important;
    transition: all 0.3s ease;
}

.mobile-menu-overlay.active {
    opacity: 1 !important;
    visibility: visible !important;
}

/* Basic Header Styling */
.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
}

.site-title {
    margin: 0;
    font-size: 1.8rem;
    font-weight: 700;
}

.site-title a {
    color: #2d3748;
    text-decoration: none;
}

.primary-menu {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 30px;
}

.primary-menu a {
    color: #2d3748;
    text-decoration: none;
    font-weight: 500;
    padding: 10px 0;
}

.primary-menu a:hover {
    color: #667eea;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 20px;
}

.search-toggle {
    background: none;
    border: none;
    color: #2d3748;
    font-size: 18px;
    cursor: pointer;
    padding: 10px;
}

.menu-toggle {
    display: none;
    background: none;
    border: none;
    cursor: pointer;
    padding: 10px;
    flex-direction: column;
    gap: 4px;
}

.menu-toggle-icon span {
    width: 24px;
    height: 2px;
    background: #2d3748;
}

@media (max-width: 991px) {
    .primary-menu {
        display: none;
    }
    
    .menu-toggle {
        display: flex;
    }
}
</style>

<script>
// Critical JavaScript - Hide Search Overlay and Control Interactions
document.addEventListener('DOMContentLoaded', function() {
    // Ensure search overlay is hidden on load
    const searchOverlay = document.querySelector('.search-overlay');
    const mobileOverlay = document.querySelector('.mobile-menu-overlay');
    
    if (searchOverlay) {
        searchOverlay.style.opacity = '0';
        searchOverlay.style.visibility = 'hidden';
        searchOverlay.classList.remove('active');
    }
    
    if (mobileOverlay) {
        mobileOverlay.style.opacity = '0';
        mobileOverlay.style.visibility = 'hidden';
        mobileOverlay.classList.remove('active');
    }
    
    // Search toggle functionality
    const searchToggle = document.querySelector('.search-toggle');
    const searchClose = document.querySelector('.search-close');
    
    if (searchToggle && searchOverlay) {
        searchToggle.addEventListener('click', function(e) {
            e.preventDefault();
            searchOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Focus on search field
            setTimeout(() => {
                const searchField = searchOverlay.querySelector('.search-field');
                if (searchField) searchField.focus();
            }, 300);
        });
    }
    
    if (searchClose && searchOverlay) {
        searchClose.addEventListener('click', function(e) {
            e.preventDefault();
            closeSearch();
        });
        
        // Close on overlay click
        searchOverlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeSearch();
            }
        });
        
        // Close on escape key
        document.addEventListener('keyup', function(e) {
            if (e.keyCode === 27 && searchOverlay.classList.contains('active')) {
                closeSearch();
            }
        });
    }
    
    function closeSearch() {
        if (searchOverlay) {
            searchOverlay.classList.remove('active');
            document.body.style.overflow = '';
            const searchField = searchOverlay.querySelector('.search-field');
            if (searchField) searchField.value = '';
        }
    }
    
    // Mobile menu functionality
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileClose = document.querySelector('.mobile-menu-close');
    
    if (menuToggle && mobileOverlay) {
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            mobileOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }
    
    if (mobileClose && mobileOverlay) {
        mobileClose.addEventListener('click', function(e) {
            e.preventDefault();
            closeMobile();
        });
        
        mobileOverlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeMobile();
            }
        });
    }
    
    function closeMobile() {
        if (mobileOverlay) {
            mobileOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
});
</script>