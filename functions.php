<?php
/**
 * Versatile functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Versatile
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Theme version.
if ( ! defined( 'VERSATILE_VERSION' ) ) {
	define( 'VERSATILE_VERSION', '1.0.0' );
}

// Theme directory path.
if ( ! defined( 'VERSATILE_THEME_DIR' ) ) {
	define( 'VERSATILE_THEME_DIR', get_template_directory() );
}

// Theme directory URI.
if ( ! defined( 'VERSATILE_THEME_URI' ) ) {
	define( 'VERSATILE_THEME_URI', get_template_directory_uri() );
}

/**
 * Load theme includes.
 */
require_once VERSATILE_THEME_DIR . '/inc/theme-support.php';
require_once VERSATILE_THEME_DIR . '/inc/enqueue-scripts.php';
require_once VERSATILE_THEME_DIR . '/inc/template-functions.php';
require_once VERSATILE_THEME_DIR . '/inc/template-tags.php';
require_once VERSATILE_THEME_DIR . '/inc/customizer/customizer-setup.php';

// Load integration files.
require_once VERSATILE_THEME_DIR . '/inc/integrations/woocommerce.php';

// Load existing functions (these can be gradually moved to appropriate inc files).
if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 * Legacy function - most features now handled in inc/theme-support.php.
 */
function versatile_legacy_setup() {
	/*
	 * Make theme available for translation.
	 */
	load_theme_textdomain( 'versatile', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in multiple locations.
	register_nav_menus(
		array(
			'menu-1'            => esc_html__( 'Primary', 'versatile' ),
			'footer-menu'       => esc_html__( 'Footer Menu', 'versatile' ),
			'footer-legal-menu' => esc_html__( 'Footer Legal Menu', 'versatile' ),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'versatilecustom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	add_editor_style( 'style-editor.css' );

	// Add custom editor font sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => esc_html__( 'Small', 'versatile' ),
				'shortName' => esc_html__( 'S', 'versatile' ),
				'size'      => 14,
				'slug'      => 'small',
			),
			array(
				'name'      => esc_html__( 'Normal', 'versatile' ),
				'shortName' => esc_html__( 'M', 'versatile' ),
				'size'      => 16,
				'slug'      => 'normal',
			),
			array(
				'name'      => esc_html__( 'Large', 'versatile' ),
				'shortName' => esc_html__( 'L', 'versatile' ),
				'size'      => 24,
				'slug'      => 'large',
			),
			array(
				'name'      => esc_html__( 'Huge', 'versatile' ),
				'shortName' => esc_html__( 'XL', 'versatile' ),
				'size'      => 32,
				'slug'      => 'huge',
			),
		)
	);

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Add support for custom line height controls.
	add_theme_support( 'custom-line-height' );

	// Add support for custom units.
	add_theme_support( 'custom-units' );

	// Remove support for custom colors.
	add_theme_support( 'disable-custom-colors' );

	// Add support for custom spacing.
	add_theme_support( 'custom-spacing' );

	// Add support for custom padding.
	add_theme_support( 'custom-padding' );

	// WooCommerce support.
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'versatile_legacy_setup' );

/**
 * Register widget area.
 */
