# Installation Guide

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Node.js 16+ (for development)
- npm or yarn (for development)

## Installation Methods

### Method 1: Upload via WordPress Admin

1. Download the theme ZIP file
2. Go to **Appearance > Themes** in your WordPress admin
3. Click **Add New** then **Upload Theme**
4. Choose the ZIP file and click **Install Now**
5. Click **Activate** to enable the theme

### Method 2: Manual Installation

1. Download and extract the theme files
2. Upload the `versatile` folder to `/wp-content/themes/`
3. Go to **Appearance > Themes** in WordPress admin
4. Find "Versatile" and click **Activate**

### Method 3: Development Setup

For developers who want to modify the theme:

```bash
# Clone or download the theme
cd wp-content/themes/versatile

# Install dependencies
npm install

# Build assets for production
npm run build

# Or watch for changes during development
npm run watch
```

## Post-Installation Setup

### 1. Configure Menus

1. Go to **Appearance > Menus**
2. Create menus for:
   - Primary Navigation
   - Footer Menu
   - Social Links Menu

### 2. Set Up Widgets

1. Go to **Appearance > Widgets**
2. Configure sidebar and footer widget areas

### 3. Customize Theme Settings

1. Go to **Appearance > Customize**
2. Configure:
   - Site Identity (logo, colors)
   - Header settings
   - Footer settings
   - Typography
   - Layout options

### 4. Import Demo Content (Optional)

If demo content is available, you can import it to see the theme in action with sample data.

## Troubleshooting

### Common Issues

**Theme doesn't activate:**
- Check PHP version (7.4+ required)
- Ensure all files were uploaded correctly

**Styles not loading:**
- Clear any caching plugins
- Run `npm run build` if using development version

**Menu not displaying:**
- Create and assign menus in **Appearance > Menus**
- Check if menu location is set correctly

### Getting Help

- Check the documentation in the `docs/` folder
- Review the theme's GitHub issues
- Contact support if you purchased the theme
