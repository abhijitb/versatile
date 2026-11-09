<?php
/**
 * "Keep reading" related posts on single posts (same category, newest first).
 *
 * @package Versatile
 */

$versatile_cats = wp_get_post_categories( get_the_ID() );

$versatile_related = new WP_Query(
	array(
		'posts_per_page'      => 3,
		'post__not_in'        => array( get_the_ID() ),
		'category__in'        => $versatile_cats,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

if ( ! $versatile_related->have_posts() ) {
	return;
}

$versatile_posts_page = get_option( 'page_for_posts' );
?>

<section class="related-posts" aria-labelledby="related-title">
	<div class="container">
		<div class="section-head">
			<h2 id="related-title" class="section-title"><?php esc_html_e( 'Keep reading', 'versatile' ); ?></h2>
			<a class="section-link" href="<?php echo esc_url( $versatile_posts_page ? get_permalink( $versatile_posts_page ) : home_url( '/' ) ); ?>"><?php esc_html_e( 'All posts', 'versatile' ); ?> <span aria-hidden="true">→</span></a>
		</div>
		<div class="posts-grid posts-grid--three">
			<?php
			while ( $versatile_related->have_posts() ) :
				$versatile_related->the_post();
				get_template_part( 'template-parts/content/content-archive', null, array( 'heading' => 'h3' ) );
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
