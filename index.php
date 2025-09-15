<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * Versatile WordPress Theme
 */

get_header(); ?>

<main class="site-main index-main">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				
				<?php if ( have_posts() ) : ?>
					
					<?php if ( is_home() && ! is_front_page() ) : ?>
						<header class="page-header">
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>
					<?php endif; ?>

					<div class="posts-container">
						<?php
						while ( have_posts() ) :
							the_post();
							?>
							<?php get_template_part( 'template-parts/content/content-archive' ); ?>
						<?php endwhile; ?>
					</div>

					<?php get_template_part( 'template-parts/navigation/pagination' ); ?>

				<?php else : ?>
					
					<?php get_template_part( 'template-parts/content/content-none' ); ?>
					
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