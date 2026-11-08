<?php
/**
 * Theme support features for the Versatile theme.
 *
 * @package Versatile
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Set up theme defaults and register support for WordPress features.
 */
function versatile_theme_support() {
	load_theme_textdomain( 'versatile', VERSATILE_THEME_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'custom-line-height' );
	add_theme_support( 'custom-units' );
	add_theme_support( 'custom-spacing' );
	add_theme_support( 'custom-padding' );

	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/dist/editor-style.css' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

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

	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'ffffff',
		)
	);

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

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'versatile' ),
			'footer'  => esc_html__( 'Footer Menu', 'versatile' ),
			'social'  => esc_html__( 'Social Links Menu', 'versatile' ),
		)
	);

	add_theme_support(
		'starter-content',
		array(
			'widgets'   => array(
				'sidebar-1' => array(
					'text_business_info',
					'search',
					'text_about',
				),
				'footer-1'  => array( 'text_about' ),
				'footer-2'  => array( 'archives' ),
				'footer-3'  => array( 'meta' ),
			),
			'posts'     => array(
				'home',
				'about',
				'contact',
				'blog',
			),
			'nav_menus' => array(
				'primary' => array(
					'name'  => __( 'Primary Menu', 'versatile' ),
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
}
add_action( 'after_setup_theme', 'versatile_theme_support' );

/**
 * Set the content width in pixels, based on the theme's design.
 */
function versatile_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'versatile_content_width', 1200 );
}
add_action( 'after_setup_theme', 'versatile_content_width', 0 );
