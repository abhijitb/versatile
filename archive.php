<?php
/**
 * Template for displaying archive pages (categories, tags, dates, etc.)
 * Versatile WordPress Theme
 */

get_header(); ?>

<main class="site-main archive-main">
    
    <!-- Archive Header -->
    <section class="archive-header">
        <div class="container">
            <div class="archive-header-content">
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
                        echo '<i class="fas fa-folder"></i> ' . esc_html__('Category:', 'versatile') . ' ';
                    } elseif (is_tag()) {
                        echo '<i class="fas fa-tag"></i> ' . esc_html__('Tag:', 'versatile') . ' ';
                    } elseif (is_author()) {
                        echo '<i class="fas fa-user"></i> ' . esc_html__('Author:', 'versatile') . ' ';
                    } elseif (is_date()) {
                        echo '<i class="fas fa-calendar"></i> ' . esc_html__('Archive:', 'versatile') . ' ';
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
                    <span class="posts-count">
                        <i class="fas fa-file-alt"></i>
                        <?php
                        global $wp_query;
                        $total_posts = $wp_query->found_posts;
                        printf(
                            _n('%s post found', '%s posts found', $total_posts, 'versatile'),
                            number_format_i18n($total_posts)
                        );
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Archive Content -->
    <section class="archive-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    
                    <!-- Filter/Sort Options -->
                    <div class="archive-controls">
                        <div class="view-toggle">
                            <button class="view-btn active" data-view="grid">
                                <i class="fas fa-th"></i> <?php esc_html_e('Grid', 'versatile'); ?>
                            </button>
                            <button class="view-btn" data-view="list">
                                <i class="fas fa-list"></i> <?php esc_html_e('List', 'versatile'); ?>
                            </button>
                        </div>
                        
                        <div class="sort-options">
                            <label for="sort-posts"><?php esc_html_e('Sort by:', 'versatile'); ?></label>
                            <select id="sort-posts" onchange="location = this.value;">
                                <option value="<?php echo add_query_arg('orderby', 'date'); ?>"><?php esc_html_e('Newest First', 'versatile'); ?></option>
                                <option value="<?php echo add_query_arg('orderby', 'title'); ?>"><?php esc_html_e('Title A-Z', 'versatile'); ?></option>
                                <option value="<?php echo add_query_arg('orderby', 'comment_count'); ?>"><?php esc_html_e('Most Comments', 'versatile'); ?></option>
                            </select>
                        </div>
                    </div>
                    
                    <?php if (have_posts()) : ?>
                        <div class="posts-grid archive-posts-grid" id="archive-posts">
                            <?php while (have_posts()) : the_post(); ?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class('archive-post-item'); ?>>
                                    
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="post-thumbnail">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('medium_large', array('class' => 'img-fluid')); ?>
                                            </a>
                                            
                                            <!-- Post Format Icon -->
                                            <?php
                                            $post_format = get_post_format() ?: 'standard';
                                            $format_icons = array(
                                                'video' => 'fas fa-play',
                                                'audio' => 'fas fa-music',
                                                'gallery' => 'fas fa-images',
                                                'image' => 'fas fa-camera',
                                                'quote' => 'fas fa-quote-right',
                                                'link' => 'fas fa-link',
                                                'standard' => 'fas fa-file-alt'
                                            );
                                            ?>
                                            <div class="post-format-icon">
                                                <i class="<?php echo $format_icons[$post_format]; ?>"></i>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <span class="post-date">
                                                <i class="fas fa-calendar-alt"></i>
                                                <?php echo get_the_date(); ?>
                                            </span>
                                            <span class="post-author">
                                                <i class="fas fa-user"></i>
                                                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                                    <?php the_author(); ?>
                                                </a>
                                            </span>
                                            <?php if (comments_open() || get_comments_number()) : ?>
                                                <span class="post-comments">
                                                    <i class="fas fa-comments"></i>
                                                    <a href="<?php comments_link(); ?>">
                                                        <?php comments_number('0', '1', '%'); ?>
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
                                            <a href="<?php the_permalink(); ?>" class="read-more-btn">
                                                <?php esc_html_e('Read More', 'versatile'); ?>
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                            
                                            <?php if (has_tag()) : ?>
                                                <div class="post-tags">
                                                    <?php
                                                    $tags = get_the_tags();
                                                    if ($tags) {
                                                        $tag_count = 0;
                                                        foreach ($tags as $tag) {
                                                            if ($tag_count >= 3) break; // Limit to 3 tags
                                                            echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag-link">' . $tag->name . '</a>';
                                                            $tag_count++;
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                        </div>
                        
                        <!-- Pagination -->
                        <nav class="archive-pagination" aria-label="Archive Pagination">
                            <?php
                            $pagination = paginate_links(array(
                                'prev_text' => '<i class="fas fa-chevron-left"></i> ' . esc_html__('Previous', 'versatile'),
                                'next_text' => esc_html__('Next', 'versatile') . ' <i class="fas fa-chevron-right"></i>',
                                'type' => 'array',
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
                        <div class="no-posts-found">
                            <div class="no-posts-content">
                                <i class="fas fa-search fa-3x"></i>
                                <h3><?php esc_html_e('No Posts Found', 'versatile'); ?></h3>
                                <p><?php esc_html_e('Sorry, no posts were found in this archive. Try searching for something else.', 'versatile'); ?></p>
                                <a href="<?php echo home_url('/'); ?>" class="btn btn-primary">
                                    <?php esc_html_e('Back to Home', 'versatile'); ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
// View toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-btn');
    const postsGrid = document.getElementById('archive-posts');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            viewButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            // Toggle view class on posts grid
            const viewType = this.getAttribute('data-view');
            postsGrid.className = postsGrid.className.replace(/archive-posts-\w+/, 'archive-posts-' + viewType);
        });
    });
});
</script>

<?php get_footer(); ?>