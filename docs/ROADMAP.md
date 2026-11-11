# Versatile Theme Roadmap

_Last reviewed: 2026-11-12 against `main` @ `03a8ae9`._

Status markers: `[x]` done · `[~]` partly done · `[ ]` not started. Items marked
**(verify)** are implemented but need a run on a live WordPress install to
confirm (PHP notices, WooCommerce on/off, real data).

## Purpose

Versatile will be a lightweight, adaptable WordPress theme for:

- Personal websites and blogs
- Freelancer and portfolio websites
- Small-business and service websites
- Optional WooCommerce stores

The product goal is to let users create either a personal or business website without editing PHP, maintaining separate themes, or depending on a page builder.

## Status Summary

| Phase | Status | Notes |
|---|---|---|
| 1. Stabilize the foundation | **Mostly done** | Inline CSS/JS in `comments.php` and `404.php`, oversized `style.css` and dead CSS remain |
| Magazine-grid redesign (added) | **Done** | Blog, single, search, header, shop, product, cart, checkout, comments |
| 2. Editor-managed sites (patterns) | **Not started** | Largest remaining block of work |
| 3. Accessibility, WooCommerce, performance | **Partly done** | WooCommerce UX largely done; focus traps, reduced motion, fonts/icons open |
| 4. Quality and release readiness | **Partly done** | Build + CSS/JS lint pass; packaging, i18n, screenshot, plugin-territory code open |

## Current Assessment

The theme is a classic/hybrid theme (PHP template hierarchy + `theme.json`) with:

- One canonical `front-page.php`; every template renders one header, one main area and one footer
- A magazine-grid design: Inter (body) + Manrope (headings), ink/neutral palette, teal accent (`#0f766e`), pill controls, unboxed widgets
- Shared listing partials (`template-parts/blog/`) for home, archives and related posts; list-style search results
- A cleaned-up Customizer (18 settings, all with controls, sanitizers and real output) with colour schemes "Versatile (Teal)" (default) and "Versatile (Ink & Blue)"
- A full WooCommerce skin: shop toolbar and category pills, built-in product sidebar, single product, notices, mini cart, block cart/checkout, star ratings, sale/sold-out states
- One asset pipeline: `assets/*/src` → `assets/*/dist` via `npm run build` (Sass modules + Webpack); the redesign lives in `assets/css/src/skin/`

What still blocks a release: leftover inline CSS/JS in two templates, legacy CSS weight, missing block patterns, accessibility gaps in overlays, CDN fonts/icons, plugin-territory code in `functions.php`, and packaging/i18n/docs.

## Architecture Decisions

### 1. Retain a classic/hybrid theme

Keep the existing PHP template hierarchy and use `theme.json`, editor styles, block patterns, and core blocks where they improve editing.

Do not rewrite Versatile as a full block theme during this roadmap.

### 2. Use one canonical homepage template

Use `front-page.php` as the single homepage entry point. When the front page shows latest posts it renders the shared magazine listing; when it shows a static page it renders that page's content with `the_content()`.

### 3. Separate global settings from page content

Use the Customizer only for site-wide options:

- Logo and site identity
- Color scheme and custom brand colors
- Typography presets
- Content width and sidebar preferences (including the shop sidebar mode)
- Header CTA
- Contact information and social links
- Footer copyright and theme credit

Use the block editor for page-specific content, including heroes, services, testimonials, statistics, calls to action, and landing-page sections.

Do not build a large collection of homepage-specific Customizer repeaters.

### 4. Provide explicit personal and business patterns

Replace automatic site-type detection with user-selectable block patterns and starter layouts.

WooCommerce activation must not reclassify an entire website as an e-commerce site.

### 5. Keep functionality in plugins

Do not register portfolio, service, or testimonial custom post types in the theme. Use core posts, pages, Query Loop blocks, or an optional companion plugin when structured content is required.

Do not implement form submission, newsletter subscription, email delivery, data-cleanup tools, or HTTP security headers in the theme. Integrate with established plugins and document supported options.

