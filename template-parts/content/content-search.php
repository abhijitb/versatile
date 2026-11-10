<?php
/**
 * Template part for a single search result row.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Versatile
 */

$versatile_type_obj = get_post_type_object( get_post_type() );
$versatile_is_post  = ( 'post' === get_post_type() );
$versatile_product  = ( 'product' === get_post_type() && function_exists( 'wc_get_product' ) ) ? wc_get_product( get_the_ID() ) : null;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'search-result' ); ?>>
	<div class="search-result__body">
		<div class="post-card__meta">
			<span class="search-result__type"><?php echo esc_html( $versatile_type_obj ? $versatile_type_obj->labels->singular_name : '' ); ?></span>
			<?php if ( $versatile_is_post ) : ?>
				<?php versatile_primary_category( 'post-card__category' ); ?>
				<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			<?php elseif ( $versatile_product ) : ?>
				<span class="search-result__price"><?php echo wp_kses_post( $versatile_product->get_price_html() ); ?></span>
			<?php endif; ?>
		</div>

		<h2 class="search-result__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<p class="search-result__excerpt"><?php echo versatile_search_excerpt(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?></p>

		<?php if ( $versatile_is_post ) : ?>
			<span class="post-card__read"><?php echo esc_html( versatile_reading_time() ); ?></span>
		<?php endif; ?>
	</div>

	<?php if ( has_post_thumbnail() ) : ?>
		<a class="search-result__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail( 'versatile-card', array( 'loading' => 'lazy' ) ); ?>
		</a>
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
