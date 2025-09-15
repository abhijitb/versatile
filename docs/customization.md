# Customization Guide

## Theme Structure

The Versatile theme follows a professional, modular structure:

```
versatile/
├── assets/                  # All static assets
│   ├── css/                # Stylesheets
│   ├── js/                 # JavaScript files
│   ├── images/             # Images and icons
│   └── fonts/              # Web fonts
├── template-parts/         # Reusable template components
├── inc/                    # PHP includes and functionality
├── docs/                   # Documentation
└── build/                  # Build configuration
```

## Customization Methods

### 1. WordPress Customizer

The easiest way to customize the theme:

1. Go to **Appearance > Customize**
2. Available sections:
   - **Site Identity**: Logo, colors, tagline
   - **Header Settings**: Layout, navigation style
   - **Footer Settings**: Widget areas, copyright
   - **Typography**: Font choices and sizes
   - **Layout**: Sidebar positions, container widths

### 2. Child Theme (Recommended)

Always use a child theme for customizations:

```php
<?php
// style.css
/*
Theme Name: Versatile Child
Template: versatile
Version: 1.0.0
*/

@import url("../versatile/style.css");

/* Your custom styles here */
```

### 3. Custom CSS

Add custom CSS via:
- **Appearance > Customize > Additional CSS**
- Child theme's `style.css`
- Custom CSS plugin

### 4. Template Overrides

Override template files in your child theme:

```
child-theme/
├── template-parts/
│   └── content/
│       └── content-single.php    # Override single post layout
├── header.php                    # Override header
└── footer.php                    # Override footer
```

## Development Setup

For advanced customization:

### Install Dependencies

```bash
# Navigate to theme directory
cd wp-content/themes/versatile

# Install development dependencies
npm install
```

### Available Scripts

```bash
# Build assets for production
npm run build

# Watch for changes during development
npm run watch

# Lint CSS and JavaScript
npm run lint

# Format code
npm run format
```

## SCSS Development

### SCSS Structure

```scss
// assets/css/src/main.scss
@import 'abstracts/variables';  // Colors, fonts, breakpoints
@import 'abstracts/mixins';     // Reusable mixins
@import 'base/reset';           // CSS reset
@import 'components/buttons';   // Button styles
@import 'layout/header';        // Header layout
// ... more imports
```

### Customizing Variables

Edit `assets/css/src/abstracts/_variables.scss`:

```scss
// Colors
$primary-color: #your-color;
$secondary-color: #your-secondary;

// Typography
$font-family-base: 'Your Font', sans-serif;

// Spacing
$spacer: 1.5rem; // Adjust base spacing
```

## Responsive Design

### Breakpoints

Use predefined breakpoints:

```scss
.my-component {
    padding: spacer(2);
    
    @include media-breakpoint-up(md) {
        padding: spacer(4);
    }
    
    @include media-breakpoint-up(lg) {
        display: flex;
    }
}
```

### Available Breakpoints

- `xs`: 0px
- `sm`: 576px
- `md`: 768px
- `lg`: 992px
- `xl`: 1200px
- `xxl`: 1400px

## Adding Custom Functionality

### Child Theme Functions

Add to child theme's `functions.php`:

```php
<?php
// Enqueue additional styles
function child_theme_styles() {
    wp_enqueue_style('child-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'child_theme_styles');

// Add custom post type
function create_custom_post_type() {
    register_post_type('portfolio',
        array(
            'labels' => array(
                'name' => 'Portfolio',
                'singular_name' => 'Portfolio Item'
            ),
            'public' => true,
            'supports' => array('title', 'editor', 'thumbnail')
        )
    );
}
add_action('init', 'create_custom_post_type');
```

## Performance Optimization

### Asset Building

```bash
# Minify assets for production
npm run build

# Watch for changes during development
npm run watch
```

### Best Practices

1. Use appropriate image sizes
2. Implement lazy loading
3. Enable caching plugins
4. Optimize database queries
5. Use WebP format for images

## Getting Help

- Check theme documentation in `docs/`
- Review code comments
- Test in staging environment
- Use browser developer tools
- Contact theme support if needed