function versatile_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'versatile' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'versatile' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	// Footer widget areas.
	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar(
			array(
				// translators: %d is the footer column number.
				'name'          => sprintf( esc_html__( 'Footer %d', 'versatile' ), $i ),
				'id'            => 'footer-' . $i,
				// translators: %d is the footer column number.
				'description'   => sprintf( esc_html__( 'Add widgets here to appear in footer column %d.', 'versatile' ), $i ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}

	// Shop sidebar for WooCommerce.
	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Shop Sidebar', 'versatile' ),
				'id'            => 'sidebar-shop',
				'description'   => esc_html__( 'Add widgets here to appear in the shop sidebar.', 'versatile' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'versatile_widgets_init' );

if ( ! function_exists( 'versatilesocial_links' ) ) {
	/**
	 * Social Links Function.
	 *
	 * @return void
	 */
	function versatile_social_links() {
		$social_links = array(
			'facebook'  => get_theme_mod( 'versatile_facebook_url', '' ),
			'twitter'   => get_theme_mod( 'versatile_twitter_url', '' ),
			'instagram' => get_theme_mod( 'versatile_instagram_url', '' ),
			'linkedin'  => get_theme_mod( 'versatile_linkedin_url', '' ),
			'youtube'   => get_theme_mod( 'versatile_youtube_url', '' ),
		);

		$social_icons = array(
			'facebook'  => 'fab fa-facebook-f',
			'twitter'   => 'fab fa-twitter',
			'instagram' => 'fab fa-instagram',
			'linkedin'  => 'fab fa-linkedin-in',
			'youtube'   => 'fab fa-youtube',
		);

		foreach ( $social_links as $platform => $url ) {
			if ( $url ) {
				echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener" class="social-link social-' . esc_attr( $platform ) . '">';
				echo '<i class="' . esc_attr( $social_icons[ $platform ] ) . '"></i>';
				echo '<span class="screen-reader-text">' . esc_html( ucfirst( $platform ) ) . '</span>';
				echo '</a>';
			}
		}
	}
}

if ( ! function_exists( 'versatilefallback_menu' ) ) {
	/**
	 * Fallback Menu Function.
	 *
	 * @return void
	 */
	function versatile_fallback_menu() {
		echo '<ul id="primary-menu" class="primary-menu">';
		echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'versatile' ) . '</a></li>';

		// Add some default pages.
		$pages = get_pages(
			array(
				'sort_column' => 'menu_order',
				'number'      => 5,
			)
		);
		foreach ( $pages as $page ) {
			echo '<li><a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . esc_html( $page->post_title ) . '</a></li>';
		}

		if ( current_user_can( 'manage_options' ) ) {
			echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Add Menu', 'versatile' ) . '</a></li>';
		}
		echo '</ul>';
	}
}

if ( ! function_exists( 'versatile_get_placeholder_image' ) ) {
	/**
	 * Generate placeholder image for posts without featured images.
	 *
	 * @param int $post_id Post ID.
	 * @return string
	 */
	function versatile_get_placeholder_image( $post_id = null ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		$unique_id = 'post-' . $post_id;

		ob_start();
		?>
		<div class="post-placeholder-image">
			<svg viewBox="0 0 400 250" class="placeholder-svg">
				<!-- Background gradient -->
				<defs>
					<linearGradient id="bgGradient-<?php echo esc_attr( $unique_id ); ?>" x1="0%" y1="0%" x2="100%" y2="100%">
						<stop offset="0%" style="stop-color:#f7fafc;stop-opacity:1" />
						<stop offset="100%" style="stop-color:#e2e8f0;stop-opacity:1" />
					</linearGradient>
					<linearGradient id="vGradient-<?php echo esc_attr( $unique_id ); ?>" x1="0%" y1="0%" x2="100%" y2="100%">
						<stop offset="0%" style="stop-color:#667eea;stop-opacity:0.4" />
						<stop offset="50%" style="stop-color:#764ba2;stop-opacity:0.6" />
						<stop offset="100%" style="stop-color:#667eea;stop-opacity:0.4" />
					</linearGradient>
					<filter id="blur-<?php echo esc_attr( $unique_id ); ?>">
						<feGaussianBlur in="SourceGraphic" stdDeviation="1"/>
					</filter>
				</defs>
				
				<!-- Background -->
				<rect width="400" height="250" fill="url(#bgGradient-<?php echo esc_attr( $unique_id ); ?>)"/>
				
				<!-- Decorative circles -->
				<circle cx="80" cy="60" r="3" fill="#cbd5e0" opacity="0.4"/>
				<circle cx="320" cy="40" r="2" fill="#cbd5e0" opacity="0.3"/>
				<circle cx="350" cy="200" r="4" fill="#cbd5e0" opacity="0.3"/>
				<circle cx="50" cy="180" r="2.5" fill="#cbd5e0" opacity="0.4"/>
				
				<!-- Main "V" design -->
				<g transform="translate(200, 125)">
					<!-- Outer V (larger, background effect) -->
					<path d="M -80 -50 L 0 70 L 80 -50" 
							stroke="url(#vGradient-<?php echo esc_attr( $unique_id ); ?>)" 
							stroke-width="24" 
							fill="none" 
							stroke-linecap="round" 
							stroke-linejoin="round" 
							opacity="0.5" 
							filter="url(#blur-<?php echo esc_attr( $unique_id ); ?>)"/>
					
					<!-- Inner V (main design) -->
					<path d="M -60 -35 L 0 50 L 60 -35" 
							stroke="url(#vGradient-<?php echo esc_attr( $unique_id ); ?>)" 
							stroke-width="12" 
							fill="none" 
							stroke-linecap="round" 
							stroke-linejoin="round" 
							opacity="0.8"/>
					
					<!-- Central accent -->
					<circle cx="0" cy="50" r="4" fill="#667eea" opacity="0.7"/>
				</g>
				
				<!-- Theme text -->
				<text x="200" y="210" 
						text-anchor="middle" 
						fill="#718096" 
						font-family="Arial, sans-serif" 
						font-size="14" 
						font-weight="600" 
						opacity="0.8">
					Versatile
				</text>
			</svg>
		</div>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'versatile_has_valid_featured_image' ) ) {
	/**
	 * Validate if featured image is actually a valid image
	 *
	 * @param int $post_id Post ID.
	 * @return bool
	 */
	function versatile_has_valid_featured_image( $post_id = null ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		// First check if post has a thumbnail.
		if ( ! has_post_thumbnail( $post_id ) ) {
			return false;
		}

		// Get the attachment ID.
		$attachment_id = get_post_thumbnail_id( $post_id );
		if ( ! $attachment_id ) {
			return false;
		}

		// Get the attachment URL.
		$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
		if ( ! $image_url ) {
			return false;
		}

		// Check if the URL points to a post on the same site (common issue).
		$site_url = get_site_url();
		if ( strpos( $image_url, $site_url ) !== false ) {
			// Check if it's pointing to a post URL pattern.
			if ( preg_match( '#' . preg_quote( $site_url, '#' ) . '/[^/]+/?$#', $image_url ) ||
				preg_match( '#' . preg_quote( $site_url, '#' ) . '/\d{4}/\d{2}/\d{2}/[^/]+/?$#', $image_url ) ||
				strpos( $image_url, '/?p=' ) !== false ||
				strpos( $image_url, '/post/' ) !== false ) {
				return false;
			}
		}

		// Get attachment metadata.
		$attachment_meta = wp_get_attachment_metadata( $attachment_id );

		// Check if it's a valid image by checking for width/height.
		if ( empty( $attachment_meta ) || ! isset( $attachment_meta['width'] ) || ! isset( $attachment_meta['height'] ) ) {
			return false;
		}

		// Check if the URL is actually an image file.
		$image_info       = pathinfo( $image_url );
		$valid_extensions = array( 'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp' );

		if ( ! isset( $image_info['extension'] ) || ! in_array( strtolower( $image_info['extension'] ), $valid_extensions, true ) ) {
			return false;
		}

		// Additional check: Ensure the attachment is actually an image post type.
		$attachment_post = get_post( $attachment_id );
		if ( ! $attachment_post || 'attachment' !== $attachment_post->post_type ) {
			return false;
		}

		// Check MIME type.
		$mime_type = get_post_mime_type( $attachment_id );
		if ( ! $mime_type || 0 !== strpos( $mime_type, 'image/' ) ) {
			return false;
		}

		return true;
	}
}

if ( ! function_exists( 'versatile_cleanup_invalid_featured_images' ) ) {
	/**
	 * Admin utility function to clean up invalid featured images.
	 * This function can be called from admin area to clean up bad data.
	 *
	 * @return array
	 */
	function versatile_cleanup_invalid_featured_images() {
		// Only allow this for admin users.
		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}

		$posts = get_posts(
			array(
				'numberposts' => -1,
				'post_type'   => 'post',
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				'meta_query'  => array(
					array(
						'key'     => '_thumbnail_id',
						'compare' => 'EXISTS',
					),
				),
				'post_status' => 'any',
			)
		);

		$cleaned_count = 0;
		$invalid_types = array(
			'url_points_to_post' => 0,
			'missing_metadata'   => 0,
			'invalid_mime_type'  => 0,
			'invalid_extension'  => 0,
		);

		foreach ( $posts as $post ) {
			if ( ! versatile_has_valid_featured_image( $post->ID ) ) {
				// Get more details about why it's invalid for logging.
				$attachment_id = get_post_thumbnail_id( $post->ID );
				if ( $attachment_id ) {
					$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
					$site_url  = get_site_url();

					if ( $image_url && strpos( $image_url, $site_url ) !== false ) {
						if ( preg_match( '#' . preg_quote( $site_url, '#' ) . '/[^/]+/?$#', $image_url ) ||
							preg_match( '#' . preg_quote( $site_url, '#' ) . '/\d{4}/\d{2}/\d{2}/[^/]+/?$#', $image_url ) ||
							strpos( $image_url, '/?p=' ) !== false ) {
							++$invalid_types['url_points_to_post'];
						}
					}

					$attachment_meta = wp_get_attachment_metadata( $attachment_id );
					if ( empty( $attachment_meta ) || ! isset( $attachment_meta['width'] ) ) {
						++$invalid_types['missing_metadata'];
					}

					$mime_type = get_post_mime_type( $attachment_id );
					if ( ! $mime_type || strpos( $mime_type, 'image/' ) !== 0 ) {
						++$invalid_types['invalid_mime_type'];
					}
				}

				// Remove invalid featured image.
				delete_post_meta( $post->ID, '_thumbnail_id' );
				++$cleaned_count;
			}
		}

		return array(
			'cleaned_count' => $cleaned_count,
			'invalid_types' => $invalid_types,
		);
	}
}

