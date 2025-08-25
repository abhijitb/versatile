<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Versatile
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar">
    <!-- Dynamic sidebar widgets or default fallback widgets -->
    <?php if (!dynamic_sidebar('sidebar-1')) : ?>
        
        <!-- Search Widget -->
        <section class="widget widget_search">
            <h2 class="widget-title"><?php esc_html_e('Search', 'versatile'); ?></h2>
            <?php get_search_form(); ?>
        </section>
        
        <!-- Recent Posts Widget -->
        <section class="widget widget_recent_entries">
            <h2 class="widget-title"><?php esc_html_e('Recent Posts', 'versatile'); ?></h2>
            <?php
            $recent_posts = wp_get_recent_posts(array(
                'numberposts' => 5,
                'post_status' => 'publish'
            ));
            
            if ($recent_posts) : ?>
                <ul>
                    <?php foreach ($recent_posts as $recent_post) : ?>
                        <li>
                            <a href="<?php echo esc_url(get_permalink($recent_post['ID'])); ?>">
                                <?php echo esc_html($recent_post['post_title']); ?>
                            </a>
                            <span class="post-date"><?php echo get_the_date('', $recent_post['ID']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
        
        <!-- Categories Widget -->
        <?php
        $categories = get_categories(array(
            'orderby' => 'count',
            'order'   => 'DESC',
            'number'  => 10,
            'hide_empty' => true,
        ));
        
        if ($categories) : ?>
            <section class="widget widget_categories">
                <h2 class="widget-title"><?php esc_html_e('Categories', 'versatile'); ?></h2>
                <ul>
                    <?php foreach ($categories as $category) : ?>
                        <li>
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                <?php echo esc_html($category->name); ?>
                                <span class="post-count">(<?php echo $category->count; ?>)</span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>
        
        <!-- Tags Widget -->
        <?php
        $tags = get_tags(array(
            'orderby' => 'count',
            'order'   => 'DESC',
            'number'  => 20,
            'hide_empty' => true,
        ));
        
        if ($tags) : ?>
            <section class="widget widget_tag_cloud">
                <h2 class="widget-title"><?php esc_html_e('Tags', 'versatile'); ?></h2>
                <div class="tagcloud">
                    <?php foreach ($tags as $tag) : ?>
                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" 
                           class="tag-cloud-link" 
                           style="font-size: <?php echo min(22, 12 + ($tag->count * 2)); ?>px;">
                            <?php echo esc_html($tag->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
        
        <!-- Archives Widget -->
        <section class="widget widget_archive">
            <h2 class="widget-title"><?php esc_html_e('Archives', 'versatile'); ?></h2>
            <ul>
                <?php wp_get_archives(array('type' => 'monthly', 'limit' => 12)); ?>
            </ul>
        </section>
        
    <?php endif; ?>
</aside><!-- #secondary -->

<style>
/* Sidebar Styles */
.sidebar {
    padding: 30px;
    margin-top: 10px;
}

@media (max-width: 1199px) {
    .sidebar {
        padding: 20px;
        margin-top: 20px;
    }
}

.widget {
    background: var(--background-color);
    padding: 25px;
    margin-bottom: 30px;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    border: 1px solid var(--border-color);
}

.widget-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 20px;
    color: var(--text-color);
    padding-bottom: 10px;
    border-bottom: 2px solid var(--primary-color);
    position: relative;
}

.widget-title::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 30px;
    height: 2px;
    background: var(--primary-color);
}

.widget ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.widget li {
    padding: 10px 0;
    border-bottom: 1px solid var(--border-color);
    transition: var(--transition);
}

.widget li:hover {
    padding-left: 5px;
}

.widget li:last-child {
    border-bottom: none;
}

.widget a {
    color: var(--text-color);
    text-decoration: none;
    transition: color 0.3s ease;
}

.widget a:hover {
    color: var(--primary-color);
}

.post-date,
.post-count {
    font-size: 12px;
    color: var(--text-muted);
    margin-left: 8px;
    padding-top: 2px;
}

.tagcloud {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tag-cloud-link {
    background: var(--secondary-color);
    color: var(--text-color) !important;
    padding: 4px 12px;
    border-radius: 15px;
    text-decoration: none !important;
    font-weight: 500;
    transition: all 0.3s ease;
}

.tag-cloud-link:hover {
    background: var(--primary-color) !important;
    color: white !important;
}

.widget_search .search-form {
    position: relative;
}

.widget_search .search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    background: var(--background-color);
    border: 2px solid var(--border-color);
    border-radius: 5px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.widget_search .search-input-wrapper:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.widget_search .search-field {
    flex: 1;
    padding: 12px 15px;
    border: none;
    outline: none;
    font-size: 14px;
    background: transparent;
    color: var(--text-color);
}

.widget_search .search-field::placeholder {
    color: var(--text-muted);
}

.wp-block-search__button {
    border-radius: 5px !important;
    color: white;
}
.widget_search .search-submit {
    padding: 12px 15px;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 45px;
}

.widget_search .search-submit:hover {
    background: var(--primary-hover);
    transform: scale(1.05);
}

/* Mobile Responsive */
@media (max-width: 991px) {
    .sidebar {
        padding: 5px;
        margin-top: 40px;
    }
    
    .widget {
        margin-bottom: 25px;
        padding: 20px;
    }
    
    .widget_search .search-input-wrapper {
        border-radius: 8px;
    }
    
    .widget_search .search-field {
        padding: 10px 12px;
        font-size: 16px; /* Prevent zoom on iOS */
    }
    
    .widget_search .search-submit {
        padding: 10px 12px;
        min-width: 40px;
    }
}

@media (max-width: 768px) {
    .tagcloud {
        justify-content: center;
    }
    
    .tag-cloud-link {
        font-size: 13px !important;
    }
}
</style>