<?php
/**
 * Template part for displaying search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Versatile
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?>>
    
    <div class="search-result-content">
        <div class="post-meta">
            <span class="post-date">
                <i class="fas fa-calendar-alt"></i>
                <?php echo get_the_date(); ?>
            </span>
            <span class="post-type">
                <i class="fas fa-file-alt"></i>
                <?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?>
            </span>
            <?php if (has_category() && get_post_type() === 'post') : ?>
                <span class="post-categories">
                    <i class="fas fa-folder"></i>
                    <?php the_category(', '); ?>
                </span>
            <?php endif; ?>
        </div>
        
        <h2 class="search-result-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        
        <div class="search-result-excerpt">
            <?php
            if (has_excerpt()) {
                the_excerpt();
            } else {
                $content = get_the_content();
                $search_term = get_search_query();
                
                // Highlight search terms in excerpt
                if ($search_term) {
                    $excerpt = wp_trim_words($content, 30, '...');
                    $highlighted = preg_replace('/(' . preg_quote($search_term, '/') . ')/i', '<mark>$1</mark>', $excerpt);
                    echo wp_kses_post($highlighted);
                } else {
                    echo wp_trim_words($content, 30, '...');
                }
            }
            ?>
        </div>
        
        <div class="search-result-footer">
            <a href="<?php the_permalink(); ?>" class="read-more-btn">
                <?php esc_html_e('View', 'versatile'); ?>
                <i class="fas fa-arrow-right"></i>
            </a>
            
            <div class="post-url">
                <small><?php echo esc_url(get_permalink()); ?></small>
            </div>
        </div>
    </div>
    
</article><!-- #post-<?php the_ID(); ?> -->
