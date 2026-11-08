<?php
/**
 * Versatile Theme Customizer
 *
 * @package Versatile
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function versatile_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'versatile_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'versatile_customize_partial_blogdescription',
			)
		);

		// Add partial for color scheme changes.
		$wp_customize->selective_refresh->add_partial(
			'versatile_color_scheme_css',
			array(
				'selector'            => '#versatile-color-scheme',
				'render_callback'     => 'versatile_customize_partial_css',
				'container_inclusive' => true,
			)
		);
	}

	// Social Media Section.
	$wp_customize->add_section(
		'versatile_social_media',
		array(
			'title'    => esc_html__( 'Social Media Links', 'versatile' ),
			'priority' => 30,
		)
	);

	// Facebook URL.
	$wp_customize->add_setting(
		'versatile_facebook_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'versatile_facebook_url',
		array(
			'label'   => esc_html__( 'Facebook URL', 'versatile' ),
			'section' => 'versatile_social_media',
			'type'    => 'url',
		)
	);

	// Twitter URL.
	$wp_customize->add_setting(
		'versatile_twitter_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'versatile_twitter_url',
		array(
			'label'   => esc_html__( 'Twitter URL', 'versatile' ),
			'section' => 'versatile_social_media',
			'type'    => 'url',
		)
	);

	// Instagram URL.
	$wp_customize->add_setting(
		'versatile_instagram_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'versatile_instagram_url',
		array(
			'label'   => esc_html__( 'Instagram URL', 'versatile' ),
			'section' => 'versatile_social_media',
			'type'    => 'url',
		)
	);

	// LinkedIn URL.
	$wp_customize->add_setting(
		'versatile_linkedin_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'versatile_linkedin_url',
		array(
			'label'   => esc_html__( 'LinkedIn URL', 'versatile' ),
			'section' => 'versatile_social_media',
			'type'    => 'url',
		)
	);

	// YouTube URL.
	$wp_customize->add_setting(
		'versatile_youtube_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'versatile_youtube_url',
		array(
			'label'   => esc_html__( 'YouTube URL', 'versatile' ),
			'section' => 'versatile_social_media',
			'type'    => 'url',
		)
	);

	// Contact Information Section.
	$wp_customize->add_section(
		'versatile_contact_info',
		array(
			'title'    => esc_html__( 'Contact Information', 'versatile' ),
			'priority' => 35,
		)
	);

	// Phone Number.
	$wp_customize->add_setting(
		'versatile_contact_phone',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'versatile_contact_phone',
		array(
			'label'   => esc_html__( 'Phone Number', 'versatile' ),
			'section' => 'versatile_contact_info',
			'type'    => 'text',
		)
	);

	// Email Address.
	$wp_customize->add_setting(
		'versatile_contact_email',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'versatile_contact_email',
		array(
			'label'   => esc_html__( 'Email Address', 'versatile' ),
			'section' => 'versatile_contact_info',
			'type'    => 'email',
		)
	);

	// Address.
	$wp_customize->add_setting(
		'versatile_contact_address',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'versatile_contact_address',
		array(
			'label'   => esc_html__( 'Address', 'versatile' ),
			'section' => 'versatile_contact_info',
			'type'    => 'textarea',
		)
	);

	// Color Schemes Section.
	$wp_customize->add_section(
		'versatile_color_schemes',
		array(
			'title'    => esc_html__( 'Color Schemes', 'versatile' ),
			'priority' => 35,
		)
	);

	// Predefined Color Schemes.
	$wp_customize->add_setting(
		'versatile_color_scheme',
		array(
			'default'           => 'versatile_teal',
			'sanitize_callback' => 'versatile_sanitize_color_scheme',
			'transport'         => 'postMessage',
		)
	);

	$color_schemes  = versatile_get_color_schemes();
	$scheme_choices = array();
	foreach ( $color_schemes as $key => $scheme ) {
		$scheme_choices[ $key ] = $scheme['label'];
	}

	$wp_customize->add_control(
		'versatile_color_scheme',
		array(
			'label'       => esc_html__( 'Choose Color Scheme', 'versatile' ),
			'section'     => 'versatile_color_schemes',
			'type'        => 'select',
			'choices'     => $scheme_choices,
			'description' => esc_html__( 'Select a predefined color scheme or use custom colors below.', 'versatile' ),
		)
	);

	// Custom Primary Color.
	$wp_customize->add_setting(
		'versatile_primary_color',
		array(
			'default'           => '#0f766e',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'versatile_primary_color',
			array(
				'label'           => esc_html__( 'Primary Color', 'versatile' ),
				'section'         => 'versatile_color_schemes',
				'description'     => esc_html__( 'Override the scheme primary color with your custom choice.', 'versatile' ),
				'active_callback' => 'versatile_is_custom_color_scheme',
			)
		)
	);

	// Custom Secondary Color.
	$wp_customize->add_setting(
		'versatile_secondary_color',
		array(
			'default'           => '#f2f7f6',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'versatile_secondary_color',
			array(
				'label'           => esc_html__( 'Secondary Color', 'versatile' ),
				'section'         => 'versatile_color_schemes',
				'description'     => esc_html__( 'Override the scheme secondary color.', 'versatile' ),
				'active_callback' => 'versatile_is_custom_color_scheme',
			)
		)
	);

	// Header Options Section.
	$wp_customize->add_section(
		'versatile_header_options',
		array(
			'title'    => esc_html__( 'Header Options', 'versatile' ),
			'priority' => 40,
		)
	);

	// Header CTA Button Text.
	$wp_customize->add_setting(
		'versatile_header_cta_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'versatile_header_cta_text',
		array(
			'label'   => esc_html__( 'Header CTA Button Text', 'versatile' ),
			'section' => 'versatile_header_options',
			'type'    => 'text',
		)
	);

	// Header CTA Button URL.
	$wp_customize->add_setting(
		'versatile_header_cta_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'versatile_header_cta_url',
		array(
			'label'   => esc_html__( 'Header CTA Button URL', 'versatile' ),
			'section' => 'versatile_header_options',
			'type'    => 'url',
		)
	);

	// Show Social Links in Header.
	$wp_customize->add_setting(
		'versatile_social_links_header',
		array(
			'default'           => false,
			'sanitize_callback' => 'versatile_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'versatile_social_links_header',
		array(
			'label'   => esc_html__( 'Show Social Links in Header', 'versatile' ),
			'section' => 'versatile_header_options',
			'type'    => 'checkbox',
		)
	);

	// Footer Options Section.
	$wp_customize->add_section(
		'versatile_footer_options',
		array(
			'title'    => esc_html__( 'Footer Options', 'versatile' ),
			'priority' => 45,
		)
	);

	// Copyright Text.
	$wp_customize->add_setting(
		'versatile_copyright_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		'versatile_copyright_text',
		array(
			'label'   => esc_html__( 'Copyright Text', 'versatile' ),
			'section' => 'versatile_footer_options',
			'type'    => 'textarea',
		)
	);

	// Show Theme Credit.
	$wp_customize->add_setting(
		'versatile_show_theme_credit',
		array(
			'default'           => true,
			'sanitize_callback' => 'versatile_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'versatile_show_theme_credit',
		array(
			'label'   => esc_html__( 'Show Theme Credit', 'versatile' ),
			'section' => 'versatile_footer_options',
			'type'    => 'checkbox',
		)
	);

	// Show Social Links in Mobile Menu.
	$wp_customize->add_setting(
		'versatile_social_links_mobile',
		array(
			'default'           => true,
			'sanitize_callback' => 'versatile_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'versatile_social_links_mobile',
		array(
			'label'   => esc_html__( 'Show Social Links in Mobile Menu', 'versatile' ),
			'section' => 'versatile_header_options',
			'type'    => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'versatile_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function versatile_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function versatile_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Render the CSS for color scheme changes.
 *
 * @return void
 */
