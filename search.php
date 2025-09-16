<?php
/**
 * Template for displaying search results
 * Versatile WordPress Theme
 *
 * @package Versatile
 */

get_header(); ?>

<main class="site-main search-main">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				
				<header class="page-header">
					<h1 class="page-title">
						<?php
						printf(
							// translators: %s is the search query.
							esc_html__( 'Search Results for: %s', 'versatile' ),
							'<span>' . get_search_query() . '</span>'
						);
						?>
					</h1>
				</header><!-- .page-header -->

				<?php if ( have_posts() ) : ?>
					
					<div class="search-results-container">
						<?php
						while ( have_posts() ) :
							the_post();
							?>
							<?php get_template_part( 'template-parts/content/content-search' ); ?>
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