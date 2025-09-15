/**
 * Customizer live preview functionality for Versatile
 */
(function($) {
    'use strict';
    
    // Ensure wp.customize is available
    if (typeof wp === 'undefined' || typeof wp.customize === 'undefined') {
        console.error('Versatile Customizer: wp.customize not available');
        return;
    }

    // Color scheme live preview
    wp.customize('versatile_color_scheme', function(value) {
        value.bind(function(newval) {
            // Define color schemes (same as PHP)
            const colorSchemes = {
                'default': {
                    primary: '#2563eb',
                    primary_hover: '#1d4ed8',
                    secondary: '#f8f9fa',
                    accent: '#3b82f6'
                },
                'emerald': {
                    primary: '#059669',
                    primary_hover: '#047857',
                    secondary: '#f0fdf4',
                    accent: '#10b981'
                },
                'sunset': {
                    primary: '#ea580c',
                    primary_hover: '#c2410c',
                    secondary: '#fff7ed',
                    accent: '#fb923c'
                },
                'royal': {
                    primary: '#7c3aed',
                    primary_hover: '#5b21b6',
                    secondary: '#faf5ff',
                    accent: '#8b5cf6'
                },
                'crimson': {
                    primary: '#dc2626',
                    primary_hover: '#b91c1c',
                    secondary: '#fef2f2',
                    accent: '#ef4444'
                },
                'slate': {
                    primary: '#374151',
                    primary_hover: '#1f2937',
                    secondary: '#f9fafb',
                    accent: '#6b7280'
                },
                'teal': {
                    primary: '#0d9488',
                    primary_hover: '#0f766e',
                    secondary: '#f0fdfa',
                    accent: '#14b8a6'
                },
                'rose': {
                    primary: '#e11d48',
                    primary_hover: '#be185d',
                    secondary: '#fff1f2',
                    accent: '#f43f5e'
                }
            };

            if (colorSchemes[newval]) {
                updateColorScheme(colorSchemes[newval]);
            } else {
                console.warn('Versatile Customizer: Unknown color scheme', newval);
            }
        });
    });

    // Custom primary color live preview
    wp.customize('versatile_primary_color', function(value) {
        value.bind(function(newval) {
            if (wp.customize('versatile_color_scheme')() === 'custom') {
                const customColors = {
                    primary: newval,
                    primary_hover: adjustColorBrightness(newval, -30),
                    secondary: wp.customize('versatile_secondary_color')(),
                    accent: newval
                };
                updateColorScheme(customColors);
            }
        });
    });

    // Custom secondary color live preview
    wp.customize('versatile_secondary_color', function(value) {
        value.bind(function(newval) {
            if (wp.customize('versatile_color_scheme')() === 'custom') {
                const customColors = {
                    primary: wp.customize('versatile_primary_color')(),
                    primary_hover: adjustColorBrightness(wp.customize('versatile_primary_color')(), -30),
                    secondary: newval,
                    accent: wp.customize('versatile_primary_color')()
                };
                updateColorScheme(customColors);
            }
        });
    });

    /**
     * Update color scheme in preview
     */
    function updateColorScheme(colors) {        
        // Remove existing custom styles
        $('#versatile-color-scheme-preview').remove();
        $('#versatile-color-scheme').remove(); // Also remove the server-side style
        
        // Create new style with higher specificity
        const css = `
            :root {
                --primary-color: ${colors.primary};
                --primary-hover: ${colors.primary_hover};
                --secondary-color: ${colors.secondary};
                --accent-color: ${colors.accent};
            }
            
            /* Update button styles */
            .btn-primary,
            .wp-block-button__link,
            button[type='submit'],
            input[type='submit'],
            .woocommerce a.button.alt,
            .woocommerce button.button.alt {
                background-color: ${colors.primary} !important;
                border-color: ${colors.primary} !important;
            }
            
            .btn-primary:hover,
            .wp-block-button__link:hover,
            button[type='submit']:hover,
            input[type='submit']:hover,
            .woocommerce a.button.alt:hover,
            .woocommerce button.button.alt:hover {
                background-color: ${colors.primary_hover} !important;
                border-color: ${colors.primary_hover} !important;
            }
            
            /* Update link colors */
            a {
                color: ${colors.primary};
            }
            
            a:hover {
                color: ${colors.primary_hover};
            }
            
            /* Update read more and post navigation colors */
            .read-more,
            .more-link,
            .continue-reading {
                color: ${colors.primary} !important;
            }
            
            .read-more:hover,
            .more-link:hover,
            .continue-reading:hover {
                color: ${colors.primary_hover} !important;
            }
            
            /* Update read more button styles */
            .read-more-btn {
                background: ${colors.primary} !important;
                color: white !important;
                border-color: ${colors.primary} !important;
            }
            
            .read-more-btn:hover {
                background: ${colors.primary_hover} !important;
                color: white !important;
                border-color: ${colors.primary_hover} !important;
            }
            
            /* Update navigation active states */
            .main-navigation .current_page_item > a,
            .main-navigation .current-menu-item > a,
            .main-navigation a:hover {
                color: ${colors.primary} !important;
            }
            
            /* Update form focus states */
            input[type='text']:focus,
            input[type='email']:focus,
            input[type='url']:focus,
            input[type='password']:focus,
            input[type='search']:focus,
            textarea:focus,
            select:focus {
                border-color: ${colors.primary} !important;
            }
            
            /* Update secondary backgrounds */
            .secondary-bg,
            .widget-area,
            .site-footer .widget {
                background-color: ${colors.secondary};
            }
            
            /* Update header footer overrides to use dynamic colors */
            .main-navigation a:hover,
            .main-navigation .current_page_item > a,
            .main-navigation .current-menu-item > a {
                color: ${colors.primary} !important;
            }
            
            .cta-button,
            .header-cta-button {
                background-color: ${colors.primary} !important;
                border-color: ${colors.primary} !important;
            }
            
            .cta-button:hover,
            .header-cta-button:hover {
                background-color: ${colors.primary_hover} !important;
                border-color: ${colors.primary_hover} !important;
            }
            
            .footer-menu a:hover,
            .social-link:hover {
                color: ${colors.primary} !important;
            }
        `;
        
        // Add new style with debugging
        const styleElement = '<style type="text/css" id="versatile-color-scheme-preview">' + css + '</style>';
        $('head').append(styleElement);
        
        // Debug: Check if style was added
        if ($('#versatile-color-scheme-preview').length <= 0) {
            console.error('Versatile Customizer: Failed to add CSS style to head');
        }
        
        // Force a repaint by toggling a class on body
        $('body').removeClass('color-updating').addClass('color-updating');
        setTimeout(function() {
            $('body').removeClass('color-updating');
        }, 50);
        
        // Test: Apply direct styles to specific elements for debugging
        $('.read-more, .more-link, .continue-reading, a').css('color', colors.primary);
        $('.btn-primary, button[type="submit"]').css({
            'background-color': colors.primary,
            'border-color': colors.primary
        });
        
        // Force update read-more buttons specifically
        $('.read-more, .more-link, .continue-reading').css({
            'color': colors.primary + ' !important'
        });
        
        // Force update read-more-btn buttons specifically
        $('.read-more-btn').css({
            'background-color': colors.primary + ' !important',
            'border-color': colors.primary + ' !important',
            'color': 'white !important'
        });
    }

    /**
     * Adjust color brightness (simplified version)
     */
    function adjustColorBrightness(hex, steps) {
        // Remove # if present
        hex = hex.replace('#', '');
        
        // Convert to decimal
        const r = parseInt(hex.substr(0, 2), 16);
        const g = parseInt(hex.substr(2, 2), 16);
        const b = parseInt(hex.substr(4, 2), 16);
        
        // Adjust brightness
        const newR = Math.max(0, Math.min(255, r + steps));
        const newG = Math.max(0, Math.min(255, g + steps));
        const newB = Math.max(0, Math.min(255, b + steps));
        
        // Convert back to hex
        return '#' + 
               newR.toString(16).padStart(2, '0') + 
               newG.toString(16).padStart(2, '0') + 
               newB.toString(16).padStart(2, '0');
    }

    // Initialize color scheme on page load
    $(document).ready(function() {        
        // Get current color scheme and apply it
        const currentScheme = wp.customize('versatile_color_scheme')();
        
        // Apply the current color scheme
        const colorSchemes = {
            'default': { primary: '#2563eb', primary_hover: '#1d4ed8', secondary: '#f8f9fa', accent: '#3b82f6' },
            'emerald': { primary: '#059669', primary_hover: '#047857', secondary: '#f0fdf4', accent: '#10b981' },
            'sunset': { primary: '#ea580c', primary_hover: '#c2410c', secondary: '#fff7ed', accent: '#fb923c' },
            'royal': { primary: '#7c3aed', primary_hover: '#5b21b6', secondary: '#faf5ff', accent: '#8b5cf6' },
            'crimson': { primary: '#dc2626', primary_hover: '#b91c1c', secondary: '#fef2f2', accent: '#ef4444' },
            'slate': { primary: '#374151', primary_hover: '#1f2937', secondary: '#f9fafb', accent: '#6b7280' },
            'teal': { primary: '#0d9488', primary_hover: '#0f766e', secondary: '#f0fdfa', accent: '#14b8a6' },
            'rose': { primary: '#e11d48', primary_hover: '#be185d', secondary: '#fff1f2', accent: '#f43f5e' }
        };
        
        if (colorSchemes[currentScheme]) {
            updateColorScheme(colorSchemes[currentScheme]);
        }
    });

    // Site title and description live preview
    wp.customize('blogname', function(value) {
        value.bind(function(newval) {
            $('.site-title a').text(newval);
        });
    });

    wp.customize('blogdescription', function(value) {
        value.bind(function(newval) {
            $('.site-description').text(newval);
        });
    });

})(jQuery);