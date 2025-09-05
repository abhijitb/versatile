<?php
/**
 * Template for displaying search results
 * Versatile WordPress Theme
 */

// Enqueue search-specific styles
wp_enqueue_style('versatile-search', get_template_directory_uri() . '/css/search.css', array(), _S_VERSION);

get_header(); ?>

<main class="site-main">
    <div class="container">
        
        <!-- Search Header -->
        <header class="search-header">
            <h1 class="search-title">
                <?php
                global $wp_query;
                $search_query = get_search_query();
                $total_results = $wp_query->found_posts;
                
                if ($total_results > 0) {
                    printf(
                        esc_html__('Search Results for: "%s"', 'versatile'),
                        '<span class="search-term">' . esc_html($search_query) . '</span>'
                    );
                } else {
                    printf(
                        esc_html__('No Results for: "%s"', 'versatile'),
                        '<span class="search-term">' . esc_html($search_query) . '</span>'
                    );
                }
                ?>
            </h1>
            
            <div class="search-meta">
                <?php if ($total_results > 0) : ?>
                    <span class="results-count">
                        <?php
                        printf(
                            _n('%s result found', '%s results found', $total_results, 'versatile'),
                            '<strong>' . number_format_i18n($total_results) . '</strong>'
                        );
                        ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <!-- Search Form -->
            <div class="search-again">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="search" 
                           class="search-field" 
                           placeholder="<?php esc_attr_e('Try another search...', 'versatile'); ?>" 
                           value="<?php echo esc_attr($search_query); ?>" 
                           name="s" 
                           title="<?php esc_attr_e('Search for:', 'versatile'); ?>">
                    <button type="submit" class="search-submit">
                        <?php esc_html_e('Search', 'versatile'); ?>
                    </button>
                </form>
            </div>
        </header>

        <!-- Search Results Content -->
        <div class="row">
            <div class="<?php echo is_active_sidebar('sidebar-1') ? 'col-lg-8' : 'col-12'; ?>">
                <div class="search-results-content">
                    
                <?php if (have_posts()) : ?>
                        
                    <div class="search-results-list">
                        <?php while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?>>
                                
                                <div class="result-content">
                                    <div class="result-meta">
                                        <span class="result-type">
                                            <?php
                                            $post_type_obj = get_post_type_object(get_post_type());
                                            echo esc_html($post_type_obj->labels->singular_name);
                                            ?>
                                        </span>
                                        <span class="result-date">
                                            <?php echo get_the_date(); ?>
                                        </span>
                                    </div>
                                    
                                    <h2 class="result-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php
                                            // Highlight search terms in title
                                            $highlighted_title = preg_replace(
                                                '/(' . preg_quote($search_query, '/') . ')/i',
                                                '<mark>$1</mark>',
                                                get_the_title()
                                            );
                                            echo $highlighted_title;
                                            ?>
                                        </a>
                                    </h2>
                                    
                                    <div class="result-excerpt">
                                        <?php
                                        $excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30);
                                        // Highlight search terms in excerpt
                                        $highlighted_excerpt = preg_replace(
                                            '/(' . preg_quote($search_query, '/') . ')/i',
                                            '<mark>$1</mark>',
                                            $excerpt
                                        );
                                        echo $highlighted_excerpt;
                                        ?>
                                    </div>
                                    
                                    <div class="result-footer">
                                        <a href="<?php the_permalink(); ?>" class="read-more-link">
                                            <?php esc_html_e('Read More', 'versatile'); ?>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                        
                    <!-- Pagination -->
                    <nav class="pagination-wrapper" aria-label="Search Results Pagination">
                        <?php
                        the_posts_pagination(array(
                            'prev_text' => esc_html__('Previous', 'versatile'),
                            'next_text' => esc_html__('Next', 'versatile'),
                        ));
                        ?>
                    </nav>
                        
                <?php else : ?>
                    
                    <div class="no-results">
                        <h2><?php esc_html_e('No Results Found', 'versatile'); ?></h2>
                        <p><?php esc_html_e('Sorry, no content matched your search criteria. Try different keywords.', 'versatile'); ?></p>
                        
                        <div class="search-suggestions">
                            <h3><?php esc_html_e('Suggestions:', 'versatile'); ?></h3>
                            <ul>
                                <li><?php esc_html_e('Check your spelling and try again', 'versatile'); ?></li>
                                <li><?php esc_html_e('Try using fewer or different keywords', 'versatile'); ?></li>
                                <li><?php esc_html_e('Use more general terms', 'versatile'); ?></li>
                            </ul>
                        </div>
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