/**
 * Add admin notice if there are posts with invalid featured images.
 *
 * @return void
 */
function versatile_check_invalid_featured_images() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Only check on admin dashboard.
	$screen = get_current_screen();
	if ( ! $screen || 'dashboard' !== $screen->id ) {
		return;
	}

	$posts_with_invalid_images = get_posts(
		array(
			'numberposts' => 5, // Check only first 5 to avoid performance issues.
			'post_type'   => 'post',
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			'meta_query'  => array(
				array(
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS',
				),
			),
			'post_status' => 'publish',
		)
	);

	$invalid_count = 0;
	$url_issues    = 0;

	foreach ( $posts_with_invalid_images as $post ) {
		if ( ! versatile_has_valid_featured_image( $post->ID ) ) {
			++$invalid_count;

			// Check if it's a URL pointing to a post issue.
			$attachment_id = get_post_thumbnail_id( $post->ID );
			if ( $attachment_id ) {
				$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
				$site_url  = get_site_url();

				if ( $image_url && strpos( $image_url, $site_url ) !== false ) {
					if ( preg_match( '#' . preg_quote( $site_url, '#' ) . '/[^/]+/?$#', $image_url ) ||
						strpos( $image_url, '/?p=' ) !== false ) {
						++$url_issues;
					}
				}
			}
		}
	}

	if ( $invalid_count > 0 ) {
		$message = '<strong>Versatile Theme:</strong> Found ' . $invalid_count . ' posts with invalid featured images. ';
		if ( $url_issues > 0 ) {
			$message .= $url_issues . ' of these appear to be post URLs set as featured images. ';
		}
		$message .= 'The theme will automatically show placeholders for these posts. ';
		$message .= '<a href="' . admin_url( 'tools.php?page=versatile-cleanup' ) . '">Click here to clean them up</a>.';

		echo '<div class="notice notice-warning is-dismissible">';
		echo '<p>' . esc_html( $message ) . '</p>';
		echo '</div>';
	}
}
add_action( 'admin_notices', 'versatile_check_invalid_featured_images' );

