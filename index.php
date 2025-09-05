<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * Versatile WordPress Theme
 */

get_header(); ?>

<main class="site-main">
    <div class="container">
        <div class="row">
            <div class="<?php echo is_active_sidebar('sidebar-1') ? 'col-lg-8' : 'col-12'; ?>">
                
                <?php if (have_posts()) : ?>
                    
                    <?php if (is_home() && !is_front_page()) : ?>
                        <header class="page-header">
                            <h1 class="page-title"><?php single_post_title(); ?></h1>
                        </header>
                    <?php endif; ?>
                    
                    <div class="posts-container posts-grid">
                        <?php while (have_posts()) : the_post(); ?>
                            
                            <article id="post-<?php the_ID(); ?>" <?php post_class('post-item post-card'); ?>>
                                
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php echo versatile_get_post_image(get_the_ID(), 'large', array('class' => 'img-fluid')); ?>
                                    </a>
                                    <div class="post-overlay">
                                        <div class="post-categories">
                                            <?php if (has_category()) : ?>
                                                <?php the_category(' '); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="post-content">
                                    <header class="entry-header">
                                        <div class="post-meta">
                                            <span class="post-date">
                                                <i class="fas fa-calendar-alt"></i>
                                                <?php echo get_the_date(); ?>
                                            </span>
                                            <span class="post-author">
                                                <i class="fas fa-user"></i>
                                                <?php the_author(); ?>
                                            </span>
                                            <?php if (comments_open() || get_comments_number()) : ?>
                                                <span class="post-comments">
                                                    <i class="fas fa-comments"></i>
                                                    <?php comments_number('0', '1', '%'); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <?php
                                        if (is_singular()) :
                                            the_title('<h1 class="entry-title">', '</h1>');
                                        else :
                                            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                                        endif;
                                        ?>
                                    </header><!-- .entry-header -->

                                    <div class="entry-content">
                                        <?php
                                        if (is_singular()) {
                                            the_content(
                                                sprintf(
                                                    wp_kses(
                                                        /* translators: %s: Name of current post. Only visible to screen readers */
                                                        __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'versatile'),
                                                        array(
                                                            'span' => array(
                                                                'class' => array(),
                                                            ),
                                                        )
                                                    ),
                                                    wp_kses_post(get_the_title())
                                                )
                                            );

                                            wp_link_pages(
                                                array(
                                                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'versatile'),
                                                    'after'  => '</div>',
                                                )
                                            );
                                        } else {
                                            // Show excerpt for archive pages
                                            if (has_excerpt()) {
                                                the_excerpt();
                                            } else {
                                                echo '<p>' . wp_trim_words(get_the_content(), 20, '...') . '</p>';
                                            }
                                            
                                            echo '<a href="' . esc_url(get_permalink()) . '" class="read-more-btn">';
                                            echo esc_html__('Read More', 'versatile');
                                            echo ' <i class="fas fa-arrow-right"></i></a>';
                                        }
                                        ?>
                                    </div><!-- .entry-content -->

                                    <?php if (has_tag() && is_singular()) : ?>
                                        <footer class="entry-footer">
                                            <div class="post-tags">
                                                <i class="fas fa-tags"></i>
                                                <?php the_tags('', ', ', ''); ?>
                                            </div>
                                        </footer><!-- .entry-footer -->
                                    <?php endif; ?>
                                </div>
                            </article><!-- #post-<?php the_ID(); ?> -->
                            
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <nav class="posts-navigation" aria-label="Posts Navigation">
                        <div class="nav-links">
                            <?php
                            // Previous/Next post navigation
                            if (is_singular()) {
                                the_post_navigation(
                                    array(
                                        'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'versatile') . '</span> <span class="nav-title">%title</span>',
                                        'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'versatile') . '</span> <span class="nav-title">%title</span>',
                                    )
                                );
                            } else {
                                // Archive pagination
                                the_posts_navigation(
                                    array(
                                        'prev_text' => '<i class="fas fa-chevron-left"></i> ' . esc_html__('Older posts', 'versatile'),
                                        'next_text' => esc_html__('Newer posts', 'versatile') . ' <i class="fas fa-chevron-right"></i>',
                                    )
                                );
                            }
                            ?>
                        </div>
                    </nav>
                    
                <?php else : ?>
                    
                    <!-- No Posts Found -->
                    <section class="no-results not-found">
                        <header class="page-header">
                            <h1 class="page-title"><?php esc_html_e('Nothing here', 'versatile'); ?></h1>
                        </header><!-- .page-header -->

                        <div class="page-content">
                            <?php if (is_home() && current_user_can('publish_posts')) : ?>

                                <p>
                                    <?php
                                    printf(
                                        wp_kses(
                                            /* translators: 1: link to WP admin new post page. */
                                            __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'versatile'),
                                            array(
                                                'a' => array(
                                                    'href' => array(),
                                                ),
                                            )
                                        ),
                                        esc_url(admin_url('post-new.php'))
                                    );
                                    ?>
                                </p>

                            <?php elseif (is_search()) : ?>

                                <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'versatile'); ?></p>
                                <?php get_search_form(); ?>

                            <?php else : ?>

                                <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'versatile'); ?></p>
                                <?php get_search_form(); ?>

                            <?php endif; ?>
                        </div><!-- .page-content -->
                    </section><!-- .no-results -->
                    
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <?php if (is_active_sidebar('sidebar-1')) : ?>
                <div class="col-lg-4">
                    <?php get_sidebar(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main><!-- #main -->

<style>
/* Modern Tiled Blog Layout */
.site-main {
    padding: 40px 0;
}

.posts-container {
    margin-bottom: 40px;
}

.posts-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-bottom: 40px;
}