function versatile_customize_partial_css() {
	$css = versatile_color_scheme_css();
	echo '<style type="text/css" id="versatile-color-scheme">' . esc_html( $css ) . '</style>';
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function versatile_customize_preview_js() {
	$customizer_js_path = VERSATILE_THEME_DIR . '/assets/js/dist/customizer.js';
	if ( file_exists( $customizer_js_path ) ) {
		wp_enqueue_script( 'versatile-customizer', VERSATILE_THEME_URI . '/assets/js/dist/customizer.js', array( 'customize-preview' ), VERSATILE_VERSION, true );
	}
}
add_action( 'customize_preview_init', 'versatile_customize_preview_js' );

/**
 * Sanitize checkbox values.
 *
 * @param mixed $checked The checkbox value.
 * @return bool The sanitized checkbox value.
 */
function versatile_sanitize_checkbox( $checked ) {
	return in_array( $checked, array( true, 1, '1', 'true', 'on' ), true );
}

/**
 * Get available color schemes.
 *
 * @return array The available color schemes.
 */
function versatile_get_color_schemes() {
	return array(
		'default'        => array(
			'label'  => esc_html__( 'Ocean Blue', 'versatile' ),
			'colors' => array(
				'primary'       => '#2563eb',
				'primary_hover' => '#1d4ed8',
				'secondary'     => '#f8f9fa',
				'accent'        => '#3b82f6',
			),
		),
		'emerald'        => array(
			'label'  => esc_html__( 'Emerald Green', 'versatile' ),
			'colors' => array(
				'primary'       => '#059669',
				'primary_hover' => '#047857',
				'secondary'     => '#f0fdf4',
				'accent'        => '#10b981',
			),
		),
		'sunset'         => array(
			'label'  => esc_html__( 'Sunset Orange', 'versatile' ),
			'colors' => array(
				'primary'       => '#ea580c',
				'primary_hover' => '#c2410c',
				'secondary'     => '#fff7ed',
				'accent'        => '#fb923c',
			),
		),
		'royal'          => array(
			'label'  => esc_html__( 'Royal Purple', 'versatile' ),
			'colors' => array(
				'primary'       => '#7c3aed',
				'primary_hover' => '#5b21b6',
				'secondary'     => '#faf5ff',
				'accent'        => '#8b5cf6',
			),
		),
		'crimson'        => array(
			'label'  => esc_html__( 'Crimson Red', 'versatile' ),
			'colors' => array(
				'primary'       => '#dc2626',
				'primary_hover' => '#b91c1c',
				'secondary'     => '#fef2f2',
				'accent'        => '#ef4444',
			),
		),
		'slate'          => array(
			'label'  => esc_html__( 'Slate Gray', 'versatile' ),
			'colors' => array(
				'primary'       => '#374151',
				'primary_hover' => '#1f2937',
				'secondary'     => '#f9fafb',
				'accent'        => '#6b7280',
			),
		),
		'teal'           => array(
			'label'  => esc_html__( 'Modern Teal', 'versatile' ),
			'colors' => array(
				'primary'       => '#0d9488',
				'primary_hover' => '#0f766e',
				'secondary'     => '#f0fdfa',
				'accent'        => '#14b8a6',
			),
		),
		'versatile_teal' => array(
			'label'  => esc_html__( 'Versatile (Teal)', 'versatile' ),
			'colors' => array(
				'primary'       => '#0f766e',
				'primary_hover' => '#115e59',
				'secondary'     => '#f2f7f6',
				'accent'        => '#2dd4bf',
			),
		),
		'rose'           => array(
			'label'  => esc_html__( 'Rose Pink', 'versatile' ),
			'colors' => array(
				'primary'       => '#e11d48',
				'primary_hover' => '#be185d',
				'secondary'     => '#fff1f2',
				'accent'        => '#f43f5e',
			),
		),
		'custom'         => array(
			'label'  => esc_html__( 'Custom Colors', 'versatile' ),
			'colors' => array(
				'primary'       => '#2563eb',
				'primary_hover' => '#1d4ed8',
				'secondary'     => '#f8f9fa',
				'accent'        => '#3b82f6',
			),
		),
	);
}

/**
 * Sanitize color scheme choice.
 *
 * @param string $input The color scheme input.
 * @return string The sanitized color scheme.
 */
function versatile_sanitize_color_scheme( $input ) {
	$valid_schemes = array_keys( versatile_get_color_schemes() );
	return in_array( $input, $valid_schemes, true ) ? $input : 'versatile_teal';
}

/**
 * Active callback for custom color controls.
 *
 * @return bool The custom color scheme value.
 */
function versatile_is_custom_color_scheme() {
	return 'custom' === get_theme_mod( 'versatile_color_scheme', 'versatile_teal' );
}

/**
 * Get the current color scheme colors.
 *
 * @return array The current color scheme colors.
 */
function versatile_get_current_color_scheme() {
	$schemes        = versatile_get_color_schemes();
	$current_scheme = get_theme_mod( 'versatile_color_scheme', 'versatile_teal' );

	if ( 'custom' === $current_scheme ) {
		return array(
			'primary'       => get_theme_mod( 'versatile_primary_color', '#0f766e' ),
			'primary_hover' => versatile_adjust_color_brightness( get_theme_mod( 'versatile_primary_color', '#0f766e' ), -30 ),
			'secondary'     => get_theme_mod( 'versatile_secondary_color', '#f2f7f6' ),
			'accent'        => get_theme_mod( 'versatile_primary_color', '#0f766e' ),
		);
	}

	return isset( $schemes[ $current_scheme ] ) ? $schemes[ $current_scheme ]['colors'] : $schemes['versatile_teal']['colors'];
}

/**
 * Adjust color brightness.
 *
 * @param string $hex The hex color.
 * @param int    $steps The number of steps to adjust the brightness.
 * @return string The adjusted color.
 */
function versatile_adjust_color_brightness( $hex, $steps ) {
	// Remove # if present.
	$hex = str_replace( '#', '', $hex );

	// Convert to decimal.
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );

	// Adjust brightness.
	$r = max( 0, min( 255, $r + $steps ) );
	$g = max( 0, min( 255, $g + $steps ) );
	$b = max( 0, min( 255, $b + $steps ) );

	// Convert back to hex.
	return '#' . str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT ) .
				str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT ) .
				str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );
}