/**
 * Add admin menu for cleanup tools.
 *
 * @return void
 */
function versatile_add_admin_menu() {
	add_management_page(
		'Versatile Theme Tools',
		'Versatile Tools',
		'manage_options',
		'versatile-cleanup',
		'versatile_admin_cleanup_page'
	);
}
add_action( 'admin_menu', 'versatile_add_admin_menu' );

/**
 * Admin cleanup page.
 *
 * @return void
 */
function versatile_admin_cleanup_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.' ) );
	}

	$message      = '';
	$message_type = '';

	// Handle cleanup action.
	if ( isset( $_POST['cleanup_images'] ) && check_admin_referer( 'versatile_cleanup_nonce' ) ) {
		$result = versatile_cleanup_invalid_featured_images();
		if ( $result ) {
			$message = 'Successfully cleaned up ' . $result['cleaned_count'] . ' invalid featured images.';
			if ( ! empty( $result['invalid_types']['url_points_to_post'] ) ) {
				$message .= ' Found ' . $result['invalid_types']['url_points_to_post'] . ' images that were pointing to post URLs.';
			}
			$message_type = 'success';
		} else {
			$message      = 'No invalid featured images found to clean up.';
			$message_type = 'info';
		}
	}

	// Count current invalid images.
	$posts_with_thumbnails = get_posts(
		array(
			'numberposts' => 50,
			'post_type'   => 'post',
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			'meta_query'  => array(
				array(
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS',
				),
			),
			'post_status' => 'publish',
		)
	);

	$invalid_count = 0;
	$url_issues    = 0;

	foreach ( $posts_with_thumbnails as $post ) {
		if ( ! versatile_has_valid_featured_image( $post->ID ) ) {
			++$invalid_count;

			$attachment_id = get_post_thumbnail_id( $post->ID );
			if ( $attachment_id ) {
				$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
				$site_url  = get_site_url();

				if ( $image_url && strpos( $image_url, $site_url ) !== false ) {
					if ( preg_match( '#' . preg_quote( $site_url, '#' ) . '/[^/]+/?$#', $image_url ) ||
						strpos( $image_url, '/?p=' ) !== false ) {
						++$url_issues;
					}
				}
			}
		}
	}

	?>
	<div class="wrap">
		<h1>Versatile Theme Tools</h1>
		
		<?php if ( $message ) : ?>
			<div class="notice notice-<?php echo esc_attr( $message_type ); ?> is-dismissible">
				<p><?php echo esc_html( $message ); ?></p>
			</div>
		<?php endif; ?>
		
		<div class="card">
			<h2>Featured Image Cleanup</h2>
			<p>This tool helps clean up posts that have invalid featured images, including cases where post URLs are set as featured images.</p>
			
			<table class="widefat">
				<tr>
					<td><strong>Posts checked:</strong></td>
					<td><?php echo count( $posts_with_thumbnails ); ?> (showing first 50)</td>
				</tr>
				<tr>
					<td><strong>Invalid featured images found:</strong></td>
					<td><?php echo esc_html( $invalid_count ); ?></td>
				</tr>
				<tr>
					<td><strong>Post URLs set as images:</strong></td>
					<td><?php echo esc_html( $url_issues ); ?></td>
				</tr>
			</table>
			
			<?php if ( $invalid_count > 0 ) : ?>
				<form method="post" action="">
					<?php wp_nonce_field( 'versatile_cleanup_nonce' ); ?>
					<p class="submit">
						<input type="submit" name="cleanup_images" class="button-primary" 
								value="Clean Up Invalid Featured Images" 
								onclick="return confirm('This will remove invalid featured images from posts. The theme will show placeholders instead. Continue?');">
					</p>
				</form>
			<?php else : ?>
				<p><em>No invalid featured images found in the checked posts.</em></p>
			<?php endif; ?>
		</div>
		
		<div class="card">
			<h2>How It Works</h2>
			<p>The Versatile theme automatically detects and handles invalid featured images by:</p>
			<ul>
				<li>Checking if the featured image URL points to a post instead of an image file</li>
				<li>Validating image metadata and MIME types</li>
				<li>Ensuring proper file extensions</li>
				<li>Automatically showing placeholders for invalid images</li>
			</ul>
			<p>When you run the cleanup tool, it will remove the invalid featured image references, allowing the theme to display consistent placeholder images instead.</p>
		</div>
	</div>
	<?php
}