.post-item {
    background: linear-gradient(145deg, #ffffff, #f8fafc);
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(226, 232, 240, 0.8);
    position: relative;
}

.post-item:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
    border-color: rgba(102, 126, 234, 0.3);
}

.post-thumbnail {
    position: relative;
    height: 250px;
    overflow: hidden;
    background: #f7fafc;
}

.post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.post-item:hover .post-thumbnail img {
    transform: scale(1.08);
}

.post-placeholder-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f7fafc, #edf2f7);
}

.placeholder-svg {
    width: 100%;
    height: 100%;
}

.post-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, transparent 50%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: flex-start;
    justify-content: flex-end;
    padding: 20px;
}

.post-item:hover .post-overlay {
    opacity: 1;
}

.post-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.post-categories a {
    background: rgba(255, 255, 255, 0.9);
    color: #2d3748;
    padding: 4px 12px;
    border-radius: 15px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.post-categories a:hover {
    background: var(--primary-color);
    color: white;
    transform: scale(1.05);
}

.post-content {
    padding: 25px;
}

.post-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 15px;
    font-size: 13px;
    color: #718096;
}

.post-meta span {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #f7fafc;
    padding: 4px 10px;
    border-radius: 12px;
    font-weight: 500;
}

.post-meta i {
    font-size: 12px;
    color: var(--primary-color);
}

.post-meta a {
    color: inherit;
    text-decoration: none;
}

.post-meta a:hover {
    color: var(--primary-color);
}

.entry-title {
    margin-bottom: 12px;
    line-height: 1.3;
    font-size: 1.25rem;
    font-weight: 700;
}

.entry-title a {
    color: #2d3748;
    text-decoration: none;
    transition: color 0.3s ease;
}

.entry-title a:hover {
    color: var(--primary-color);
}

.entry-content {
    line-height: 1.6;
    margin-bottom: 20px;
    color: #4a5568;
}

.entry-content p {
    margin-bottom: 12px;
    font-size: 14px;
}

.read-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(45deg, var(--primary-color), #764ba2);
    color: white;
    padding: 10px 18px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.read-more-btn:hover {
    background: linear-gradient(45deg, var(--primary-hover), #6b46c1);
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.read-more-btn i {
    transition: transform 0.3s ease;
}

.read-more-btn:hover i {
    transform: translateX(3px);
}

.post-tags {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
}

.post-tags i {
    color: #667eea;
    margin-right: 8px;
}

.post-tags a {
    display: inline-block;
    background: #f7fafc;
    color: #4a5568;
    padding: 4px 12px;
    border-radius: 15px;
    text-decoration: none;
    font-size: 14px;
    margin: 2px;
    transition: all 0.3s ease;
}

.post-tags a:hover {
    background: #667eea;
    color: white;
}

.posts-navigation {
    margin-top: 40px;
    margin-bottom: 40px;
    clear: both;
}

.nav-links {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.nav-links a {
    background: var(--primary-color);
    color: white;
    padding: 12px 24px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    min-width: 120px;
    text-align: center;
}

.nav-links a:hover {
    background: var(--primary-hover);
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

/* Distinct styles for previous and next buttons */
.nav-previous a {
    background: var(--secondary-color) !important;
    color: var(--text-color) !important;
    border: 2px solid var(--border-color) !important;
}

.nav-previous a:hover {
    background: var(--primary-color) !important;
    color: white !important;
    border-color: var(--primary-color) !important;
}

.nav-next a {
    background: var(--text-color) !important;
    color: white !important;
    border: 2px solid var(--text-color) !important;
}

.nav-next a:hover {
    background: var(--primary-color) !important;
    color: white !important;
    border-color: var(--primary-color) !important;
}

.no-results {
    text-align: center;
    padding: 60px 30px;
    background: #f7fafc;
    border-radius: 10px;
}

.page-title {
    color: #2d3748;
    margin-bottom: 20px;
}

.page-content p {
    color: #4a5568;
    margin-bottom: 20px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .posts-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }
}

@media (max-width: 900px) {
    .posts-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}

@media (max-width: 768px) {
    .site-main {
        padding: 30px 0;
    }
    
    .posts-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .post-item {
        border-radius: 15px;
    }
    
    .post-thumbnail {
        height: 220px;
    }
    
    .post-content {
        padding: 20px;
    }
    
    .post-meta {
        gap: 8px;
        margin-bottom: 12px;
    }
    
    .post-meta span {
        padding: 3px 8px;
        font-size: 12px;
    }
    
    .entry-title {
        font-size: 1.2rem;
        margin-bottom: 10px;
    }
    
    .entry-content p {
        font-size: 13px;
    }
    
    .read-more-btn {
        padding: 8px 16px;
        font-size: 13px;
    }
    
    .nav-links {
        flex-direction: column;
        gap: 15px;
    }
    
    .nav-links a {
        width: 100%;
        text-align: center;
        padding: 15px 20px;
    }
    
    .post-overlay {
        padding: 15px;
    }
    
    .post-categories a {
        font-size: 11px;
        padding: 3px 8px;
    }
}

@media (max-width: 480px) {
    .posts-grid {
        gap: 15px;
    }
    
    .post-thumbnail {
        height: 200px;
    }
    
    .post-content {
        padding: 18px;
    }
    
    .entry-title {
        font-size: 1.1rem;
    }
    
    .read-more-btn {
        width: 100%;
        justify-content: center;
        padding: 10px;
    }
    
    .placeholder-svg {
        width: 100%;
        height: 100%;
    }
}
</style>

<?php get_footer(); ?>