<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Versatile
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function versatile_woocommerce_setup() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'max_rows'        => 10,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'versatile_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function versatile_woocommerce_scripts() {
	if ( ! class_exists( 'WooCommerce' ) || ! function_exists( 'is_woocommerce' ) ) {
		return;
	}

	if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() ) {
		return;
	}

	wp_enqueue_style(
		'versatile-woocommerce-style',
		VERSATILE_THEME_URI . '/assets/css/dist/woocommerce.css',
		array( 'versatile-main' ),
		VERSATILE_VERSION
	);

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'versatile-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'versatile_woocommerce_scripts' );

/**
 * Load WooCommerce's cart fragments script on every page.
 *
 * Since WooCommerce 7.8 it is no longer enqueued by default, but the header
 * cart (count + mini-cart dropdown) on every page relies on it to update
 * after add-to-cart / remove without a reload.
 */
function versatile_woocommerce_cart_fragments() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	wp_enqueue_script( 'wc-cart-fragments' );
}
add_action( 'wp_enqueue_scripts', 'versatile_woocommerce_cart_fragments', 20 );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function versatile_woocommerce_active_body_class( $classes ) {
	if ( class_exists( 'WooCommerce' ) ) {
		$classes[] = 'woocommerce-active';
	}
	return $classes;
}
add_filter( 'body_class', 'versatile_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function versatile_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 4,
		'columns'        => 4,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'versatile_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'versatile_shop_sidebar_mode' ) ) {
	/**
	 * Shop sidebar mode for product listings and single products.
	 *
	 * - builtin (default): product search, categories, price filter, top rated.
	 * - widgets: the "Shop Sidebar" widget area.
	 * - none: full width.
	 *
	 * Cart, checkout and account pages are always full width.
	 *
	 * @return string builtin|widgets|none
	 */
	function versatile_shop_sidebar_mode() {
		if ( ! ( is_shop() || is_product_taxonomy() || is_product() ) ) {
			return 'none';
		}

		$mode = get_theme_mod( 'versatile_shop_sidebar', 'builtin' );
		if ( true === $mode || '1' === $mode ) {
			$mode = 'widgets'; // Legacy checkbox value.
		}
		if ( 'widgets' === $mode && ! is_active_sidebar( 'shop-sidebar' ) ) {
			$mode = 'builtin';
		}

		return in_array( $mode, array( 'builtin', 'widgets', 'none' ), true ) ? $mode : 'builtin';
	}
}

if ( ! function_exists( 'versatile_show_shop_sidebar' ) ) {
	/**
	 * Whether the current WooCommerce page shows a sidebar.
	 *
	 * @return bool
	 */
	function versatile_show_shop_sidebar() {
		return 'none' !== versatile_shop_sidebar_mode();
	}
}

