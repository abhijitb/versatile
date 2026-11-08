# Versatile Theme Roadmap

## Purpose

Versatile will be a lightweight, adaptable WordPress theme for:

- Personal websites and blogs
- Freelancer and portfolio websites
- Small-business and service websites
- Optional WooCommerce stores

The product goal is to let users create either a personal or business website without editing PHP, maintaining separate themes, or depending on a page builder.

## Current Assessment

The theme already has a substantial foundation:

- Core PHP templates for posts, pages, archives, authors, search, comments, sidebars, and 404 pages
- An editorial visual direction with a teal palette and Fraunces/Newsreader typography
- Customizer options for colors, social links, contact information, header CTA, and footer content
- Widget areas, navigation menus, pagination, and author biographies
- WooCommerce integration
- SCSS, Webpack, PHPCS, and `theme.json` groundwork

The current code is not yet release-ready. The main problems are overlapping theme generations, duplicated homepage markup, disconnected Customizer settings, multiple asset paths, placeholder functionality, and incomplete quality tooling.

The next phase must prioritize consolidation over new features.

## Architecture Decisions

### 1. Retain a classic/hybrid theme

Keep the existing PHP template hierarchy and use `theme.json`, editor styles, block patterns, and core blocks where they improve editing.

Do not rewrite Versatile as a full block theme during this roadmap.

### 2. Use one canonical homepage template

Use `front-page.php` as the single homepage entry point. It must contain one `get_header()` call, one main content area, and one `get_footer()` call.

Preserve the latest editorial design system and components, but not the duplicated monolithic PHP structure. Remove `front-page-template.php` and `front-page-versatile.php` after their useful components have been migrated.

The homepage must render the assigned page's content with `the_content()` so users can edit it in WordPress. Dynamic post sections should use core Query Loop blocks or deliberate theme queries.

### 3. Separate global settings from page content

Use the Customizer only for site-wide options:

- Logo and site identity
- Color scheme and custom brand colors
- Typography presets
- Content width and sidebar preferences
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

Do not implement form submission, newsletter subscription, or email delivery in the theme. Integrate with established form and newsletter plugins and document supported options.

### 6. Maintain one asset pipeline

Use SCSS and JavaScript sources under `assets/*/src/` and generated files under `assets/*/dist/`.

The root `style.css` should contain the WordPress theme header and only essential compatibility rules. Component styles, inline header styles, and duplicate JavaScript handlers must move into the source asset pipeline.

## Phase 1: Stabilize the Foundation

### Homepage and template cleanup

- Create one canonical `front-page.php` based on the editorial design.
- Remove duplicate headers, footers, and homepage implementations.
- Ensure the site footer appears only once.
- Render editor-managed page content on the homepage.
- Remove empty `#` links and nonfunctional forms.
- Hide optional sections until they have meaningful content.
- Keep demonstration statistics, client names, ratings, and testimonials out of live defaults; provide them only as optional starter content.

### Theme setup consolidation

- Make `inc/theme-support.php` the single source for theme support and navigation locations.
- Standardize navigation locations as `primary`, `footer`, and `social`, and update every template to use them.
- Keep widget registration in one location.
- Standardize the shop sidebar ID as `shop-sidebar` and remove the duplicate `sidebar-shop` registration.
- Register WooCommerce support only in `inc/integrations/woocommerce.php`.
- Retain runtime guards so the theme works when WooCommerce is inactive.

### Customizer repair

- Correct all selective-refresh callback names.
- Correct every checkbox sanitization callback.
- Remove or migrate disconnected `vs_*`, `hero_*`, `business_*`, `portfolio_*`, and `shop_*` settings.
- Ensure every visible Customizer control saves, sanitizes, previews, and affects the intended output.
- Avoid theme-mod arrays that have no user-facing editing controls.

### CSS and JavaScript consolidation

- Establish `assets/css/src/main.scss` as the front-end stylesheet entry point.
- Replace deprecated Sass `@import` usage with the current module convention during SCSS consolidation.
- Move header CSS into the appropriate SCSS partials.
- Move inline header interactions into `assets/js/src/main.js` and keep one handler per control.
- Remove duplicate WooCommerce style loading and load store-specific assets only where needed.
- Create a compiled editor stylesheet and reference that single file through `add_editor_style()`.
- Use generated assets in production rather than the current fallback collection of individual source files.

### Phase 1 Acceptance Criteria

- Every tested page contains one document header, one primary content area, and one footer.
- No homepage section is rendered more than once.
- Personal and static-page homepage settings work through normal WordPress reading settings.
- All registered Customizer controls save without callback errors.
- Navigation can be assigned to each documented menu location.
- No PHP notices or fatal errors occur with WooCommerce active or inactive.
- The homepage has no placeholder links or nonfunctional forms.
- Editor styles load in the block editor.
- Front-end CSS and JavaScript are generated from the documented source entry points.

## Phase 2: Editor-Managed Personal and Business Sites

### Block pattern infrastructure

