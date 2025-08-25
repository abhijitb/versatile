<?php
/**
 * The footer template file
 * Contains the closing of the #content div and all content after
 * Versatile WordPress Theme
 */
?>

    </div><!-- #content -->

    <!-- Footer -->
    <footer id="colophon" class="site-footer">
        
        <!-- Footer Widgets -->
        <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) : ?>
            <div class="footer-widgets">
                <div class="container">
                    <div class="footer-widgets-grid">
                        <?php if (is_active_sidebar('footer-1')) : ?>
                            <div class="footer-widget-area footer-1">
                                <?php dynamic_sidebar('footer-1'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (is_active_sidebar('footer-2')) : ?>
                            <div class="footer-widget-area footer-2">
                                <?php dynamic_sidebar('footer-2'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (is_active_sidebar('footer-3')) : ?>
                            <div class="footer-widget-area footer-3">
                                <?php dynamic_sidebar('footer-3'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (is_active_sidebar('footer-4')) : ?>
                            <div class="footer-widget-area footer-4">
                                <?php dynamic_sidebar('footer-4'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Footer Info -->
        <div class="footer-info">
            <div class="container">
                <div class="footer-info-content">
                    
                    <!-- Footer Left -->
                    <div class="footer-left">
                        <div class="footer-branding">
                            <?php if (has_custom_logo()) : ?>
                                <div class="footer-logo">
                                    <?php the_custom_logo(); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="footer-site-info">
                                <h3 class="footer-site-title">
                                    <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
                                </h3>
                                <?php
                                $description = get_bloginfo('description', 'display');
                                if ($description || is_customize_preview()) :
                                ?>
                                    <p class="footer-site-description"><?php echo $description; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Footer Contact Info -->
                        <?php
                        $phone = get_theme_mod('versatile_contact_phone', '');
                        $email = get_theme_mod('versatile_contact_email', '');
                        $address = get_theme_mod('versatile_contact_address', '');
                        
                        if ($phone || $email || $address) :
                        ?>
                            <div class="footer-contact">
                                <?php if ($phone) : ?>
                                    <div class="contact-item">
                                        <i class="fas fa-phone"></i>
                                        <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($email) : ?>
                                    <div class="contact-item">
                                        <i class="fas fa-envelope"></i>
                                        <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($address) : ?>
                                    <div class="contact-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span><?php echo esc_html($address); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Footer Center -->
                    <div class="footer-center">
                        
                        <!-- Footer Navigation -->
                        <?php if (has_nav_menu('footer-menu')) : ?>
                            <nav class="footer-navigation">
                                <h4 class="footer-nav-title"><?php esc_html_e('Quick Links', 'versatile'); ?></h4>
                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'footer-menu',
                                    'menu_class'     => 'footer-menu',
                                    'container'      => false,
                                    'depth'          => 1,
                                ));
                                ?>
                            </nav>
                        <?php endif; ?>
                        
                        <!-- Newsletter Signup -->
                        <?php if (get_theme_mod('versatile_newsletter_enable', false)) : ?>
                            <div class="footer-newsletter">
                                <h4 class="newsletter-title">
                                    <?php echo esc_html(get_theme_mod('versatile_newsletter_title', __('Subscribe to Newsletter', 'versatile'))); ?>
                                </h4>
                                <p class="newsletter-description">
                                    <?php echo esc_html(get_theme_mod('versatile_newsletter_description', __('Get the latest updates and news.', 'versatile'))); ?>
                                </p>
                                
                                <form class="newsletter-form" method="post" action="#" onsubmit="handleNewsletterSignup(event)">
                                    <div class="newsletter-input-group">
                                        <input type="email" 
                                               name="newsletter_email" 
                                               placeholder="<?php esc_attr_e('Enter your email', 'versatile'); ?>" 
                                               required>
                                        <button type="submit" class="newsletter-submit">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Footer Right -->
                    <div class="footer-right">
                        
                        <!-- Social Media Links -->
                        <div class="footer-social">
                            <h4 class="social-title"><?php esc_html_e('Follow Us', 'versatile'); ?></h4>
                            <div class="social-links">
                                <?php versatile_social_links(); ?>
                            </div>
                        </div>
                        
                        <!-- Payment Methods (for e-commerce) -->
                        <?php if (class_exists('WooCommerce') && get_theme_mod('versatile_payment_methods', false)) : ?>
                            <div class="payment-methods">
                                <h4 class="payment-title"><?php esc_html_e('We Accept', 'versatile'); ?></h4>
                                <div class="payment-icons">
                                    <i class="fab fa-cc-visa" title="Visa"></i>
                                    <i class="fab fa-cc-mastercard" title="Mastercard"></i>
                                    <i class="fab fa-cc-paypal" title="PayPal"></i>
                                    <i class="fab fa-cc-stripe" title="Stripe"></i>
                                    <i class="fab fa-cc-apple-pay" title="Apple Pay"></i>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    
                    <!-- Copyright -->
                    <div class="footer-copyright">
                        <?php
                        $copyright_text = get_theme_mod('versatile_copyright_text', '');
                        if ($copyright_text) {
                            echo wp_kses_post($copyright_text);
                        } else {
                            printf(
                                esc_html__('© %1$s %2$s. All rights reserved.', 'versatile'),
                                date('Y'),
                                get_bloginfo('name')
                            );
                        }
                        ?>
                    </div>
                    
                    <!-- Footer Menu (Legal/Privacy) -->
                    <?php if (has_nav_menu('footer-legal-menu')) : ?>
                        <nav class="footer-legal-nav">
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer-legal-menu',
                                'menu_class'     => 'footer-legal-menu',
                                'container'      => false,
                                'depth'          => 1,
                            ));
                            ?>
                        </nav>
                    <?php endif; ?>
                    
                    <!-- Theme Credit -->
                    <div class="theme-credit">
                        <?php
                        if (get_theme_mod('versatile_show_theme_credit', true)) {
                            printf(
                                esc_html__('Powered by %1$s | Theme: %2$s', 'versatile'),
                                '<a href="' . esc_url('https://wordpress.org/') . '">WordPress</a>',
                                '<a href="#" rel="designer">Versatile</a>'
                            );
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->
    
    <!-- Back to Top Button -->
    <button id="back-to-top" class="back-to-top" aria-label="<?php esc_attr_e('Back to top', 'versatile'); ?>">
        <i class="fas fa-chevron-up"></i>
    </button>
    
    <!-- Notification Container -->
    <div id="notifications" class="notifications-container"></div>

</div><!-- #page -->

<script>
// Newsletter signup handling
function handleNewsletterSignup(event) {
    event.preventDefault();
    const email = event.target.newsletter_email.value;
    
    // Here you would typically send to your newsletter service
    console.log('Newsletter signup:', email);
    
    // Show success message
    showNotification('Thank you for subscribing!', 'success');
    
    // Reset form
    event.target.reset();
}

// Notification system
function showNotification(message, type = 'info') {
    const container = document.getElementById('notifications');
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <span class="notification-message">${message}</span>
        <button class="notification-close" onclick="this.parentElement.remove()">×</button>
    `;
    
    container.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Back to top functionality
document.addEventListener('DOMContentLoaded', function() {
    const backToTop = document.getElementById('back-to-top');
    
    if (backToTop) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });
        
        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
</script>

<?php wp_footer(); ?>

</body>
</html>