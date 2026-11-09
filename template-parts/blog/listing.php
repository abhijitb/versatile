<?php
/**
 * Shared magazine-grid listing for the blog home and archives.
 *
 * On the first page of the blog home, the first post becomes the featured
 * lead with a "Popular" rail beside it; everything else is a card grid.
 *
 * @package Versatile
 */

$versatile_is_lead = is_home() && ! is_paged();
?>

<main id="primary" class="site-main magazine-main">
	<div class="container">

		<header class="magazine-header">
			<?php if ( is_home() ) : ?>
				<p class="eyebrow"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
				<h1 class="magazine-title">
					<?php
					$versatile_posts_page = get_option( 'page_for_posts' );
					echo esc_html( $versatile_posts_page ? get_the_title( $versatile_posts_page ) : __( 'Latest stories', 'versatile' ) );
					?>
				</h1>
			<?php else : ?>
				<p class="eyebrow"><?php esc_html_e( 'Archive', 'versatile' ); ?></p>
				<?php
				the_archive_title( '<h1 class="magazine-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			<?php endif; ?>
		</header>

		<?php if ( have_posts() ) : ?>

			<?php
			if ( $versatile_is_lead ) :
				the_post();
				?>
				<section class="magazine-lead">
					<?php get_template_part( 'template-parts/content/content-featured' ); ?>
					<?php get_template_part( 'template-parts/blog/trending', null, array( 'exclude' => array( get_the_ID() ) ) ); ?>
				</section>
			<?php endif; ?>

			<?php versatile_category_pills(); ?>

			<div class="magazine-body<?php echo is_active_sidebar( 'sidebar-1' ) ? ' has-sidebar' : ''; ?>">
				<div class="magazine-grid-wrap">
					<div class="posts-grid">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content/content-archive' );
						endwhile;
						?>
					</div>

					<?php get_template_part( 'template-parts/navigation/pagination' ); ?>
				</div>

				<?php get_sidebar(); ?>
			</div>

		<?php else : ?>
			<?php get_template_part( 'template-parts/content/content-none' ); ?>
		<?php endif; ?>

	</div>
</main>
