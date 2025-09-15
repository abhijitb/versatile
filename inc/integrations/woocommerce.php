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
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'versatile_woocommerce_setup');

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function versatile_woocommerce_scripts() {
	wp_enqueue_style('versatile-woocommerce-style', get_template_directory_uri() . '/assets/css/src/woocommerce.css', array(), _S_VERSION);

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

	wp_add_inline_style('versatile-woocommerce-style', $inline_font);
}
add_action('wp_enqueue_scripts', 'versatile_woocommerce_scripts');

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function versatile_woocommerce_active_body_class($classes) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter('body_class', 'versatile_woocommerce_active_body_class');

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function versatile_woocommerce_related_products_args($args) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args($defaults, $args);

	return $args;
}
add_filter('woocommerce_output_related_products_args', 'versatile_woocommerce_related_products_args');

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if (!function_exists('versatile_woocommerce_wrapper_before')) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function versatile_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main">
				<div class="container">
					<div class="row">
						<div class="<?php echo is_active_sidebar('shop-sidebar') ? 'col-lg-8' : 'col-12'; ?>">
		<?php
	}
}
add_action('woocommerce_before_main_content', 'versatile_woocommerce_wrapper_before');

if (!function_exists('versatile_woocommerce_wrapper_after')) {
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
						<?php if (is_active_sidebar('shop-sidebar')) : ?>
							<div class="col-lg-4">
								<aside id="secondary" class="widget-area shop-sidebar">
									<?php dynamic_sidebar('shop-sidebar'); ?>
								</aside>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</main>
		<?php
	}
}
add_action('woocommerce_after_main_content', 'versatile_woocommerce_wrapper_after');

/**
 * Register WooCommerce sidebar.
 */
function versatile_woocommerce_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__('Shop Sidebar', 'versatile'),
			'id'            => 'shop-sidebar',
			'description'   => esc_html__('Add widgets here to appear in your shop sidebar.', 'versatile'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'versatile_woocommerce_widgets_init');

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

if (!function_exists('versatile_woocommerce_cart_link_fragment')) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function versatile_woocommerce_cart_link_fragment($fragments) {
		ob_start();
		versatile_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter('woocommerce_add_to_cart_fragments', 'versatile_woocommerce_cart_link_fragment');

if (!function_exists('versatile_woocommerce_cart_link')) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function versatile_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'versatile'); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n('%d item', '%d items', WC()->cart->get_cart_contents_count(), 'versatile'),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span> <span class="count"><?php echo esc_html($item_count_text); ?></span>
		</a>
		<?php
	}
}

if (!function_exists('versatile_woocommerce_header_cart')) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function versatile_woocommerce_header_cart() {
		if (is_cart()) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr($class); ?>">
				<?php versatile_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget('WC_Widget_Cart', $instance);
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
		'wrap_before' => '<nav class="woocommerce-breadcrumb" ' . (is_single() ? 'itemprop="breadcrumb"' : '') . '>',
		'wrap_after'  => '</nav>',
		'before'      => '',
		'after'       => '',
		'home'        => _x('Home', 'breadcrumb', 'versatile'),
	);
}
add_filter('woocommerce_breadcrumb_defaults', 'versatile_woocommerce_breadcrumbs');

/**
 * Customize WooCommerce loop product columns on shop page.
 */
function versatile_woocommerce_loop_columns() {
	return 3;
}
add_filter('loop_shop_columns', 'versatile_woocommerce_loop_columns');

/**
 * Customize products per page on shop.
 */
function versatile_woocommerce_products_per_page() {
	return 12;
}
add_filter('loop_shop_per_page', 'versatile_woocommerce_products_per_page');

/**
 * Remove WooCommerce sidebar on shop and product pages.
 */
function versatile_remove_woocommerce_sidebar() {
	if (is_shop() || is_product_category() || is_product_tag()) {
		remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
	}
}
add_action('wp', 'versatile_remove_woocommerce_sidebar');

/**
 * Ensure cart contents are displayed correctly after the cart is emptied.
 */
if (!function_exists('versatile_woocommerce_cart_emptied')) {
	/**
	 * Cart emptied
	 *
	 * @return void
	 */
	function versatile_woocommerce_cart_emptied() {
		?>
		<div class="cart-empty woocommerce-info">
			<?php esc_html_e('Your cart is currently empty.', 'versatile'); ?>
		</div>
		<?php
	}
}
add_action('woocommerce_cart_is_empty', 'versatile_woocommerce_cart_emptied');