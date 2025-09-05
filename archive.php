<?php
/**
 * Template for displaying archive pages (categories, tags, dates, etc.)
 * Versatile WordPress Theme
 */

// Enqueue archive-specific styles and scripts
wp_enqueue_style('versatile-archive', get_template_directory_uri() . '/css/archive.css', array(), _S_VERSION);
wp_enqueue_script('versatile-archive-toggle', get_template_directory_uri() . '/js/archive-view-toggle.js', array(), filemtime(get_template_directory() . '/js/archive-view-toggle.js'), true);

get_header(); ?>

<main class="site-main">
    <div class="container">
        
        <!-- Archive Header -->
        <header class="archive-header">
            <?php
            $archive_title = '';
            $archive_description = '';
            
            if (is_category()) {
                $archive_title = single_cat_title('', false);
                $archive_description = category_description();
            } elseif (is_tag()) {
                $archive_title = single_tag_title('', false);
                $archive_description = tag_description();
            } elseif (is_author()) {
                $archive_title = get_the_author();
                $archive_description = get_the_author_meta('description');
            } elseif (is_date()) {
                if (is_year()) {
                    $archive_title = get_the_date('Y');
                } elseif (is_month()) {
                    $archive_title = get_the_date('F Y');
                } elseif (is_day()) {
                    $archive_title = get_the_date();
                }
            } else {
                $archive_title = post_type_archive_title('', false);
            }
            ?>
            
            <h1 class="archive-title">
                <?php
                if (is_category()) {
                    echo esc_html__('Category:', 'versatile') . ' ';
                } elseif (is_tag()) {
                    echo esc_html__('Tag:', 'versatile') . ' ';
                } elseif (is_author()) {
                    echo esc_html__('Author:', 'versatile') . ' ';
                } elseif (is_date()) {
                    echo esc_html__('Archive:', 'versatile') . ' ';
                }
                echo esc_html($archive_title);
                ?>
            </h1>
            
            <?php if ($archive_description) : ?>
                <div class="archive-description">
                    <?php echo wp_kses_post($archive_description); ?>
                </div>
            <?php endif; ?>
            
            <div class="archive-meta">
                <?php
                global $wp_query;
                $total_posts = $wp_query->found_posts;
                printf(
                    _n('%s post found', '%s posts found', $total_posts, 'versatile'),
                    number_format_i18n($total_posts)
                );
                ?>
            </div>
        </header>

        <!-- Archive Content -->
        <div class="row">
            <div class="<?php echo is_active_sidebar('sidebar-1') ? 'col-lg-8' : 'col-12'; ?>">
                <div class="archive-content">
                    
                    <?php if (have_posts()) : ?>
                        
                        <!-- View Toggle Controls -->
                        <div class="archive-controls">
                            <div class="view-toggle">
                                <button class="view-btn active" data-view="grid">
                                    <?php esc_html_e('Grid View', 'versatile'); ?>
                                </button>
                                <button class="view-btn" data-view="list">
                                    <?php esc_html_e('List View', 'versatile'); ?>
                                </button>
                            </div>
                        </div>
                        
                        <div class="archive-posts-grid" id="archive-posts">
                            <?php while (have_posts()) : the_post(); ?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class('archive-post-item'); ?>>
                                    
                                    <!-- Featured Image -->
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php echo versatile_get_post_image(get_the_ID(), 'medium', array('class' => 'img-fluid')); ?>
                                        </a>
                                    </div>
                                    
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <span class="post-date">
                                                <?php echo get_the_date(); ?>
                                            </span>
                                            <span class="post-author">
                                                <?php esc_html_e('by', 'versatile'); ?> 
                                                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                                    <?php the_author(); ?>
                                                </a>
                                            </span>
                                            <?php if (comments_open() || get_comments_number()) : ?>
                                                <span class="post-comments">
                                                    <a href="<?php comments_link(); ?>">
                                                        <?php comments_number('0 comments', '1 comment', '% comments'); ?>
                                                    </a>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <h2 class="post-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        
                                        <?php if (has_category() && !is_category()) : ?>
                                            <div class="post-categories">
                                                <?php the_category(', '); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="post-excerpt">
                                            <?php
                                            if (has_excerpt()) {
                                                the_excerpt();
                                            } else {
                                                echo wp_trim_words(get_the_content(), 25, '...');
                                            }
                                            ?>
                                        </div>
                                        
                                        <div class="post-footer">
                                            <a href="<?php the_permalink(); ?>" class="read-more-link">
                                                <?php esc_html_e('Read More', 'versatile'); ?>
                                            </a>
                                            
                                            <?php if (has_tag()) : ?>
                                                <div class="post-tags">
                                                    <?php the_tags('', ' '); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                        </div>
                            
                        <!-- Pagination -->
                        <nav class="pagination-wrapper" aria-label="Archive Pagination">
                            <?php
                            the_posts_pagination(array(
                                'prev_text' => esc_html__('Previous', 'versatile'),
                                'next_text' => esc_html__('Next', 'versatile'),
                            ));
                            ?>
                        </nav>
                            
                    <?php else : ?>
                        
                        <div class="no-posts">
                            <h2><?php esc_html_e('No Posts Found', 'versatile'); ?></h2>
                            <p><?php esc_html_e('Sorry, no posts were found in this archive.', 'versatile'); ?></p>
                            <a href="<?php echo home_url('/'); ?>" class="back-home-link">
                                <?php esc_html_e('Back to Home', 'versatile'); ?>
                            </a>
                        </div>
                        
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Sidebar -->
            <?php if (is_active_sidebar('sidebar-1')) : ?>
                <div class="col-lg-4">
                    <?php get_sidebar(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>