- Register a `Versatile` block pattern category.
- Store patterns in the theme's `patterns/` directory using core block markup.
- Use `theme.json` tokens for colors, typography, spacing, and layout.
- Ensure patterns remain editable after insertion and do not require theme-specific PHP helpers.

### Personal website patterns

Provide:

- Personal homepage
- Profile introduction with image and social links
- About section
- Selected-work or latest-posts section
- Personal contact CTA
- Blog-focused landing layout

### Small-business patterns

Provide:

- Business homepage
- Business hero with primary and secondary CTA
- Services grid
- About/company section
- Statistics or trust-indicators section
- Testimonials built from core quote/group blocks
- Contact CTA
- Services, about, contact, and conversion-focused landing layouts

### Reusable section patterns

Extract shared sections rather than duplicating complete pages:

- Hero
- Services/features
- Latest posts or Query Loop grid
- Testimonials
- Statistics
- Newsletter introduction
- CTA banner
- Contact details

Newsletter and contact patterns should default to a valid contact-page CTA. Document how users can replace that CTA with their chosen plugin's block or shortcode.

### Phase 2 Acceptance Criteria

- A user can create personal and business homepages without editing PHP.
- Pattern content can be edited, reordered, duplicated, or removed in the block editor.
- Patterns use global design tokens rather than hardcoded copies of theme colors.
- No pattern requires a custom post type registered by the theme.
- The theme remains useful when no form, newsletter, portfolio, or WooCommerce plugin is installed.

## Phase 3: Accessibility, WooCommerce, and Performance

### Accessibility

Target WCAG 2.2 AA behavior for theme-controlled components:

- Complete keyboard navigation
- Visible focus states
- Correct `aria-expanded` and accessible names
- Focus placement, containment, and restoration for overlays
- Escape-key support for search and mobile navigation
- Sufficient color contrast for every color scheme
- Reduced-motion support
- Semantic headings, landmarks, forms, and error states

### WooCommerce

Test with WooCommerce both active and inactive, including:

- Shop and product archives
- Single products
- Cart and checkout
- Customer account pages
- Mini-cart and mobile cart behavior
- Empty and populated shop sidebars
- Theme color and typography controls

### Performance

- Load only required front-end assets.
- Avoid loading WooCommerce assets on unrelated pages where safe.
- Self-host font files with appropriate licenses or provide a system-font default.
- Replace broad icon-font usage with small inline SVG icons where practical.
- Remove unused legacy CSS and JavaScript.
- Test responsive images, lazy loading behavior, layout shift, and mobile Core Web Vitals.

## Phase 4: Quality and Release Readiness

### Development tooling

- Install reproducible dependencies with `npm ci` and `composer install`.
- Add Stylelint and ESLint configuration files compatible with the declared dependency versions.
- Ensure `npm run build` and `npm run lint` complete successfully.
- Add focused tests for helper functions, sanitizers, and color-scheme behavior where useful.
- Run WordPress Theme Check and PHP syntax checks before release.

### Compatibility and internationalization

- Align the declared WordPress minimum with the `theme.json` features used.
- Test against the current stable WordPress release and supported PHP versions.
- Update `Tested up to` at release time.
- Make all user-facing strings translatable with the `versatile` text domain.
- Generate `languages/versatile.pot`.
- Verify child-theme behavior and template overrides.

### Documentation and packaging

Update the documentation to describe only implemented features:

- Installation and first-time setup
- Homepage and reading settings
- Personal and business patterns
- Customizer options
- Menu and widget locations
- Form and newsletter plugin integration
- Optional WooCommerce setup
- Development, build, lint, and test commands

Create a production ZIP containing compiled assets and required theme files while excluding development dependencies, local files, and unrelated artifacts. Verify the required theme screenshot dimensions and update the changelog.

### Release Acceptance Criteria

- Clean installation and activation on a fresh WordPress site
- No PHP fatal errors, unexpected notices, placeholder links, or nonfunctional default forms
- Successful production build and lint runs
- Keyboard and responsive smoke tests passed
- Personal and business starter layouts tested
- WooCommerce-active and WooCommerce-inactive paths tested
- Documentation matches the released behavior
- Production package installs without requiring Node.js or Composer

## Non-Goals for This Roadmap

- Full block-theme rewrite
- Theme-registered custom post types
- Built-in form or newsletter delivery
- A proprietary page builder
- A demo importer before the underlying templates and patterns are stable
- Additional homepage variants before the canonical template is repaired

## Immediate Implementation Batch

The first implementation batch should contain only Phase 1 work:

1. Consolidate the homepage into `front-page.php`.
2. Consolidate theme support, menus, widget IDs, and WooCommerce setup.
3. Repair Customizer callbacks and remove disconnected settings.
4. Consolidate front-end and editor assets.
5. Remove placeholder interactions and misleading live defaults.
6. Run syntax, build, lint, and WordPress smoke checks.

After this batch passes its acceptance criteria, begin the personal and business block-pattern work in Phase 2.
