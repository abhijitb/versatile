<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Versatile
 */

if ( ! function_exists( 'versatile_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function versatile_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'versatile' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'versatile_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function versatile_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'versatile' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'versatile_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function versatile_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'versatile' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'versatile' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'versatile' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'versatile' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'versatile' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'versatile' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'versatile_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function versatile_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail(
					'post-thumbnail',
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;
if ( ! function_exists( 'versatile_reading_time' ) ) :
	/**
	 * Estimated reading time for a post, e.g. "4 min read".
	 *
	 * @param int|null $post_id Post ID. Defaults to the current post.
	 * @return string
	 */
	function versatile_reading_time( $post_id = null ) {
		$words   = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ) );
		$minutes = max( 1, (int) ceil( $words / 225 ) );

		/* translators: %d: minutes. */
		return sprintf( _n( '%d min read', '%d min read', $minutes, 'versatile' ), $minutes );
	}
endif;

if ( ! function_exists( 'versatile_primary_category' ) ) :
	/**
	 * Prints the first category of a post as a link.
	 *
	 * @param string   $class   CSS class for the link.
	 * @param int|null $post_id Post ID. Defaults to the current post.
	 */
	function versatile_primary_category( $class = 'post-category', $post_id = null ) {
		$categories = get_the_category( $post_id );
		if ( empty( $categories ) ) {
			return;
		}
		printf(
			'<a class="%1$s" href="%2$s">%3$s</a>',
			esc_attr( $class ),
			esc_url( get_category_link( $categories[0]->term_id ) ),
			esc_html( $categories[0]->name )
		);
	}
endif;

if ( ! function_exists( 'versatile_category_pills' ) ) :
	/**
	 * Prints a row of category filter pills linking to category archives.
	 *
	 * @param int $limit Max categories to show.
	 */
	function versatile_category_pills( $limit = 6 ) {
		$categories = get_categories(
			array(
				'orderby'    => 'count',
				'order'      => 'DESC',
				'number'     => $limit,
				'hide_empty' => true,
			)
		);
		if ( count( $categories ) < 2 ) {
			return;
		}

		$posts_page = get_option( 'page_for_posts' );
		$all_url    = $posts_page ? get_permalink( $posts_page ) : home_url( '/' );
		$current    = is_category() ? get_queried_object_id() : 0;

		echo '<nav class="category-pills" aria-label="' . esc_attr__( 'Browse by category', 'versatile' ) . '">';
		printf(
			'<a class="category-pill%1$s" href="%2$s"%3$s>%4$s</a>',
			$current ? '' : ' is-active',
			esc_url( $all_url ),
			$current ? '' : ' aria-current="page"',
			esc_html__( 'All', 'versatile' )
		);
		foreach ( $categories as $category ) {
			$active = ( $current === $category->term_id );
			printf(
				'<a class="category-pill%1$s" href="%2$s"%3$s>%4$s</a>',
				$active ? ' is-active' : '',
				esc_url( get_category_link( $category->term_id ) ),
				$active ? ' aria-current="page"' : '',
				esc_html( $category->name )
			);
		}
		echo '</nav>';
	}
endif;

if ( ! function_exists( 'versatile_search_excerpt' ) ) :
	/**
	 * Returns an escaped excerpt for the current search result with each
	 * search term wrapped in <mark>.
	 *
	 * @param int $words Excerpt length in words.
	 * @return string Safe HTML.
	 */
	function versatile_search_excerpt( $words = 32 ) {
		$source  = has_excerpt() ? get_the_excerpt() : strip_shortcodes( get_the_content() );
		$excerpt = esc_html( wp_trim_words( wp_strip_all_tags( $source ), $words, '…' ) );

		$terms = array_filter( preg_split( '/\s+/', trim( get_search_query( false ) ) ) );
		$terms = array_filter(
			$terms,
			function ( $term ) {
				return mb_strlen( $term ) > 1;
			}
		);
		if ( empty( $terms ) ) {
			return $excerpt;
		}

		$pattern = implode( '|', array_map( 'preg_quote', array_map( 'esc_html', $terms ), array_fill( 0, count( $terms ), '/' ) ) );

		// Skip HTML entities so a term like "amp" never splits "&amp;".
		return preg_replace_callback(
			'/(&#?\w+;)|(' . $pattern . ')/iu',
			function ( $m ) {
				return '' !== $m[1] ? $m[1] : '<mark>' . $m[2] . '</mark>';
			},
			$excerpt
		);
	}
endif;

if ( ! function_exists( 'versatile_search_type_pills' ) ) :
	/**
	 * Prints filter pills (All / Posts / Pages / Products) for search results.
	 */
	function versatile_search_type_pills() {
		$types = array(
			''     => __( 'All', 'versatile' ),
			'post' => __( 'Posts', 'versatile' ),
			'page' => __( 'Pages', 'versatile' ),
		);
		if ( post_type_exists( 'product' ) ) {
			$types['product'] = __( 'Products', 'versatile' );
		}

		$current = get_query_var( 'post_type' );
		$current = is_array( $current ) ? '' : (string) $current;
		$query   = get_search_query( false );

		echo '<nav class="category-pills search-type-pills" aria-label="' . esc_attr__( 'Filter results by type', 'versatile' ) . '">';
		foreach ( $types as $type => $label ) {
			$args = array( 's' => $query );
			if ( $type ) {
				$args['post_type'] = $type;
			}
			$active = ( $current === $type );
			printf(
				'<a class="category-pill%1$s" href="%2$s"%3$s>%4$s</a>',
				$active ? ' is-active' : '',
				esc_url( add_query_arg( array_map( 'rawurlencode', $args ), home_url( '/' ) ) ),
				$active ? ' aria-current="page"' : '',
				esc_html( $label )
			);
		}
		echo '</nav>';
	}
endif;

if ( ! function_exists( 'versatile_is_commerce_flow_page' ) ) :
	/**
	 * Whether the current page is part of the purchase flow (cart,
	 * checkout incl. order received, My Account). These pages render
	 * without a sidebar so nothing distracts from placing the order.
	 *
	 * @return bool
	 */
	function versatile_is_commerce_flow_page() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return false;
		}

		$flow = ( function_exists( 'is_cart' ) && is_cart() )
			|| ( function_exists( 'is_checkout' ) && is_checkout() )
			|| ( function_exists( 'is_account_page' ) && is_account_page() );

		/**
		 * Filters whether the current page is treated as a purchase-flow page.
		 *
		 * @param bool $flow Whether the page is cart/checkout/account.
		 */
		return (bool) apply_filters( 'versatile_is_commerce_flow_page', $flow );
	}
endif;
