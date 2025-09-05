<?php
/**
 * Template for displaying single pages
 * Versatile WordPress Theme
 */

// Ensure main CSS is loaded (contains grid system)
wp_enqueue_style('versatile-main', get_template_directory_uri() . '/css/main.css', array(), _S_VERSION);

get_header(); ?>

<main class="site-main page-main">
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Page Hero Section -->
        <section class="page-hero">
            <div class="container">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="page-featured-image">
                        <?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?>
                    </div>
                <?php endif; ?>
                
                <div class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php if (has_excerpt()) : ?>
                        <div class="page-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Page Content -->
        <section class="page-content-section">
            <div class="container">
                <div class="row">
                    <?php
                    // Check if page should have sidebar
                    $page_layout = get_post_meta(get_the_ID(), '_page_layout', true);
                    $has_sidebar = ($page_layout !== 'full-width' && is_active_sidebar('sidebar-1'));
                    $content_class = $has_sidebar ? 'col-lg-8' : 'col-12';
                    ?>
                    
                    <div class="<?php echo $content_class; ?>">
                        <article id="post-<?php the_ID(); ?>" <?php post_class('page-article'); ?>>
                            <div class="page-content">
                                <?php
                                the_content();
                                
                                wp_link_pages(array(
                                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'versatile'),
                                    'after'  => '</div>',
                                ));
                                ?>
                            </div>
                        </article>
                        
                        <!-- Page Comments (if enabled) -->
                        <?php
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;
                        ?>
                    </div>
                    
                    <!-- Sidebar -->
                    <?php if ($has_sidebar) : ?>
                        <div class="col-lg-4">
                            <?php get_sidebar(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        
        <!-- Contact Form Section (for contact page) -->
        <?php if (is_page('contact') || is_page('contact-us')) : ?>
            <section class="contact-form-section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="contact-form-wrapper">
                                <h3><?php esc_html_e('Get In Touch', 'versatile'); ?></h3>
                                
                                <?php if (shortcode_exists('contact-form-7')) : ?>
                                    <!-- Contact Form 7 integration -->
                                    <p><?php esc_html_e('Please use the contact form below to send us a message.', 'versatile'); ?></p>
                                    <?php echo do_shortcode('[contact-form-7 id="1" title="Contact form 1"]'); ?>
                                <?php else : ?>
                                    <!-- Fallback contact form -->
                                    <form class="contact-form" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="contact_name"><?php esc_html_e('Name', 'versatile'); ?> *</label>
                                                <input type="text" class="form-control" id="contact_name" name="contact_name" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="contact_email"><?php esc_html_e('Email', 'versatile'); ?> *</label>
                                                <input type="email" class="form-control" id="contact_email" name="contact_email" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact_subject"><?php esc_html_e('Subject', 'versatile'); ?></label>
                                            <input type="text" class="form-control" id="contact_subject" name="contact_subject">
                                        </div>
                                        <div class="form-group">
                                            <label for="contact_message"><?php esc_html_e('Message', 'versatile'); ?> *</label>
                                            <textarea class="form-control" id="contact_message" name="contact_message" rows="6" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-lg" name="submit_contact"><?php esc_html_e('Send Message', 'versatile'); ?></button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        
        <!-- Services Grid (for services page) -->
        <?php if (is_page('services') || is_page('our-services')) : ?>
            <section class="services-grid-section">
                <div class="container">
                    <div class="services-grid">
                        <?php
                        // Get services from customizer or create default ones
                        $services = get_theme_mod('versatile_services', array());
                        
                        if (empty($services)) {
                            // Default services
                            $services = array(
                                array(
                                    'title' => 'Web Design',
                                    'description' => 'Modern, responsive websites tailored to your needs.',
                                    'icon' => 'fas fa-laptop-code'
                                ),
                                array(
                                    'title' => 'Development',
                                    'description' => 'Custom web applications and functionality.',
                                    'icon' => 'fas fa-code'
                                ),
                                array(
                                    'title' => 'SEO Optimization',
                                    'description' => 'Improve your search engine rankings.',
                                    'icon' => 'fas fa-search'
                                ),
                                array(
                                    'title' => 'Maintenance',
                                    'description' => 'Keep your website secure and up-to-date.',
                                    'icon' => 'fas fa-tools'
                                )
                            );
                        }
                        
                        foreach ($services as $service) : ?>
                            <div class="service-item">
                                <?php if (isset($service['icon'])) : ?>
                                    <div class="service-icon">
                                        <i class="<?php echo esc_attr($service['icon']); ?>"></i>
                                    </div>
                                <?php endif; ?>
                                <h4><?php echo esc_html($service['title']); ?></h4>
                                <p><?php echo esc_html($service['description']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>