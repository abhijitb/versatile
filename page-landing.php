<?php
/**
 * Template Name: Landing Page
 *
 * A full-width, editor-managed page template without a sidebar.
 *
 * @package Versatile
 */

get_header();
?>

<main id="primary" class="site-main landing-main">
	<div class="container">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'landing-article' ); ?>>
				<header class="landing-header">
					<h1 class="landing-title"><?php the_title(); ?></h1>
				</header>

				<div class="landing-content entry-content">
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
	</div>
</main>

<?php
get_footer();
