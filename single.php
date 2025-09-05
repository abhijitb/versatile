<?php
/**
 * Template for displaying single posts
 * Versatile WordPress Theme
 */

get_header(); ?>

<main class="site-main single-post-main">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-article'); ?>>
            
            <!-- Hero Section -->
            <div class="post-hero">
                <div class="container">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-featured-image">
                            <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="post-header">
                        <div class="post-meta">
                            <span class="post-date">
                                <i class="fas fa-calendar-alt"></i>
                                <?php echo get_the_date(); ?>
                            </span>
                            <span class="post-author">
                                <i class="fas fa-user"></i>
                                <?php the_author(); ?>
                            </span>
                            <?php if (has_category()) : ?>
                                <span class="post-categories">
                                    <i class="fas fa-folder"></i>
                                    <?php the_category(', '); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <h1 class="post-title"><?php the_title(); ?></h1>
                        
                        <?php if (has_excerpt()) : ?>
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Post Content -->
            <div class="post-content-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="post-content">
                                <?php the_content(); ?>
                                
                                <?php
                                wp_link_pages(array(
                                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'versatile'),
                                    'after'  => '</div>',
                                ));
                                ?>
                            </div>
                            
                            <!-- Tags -->
                            <?php if (has_tag()) : ?>
                                <div class="post-tags">
                                    <h4><?php esc_html_e('Tags:', 'versatile'); ?></h4>
                                    <?php the_tags('<div class="tag-cloud">', '', '</div>'); ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Author Bio -->
                            <?php if (get_the_author_meta('description')) : ?>
                                <div class="author-bio">
                                    <div class="author-avatar">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                                    </div>
                                    <div class="author-info">
                                        <h4><?php the_author(); ?></h4>
                                        <p><?php echo get_the_author_meta('description'); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Post Navigation -->
                            <nav class="post-navigation" aria-label="Post Navigation">
                                <div class="nav-links">
                                    <?php
                                    $prev_post = get_previous_post();
                                    $next_post = get_next_post();
                                    
                                    if ($prev_post) : ?>
                                        <div class="nav-previous">
                                            <a href="<?php echo get_permalink($prev_post); ?>" class="nav-link">
                                                <span class="nav-direction"><?php esc_html_e('Previous', 'versatile'); ?></span>
                                                <span class="nav-title"><?php echo wp_trim_words(get_the_title($prev_post), 6, '...'); ?></span>
                                            </a>
                                        </div>
                                    <?php endif;
                                    
                                    if ($next_post) : ?>
                                        <div class="nav-next">
                                            <a href="<?php echo get_permalink($next_post); ?>" class="nav-link">
                                                <span class="nav-direction"><?php esc_html_e('Next', 'versatile'); ?></span>
                                                <span class="nav-title"><?php echo wp_trim_words(get_the_title($next_post), 6, '...'); ?></span>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </nav>
                            
                            <!-- Related Posts -->
                            <?php
                            $related_posts = get_posts(array(
                                'category__in' => wp_get_post_categories($post->ID),
                                'numberposts' => 3,
                                'post__not_in' => array($post->ID)
                            ));
                            
                            if ($related_posts) : ?>
                                <section class="related-posts">
                                    <h3><?php esc_html_e('Related Posts', 'versatile'); ?></h3>
                                    <div class="related-posts-grid">
                                        <?php foreach ($related_posts as $related_post) : ?>
                                            <article class="related-post-item">
                                                <?php if (has_post_thumbnail($related_post->ID)) : ?>
                                                    <div class="related-post-image">
                                                        <a href="<?php echo get_permalink($related_post->ID); ?>">
                                                            <?php echo get_the_post_thumbnail($related_post->ID, 'medium'); ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="related-post-content">
                                                    <h4><a href="<?php echo get_permalink($related_post->ID); ?>"><?php echo get_the_title($related_post->ID); ?></a></h4>
                                                    <span class="related-post-date"><?php echo get_the_date('', $related_post->ID); ?></span>
                                                </div>
                                            </article>
                                        <?php endforeach; ?>
                                    </div>
                                </section>
                            <?php endif; ?>
                            
                            <!-- Comments -->
                            <?php
                            if (comments_open() || get_comments_number()) :
                                comments_template();
                            endif;
                            ?>
                        </div>
                        
                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <?php get_sidebar(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>