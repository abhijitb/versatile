<?php
/**
 * Template for displaying single posts
 * Versatile WordPress Theme
 */

get_header(); ?>

<main class="site-main single-post-main">
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('template-parts/content/content-single'); ?>
    <?php endwhile; ?>
</main>

<?php
get_footer();