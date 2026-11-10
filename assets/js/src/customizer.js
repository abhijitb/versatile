/**
 * Customizer live preview functionality for Versatile.
 */
(function($) {
    'use strict';

    if (typeof wp === 'undefined' || typeof wp.customize === 'undefined') {
        return;
    }

    const colorSchemes = {
        default: {
            primary: '#2563eb',
            primary_hover: '#1d4ed8',
            secondary: '#f8f9fa',
            accent: '#3b82f6'
        },
        emerald: {
            primary: '#059669',
            primary_hover: '#047857',
            secondary: '#f0fdf4',
            accent: '#10b981'
        },
        sunset: {
            primary: '#ea580c',
            primary_hover: '#c2410c',
            secondary: '#fff7ed',
            accent: '#fb923c'
        },
        royal: {
            primary: '#7c3aed',
            primary_hover: '#5b21b6',
            secondary: '#faf5ff',
            accent: '#8b5cf6'
        },
        crimson: {
            primary: '#dc2626',
            primary_hover: '#b91c1c',
            secondary: '#fef2f2',
            accent: '#ef4444'
        },
        slate: {
            primary: '#374151',
            primary_hover: '#1f2937',
            secondary: '#f9fafb',
            accent: '#6b7280'
        },
        teal: {
            primary: '#0d9488',
            primary_hover: '#0f766e',
            secondary: '#f0fdfa',
            accent: '#14b8a6'
        },
        versatile_ink: {
            primary: '#2747e8',
            primary_hover: '#1d36c4',
            secondary: '#f2f3f5',
            accent: '#2747e8'
        },
        versatile_teal: {
            primary: '#0f766e',
            primary_hover: '#115e59',
            secondary: '#f2f7f6',
            accent: '#2dd4bf'
        },
        rose: {
            primary: '#e11d48',
            primary_hover: '#be185d',
            secondary: '#fff1f2',
            accent: '#f43f5e'
        }
    };

    function adjustColorBrightness(hex, steps) {
        const value = hex.replace('#', '');
        const channels = [0, 2, 4].map(function(offset) {
            const channel = parseInt(value.substr(offset, 2), 16);
            return Math.max(0, Math.min(255, channel + steps))
                .toString(16)
                .padStart(2, '0');
        });

        return '#' + channels.join('');
    }

    function getCurrentColors() {
        const scheme = wp.customize('versatile_color_scheme')();

        if (scheme !== 'custom') {
            return colorSchemes[scheme] || colorSchemes.versatile_ink;
        }

        const primary = wp.customize('versatile_primary_color')();

        return {
            primary: primary,
            primary_hover: adjustColorBrightness(primary, -30),
            secondary: wp.customize('versatile_secondary_color')(),
            accent: primary
        };
    }

    function updateColorScheme() {
        const colors = getCurrentColors();
        let style = document.getElementById('versatile-color-scheme-preview');

        if (!style) {
            style = document.createElement('style');
            style.id = 'versatile-color-scheme-preview';
            document.head.appendChild(style);
        }

        style.textContent = ':root {' +
            '--primary-color: ' + colors.primary + ';' +
            '--primary-hover: ' + colors.primary_hover + ';' +
            '--secondary-color: ' + colors.secondary + ';' +
            '--accent-color: ' + colors.accent + ';' +
            '}';
    }

    [
        'versatile_color_scheme',
        'versatile_primary_color',
        'versatile_secondary_color'
    ].forEach(function(setting) {
        wp.customize(setting, function(value) {
            value.bind(updateColorScheme);
        });
    });

    wp.customize('blogname', function(value) {
        value.bind(function(newValue) {
            $('.site-title a').text(newValue);
        });
    });

    wp.customize('blogdescription', function(value) {
        value.bind(function(newValue) {
            $('.site-description').text(newValue);
        });
    });

    $(document).ready(updateColorScheme);
})(jQuery);
