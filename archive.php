<?php
/**
 * Template for displaying archive pages
 * Versatile WordPress Theme
 */

get_header(); ?>

<main class="site-main archive-main">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                
                <?php if (have_posts()) : ?>
                    
                    <header class="page-header">
                        <?php
                        the_archive_title('<h1 class="page-title">', '</h1>');
                        the_archive_description('<div class="archive-description">', '</div>');
                        ?>
                    </header><!-- .page-header -->

                    <div class="posts-container">
                        <?php while (have_posts()) : the_post(); ?>
                            <?php get_template_part('template-parts/content/content-archive'); ?>
                        <?php endwhile; ?>
                    </div>

                    <?php get_template_part('template-parts/navigation/pagination'); ?>

                <?php else : ?>
                    
                    <?php get_template_part('template-parts/content/content-none'); ?>
                    
                <?php endif; ?>
                
            </div><!-- .col-lg-8 -->
            
            <div class="col-lg-4">
                <?php get_sidebar(); ?>
            </div><!-- .col-lg-4 -->
            
        </div><!-- .row -->
    </div><!-- .container -->
</main><!-- .site-main -->

<?php
get_footer();