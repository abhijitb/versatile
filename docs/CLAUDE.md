# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Theme Overview

**Versatile** is a custom WordPress theme designed for flexibility and adaptability across multiple site types:
- Personal websites and blogs
- Business/corporate sites  
- E-commerce stores (with WooCommerce integration)
- Portfolio sites

## Architecture & File Structure

### Core Theme Files
- `style.css` - Main theme identifier with imports to modular CSS files
- `functions.php` - Theme functionality, hooks, and WordPress feature support
- `index.php` - Main template fallback
- Template files: `single.php`, `page.php`, `archive.php`, `404.php`, etc.

### Key Directories
- `css/` - Modular stylesheets
  - `main.css` - Core theme styles with CSS custom properties
  - `header-footer.css` - Header and footer specific styles  
  - `woocommerce.css` - E-commerce styling when WooCommerce is active
- `inc/` - PHP includes and functionality
  - `template-tags.php` - Custom template functions
  - `template-functions.php` - Theme enhancement functions
  - `customizer.php` - WordPress Customizer integration
- `js/` - JavaScript functionality
  - `main.js` - Core theme JavaScript (jQuery-based)

### Template Hierarchy
- Standard WordPress template hierarchy applies
- Special templates:
  - `front-page-template.php` - Homepage template
  - `page-landing.php` - Landing page template
- Uses `get_template_directory()` for file includes

## Development Workflow

### No Build Process
This theme uses **direct CSS/JS development** without build tools like Gulp, Webpack, or npm scripts. Files are edited directly and loaded via WordPress enqueuing.

### CSS Development
- Modular approach with separate CSS files for different concerns
- Uses CSS custom properties (variables) defined in `:root`
- Import structure: `style.css` imports `main.css` and conditionally `woocommerce.css`

### JavaScript Development  
- jQuery-based JavaScript in `js/main.js`
- Enqueued with WordPress dependencies in `functions.php`
- AJAX functionality available with localized `versatile_ajax` object

### Theme Customization
- WordPress Customizer integration in `inc/customizer.php`
- Theme supports custom colors, fonts, layouts
- Detects site type (personal, business, blog, ecommerce) automatically

## Key Features & Functionality

### Responsive Design
- Mobile-first CSS approach
- Flexible grid system using CSS custom properties
- Adaptive layouts based on content and sidebar presence

### WooCommerce Integration
- Conditional WooCommerce support loaded when plugin active
- Custom product layouts and styling
- Shop-specific sidebar registration

### Performance Optimizations
- Selective script/style loading based on context
- Removed unnecessary WordPress features (emojis, RSD, etc.)
- Preconnect hints for external resources
- Security headers implementation

### Multi-Site Type Support
- Automatic site type detection (personal/business/blog/ecommerce)
- Adaptive styling based on detected type
- Body classes added for site-type specific styling

## Common Development Tasks

### Adding New Styles
1. Edit relevant CSS file in `css/` directory
2. Use CSS custom properties from `:root` for consistency
3. Follow existing naming conventions and structure

### Modifying Theme Functions
1. Edit `functions.php` for WordPress hooks and features
2. Add custom functions to appropriate `inc/` files
3. Use `versatile_` prefix for all custom functions

### Template Modifications
1. Follow WordPress template hierarchy
2. Use theme's custom template tags from `inc/template-tags.php`
3. Maintain accessibility and semantic HTML structure

### Customizer Options
1. Add new options in `inc/customizer.php`
2. Use `postMessage` transport for live preview when possible
3. Implement selective refresh for better UX

## Theme Constants & Globals

- `_S_VERSION` - Theme version constant (defined in functions.php)
- Uses `get_template_directory()` and `get_template_directory_uri()` for paths
- Text domain: `versatile`
- Supports RTL languages

## WordPress Features Supported

- Custom backgrounds, headers, logos
- Block editor styles and wide alignment
- Custom image sizes and post thumbnails  
- Multiple navigation menus
- Widget areas (sidebar + 4 footer areas + shop sidebar)
- Translation ready
- Selective refresh in Customizer

## Important Notes

- Theme includes security headers and performance optimizations
- Uses semantic HTML5 markup throughout
- Accessibility considerations built-in
- No external dependencies beyond WordPress and jQuery
- All code follows WordPress coding standards