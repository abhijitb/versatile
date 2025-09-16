<?php
/**
 * Theme support features for the Versatile theme
 *
 * @package Versatile
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Set up theme defaults and register support for various WordPress features.
 */
function versatile_theme_support() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Enqueue editor styles.
	add_editor_style( 'assets/css/src/editor-style.css' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for custom logo.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Add support for custom header.
	add_theme_support(
		'custom-header',
		array(
			'default-color'      => 'ffffff',
			'default-text-color' => '000000',
			'width'              => 1200,
			'height'             => 280,
			'flex-width'         => true,
			'flex-height'        => true,
		)
	);

	// Add support for custom background.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'ffffff',
		)
	);

	// Add support for HTML5 markup.
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

	// Add support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for starter content.
	add_theme_support(
		'starter-content',
		array(
			'widgets'    => array(
				'sidebar-1' => array(
					'text_business_info',
					'search',
					'text_about',
				),
				'footer-1'  => array(
					'text_about',
				),
				'footer-2'  => array(
					'archives',
				),
				'footer-3'  => array(
					'meta',
				),
			),
			'posts'      => array(
				'home',
				'about',
				'contact',
				'blog',
			),
			'theme_mods' => array(
				'panel_1' => '{{home}}',
				'panel_2' => '{{about}}',
				'panel_3' => '{{blog}}',
				'panel_4' => '{{contact}}',
			),
			'nav_menus'  => array(
				'top' => array(
					'name'  => __( 'Top Menu', 'versatile' ),
					'items' => array(
						'link_home',
						'page_about',
						'page_blog',
						'page_contact',
					),
				),
			),
		)
	);

	// Register navigation menus.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'versatile' ),
			'footer'  => esc_html__( 'Footer Menu', 'versatile' ),
			'social'  => esc_html__( 'Social Links Menu', 'versatile' ),
		)
	);

	// Add support for block styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for editor font sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name' => esc_attr__( 'Small', 'versatile' ),
				'size' => 12,
				'slug' => 'small',
			),
			array(
				'name' => esc_attr__( 'Regular', 'versatile' ),
				'size' => 16,
				'slug' => 'regular',
			),
			array(
				'name' => esc_attr__( 'Large', 'versatile' ),
				'size' => 36,
				'slug' => 'large',
			),
			array(
				'name' => esc_attr__( 'Huge', 'versatile' ),
				'size' => 50,
				'slug' => 'huge',
			),
		)
	);

	// Add support for editor color palette.
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => esc_attr__( 'Primary', 'versatile' ),
				'slug'  => 'primary',
				'color' => '#007cba',
			),
			array(
				'name'  => esc_attr__( 'Secondary', 'versatile' ),
				'slug'  => 'secondary',
				'color' => '#006ba1',
			),
			array(
				'name'  => esc_attr__( 'Dark Gray', 'versatile' ),
				'slug'  => 'dark-gray',
				'color' => '#333333',
			),
			array(
				'name'  => esc_attr__( 'Light Gray', 'versatile' ),
				'slug'  => 'light-gray',
				'color' => '#f8f9fa',
			),
			array(
				'name'  => esc_attr__( 'White', 'versatile' ),
				'slug'  => 'white',
				'color' => '#ffffff',
			),
		)
	);
}
add_action( 'after_setup_theme', 'versatile_theme_support' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet
 */
function versatile_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'versatile_content_width', 1200 );
}
add_action( 'after_setup_theme', 'versatile_content_width', 0 );
