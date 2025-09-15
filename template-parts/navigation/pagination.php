<?php
/**
 * Template part for displaying pagination
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Versatile
 */

// Don't display pagination if there's only one page
if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
	return;
}
?>

<nav class="navigation pagination" role="navigation" aria-label="<?php esc_attr_e( 'Posts navigation', 'versatile' ); ?>">
	<h2 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'versatile' ); ?></h2>
	
	<div class="nav-links">
		<?php
		echo paginate_links(
			array(
				'mid_size'           => 2,
				'prev_text'          => '<i class="fas fa-chevron-left"></i> ' . esc_html__( 'Previous', 'versatile' ),
				'next_text'          => esc_html__( 'Next', 'versatile' ) . ' <i class="fas fa-chevron-right"></i>',
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'versatile' ) . ' </span>',
				'type'               => 'list',
			)
		);
		?>
	</div><!-- .nav-links -->
</nav><!-- .navigation -->
