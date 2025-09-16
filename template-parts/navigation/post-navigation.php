<?php
/**
 * Template part for displaying post navigation
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Versatile
 */

$previous_post = get_previous_post();
$next_post     = get_next_post();

// Don't display navigation if there are no adjacent posts.
if ( ! $previous_post && ! $next_post ) {
	return;
}
?>

<nav class="navigation post-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Post navigation', 'versatile' ); ?>">
	<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'versatile' ); ?></h2>
	
	<div class="nav-links">
		
		<?php if ( $previous_post ) : ?>
			<div class="nav-previous">
				<a href="<?php echo esc_url( get_permalink( $previous_post ) ); ?>" rel="prev">
					<div class="nav-direction">
						<i class="fas fa-chevron-left"></i>
						<span class="nav-text"><?php esc_html_e( 'Previous Post', 'versatile' ); ?></span>
					</div>
					<div class="nav-title">
						<?php echo esc_html( get_the_title( $previous_post ) ); ?>
					</div>
					<?php if ( has_post_thumbnail( $previous_post ) ) : ?>
						<div class="nav-thumbnail">
							<?php echo get_the_post_thumbnail( $previous_post, 'thumbnail' ); ?>
						</div>
					<?php endif; ?>
				</a>
			</div>
		<?php endif; ?>
		
		<?php if ( $next_post ) : ?>
			<div class="nav-next">
				<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" rel="next">
					<div class="nav-direction">
						<span class="nav-text"><?php esc_html_e( 'Next Post', 'versatile' ); ?></span>
						<i class="fas fa-chevron-right"></i>
					</div>
					<div class="nav-title">
						<?php echo esc_html( get_the_title( $next_post ) ); ?>
					</div>
					<?php if ( has_post_thumbnail( $next_post ) ) : ?>
						<div class="nav-thumbnail">
							<?php echo get_the_post_thumbnail( $next_post, 'thumbnail' ); ?>
						</div>
					<?php endif; ?>
				</a>
			</div>
		<?php endif; ?>
		
	</div><!-- .nav-links -->
</nav><!-- .navigation -->
