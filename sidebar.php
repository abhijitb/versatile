<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Versatile
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

// Enqueue sidebar-specific CSS
wp_enqueue_style( 'versatile-sidebar', get_template_directory_uri() . '/assets/css/src/sidebar.css', array(), _S_VERSION );
?>

<aside id="secondary" class="widget-area sidebar">
	<!-- Dynamic sidebar widgets or default fallback widgets -->
	<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
		
		<!-- Search Widget -->
		<section class="widget widget_search">
			<h2 class="widget-title"><?php esc_html_e( 'Search', 'versatile' ); ?></h2>
			<?php get_search_form(); ?>
		</section>
		
		<!-- Recent Posts Widget -->
		<section class="widget widget_recent_entries">
			<h2 class="widget-title"><?php esc_html_e( 'Recent Posts', 'versatile' ); ?></h2>
			<?php
			$recent_posts = wp_get_recent_posts(
				array(
					'numberposts' => 5,
					'post_status' => 'publish',
				)
			);

			if ( $recent_posts ) :
				?>
				<ul>
					<?php foreach ( $recent_posts as $recent_post ) : ?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $recent_post['ID'] ) ); ?>">
								<?php echo esc_html( $recent_post['post_title'] ); ?>
							</a>
							<span class="post-date"><?php echo get_the_date( '', $recent_post['ID'] ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</section>
		
		<!-- Categories Widget -->
		<?php
		$categories = get_categories(
			array(
				'orderby'    => 'count',
				'order'      => 'DESC',
				'number'     => 10,
				'hide_empty' => true,
			)
		);

		if ( $categories ) :
			?>
			<section class="widget widget_categories">
				<h2 class="widget-title"><?php esc_html_e( 'Categories', 'versatile' ); ?></h2>
				<ul>
					<?php foreach ( $categories as $category ) : ?>
						<li>
							<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
								<?php echo esc_html( $category->name ); ?>
								<span class="post-count">(<?php echo $category->count; ?>)</span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endif; ?>
		
		<!-- Tags Widget -->
		<?php
		$tags = get_tags(
			array(
				'orderby'    => 'count',
				'order'      => 'DESC',
				'number'     => 20,
				'hide_empty' => true,
			)
		);

		if ( $tags ) :
			?>
			<section class="widget widget_tag_cloud">
				<h2 class="widget-title"><?php esc_html_e( 'Tags', 'versatile' ); ?></h2>
				<div class="tagcloud">
					<?php foreach ( $tags as $tag ) : ?>
						<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" 
							class="tag-cloud-link" 
							style="font-size: <?php echo min( 22, 12 + ( $tag->count * 2 ) ); ?>px;">
							<?php echo esc_html( $tag->name ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>
		
		<!-- Archives Widget -->
		<section class="widget widget_archive">
			<h2 class="widget-title"><?php esc_html_e( 'Archives', 'versatile' ); ?></h2>
			<ul>
				<?php
				wp_get_archives(
					array(
						'type'  => 'monthly',
						'limit' => 12,
					)
				);
				?>
			</ul>
		</section>
		
	<?php endif; ?>
</aside><!-- #secondary -->
