# WPFrank Companion - Changelog

## [0.3.4] - 2026-05-12 — Customizer Restoration & Reliability Fixes

### Overview
Fixed critical issues with Customizer visibility, structural PHP errors, and the Section Order drag-and-drop functionality introduced during the theme-to-plugin migration.

### Files Changed
- `wpfrank-companion.php`
- `inc/homerix/customizer/frontpage-sections/hero-section.php`
- `inc/homerix/customizer/frontpage-sections/services-section.php`
- `inc/homerix/customizer/frontpage-sections/whyus-section.php`
- `inc/homerix/customizer/frontpage-sections/technicians-section.php`
- `inc/homerix/customizer/frontpage-sections/testimonials-section.php`
- `inc/homerix/customizer/frontpage-sections/cta-section.php`
- `inc/homerix/customizer/frontpage-sections/blog-section.php`
- `inc/homerix/customizer/sections-order/customizer-sections-order.php`
- `inc/homerix/customizer/sections-order/js/customizer-sections-order.js`
- `inc/homerix/customizer/sections-order/css/customizer-sections-order-style.css`
- `readme.txt`

### Detailed Technical Changes

#### 1. Core Initialization & Detection
- **`wpfrank-companion.php`**: Adjusted `wpfrank_companion_init` priority from default `10` to `9`. This ensures all theme-specific Customizer files are loaded and their hooks registered *before* the Customizer API reaches its main execution at priority 10, preventing a race condition where settings were being missed.
- **Theme Detection**: Updated the detection logic to use `get_template()` instead of `wp_get_theme()->name`. This ensures consistent behavior even when using child themes or if the theme name is translated.

#### 2. Customizer Visibility & Structural Fixes
- **Section Registration**: Restored missing `Kirki::add_section` calls in `hero-section.php`, `services-section.php`, and `whyus-section.php`. Without these explicit registrations, the fields existed but their containers were hidden in the Customizer UI.
- **PHP Repair**: Fixed a structural error in `services-section.php` where a prematurely placed closing brace was causing Customizer fields to be orphaned outside of the initialization function.

#### 3. Section Order Reordering (Drag & Drop)
- **Priority Filtering**: Updated all 7 homepage section registration files to use `apply_filters( 'section_priority', <default>, <id> )`. This was the missing link that allowed the "Section Order" settings to actually influence the Customizer UI and frontend rendering.
- **JS Modernization**: Updated `customizer-sections-order.js` with more robust selectors (targeting `#sub-accordion-panel-homerix_sections`) and improved the handle selector to `.accordion-section-title` for better compatibility with modern WordPress.
- **CSS Correction**: Resolved case-sensitivity issues in `customizer-sections-order-style.css` (changed `Homerix` to `homerix`) and removed hardcoded references to the `avantex` theme, ensuring drag handles now appear correctly for all sections.
- **Asset Paths**: Updated `customizer-sections-order.php` to use `WPFRANK_HOMERIX_URL`, fixing 404 errors for internal JS and CSS assets.

## [0.3.3] - 2026-03-24 — Homerix Theme Compliance Refactoring

### Overview
All content-generating functionality has been migrated from the **Homerix** theme to the **WPFrank Companion** plugin to comply with WordPress.org theme review guidelines. The theme now relies on action hooks and the companion plugin to render homepage sections, page templates, and manage default data.

---

### New Files & Directories

#### `inc/homerix/` — Homerix Theme Integration Module

| Path | Purpose |
|------|---------|
| `inc/homerix/homerix.php` | **Entry point.** Loaded by `wpfrank-companion.php` when Homerix theme is active. Registers page templates, loads all sub-modules. |
| `inc/homerix/default-content.php` | Creates default pages (About Us, Services, Contact, etc.) and assigns page templates on plugin activation or `init`. Sets WordPress reading settings (front page, posts page). |
| `inc/homerix/default-data/technicians.php` | Seeds default technician data into `theme_mods` on `init` and `customize_register`. Provides `homerix_get_default_technicians()` helper. |

