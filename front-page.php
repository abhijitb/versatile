<?php
/**
 * The front page template.
 *
 * Displays the post listing or the assigned static page, depending on the
 * site's Reading settings.
 *
 * @package Versatile
 */

get_header();
?>

<main id="primary" class="site-main front-page-main">
	<div class="container">
		<?php if ( 'posts' === get_option( 'show_on_front' ) ) : ?>
			<div class="row">
				<div class="col-lg-8">
					<?php if ( have_posts() ) : ?>
						<div class="posts-container">
							<?php
							while ( have_posts() ) :
								the_post();
								get_template_part( 'template-parts/content/content-archive' );
							endwhile;
							?>
						</div>

						<?php get_template_part( 'template-parts/navigation/pagination' ); ?>
					<?php else : ?>
						<?php get_template_part( 'template-parts/content/content-none' ); ?>
					<?php endif; ?>
				</div>

				<div class="col-lg-4">
					<?php get_sidebar(); ?>
				</div>
			</div>
		<?php else : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'front-page-article' ); ?>>
					<div class="front-page-content entry-content">
						<?php
						the_content();
						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'versatile' ),
								'after'  => '</div>',
							)
						);
						?>
					</div>
				</article>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
