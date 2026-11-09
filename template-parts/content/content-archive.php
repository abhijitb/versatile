<?php
/**
 * Template part for a post card in the magazine grid.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Versatile
 */

$versatile_heading = ( isset( $args['heading'] ) && 'h3' === $args['heading'] ) ? 'h3' : 'h2';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
	<a class="post-card__media<?php echo has_post_thumbnail() ? '' : ' is-empty'; ?>" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'versatile-card', array( 'loading' => 'lazy' ) );
		}
		?>
	</a>

	<div class="post-card__meta">
		<?php versatile_primary_category( 'post-card__category' ); ?>
		<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
	</div>

	<<?php echo $versatile_heading; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- whitelisted tag. ?> class="post-card__title">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</<?php echo $versatile_heading; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- whitelisted tag. ?>>

	<span class="post-card__read"><?php echo esc_html( versatile_reading_time() ); ?></span>
</article><!-- #post-<?php the_ID(); ?> -->
