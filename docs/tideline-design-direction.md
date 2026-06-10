# Tideline Direction — Implementation for Versatile

## 1. Token changes — `assets/css/src/main-styles.css` (`:root` block)

```css
:root {
    --primary-color: #0f766e;
    --primary-hover: #115e59;
    --secondary-color: #f2f7f6;
    --text-color: #1f2933;
    --text-muted: #5f6c7b;
    --border-color: #dbe7e4;
    --background-color: #ffffff;
    --background-alt: #f2f7f6;
    --header-bg: #fdfdfc;
    --footer-bg: #0b3b39;
    --border-radius: 14px;
    --box-shadow: 0 10px 30px rgba(15, 118, 110, 0.10);
    /* keep remaining tokens as-is */
    --font-family-heading: 'Fraunces', Georgia, serif;
}
```

Also sync the SCSS side so the two systems stop disagreeing — `assets/css/src/abstracts/_variables.scss`:
```scss
$primary-color: #0f766e;
$secondary-color: #115e59;
$accent-color: #14b8a6;
$font-family-heading: 'Fraunces', Georgia, serif;
```

## 2. Heading font rule (append to main-styles.css or _typography.scss)

```css
h1, h2, h3, h4, .post-title, .site-title, .hero-title, .section-title {
    font-family: var(--font-family-heading);
    font-weight: 600;
    letter-spacing: -0.01em;
}
.hero-subtitle {
    font-family: 'Newsreader', Georgia, serif;
    font-style: italic;
    color: var(--primary-color);
}
```

Note: remove the gradient text-fill on `.site-title a` (currently `linear-gradient(135deg, gray, darkgray)` with transparent fill) — it fights the serif and looks washed out.

## 3. Font enqueue — `inc/enqueue-scripts.php`

```php
wp_enqueue_style(
    'versatile-fonts',
    'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,640&family=Newsreader:ital,opsz,wght@1,6..72,500&display=swap',
    array(),
    null
);
```
(For GPL/theme-directory compliance, consider self-hosting the two font files instead.)

## 4. Hero wave (optional signature touch)

```css
.hero-section { position: relative;
    background: linear-gradient(180deg, #f2f7f6 0%, #fdfdfc 100%); }
.hero-section::after { content: ""; position: absolute; left: 0; right: 0;
    bottom: -1px; height: 42px;
    background: radial-gradient(60% 120% at 50% 0, transparent 60%, #fff 61%); }
```

## 5. Release checklist (look & feel)

- [ ] Apply tokens + heading font above, rebuild with `npm run build`
- [ ] Create `screenshot.png` (1200x900) showing the Tideline homepage
- [ ] Remove gradient text-fill from `.site-title a`
- [ ] Bump `Tested up to:` in style.css header to current WP version
- [ ] Verify dark-mode tokens (`:root[data-theme="dark"]`) against teal primary — suggest `--primary-color: #2dd4bf` for dark
