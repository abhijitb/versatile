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

if ( 'posts' === get_option( 'show_on_front' ) ) {
	get_template_part( 'template-parts/blog/listing' );
	get_footer();
	return;
}
?>

<main id="primary" class="site-main front-page-main">
	<div class="container">
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
	</div>
</main>

<?php
get_footer();
