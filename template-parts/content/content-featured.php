<?php
/**
 * Template part for the featured (lead) post on the blog home.
 *
 * @package Versatile
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-featured' ); ?>>
	<a class="post-featured__media<?php echo has_post_thumbnail() ? '' : ' is-empty'; ?>" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'versatile-hero', array( 'fetchpriority' => 'high' ) );
		}
		?>
		<span class="post-featured__badge"><?php esc_html_e( 'Featured', 'versatile' ); ?></span>
	</a>

	<div class="post-featured__body">
		<div class="post-card__meta">
			<?php versatile_primary_category( 'post-card__category is-accent' ); ?>
			<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			<span><?php echo esc_html( versatile_reading_time() ); ?></span>
		</div>

		<h2 class="post-featured__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<p class="post-featured__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 32, '…' ) ); ?></p>
	</div>
</article>
