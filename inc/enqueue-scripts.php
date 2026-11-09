<?php
/**
 * Enqueue scripts and styles for the Versatile theme
 *
 * @package Versatile
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue theme styles and scripts.
 */
function versatile_enqueue_assets() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// Enqueue theme fonts: Inter (body) and Manrope (headings).
	wp_enqueue_style(
		'versatile-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@700;800&display=swap',
		array(),
		$theme_version
	);

	// Enqueue Font Awesome.
	wp_enqueue_style(
		'font-awesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
		array(),
		'6.4.0'
	);

	// Enqueue main stylesheet.
	wp_enqueue_style(
		'versatile-style',
		get_stylesheet_uri(),
		array( 'font-awesome' ),
		$theme_version
	);

	wp_enqueue_style(
		'versatile-main',
		VERSATILE_THEME_URI . '/assets/css/dist/main.css',
		array( 'versatile-style', 'versatile-fonts' ),
		$theme_version
	);

	wp_enqueue_script(
		'versatile-main',
		VERSATILE_THEME_URI . '/assets/js/dist/main.js',
		array( 'jquery' ),
		$theme_version,
		true
	);

	// Enqueue comment reply script on single posts.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'versatile_enqueue_assets' );