if ( ! function_exists( 'versatile_get_post_image' ) ) {
	/**
	 * Enhanced function to get post thumbnail or placeholder.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $size Image size.
	 * @param array  $attr Image attributes.
	 * @return string
	 */
	function versatile_get_post_image( $post_id = null, $size = 'large', $attr = array() ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		// Check if post has a valid featured image.
		if ( versatile_has_valid_featured_image( $post_id ) ) {
			return get_the_post_thumbnail( $post_id, $size, $attr );
		}

		// Return placeholder if no valid image.
		return versatile_get_placeholder_image( $post_id );
	}
}

if ( ! function_exists( 'versatile_get_small_post_image' ) ) {
	/**
	 * Get small thumbnail for post listings (like in 404 page).
	 *
	 * @param int   $post_id Post ID.
	 * @param array $size Image size.
	 * @return string
	 */
	function versatile_get_small_post_image( $post_id, $size = array( 60, 60 ) ) {
		// Check if post has a valid featured image.
		if ( versatile_has_valid_featured_image( $post_id ) ) {
			return get_the_post_thumbnail( $post_id, $size );
		}

		// Return small placeholder if no valid image.
		return '<div class="post-placeholder-thumb">
                    <svg viewBox="0 0 60 60" class="placeholder-svg-small">
                        <rect width="60" height="60" fill="#f7fafc"/>
                        <text x="30" y="35" text-anchor="middle" fill="#718096" font-size="8" font-weight="600">V</text>
                    </svg>
                </div>';
	}
}

