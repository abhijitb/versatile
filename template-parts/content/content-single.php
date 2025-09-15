<?php
/**
 * Template part for displaying single post content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Versatile
 */

?>

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
                        <?php
                        the_content();
                        
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'versatile'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>

                    <?php if (has_tag()) : ?>
                        <div class="post-tags">
                            <h3><?php esc_html_e('Tags', 'versatile'); ?></h3>
                            <?php the_tags('<div class="tag-links">', '', '</div>'); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Author Bio -->
                    <?php get_template_part('template-parts/content/author-bio'); ?>

                    <!-- Post Navigation -->
                    <?php get_template_part('template-parts/navigation/post-navigation'); ?>

                    <!-- Comments -->
                    <?php
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                </div>

                <div class="col-lg-4">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->