### 6. Maintain one asset pipeline

Use SCSS and JavaScript sources under `assets/*/src/` and generated files under `assets/*/dist/`. Redesign styles live in `assets/css/src/skin/_magazine.scss` (site-wide, in `main.css`) and `skin/_store.scss` (WooCommerce pages, in `woocommerce.css`).

The root `style.css` should contain the WordPress theme header and only essential compatibility rules. Component styles, inline template styles, and duplicate JavaScript handlers must move into the source asset pipeline.

### 7. Header cart works on every page (added)

The header cart pill and mini-cart dropdown are present site-wide, so `wc-cart-fragments` is enqueued on every page (WooCommerce ≥ 7.8 no longer does this by default), and `assets/js/src/cart-sync.js` keeps it in sync with the block Cart/Checkout. Mini-cart styles therefore live in `main.css`, not `woocommerce.css`.

## Completed: Magazine-Grid Redesign

Delivered on `design/magazine-grid`, merged into `main`.

- [x] Design tokens: Inter + Manrope, ink/neutral palette, teal accent; synced `theme.json`, CSS custom properties, SCSS variables and editor styles
- [x] Header: sticky frosted bar (backdrop-filter on a `::before` layer so fixed overlays aren't trapped), pill navigation, search button, cart pill sharing one markup function with the AJAX fragment
- [x] Blog home: featured lead post, "Popular" rail, category pills, image-led card grid, pill pagination
- [x] Archives use the same listing partial; sidebar widgets unboxed
- [x] Single post: aligned 680px reading column, restrained heading scale, reading progress bar, copy/share, author card, related posts, restyled comment form (consent checkbox, submit button)
- [x] Search results: header with refine field, type filter pills, list rows with highlighted terms, restyled empty state
- [x] Horizontal overflow fixed site-wide (`overflow-x: clip` safety net)
- [x] Shop: toolbar (count + custom sort select), product category pills, teal add-to-cart and sale badge, added-to-cart state and "View cart →" link, "Sold out" badge and "View product" button, consistent regular/sale price scale, buttons aligned per row, two-up grid on phones
- [x] Shop sidebar: built-in product filters by default (search, active filters, price, categories, top rated); Customizer mode Built-in / Widgets / None; never on cart, checkout or account (`versatile_is_commerce_flow_page` filter)
- [x] Single product: full-width tabs and related row (legacy 2-col grid fixed), compact related products, gallery zoom button and thumbnails, SVG-mask star ratings and review picker, tab links no longer hijacked by smooth scroll
- [x] Notices, mini cart (always-rendered fragment container, delegated hover/keyboard handlers), block checkout checkbox and Place Order button
- [x] Customizer: "Versatile (Ink & Blue)" scheme added; teal remains the default

## Phase 1: Stabilize the Foundation

### Homepage and template cleanup

- [x] Create one canonical `front-page.php` based on the editorial design.
- [x] Remove duplicate headers, footers, and homepage implementations (`front-page-template.php`, `front-page-versatile.php` removed).
- [x] Ensure the site footer appears only once.
- [x] Render editor-managed page content on the homepage.
- [x] Remove empty `#` links and nonfunctional forms.
- [x] Hide optional sections until they have meaningful content.
- [x] Keep demonstration statistics, client names, ratings, and testimonials out of live defaults.

### Theme setup consolidation

- [x] Make `inc/theme-support.php` the single source for theme support and navigation locations.
- [x] Standardize navigation locations as `primary`, `footer`, and `social`; every template uses them.
- [~] Keep widget registration in one location. `sidebar-1` and `footer-*` are in `functions.php`; `shop-sidebar` is in `inc/integrations/woocommerce.php`. Either move them together or document the WooCommerce one as an intentional exception.
- [x] Standardize the shop sidebar ID as `shop-sidebar`; no `sidebar-shop` registration remains.
- [x] Register WooCommerce support only in `inc/integrations/woocommerce.php`.
- [~] Retain runtime guards so the theme works when WooCommerce is inactive. Guards are in place; **(verify)** on a site without WooCommerce.

### Customizer repair

- [x] Correct all selective-refresh callback names.
- [x] Correct every checkbox sanitization callback.
- [x] Remove or migrate disconnected `vs_*`, `hero_*`, `business_*`, `portfolio_*`, and `shop_*` settings.
- [x] Ensure every visible Customizer control saves, sanitizes, previews, and affects the intended output (18 settings, all read).
- [x] Avoid theme-mod arrays that have no user-facing editing controls.

### CSS and JavaScript consolidation

- [x] Establish `assets/css/src/main.scss` as the front-end stylesheet entry point.
- [x] Replace deprecated Sass `@import` with `@use`.
- [x] Move header CSS into SCSS partials; header interactions live in `assets/js/src/main.js`.
- [x] Remove duplicate WooCommerce style loading; `woocommerce.css` loads only on WooCommerce pages.
- [x] Create a compiled editor stylesheet and reference it through `add_editor_style()`.
- [x] Use generated assets in production.
- [ ] Move the inline `<style>` block in `comments.php` (~415 lines) into SCSS. Its `.comment-form input { width: 100% }` rule already caused a bug.
- [ ] Move the inline `<style>` (~300 lines) and `<script>` in `404.php` into the pipeline.
- [ ] Reduce root `style.css` (~900 lines) to the theme header plus essential compatibility rules; move the rest into SCSS.
- [ ] Remove dead CSS: legacy `.site-type-*` rules (site-type detection is gone), and the unused WooCommerce `star` `@font-face` inline style (stars are SVG now).

### Phase 1 Acceptance Criteria

- [x] Every tested page contains one document header, one primary content area, and one footer.
- [x] No homepage section is rendered more than once.
- [x] Personal and static-page homepage settings work through normal WordPress reading settings.
- [x] All registered Customizer controls save without callback errors.
- [x] Navigation can be assigned to each documented menu location.
- [~] No PHP notices or fatal errors with WooCommerce active or inactive. All PHP files pass `php -l`; **(verify)** with `WP_DEBUG` on, WooCommerce on and off.
- [x] The homepage has no placeholder links or nonfunctional forms.
- [x] Editor styles load in the block editor.
- [~] Front-end CSS and JavaScript are generated from the documented source entry points. True for the pipeline; inline template CSS/JS above still bypasses it.

## Phase 2: Editor-Managed Personal and Business Sites

_Not started: there is no `patterns/` directory and no pattern category._

### Block pattern infrastructure

- [ ] Register a `Versatile` block pattern category.
- [ ] Store patterns in the theme's `patterns/` directory using core block markup.
- [ ] Use `theme.json` tokens for colors, typography, spacing, and layout. Tokens exist; patterns must reference them.
- [ ] Ensure patterns remain editable after insertion and do not require theme-specific PHP helpers.

### Personal website patterns

- [ ] Personal homepage
- [ ] Profile introduction with image and social links
- [ ] About section
- [ ] Selected-work or latest-posts section
- [ ] Personal contact CTA
- [ ] Blog-focused landing layout

### Small-business patterns

- [ ] Business homepage
- [ ] Business hero with primary and secondary CTA
- [ ] Services grid
- [ ] About/company section
- [ ] Statistics or trust-indicators section
- [ ] Testimonials built from core quote/group blocks
- [ ] Contact CTA
- [ ] Services, about, contact, and conversion-focused landing layouts

### Reusable section patterns

- [ ] Hero
- [ ] Services/features
- [ ] Latest posts or Query Loop grid (match the magazine card style)
- [ ] Testimonials
- [ ] Statistics
- [ ] Newsletter introduction
- [ ] CTA banner
- [ ] Contact details

Newsletter and contact patterns should default to a valid contact-page CTA. Document how users can replace that CTA with their chosen plugin's block or shortcode.

### Phase 2 Acceptance Criteria

- [ ] A user can create personal and business homepages without editing PHP.
- [ ] Pattern content can be edited, reordered, duplicated, or removed in the block editor.
- [ ] Patterns use global design tokens rather than hardcoded copies of theme colors.
- [ ] No pattern requires a custom post type registered by the theme.
- [ ] The theme remains useful when no form, newsletter, portfolio, or WooCommerce plugin is installed.

## Phase 3: Accessibility, WooCommerce, and Performance

### Accessibility (target WCAG 2.2 AA for theme-controlled components)

- [~] Complete keyboard navigation. The header, mini cart (focus opens, Escape closes), star picker, tabs and forms work; **(verify)** with a full keyboard pass.
- [x] Visible focus states (`:focus-visible` rings on controls; programmatic focus on notices suppressed).
- [x] Correct `aria-expanded` and accessible names (search, menu, icon-only buttons, cart pill).
- [~] Focus placement, containment, and restoration for overlays. Placement and restoration are done; **containment (focus trap) is missing** for the search overlay and mobile menu.
- [x] Escape-key support for search, mobile navigation and mini cart.
- [~] Sufficient color contrast for every color scheme. Teal (~5.5:1) and Ink & Blue pass; **audit the remaining Customizer schemes**.
- [ ] Reduced-motion support: no `prefers-reduced-motion` rules exist yet (~90 transitions/animations).
- [~] Semantic headings, landmarks, forms, and error states. Landmarks and heading levels are reviewed; WooCommerce error notices are styled; **(verify)** comment and checkout validation states.

### WooCommerce

- [x] Shop and product archives
- [x] Single products
- [x] Cart and checkout (block-based; sidebar removed)
- [ ] Customer account pages: not yet reviewed or styled
- [~] Mini-cart and mobile cart behavior. The desktop dropdown and live sync are done; **(verify)** the mobile full-screen dropdown has a clear way to close.
- [x] Empty and populated shop sidebars (built-in filters when the widget area is empty or unused)
- [x] Theme color and typography controls (accent drives buttons, badges, stars, notices)
- [ ] Raise WooCommerce image sizes: `thumbnail_image_width` is 150 and `single_image_width` is 300, but the grid shows ~300px and single products ~600px, so images look soft. Use ~600 and ~1000, then regenerate thumbnails.
- [ ] **(verify)** The whole site with WooCommerce deactivated.

### Performance

- [x] Load only required front-end assets; `woocommerce.css` is limited to WooCommerce pages.
- [~] Avoid loading WooCommerce assets on unrelated pages where safe. `wc-cart-fragments` is intentionally global for the header cart (see Decision 7).
- [ ] Self-host Inter and Manrope (front end and editor currently use the Google Fonts CDN), or offer a system-font default.
- [ ] Replace Font Awesome 6 (full CDN stylesheet, ~35 distinct icons used) with small inline SVG icons.
- [ ] Remove unused legacy CSS and JavaScript (legacy stylesheets are overridden by the skin rather than removed).
- [ ] Test responsive images, lazy loading, layout shift, and mobile Core Web Vitals.

## Phase 4: Quality and Release Readiness

### Development tooling

- [~] Install reproducible dependencies with `npm ci` and `composer install`. `npm ci` works; run `composer install` locally.
- [~] Add Stylelint and ESLint configs compatible with the declared dependency versions. Both exist and pass; `.stylelintrc.json` still uses stylistic rules deprecated in Stylelint 15+ and should be migrated.
- [~] Ensure `npm run build` and `npm run lint` complete successfully. Build, `lint:css` and `lint:js` pass; **(verify)** `lint:php` (PHPCS needs `composer install`).
- [ ] Add focused tests for helper functions, sanitizers, and color-scheme behavior. PHPUnit is a dev dependency but there is no `tests/` directory. Good first candidates: `versatile_search_excerpt()`, `versatile_is_commerce_flow_page()`, the sold-out filters, the sanitizers.
- [ ] Run WordPress Theme Check and PHP syntax checks before release (`php -l` passes today).

### Compatibility and internationalization

- [ ] Align the declared WordPress minimum with the `theme.json` features used: `theme.json` is version 3 (WordPress 6.6+) but `style.css` says `Requires at least: 5.0`.
- [ ] Test against the current stable WordPress release and supported PHP versions.
- [ ] Update `Tested up to` at release time (currently 6.8).
- [~] Make all user-facing strings translatable with the `versatile` text domain. Most are; the featured-image cleanup admin page in `functions.php` has hardcoded English.
- [ ] Generate `languages/versatile.pot`.
- [ ] Verify child-theme behavior and template overrides.

### Plugin-territory code (added)

Required by Decision 5 and WordPress.org theme review. Move these to a companion plugin or remove them:

- [ ] Featured-image cleanup admin page, admin notice and bulk data changes (`functions.php`)
- [ ] HTTP security headers (`versatile_security_headers`)
- [ ] Removal of emoji scripts, generator, RSD and wlwmanifest tags (`versatile_performance_optimizations`)

### Documentation and packaging

- [ ] Update the documentation to describe only implemented features:
  - Installation and first-time setup
  - Homepage and reading settings
  - Personal and business patterns
  - Customizer options, including colour schemes and the shop sidebar mode
  - Menu and widget locations
  - Form and newsletter plugin integration
  - Optional WooCommerce setup, including the `versatile_is_commerce_flow_page` filter
  - Development, build, lint, and test commands
- [ ] Rewrite `docs/CLAUDE.md`. It still describes "no build process", `css/` and `js/` folders, `front-page-template.php`, automatic site-type detection and security headers.
- [ ] Update `docs/tideline-design-direction.md` (Fraunces/Newsreader) or mark it superseded by the magazine-grid direction.
- [ ] Archive the historical fix notes (`*-FIX.md`, `SIDEBAR-CSS-ORGANIZATION.md`) under `docs/archive/`.
- [ ] Replace the placeholder `CHANGELOG.md` (single 1.0.0 entry dated 2024) with real entries, including the redesign.
- [ ] Replace `screenshot.png` (1944×1438, old design) with a 1200×900 capture of the new design.
- [ ] Add `.distignore` and an `npm run zip` (or similar) script that builds a production ZIP with compiled assets and no dev files.
- [ ] Review `style.css` tags against implemented features (e.g. `portfolio`, `custom-header`).

### Release Acceptance Criteria

- [ ] Clean installation and activation on a fresh WordPress site
- [ ] No PHP fatal errors, unexpected notices, placeholder links, or nonfunctional default forms
- [~] Successful production build and lint runs (PHP lint pending)
- [ ] Keyboard and responsive smoke tests passed
- [ ] Personal and business starter layouts tested
- [ ] WooCommerce-active and WooCommerce-inactive paths tested
- [ ] Documentation matches the released behavior
- [ ] Production package installs without requiring Node.js or Composer

## Next Implementation Batches

1. **Finish Phase 1.** Move the `comments.php` and `404.php` inline CSS/JS into the pipeline; slim `style.css`; delete the dead `.site-type-*` and star-font code.
2. **Release quick wins.** Set `Requires at least: 6.6`; raise WooCommerce image sizes; new screenshot; generate `.pot`; add `.distignore` and a ZIP script; move the plugin-territory code out.
3. **Accessibility.** Focus traps for the search overlay and mobile menu; `prefers-reduced-motion`; contrast audit of all colour schemes; My Account pages.
4. **Performance.** Self-host fonts; replace Font Awesome with inline SVG; prune legacy CSS.
5. **Phase 2 patterns.** Pattern category, reusable sections, then personal and business starter layouts.
6. **Docs and tooling.** Rewrite `CLAUDE.md`, the changelog and user docs; migrate the Stylelint config; add PHPUnit tests; Theme Check; full WooCommerce on/off smoke test.

## Non-Goals for This Roadmap

- Full block-theme rewrite
- Theme-registered custom post types
- Built-in form or newsletter delivery
- A proprietary page builder
- A demo importer before the underlying templates and patterns are stable
- Additional homepage variants before the canonical template is repaired
