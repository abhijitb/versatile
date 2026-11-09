<?php
/**
 * Template part for displaying single post content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Versatile
 */

?>

<div class="reading-progress" aria-hidden="true"><span class="reading-progress__bar"></span></div>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-article' ); ?>>

	<header class="entry-hero">
		<div class="entry-hero__inner">
			<nav class="entry-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'versatile' ); ?>">
				<?php
				$versatile_posts_page = get_option( 'page_for_posts' );
				printf(
					'<a href="%1$s">%2$s</a>',
					esc_url( $versatile_posts_page ? get_permalink( $versatile_posts_page ) : home_url( '/' ) ),
					esc_html( $versatile_posts_page ? get_the_title( $versatile_posts_page ) : __( 'Home', 'versatile' ) )
				);
				?>
				<span aria-hidden="true">/</span>
				<?php versatile_primary_category( 'entry-breadcrumb__category' ); ?>
			</nav>

			<h1 class="entry-title"><?php the_title(); ?></h1>

			<?php if ( has_excerpt() ) : ?>
				<p class="entry-standfirst"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>

			<div class="entry-byline">
				<div class="entry-byline__author">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 44 ); ?>
					<div>
						<a class="entry-byline__name" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
						<span class="entry-byline__meta">
							<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							· <?php echo esc_html( versatile_reading_time() ); ?>
						</span>
					</div>
				</div>
				<div class="entry-share">
					<button type="button" class="icon-button js-copy-link" data-url="<?php the_permalink(); ?>" aria-label="<?php esc_attr_e( 'Copy link', 'versatile' ); ?>">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1 1"/><path d="M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1-1"/></svg>
					</button>
					<button type="button" class="icon-button js-share" data-url="<?php the_permalink(); ?>" data-title="<?php the_title_attribute(); ?>" aria-label="<?php esc_attr_e( 'Share', 'versatile' ); ?>" hidden>
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3v12"/><path d="M7 8l5-5 5 5"/><path d="M5 13v6h14v-6"/></svg>
					</button>
					<span class="entry-share__status" role="status"></span>
				</div>
			</div>
		</div>

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="entry-featured-image">
				<?php the_post_thumbnail( 'versatile-wide', array( 'fetchpriority' => 'high' ) ); ?>
			</figure>
		<?php endif; ?>
	</header>

	<div class="entry-content post-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'versatile' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<footer class="entry-footer">
		<?php if ( has_tag() ) : ?>
			<div class="entry-tags">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Tags', 'versatile' ); ?></h2>
				<?php the_tags( '', '', '' ); ?>
			</div>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/content/author-bio' ); ?>
	</footer>

</article><!-- #post-<?php the_ID(); ?> -->

<?php get_template_part( 'template-parts/blog/related' ); ?>

<?php if ( comments_open() || get_comments_number() ) : ?>
	<div class="entry-comments">
		<?php comments_template(); ?>
	</div>
<?php endif; ?>