/**
 * Detect site type and apply appropriate settings.
 *
 * @return string
 */
function versatile_detect_site_type() {
	$site_type = 'personal'; // default.

	// Check for WooCommerce.
	if ( class_exists( 'WooCommerce' ) ) {
		$site_type = 'ecommerce';
	} elseif ( 'page' === get_option( 'show_on_front' ) && get_option( 'page_on_front' ) ) { // Check for business indicators.
		$site_type = 'business';
	} elseif ( 'posts' === get_option( 'show_on_front' ) ) { // Check for blog.
		$site_type = 'blog';
	}

	return apply_filters( 'versatilesite_type', $site_type );
}

/**
 * Add body classes based on site type.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function versatile_body_classes( $classes ) {
	$site_type = versatile_detect_site_type();
	$classes[] = 'site-type-' . $site_type;

	// Add class for sidebar.
	if ( is_active_sidebar( 'sidebar-1' ) && ! is_page_template( 'page-landing.php' ) ) {
		$classes[] = 'has-sidebar';
	} else {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'versatile_body_classes' );

/**
 * Custom excerpt length.
 *
 * @param int $length Excerpt length.
 * @return int
 */
function versatile_excerpt_length( $length ) {
	return $length ?? 25;
}
add_filter( 'excerpt_length', 'versatile_excerpt_length', 999 );

/**
 * Custom excerpt more string.
 *
 * @param string $more Excerpt more string.
 * @return string
 */
function versatile_excerpt_more( $more ) {
	return $more ?? '...';
}
add_filter( 'excerpt_more', 'versatile_excerpt_more' );

/**
 * Add custom image sizes.
 *
 * @return void
 */
function versatile_custom_image_sizes() {
	add_image_size( 'versatile-featured', 800, 400, true );
	add_image_size( 'versatile-portfolio', 600, 400, true );
	add_image_size( 'versatile-testimonial', 100, 100, true );
}
add_action( 'after_setup_theme', 'versatile_custom_image_sizes' );

/**
 * Register block styles.
 *
 * @return void
 */
function versatile_register_block_styles() {
	// Register custom block styles here if needed.
}
add_action( 'init', 'versatile_register_block_styles' );

/**
 * Add preload for Google Fonts.
 *
 * @param array  $urls URLs to preload.
 * @param string $relation_type Relation type.
 * @return array
 */
function versatile_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'google-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'versatile_resource_hints', 10, 2 );

/**
 * Improve site performance.
 *
 * @return void
 */
function versatile_performance_optimizations() {
	// Remove unnecessary WordPress features.
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );

	// Remove WordPress version from head.
	remove_action( 'wp_head', 'wp_generator' );

	// Remove RSD link.
	remove_action( 'wp_head', 'rsd_link' );

	// Remove wlwmanifest link.
	remove_action( 'wp_head', 'wlwmanifest_link' );
}
add_action( 'init', 'versatile_performance_optimizations' );

/**
 * Security enhancements.
 *
 * @return void
 */