if ( ! function_exists( 'versatile_builtin_shop_sidebar' ) ) {
	/**
	 * Renders the default product sidebar with core WooCommerce widgets.
	 */
	function versatile_builtin_shop_sidebar() {
		$args = array(
			'before_widget' => '<section class="widget %s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		);

		the_widget( 'WC_Widget_Product_Search', array( 'title' => __( 'Search products', 'versatile' ) ), $args );

		if ( ! is_product() ) {
			the_widget( 'WC_Widget_Layered_Nav_Filters', array( 'title' => __( 'Active filters', 'versatile' ) ), $args );
			the_widget( 'WC_Widget_Price_Filter', array( 'title' => __( 'Price', 'versatile' ) ), $args );
		}

		the_widget(
			'WC_Widget_Product_Categories',
			array(
				'title'        => __( 'Categories', 'versatile' ),
				'count'        => 1,
				'hierarchical' => 1,
				'hide_empty'   => 1,
				'orderby'      => 'name',
			),
			$args
		);

		the_widget(
			'WC_Widget_Top_Rated_Products',
			array(
				'title'  => __( 'Top rated', 'versatile' ),
				'number' => 3,
			),
			$args
		);
	}
}

if ( ! function_exists( 'versatile_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function versatile_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main shop-main">
				<div class="container">
					<div class="shop-layout<?php echo versatile_show_shop_sidebar() ? ' has-sidebar' : ''; ?>">
						<div class="shop-content">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'versatile_woocommerce_wrapper_before' );

if ( ! function_exists( 'versatile_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function versatile_woocommerce_wrapper_after() {
		?>
						</div>
						<?php
						$versatile_sidebar_mode = versatile_shop_sidebar_mode();
						if ( 'none' !== $versatile_sidebar_mode ) :
							?>
							<aside id="secondary" class="widget-area shop-sidebar" aria-label="<?php esc_attr_e( 'Shop sidebar', 'versatile' ); ?>">
								<?php
								if ( 'widgets' === $versatile_sidebar_mode ) {
									dynamic_sidebar( 'shop-sidebar' );
								} else {
									versatile_builtin_shop_sidebar();
								}
								?>
							</aside>
						<?php endif; ?>
					</div>
				</div>
			</main>
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'versatile_woocommerce_wrapper_after' );

/**
 * Register WooCommerce sidebar.
 */
function versatile_woocommerce_widgets_init() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	register_sidebar(
		array(
			'name'          => esc_html__( 'Shop Sidebar', 'versatile' ),
			'id'            => 'shop-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in your shop sidebar.', 'versatile' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'versatile_woocommerce_widgets_init' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'versatile_woocommerce_header_cart' ) ) {
			versatile_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'versatile_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function versatile_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		versatile_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'versatile_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'versatile_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function versatile_woocommerce_cart_link() {
		?>
		<?php
		$count           = WC()->cart->get_cart_contents_count();
		$item_count_text = sprintf(
			/* translators: %d: number of items in the cart. */
			_n( 'Cart, %d item', 'Cart, %d items', $count, 'versatile' ),
			$count
		);
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php echo esc_attr( $item_count_text ); ?>">
			<svg class="cart-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 7h12l-1 13H7L6 7z"/><path d="M9 7a3 3 0 0 1 6 0"/></svg>
			<span class="cart-label" aria-hidden="true"><?php esc_html_e( 'Cart', 'versatile' ); ?></span>
			<span class="cart-count" aria-hidden="true"><?php echo esc_html( $count ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'versatile_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function versatile_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php versatile_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}

/**
 * Customize WooCommerce breadcrumbs.
 */
function versatile_woocommerce_breadcrumbs() {
	return array(
		'delimiter'   => ' &nbsp;&#47;&nbsp; ',
		'wrap_before' => '<nav class="woocommerce-breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>',
		'wrap_after'  => '</nav>',
		'before'      => '',
		'after'       => '',
		'home'        => _x( 'Home', 'breadcrumb', 'versatile' ),
	);
}
add_filter( 'woocommerce_breadcrumb_defaults', 'versatile_woocommerce_breadcrumbs' );

/**
 * Customize WooCommerce loop product columns on shop page.
 */
function versatile_woocommerce_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'versatile_woocommerce_loop_columns' );

/**
 * Customize products per page on shop.
 */
function versatile_woocommerce_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'versatile_woocommerce_products_per_page' );

/**
 * Remove WooCommerce sidebar on shop and product pages.
 */
function versatile_remove_woocommerce_sidebar() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	// The theme wrapper renders the shop sidebar itself; WooCommerce's own
	// call would fall back to the blog sidebar on product pages.
	if ( is_woocommerce() ) {
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	}
}
add_action( 'wp', 'versatile_remove_woocommerce_sidebar' );

/**
 * Ensure cart contents are displayed correctly after the cart is emptied.
 */
if ( ! function_exists( 'versatile_woocommerce_cart_emptied' ) ) {
	/**
	 * Cart emptied
	 *
	 * @return void
	 */
	function versatile_woocommerce_cart_emptied() {
		?>
		<div class="cart-empty woocommerce-info">
			<?php esc_html_e( 'Your cart is currently empty.', 'versatile' ); ?>
		</div>
		<?php
	}
}
add_action( 'woocommerce_cart_is_empty', 'versatile_woocommerce_cart_emptied' );

/**
 * Shop toolbar: product category pills, then result count + sorting on one row.
 */
function versatile_shop_category_pills() {
	if ( ! ( is_shop() || is_product_taxonomy() ) ) {
		return;
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'parent'     => 0,
			'hide_empty' => true,
			'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
			'number'     => 8,
		)
	);
	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return;
	}

	$current = is_product_category() ? get_queried_object_id() : 0;

	echo '<nav class="category-pills shop-category-pills" aria-label="' . esc_attr__( 'Browse by category', 'versatile' ) . '">';
	printf(
		'<a class="category-pill%1$s" href="%2$s"%3$s>%4$s</a>',
		$current ? '' : ' is-active',
		esc_url( wc_get_page_permalink( 'shop' ) ),
		$current ? '' : ' aria-current="page"',
		esc_html__( 'All', 'versatile' )
	);
	foreach ( $terms as $term ) {
		$active = ( $current === $term->term_id );
		printf(
			'<a class="category-pill%1$s" href="%2$s"%3$s>%4$s</a>',
			$active ? ' is-active' : '',
			esc_url( get_term_link( $term ) ),
			$active ? ' aria-current="page"' : '',
			esc_html( $term->name )
		);
	}
	echo '</nav>';
}
add_action( 'woocommerce_before_shop_loop', 'versatile_shop_category_pills', 15 );