#### Front-Page Sections (`inc/homerix/front-page/`)
Renders each homepage section via the `wpfrank_homerix_frontpage` action hook (called from theme's `front-page.php`).

| File | Section | Default Data |
|------|---------|--------------|
| `section-hero.php` | Hero slider | 3 slides with theme images |
| `section-services.php` | Services grid | 4 icon-based service cards |
| `section-whyus.php` | Why Choose Us | 4 icon-based feature cards |
| `section-technicians.php` | Technicians | 4 technician cards with images |
| `section-testimonials.php` | Testimonials | 3 testimonials |
| `section-cta.php` | Call-to-Action | Title + 2 buttons |
| `section-blog.php` | Latest Blog Posts | Dynamic from recent posts |

#### Page Templates (`inc/homerix/page-templates/`)
Plugin-based page templates registered via `theme_{post_type}_templates` filter.

| File | Template Name |
|------|---------------|
| `page-about-us.php` | Homerix About Us |
| `page-site-services.php` | Homerix Site Services |
| `page-find-technician.php` | Homerix Find a Technician |
| `page-book-now.php` | Homerix Book Now |
| `page-contact-us.php` | Homerix Contact Us |
| `page-faq.php` | Homerix FAQ |
| `page-privacy-policy.php` | Homerix Privacy Policy |
| `page-terms-of-service.php` | Homerix Terms of Service |

#### Customizer Sections (`inc/homerix/customizer/`)
All Kirki-based customizer panels for homepage sections and page templates.

| Directory | Contents |
|-----------|----------|
| `customizer/frontpage-sections/` | Hero, Services, WhyUs, Technicians, Testimonials, CTA, Blog, Sections-Order |
| `customizer/page-sections/` | About, Services Page, Contact, FAQ, Privacy, Terms, Book Now, Find Technician |
| `customizer/sections-order/` | Section reordering controls |

#### AJAX Handlers (`inc/homerix/ajax/`)

| File | Purpose |
|------|---------|
| `booking-handler.php` | Processes booking form submissions, creates `bookings` posts, sends HTML email notifications |
| `contact-handler.php` | Processes contact form submissions, sends HTML email notifications |

#### Post Types (`inc/homerix/post-types/`)

| File | Purpose |
|------|---------|
| `booking-details-display.php` | Adds custom columns and metaboxes to the `bookings` post type admin list |

#### Integrations (`inc/homerix/integrations/`)

| File | Purpose |
|------|---------|
| `kirki-loader.php` | Loads bundled Kirki customizer framework if not already active |

#### Email (`inc/homerix/email/`)

| File | Purpose |
|------|---------|
| `smtp-settings.php` | SMTP configuration customizer settings |

---

### Modified Files

#### `wpfrank-companion.php`
- Added Homerix theme detection via `get_template()` check
- Loads `inc/homerix/homerix.php` only when Homerix theme is active
- Added `register_activation_hook` to trigger default content creation on plugin activation

#### `readme.txt`
- Updated version and changelog entries

---

### Key Architecture Decisions

1. **Hook-based rendering:** Theme's `front-page.php` calls `do_action('wpfrank_homerix_frontpage')`. The companion plugin hooks into this action to render all homepage sections. If the plugin is deactivated, the theme shows a notice instead of sections.

2. **Plugin-based page templates:** Templates are registered via the `theme_page_templates` filter and loaded via `template_include` filter. The template slug uses the `homerix-companion/` prefix (e.g., `homerix-companion/page-about-us.php`).

3. **Template slug migration:** A one-time migration on `init` converts any existing pages using old theme-based slugs (`page-templates/...`) to the new plugin-based slugs (`homerix-companion/...`).

4. **Default data seeding:** Default pages and technician data are seeded on both plugin activation (`register_activation_hook`) and `init` (with option flags to prevent re-running). This handles both fresh installs and cases where the plugin is activated after the theme.

5. **Fallback defaults in templates:** Front-page sections and page templates include hardcoded default data arrays so content displays immediately without requiring Customizer interaction.

6. **Pro plugin compatibility:** All sections use `HOMERIX_IS_PRO()` (defined in theme) for feature limits, and `apply_filters('homerix_{section}_color_overrides', array())` for Pro color overrides. The Pro plugin hooks into these filters — no changes needed in Pro.

---

### Pro Plugin Compatibility Matrix

| Pro File | Integration Point | Status |
|----------|-------------------|--------|
| `class-pro-features.php` | Removes upgrade notices, hides Pro badges | ✅ Compatible |
| `class-pro-customizer.php` | Uses `HOMERIX_IS_PRO` constant | ✅ Compatible |
| `class-pro-color-overrides.php` | Filters: `homerix_{section}_color_overrides` | ✅ Compatible |
| `class-pro-book-now.php` | Action: `homerix_book_now_content` | ✅ Compatible |
| `class-pro-technicians.php` | Action: `homerix_find_technician_content` | ✅ Compatible |
| `class-pro-bookings.php` | Registers `bookings` post type (companion adds columns/metaboxes) | ✅ Compatible |

---

### Theme-Side Changes (for reference)

| File | Change |
|------|--------|
| `front-page.php` | Replaced section includes with `do_action('wpfrank_homerix_frontpage')` |
| `inc/autoloader.php` | Removed moved includes, added `inc/admin/class-homerix-bookings-teaser.php` |
| `functions.php` | Added companion plugin notice (admin + frontend) |
| `inc/admin/class-homerix-bookings-teaser.php` | Shows locked "Upgrade to Pro" bookings page when Pro is not active |
| Deleted files | All `inc/frontpage/`, `inc/customizer/frontpage-sections/`, `page-templates/`, `inc/ajax/`, `inc/default-data/`, `inc/post-types/` |