function versatile_security_headers() {
	if ( ! is_admin() ) {
		header( 'X-Frame-Options: SAMEORIGIN' );
		header( 'X-Content-Type-Options: nosniff' );
		header( 'X-XSS-Protection: 1; mode=block' );
	}
}
add_action( 'send_headers', 'versatile_security_headers' );

/**
 * Output custom CSS for color schemes.
 *
 * @return string
 */
function versatile_color_scheme_css() {
	$colors = versatile_get_current_color_scheme();

	$css = "
    :root {
        --primary-color: {$colors['primary']};
        --primary-hover: {$colors['primary_hover']};
        --secondary-color: {$colors['secondary']};
        --accent-color: {$colors['accent']};
    }
    
    /* Update button styles */
    .btn-primary,
    .wp-block-button__link,
    button[type='submit'],
    input[type='submit'],
    .woocommerce a.button.alt,
    .woocommerce button.button.alt {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
    }
    
    .btn-primary:hover,
    .wp-block-button__link:hover,
    button[type='submit']:hover,
    input[type='submit']:hover,
    .woocommerce a.button.alt:hover,
    .woocommerce button.button.alt:hover {
        background-color: var(--primary-hover) !important;
        border-color: var(--primary-hover) !important;
    }
    
    /* Update post button styles */
    .read-more,
    .more-link,
    .continue-reading {
        color: var(--primary-color) !important;
        white-space: normal;
        overflow-wrap: break-word;
        word-break: break-word;
    }
    
    .read-more:hover,
    .more-link:hover,
    .continue-reading:hover {
        color: var(--primary-hover) !important;
        white-space: normal;
        overflow-wrap: break-word;
        word-break: break-word;
    }
    
    /* Update read more button styles */
    .read-more-btn {
        background: var(--primary-color) !important;
        color: white !important;
        border-color: var(--primary-color) !important;
    }
    
    .read-more-btn:hover {
        background: var(--primary-hover) !important;
        color: white !important;
        border-color: var(--primary-hover) !important;
    }
    
    .entry-footer a,
    .post-navigation a,
    .nav-links a,
    .page-numbers .current,
    .widget-title {
        white-space: normal;
        overflow-wrap: break-word;
        word-break: break-word;
    }
    
    .entry-footer a:hover,
    .post-navigation a:hover,
    .nav-links a:hover {
        white-space: normal;
        overflow-wrap: break-word;
        word-break: break-word;
    }
    
    /* Update link colors */
    a {
        color: var(--primary-color);
    }
    
    a:hover {
        color: var(--primary-hover);
    }
    
    /* Update navigation active states */
    .main-navigation .current_page_item > a,
    .main-navigation .current-menu-item > a,
    .main-navigation a:hover {
        color: var(--primary-color) !important;
    }
    
    /* Update form focus states */
    input[type='text']:focus,
    input[type='email']:focus,
    input[type='url']:focus,
    input[type='password']:focus,
    input[type='search']:focus,
    textarea:focus,
    select:focus {
        border-color: var(--primary-color) !important;
    }
    
    /* Update secondary backgrounds */
    .secondary-bg,
    .widget-area,
    .site-footer .widget {
        background-color: var(--secondary-color);
    }
    
    /* Update header footer overrides to use dynamic colors */
    .main-navigation a:hover,
    .main-navigation .current_page_item > a,
    .main-navigation .current-menu-item > a {
        color: var(--primary-color) !important;
    }
    
    .cta-button,
    .header-cta-button {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
    }
    
    .cta-button:hover,
    .header-cta-button:hover {
        background-color: var(--primary-hover) !important;
        border-color: var(--primary-hover) !important;
    }
    
    .footer-menu a:hover,
    .social-link:hover {
        color: var(--primary-color) !important;
    }
    ";

	return $css;
}

/**
 * Add custom CSS to head (only for non-customizer preview).
 *
 * @return void
 */
function versatile_custom_css() {
	if ( ! is_customize_preview() ) {
		$css = versatile_color_scheme_css();
		echo '<style type="text/css" id="versatile-color-scheme">' . esc_html( $css ) . '</style>';
	}
}
add_action( 'wp_head', 'versatile_custom_css' );