/**
 * Opens the toolbar row around the result count (20) and ordering (30).
 */
function versatile_shop_toolbar_open() {
	echo '<div class="shop-toolbar">';
}
add_action( 'woocommerce_before_shop_loop', 'versatile_shop_toolbar_open', 19 );

/**
 * Closes the toolbar row.
 */
function versatile_shop_toolbar_close() {
	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop', 'versatile_shop_toolbar_close', 31 );

/**
 * Sanitizes the shop sidebar mode.
 *
 * @param string $value Raw value.
 * @return string
 */
function versatile_sanitize_shop_sidebar( $value ) {
	return in_array( $value, array( 'builtin', 'widgets', 'none' ), true ) ? $value : 'builtin';
}

/**
 * Customizer: shop sidebar mode.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function versatile_woocommerce_customize_register( $wp_customize ) {
	$wp_customize->add_setting(
		'versatile_shop_sidebar',
		array(
			'default'           => 'builtin',
			'sanitize_callback' => 'versatile_sanitize_shop_sidebar',
		)
	);
	$wp_customize->add_control(
		'versatile_shop_sidebar',
		array(
			'label'       => esc_html__( 'Shop sidebar', 'versatile' ),
			'description' => esc_html__( 'Shown on product listings and product pages.', 'versatile' ),
			'section'     => 'woocommerce_product_catalog',
			'type'        => 'select',
			'choices'     => array(
				'builtin' => esc_html__( 'Product filters (built-in)', 'versatile' ),
				'widgets' => esc_html__( 'Shop Sidebar widgets', 'versatile' ),
				'none'    => esc_html__( 'None (full width)', 'versatile' ),
			),
		)
	);
}
add_action( 'customize_register', 'versatile_woocommerce_customize_register', 20 );

/**
 * Out-of-stock products: "Sold out" badge instead of "Sale!", and a clear
 * "View product" button instead of WooCommerce's generic "Read more".
 *
 * @param WC_Product|mixed $product Product.
 * @return bool
 */
function versatile_is_sold_out( $product ) {
	return $product instanceof WC_Product && ! $product->is_in_stock();
}

/**
 * Hide the sale flash on sold-out products (the Sold out badge takes its place).
 *
 * @param string     $html    Sale flash HTML.
 * @param WP_Post    $post    Post object.
 * @param WC_Product $product Product.
 * @return string
 */
function versatile_sold_out_hide_sale_flash( $html, $post, $product ) {
	return versatile_is_sold_out( $product ) ? '' : $html;
}
add_filter( 'woocommerce_sale_flash', 'versatile_sold_out_hide_sale_flash', 10, 3 );

/**
 * Prints the Sold out badge (loop and single product).
 */
function versatile_sold_out_badge() {
	global $product;
	if ( versatile_is_sold_out( $product ) ) {
		echo '<span class="soldout">' . esc_html__( 'Sold out', 'versatile' ) . '</span>';
	}
}
add_action( 'woocommerce_before_shop_loop_item_title', 'versatile_sold_out_badge', 9 );
add_action( 'woocommerce_before_single_product_summary', 'versatile_sold_out_badge', 9 );

/**
 * Loop button text for products that can't be added from the listing.
 *
 * Keeps WooCommerce's own text for variable ("Select options"), grouped
 * and external products.
 *
 * @param string     $text    Button text.
 * @param WC_Product $product Product.
 * @return string
 */
function versatile_loop_add_to_cart_text( $text, $product ) {
	if ( $product instanceof WC_Product && $product->is_type( 'simple' ) && ( ! $product->is_in_stock() || ! $product->is_purchasable() ) ) {
		return __( 'View product', 'versatile' );
	}
	return $text;
}
add_filter( 'woocommerce_product_add_to_cart_text', 'versatile_loop_add_to_cart_text', 10, 2 );

/**
 * Marks the loop button of sold-out products for styling.
 *
 * @param array      $args    Button args.
 * @param WC_Product $product Product.
 * @return array
 */
function versatile_loop_add_to_cart_args( $args, $product ) {
	if ( versatile_is_sold_out( $product ) ) {
		$args['class'] = trim( ( $args['class'] ?? '' ) . ' is-soldout' );
	}
	return $args;
}
add_filter( 'woocommerce_loop_add_to_cart_args', 'versatile_loop_add_to_cart_args', 10, 2 );
