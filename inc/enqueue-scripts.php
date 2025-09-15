<?php
/**
 * Enqueue scripts and styles for the Versatile theme
 *
 * @package Versatile
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue theme styles and scripts
 */
function versatile_enqueue_assets() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// Enqueue Font Awesome
	wp_enqueue_style(
		'font-awesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
		array(),
		'6.4.0'
	);

	// Enqueue main stylesheet
	wp_enqueue_style(
		'versatile-style',
		get_stylesheet_uri(),
		array( 'font-awesome' ),
		$theme_version
	);

	// Enqueue compiled CSS if exists, otherwise fallback to individual files
	$main_css_path = get_template_directory() . '/assets/css/dist/main.css';
	if ( file_exists( $main_css_path ) ) {
		wp_enqueue_style(
			'versatile-main',
			get_template_directory_uri() . '/assets/css/dist/main.css',
			array( 'versatile-style' ),
			$theme_version
		);
	} else {
		// Fallback to individual CSS files
		$css_files = array(
			'main-styles',
			'header-footer',
			'sidebar',
			'archive',
			'author',
			'search',
			'woocommerce',
		);

		foreach ( $css_files as $css_file ) {
			$css_path = get_template_directory() . '/assets/css/src/' . $css_file . '.css';
			if ( file_exists( $css_path ) ) {
				wp_enqueue_style(
					'versatile-' . $css_file,
					get_template_directory_uri() . '/assets/css/src/' . $css_file . '.css',
					array( 'versatile-style' ),
					$theme_version
				);
			}
		}
	}

	// Enqueue compiled JS if exists, otherwise fallback to individual files
	$main_js_path = get_template_directory() . '/assets/js/dist/main.js';
	if ( file_exists( $main_js_path ) ) {
		wp_enqueue_script(
			'versatile-main',
			get_template_directory_uri() . '/assets/js/dist/main.js',
			array( 'jquery' ),
			$theme_version,
			true
		);
	} else {
		// Fallback to individual JS files
		$js_files = array(
			'main',
			'archive-view-toggle',
			'author-filter',
		);

		foreach ( $js_files as $js_file ) {
			$js_path = get_template_directory() . '/assets/js/src/' . $js_file . '.js';
			if ( file_exists( $js_path ) ) {
				wp_enqueue_script(
					'versatile-' . $js_file,
					get_template_directory_uri() . '/assets/js/src/' . $js_file . '.js',
					array( 'jquery' ),
					$theme_version,
					true
				);
			}
		}
	}

	// Enqueue comment reply script on single posts
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'versatile_enqueue_assets' );
