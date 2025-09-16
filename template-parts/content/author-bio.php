<?php
/**
 * Template part for displaying author bio.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Versatile
 */

$author_description = get_the_author_meta( 'description' );

// Don't display author bio if there's no description.
if ( ! $author_description ) {
	return;
}
?>

<div class="author-bio">
	<div class="author-bio-content">
		<div class="author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
		</div>
		
		<div class="author-info">
			<h3 class="author-name">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php echo esc_html( get_the_author() ); ?>
				</a>
			</h3>
			
			<div class="author-description">
				<?php echo wp_kses_post( $author_description ); ?>
			</div>
			
			<div class="author-links">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author-posts-link">
					<?php esc_html_e( 'View all posts by', 'versatile' ); ?> <?php echo esc_html( get_the_author() ); ?>
					<i class="fas fa-arrow-right"></i>
				</a>
				
				<?php
				$author_website = get_the_author_meta( 'url' );
				if ( $author_website ) :
					?>
					<a href="<?php echo esc_url( $author_website ); ?>" class="author-website" target="_blank" rel="noopener noreferrer">
						<i class="fas fa-external-link-alt"></i>
						<?php esc_html_e( 'Website', 'versatile' ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div><!-- .author-bio -->
