<?php
/**
 * "Popular" rail beside the featured post: most-commented recent posts.
 *
 * @package Versatile
 */

$versatile_exclude = isset( $args['exclude'] ) ? (array) $args['exclude'] : array();

$versatile_trending = new WP_Query(
	array(
		'posts_per_page'      => 4,
		'post__not_in'        => $versatile_exclude,
		'orderby'             => array(
			'comment_count' => 'DESC',
			'date'          => 'DESC',
		),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'date_query'          => array( array( 'after' => '1 year ago' ) ),
	)
);

if ( ! $versatile_trending->have_posts() ) {
	return;
}
?>

<aside class="trending-rail" aria-labelledby="trending-title">
	<h2 id="trending-title" class="section-label"><?php esc_html_e( 'Popular', 'versatile' ); ?></h2>
	<ol class="trending-list">
		<?php
		while ( $versatile_trending->have_posts() ) :
			$versatile_trending->the_post();
			?>
			<li class="trending-item">
				<a href="<?php the_permalink(); ?>">
					<span class="trending-item__title"><?php the_title(); ?></span>
					<span class="trending-item__meta"><?php echo esc_html( get_the_date( 'M j' ) ); ?> · <?php echo esc_html( versatile_reading_time() ); ?></span>
				</a>
			</li>
		<?php endwhile; ?>
	</ol>
</aside>
<?php
wp_reset_postdata();
