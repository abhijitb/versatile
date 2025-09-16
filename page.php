<?php
/**
 * Template for displaying pages
 * Versatile WordPress Theme
 *
 * @package Versatile
 */

get_header(); ?>

<main class="site-main page-main">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>>
						
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="page-featured-image">
								<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) ); ?>
							</div>
						<?php endif; ?>
						
						<header class="page-header">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</header><!-- .page-header -->

						<div class="page-content">
							<?php
							the_content();

							wp_link_pages(
								array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'versatile' ),
									'after'  => '</div>',
								)
							);
							?>
						</div><!-- .page-content -->

						<?php if ( get_edit_post_link() ) : ?>
							<footer class="entry-footer">
								<?php
								edit_post_link(
									sprintf(
										wp_kses(
											// translators: %s is the theme name.
											__( 'Edit <span class="screen-reader-text">%s</span>', 'versatile' ),
											array(
												'span' => array(
													'class' => array(),
												),
											)
										),
										get_the_title()
									),
									'<span class="edit-link">',
									'</span>'
								);
								?>
							</footer><!-- .entry-footer -->
						<?php endif; ?>

					</article><!-- #post-<?php the_ID(); ?> -->

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; ?>
				
			</div><!-- .col-lg-8 -->
			
			<div class="col-lg-4">
				<?php get_sidebar(); ?>
			</div><!-- .col-lg-4 -->
			
		</div><!-- .row -->
	</div><!-- .container -->
</main><!-- .site-main -->

<?php
get_footer();