<?php
/**
 * Template for displaying search results
 * Versatile WordPress Theme
 */

get_header(); ?>

<main class="site-main search-main">
    
    <!-- Search Header -->
    <section class="search-header">
        <div class="container">
            <div class="search-header-content">
                <h1 class="search-title">
                    <i class="fas fa-search"></i>
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
                            <i class="fas fa-file-alt"></i>
                            <?php
                            printf(
                                _n('%s result found', '%s results found', $total_results, 'versatile'),
                                '<strong>' . number_format_i18n($total_results) . '</strong>'
                            );
                            ?>
                        </span>
                    <?php endif; ?>
                    
                    <span class="search-time">
                        <i class="fas fa-clock"></i>
                        <?php printf(esc_html__('Search completed in %s seconds', 'versatile'), timer_stop(0, 3)); ?>
                    </span>
                </div>
                
                <!-- New Search Form -->
                <div class="search-again">
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="search-input-group">
                            <input type="search" 
                                   class="search-field" 
                                   placeholder="<?php esc_attr_e('Try another search...', 'versatile'); ?>" 
                                   value="<?php echo esc_attr($search_query); ?>" 
                                   name="s" 
                                   title="<?php esc_attr_e('Search for:', 'versatile'); ?>">
                            <button type="submit" class="search-submit">
                                <i class="fas fa-search"></i>
                                <span class="sr-only"><?php esc_html_e('Search', 'versatile'); ?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Results Content -->
    <section class="search-results-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    
                    <?php if (have_posts()) : ?>
                        
                        <!-- Search Filters -->
                        <div class="search-filters">
                            <div class="filter-group">
                                <label for="search-filter"><?php esc_html_e('Filter by:', 'versatile'); ?></label>
                                <select id="search-filter" onchange="filterSearchResults(this.value)">
                                    <option value="all"><?php esc_html_e('All Content', 'versatile'); ?></option>
                                    <option value="post"><?php esc_html_e('Blog Posts', 'versatile'); ?></option>
                                    <option value="page"><?php esc_html_e('Pages', 'versatile'); ?></option>
                                    <?php if (class_exists('WooCommerce')) : ?>
                                        <option value="product"><?php esc_html_e('Products', 'versatile'); ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            
                            <div class="sort-group">
                                <label for="search-sort"><?php esc_html_e('Sort by:', 'versatile'); ?></label>
                                <select id="search-sort" onchange="location = this.value;">
                                    <option value="<?php echo add_query_arg(array('s' => $search_query, 'orderby' => 'relevance')); ?>">
                                        <?php esc_html_e('Relevance', 'versatile'); ?>
                                    </option>
                                    <option value="<?php echo add_query_arg(array('s' => $search_query, 'orderby' => 'date')); ?>">
                                        <?php esc_html_e('Newest First', 'versatile'); ?>
                                    </option>
                                    <option value="<?php echo add_query_arg(array('s' => $search_query, 'orderby' => 'title')); ?>">
                                        <?php esc_html_e('Title A-Z', 'versatile'); ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="search-results-list" id="search-results">
                            <?php while (have_posts()) : the_post(); ?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?> data-post-type="<?php echo get_post_type(); ?>">
                                    
                                    <div class="search-result-content">
                                        <div class="result-header">
                                            <div class="result-meta">
                                                <span class="result-type">
                                                    <?php
                                                    $post_type_obj = get_post_type_object(get_post_type());
                                                    echo esc_html($post_type_obj->labels->singular_name);
                                                    ?>
                                                </span>
                                                <span class="result-date">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <?php echo get_the_date(); ?>
                                                </span>
                                                <?php if ('post' === get_post_type() && has_category()) : ?>
                                                    <span class="result-category">
                                                        <i class="fas fa-folder"></i>
                                                        <?php the_category(', '); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Relevance Score (mock implementation) -->
                                            <div class="relevance-score">
                                                <?php
                                                // Simple relevance calculation based on title and content matches
                                                $title_matches = substr_count(strtolower(get_the_title()), strtolower($search_query));
                                                $content_matches = substr_count(strtolower(get_the_content()), strtolower($search_query));
                                                $total_matches = $title_matches * 2 + $content_matches; // Title matches worth more
                                                $relevance_percentage = min(100, $total_matches * 10);
                                                ?>
                                                <div class="relevance-bar">
                                                    <div class="relevance-fill" style="width: <?php echo $relevance_percentage; ?>%"></div>
                                                </div>
                                                <span class="relevance-text"><?php echo $relevance_percentage; ?>% <?php esc_html_e('match', 'versatile'); ?></span>
                                            </div>
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
                                        
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="result-thumbnail">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail('thumbnail', array('class' => 'img-fluid')); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        
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
                                            <a href="<?php the_permalink(); ?>" class="result-link">
                                                <?php esc_html_e('Read More', 'versatile'); ?>
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                            
                                            <div class="result-url">
                                                <?php echo esc_url(get_permalink()); ?>
                                            </div>
                                            
                                            <?php if ('post' === get_post_type() && has_tag()) : ?>
                                                <div class="result-tags">
                                                    <?php the_tags('', ' '); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                        </div>
                        
                        <!-- Search Pagination -->
                        <nav class="search-pagination" aria-label="Search Results Pagination">
                            <?php
                            $pagination = paginate_links(array(
                                'prev_text' => '<i class="fas fa-chevron-left"></i> ' . esc_html__('Previous', 'versatile'),
                                'next_text' => esc_html__('Next', 'versatile') . ' <i class="fas fa-chevron-right"></i>',
                                'type' => 'array',
                                'add_args' => array('s' => $search_query),
                            ));
                            
                            if ($pagination) {
                                echo '<ul class="pagination">';
                                foreach ($pagination as $page) {
                                    echo '<li class="page-item">' . $page . '</li>';
                                }
                                echo '</ul>';
                            }
                            ?>
                        </nav>
                        
                    <?php else : ?>
                        
                        <!-- No Results Found -->
                        <div class="no-results-found">
                            <div class="no-results-content">
                                <i class="fas fa-search-minus fa-4x"></i>
                                <h3><?php esc_html_e('No Results Found', 'versatile'); ?></h3>
                                <p><?php esc_html_e('Sorry, no content matched your search criteria. Here are some suggestions:', 'versatile'); ?></p>
                                
                                <div class="search-suggestions">
                                    <ul>
                                        <li><?php esc_html_e('Check your spelling and try again', 'versatile'); ?></li>
                                        <li><?php esc_html_e('Try using fewer or different keywords', 'versatile'); ?></li>
                                        <li><?php esc_html_e('Use more general terms', 'versatile'); ?></li>
                                        <li><?php esc_html_e('Browse our categories instead', 'versatile'); ?></li>
                                    </ul>
                                </div>
                                
                                <!-- Popular Categories -->
                                <div class="popular-categories">
                                    <h4><?php esc_html_e('Popular Categories', 'versatile'); ?></h4>
                                    <div class="category-links">
                                        <?php
                                        $popular_categories = get_categories(array(
                                            'orderby' => 'count',
                                            'order' => 'DESC',
                                            'number' => 5,
                                            'hide_empty' => true,
                                        ));
                                        
                                        foreach ($popular_categories as $category) {
                                            echo '<a href="' . get_category_link($category->term_id) . '" class="category-link">';
                                            echo esc_html($category->name) . ' (' . $category->count . ')';
                                            echo '</a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                
                                <!-- Recent Posts -->
                                <div class="recent-posts-suggestions">
                                    <h4><?php esc_html_e('Recent Posts', 'versatile'); ?></h4>
                                    <?php
                                    $recent_posts = get_posts(array(
                                        'numberposts' => 3,
                                        'post_status' => 'publish',
                                    ));
                                    
                                    if ($recent_posts) {
                                        echo '<div class="recent-posts-list">';
                                        foreach ($recent_posts as $recent_post) {
                                            echo '<div class="recent-post-item">';
                                            echo '<a href="' . get_permalink($recent_post->ID) . '">' . get_the_title($recent_post->ID) . '</a>';
                                            echo '<span class="recent-post-date">' . get_the_date('', $recent_post->ID) . '</span>';
                                            echo '</div>';
                                        }
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                    <?php endif; ?>
                </div>
                
                <!-- Search Sidebar -->
                <div class="col-lg-4">
                    <aside class="search-sidebar">
                        
                        <!-- Search Statistics -->
                        <?php if (have_posts()) : ?>
                            <div class="widget search-stats-widget">
                                <h3 class="widget-title"><?php esc_html_e('Search Statistics', 'versatile'); ?></h3>
                                <div class="search-stats">
                                    <div class="stat-item">
                                        <span class="stat-label"><?php esc_html_e('Total Results:', 'versatile'); ?></span>
                                        <span class="stat-value"><?php echo number_format_i18n($total_results); ?></span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label"><?php esc_html_e('Current Page:', 'versatile'); ?></span>
                                        <span class="stat-value"><?php echo get_query_var('paged') ?: 1; ?> of <?php echo $wp_query->max_num_pages; ?></span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label"><?php esc_html_e('Search Term:', 'versatile'); ?></span>
                                        <span class="stat-value">"<?php echo esc_html($search_query); ?>"</span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Related Searches -->
                        <div class="widget related-searches-widget">
                            <h3 class="widget-title"><?php esc_html_e('Related Searches', 'versatile'); ?></h3>
                            <div class="related-searches">
                                <?php
                                // Generate related search suggestions based on the search term
                                $search_words = explode(' ', $search_query);
                                $related_terms = array();
                                
                                // Get tags that contain search words
                                $related_tags = get_tags(array(
                                    'search' => $search_query,
                                    'number' => 5,
                                ));
                                
                                foreach ($related_tags as $tag) {
                                    $related_terms[] = $tag->name;
                                }
                                
                                // Get categories that contain search words
                                $related_categories = get_categories(array(
                                    'search' => $search_query,
                                    'number' => 3,
                                ));
                                
                                foreach ($related_categories as $category) {
                                    $related_terms[] = $category->name;
                                }
                                
                                // Remove duplicates and limit
                                $related_terms = array_unique($related_terms);
                                $related_terms = array_slice($related_terms, 0, 8);
                                
                                if ($related_terms) {
                                    foreach ($related_terms as $term) {
                                        $search_url = add_query_arg('s', $term, home_url('/'));
                                        echo '<a href="' . esc_url($search_url) . '" class="related-search-link">' . esc_html($term) . '</a>';
                                    }
                                } else {
                                    echo '<p>' . esc_html__('No related searches found.', 'versatile') . '</p>';
                                }
                                ?>
                            </div>
                        </div>
                        
                        <!-- Regular Sidebar -->
                        <?php if (is_active_sidebar('sidebar-1')) : ?>
                            <?php dynamic_sidebar('sidebar-1'); ?>
                        <?php endif; ?>
                    </aside>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
// Search results filtering
function filterSearchResults(postType) {
    const results = document.querySelectorAll('.search-result-item');
    
    results.forEach(result => {
        if (postType === 'all' || result.getAttribute('data-post-type') === postType) {
            result.style.display = 'block';
        } else {
            result.style.display = 'none';
        }
    });
}

// Auto-focus search field when page loads
document.addEventListener('DOMContentLoaded', function() {
    const searchField = document.querySelector('.search-field');
    if (searchField && window.location.search.includes('s=')) {
        searchField.focus();
        searchField.setSelectionRange(searchField.value.length, searchField.value.length);
    }
});
</script>

<?php get_footer(); ?>