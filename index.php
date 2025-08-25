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
                    
                    <div class="posts-container">
                        <?php while (have_posts()) : the_post(); ?>
                            
                            <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="post-content">
                                    <header class="entry-header">
                                        <div class="post-meta">
                                            <span class="post-date">
                                                <i class="fas fa-calendar-alt"></i>
                                                <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo get_the_date(); ?></a>
                                            </span>
                                            <span class="post-author">
                                                <i class="fas fa-user"></i>
                                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                    <?php the_author(); ?>
                                                </a>
                                            </span>
                                            <?php if (has_category()) : ?>
                                                <span class="post-categories">
                                                    <i class="fas fa-folder"></i>
                                                    <?php the_category(', '); ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if (comments_open() || get_comments_number()) : ?>
                                                <span class="post-comments">
                                                    <i class="fas fa-comments"></i>
                                                    <a href="<?php comments_link(); ?>">
                                                        <?php comments_number('0 Comments', '1 Comment', '% Comments'); ?>
                                                    </a>
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
                                                echo '<p>' . wp_trim_words(get_the_content(), 25, '...') . '</p>';
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
/* Basic Index Page Styles */
.site-main {
    padding: 40px 0;
}

.posts-container {
    margin-bottom: 40px;
}

.post-item {
    background: #fff;
    border-radius: 10px;
    margin-bottom: 40px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: all 0.3s ease;
}

.post-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.post-thumbnail {
    overflow: hidden;
}

.post-thumbnail img {
    width: 100%;
    height: auto;
    transition: transform 0.3s ease;
}

.post-item:hover .post-thumbnail img {
    transform: scale(1.05);
}

.post-content {
    padding: 30px;
}

.post-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 15px;
    font-size: 14px;
    color: #666;
}

.post-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

.post-meta a {
    color: inherit;
    text-decoration: none;
}

.post-meta a:hover {
    color: #667eea;
}

.entry-title {
    margin-bottom: 15px;
    line-height: 1.3;
}

.entry-title a {
    color: #2d3748;
    text-decoration: none;
}

.entry-title a:hover {
    color: #667eea;
}

.entry-content {
    line-height: 1.6;
    margin-bottom: 20px;
}

.read-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--primary-color);
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.read-more-btn:hover {
    background: var(--primary-hover);
    color: white;
    text-decoration: none;
    transform: translateX(5px);
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

/* Responsive */
@media (max-width: 768px) {
    .post-meta {
        flex-direction: column;
        gap: 10px;
    }
    
    .entry-title {
        font-size: 1.5rem;
    }
    
    .nav-links {
        flex-direction: column;
        gap: 15px;
    }
    
    .nav-links a {
        width: 100%;
        text-align: center;
    }
}
</style>

<?php get_footer(); ?>