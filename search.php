<?php
/**
 * Template for displaying search results
 * Versatile WordPress Theme
 *
 * @package Versatile
 */

get_header();

global $wp_query;
$versatile_total = (int) $wp_query->found_posts;
?>

<main id="primary" class="site-main magazine-main search-main">
	<div class="container">

		<header class="magazine-header search-header">
			<p class="eyebrow"><?php esc_html_e( 'Search', 'versatile' ); ?></p>
			<h1 class="magazine-title">
				<?php
				printf(
					/* translators: %s: search query. */
					esc_html__( 'Results for “%s”', 'versatile' ),
					'<span class="search-query">' . esc_html( get_search_query( false ) ) . '</span>'
				);
				?>
			</h1>
			<p class="search-count">
				<?php
				printf(
					/* translators: %s: number of results. */
					esc_html( _n( '%s result', '%s results', $versatile_total, 'versatile' ) ),
					esc_html( number_format_i18n( $versatile_total ) )
				);
				?>
			</p>
			<div class="search-header__form">
				<?php get_search_form(); ?>
			</div>
		</header>

		<?php versatile_search_type_pills(); ?>

		<div class="magazine-body<?php echo is_active_sidebar( 'sidebar-1' ) ? ' has-sidebar' : ''; ?>">
			<div class="magazine-grid-wrap">
				<?php if ( have_posts() ) : ?>
					<div class="search-results-list">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content/content-search' );
						endwhile;
						?>
					</div>

					<?php get_template_part( 'template-parts/navigation/pagination' ); ?>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content/content-none' ); ?>
				<?php endif; ?>
			</div>

			<?php get_sidebar(); ?>
		</div>

	</div>
</main>

<?php
get_footer();
