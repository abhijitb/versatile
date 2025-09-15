<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Versatile
 */

?>

<section class="no-results not-found">
	<div class="page-content">
		
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			
			<h2 class="page-title"><?php esc_html_e( 'Ready to publish your first post?', 'versatile' ); ?></h2>
			<p>
			<?php
				printf(
					wp_kses(
						/* translators: 1: link to WP admin new post page. */
						__( 'Get started by <a href="%1$s">creating a new post</a>.', 'versatile' ),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
			?>
			</p>
			
		<?php elseif ( is_search() ) : ?>
			
			<h2 class="page-title"><?php esc_html_e( 'Nothing found', 'versatile' ); ?></h2>
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'versatile' ); ?></p>
			
			<div class="search-form-wrapper">
				<?php get_search_form(); ?>
			</div>
			
			<div class="search-suggestions">
				<h3><?php esc_html_e( 'Search Suggestions:', 'versatile' ); ?></h3>
				<ul>
					<li><?php esc_html_e( 'Check your spelling', 'versatile' ); ?></li>
					<li><?php esc_html_e( 'Try different keywords', 'versatile' ); ?></li>
					<li><?php esc_html_e( 'Try more general keywords', 'versatile' ); ?></li>
					<li><?php esc_html_e( 'Try fewer keywords', 'versatile' ); ?></li>
				</ul>
			</div>
			
		<?php else : ?>
			
			<h2 class="page-title"><?php esc_html_e( 'Nothing here', 'versatile' ); ?></h2>
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'versatile' ); ?></p>
			
			<div class="search-form-wrapper">
				<?php get_search_form(); ?>
			</div>
			
		<?php endif; ?>
		
	</div><!-- .page-content -->
</section><!-- .no-results -->
