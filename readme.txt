=== Clear ===
Contributors: alexaitken
Tags: blog, one-column, two-columns, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready, rtl-language-support, editor-style, accessibility-ready
Requires at least: 6.4
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 1.1.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A minimalist, privacy-friendly editorial theme for text-first WordPress publishing.

== Description ==

Clear is built for readable long-form content, calm archives, and practical customization.

Theme goals:

- clean editorial layouts
- accessible defaults
- predictable typography
- privacy-friendly behavior by default

Font behavior:

- By default, Clear uses a system font stack and does not request remote fonts.
- Optional: enable hosted Inter font from Google Fonts in **Appearance → Customize → Theme Presentation**.
- Developers can force or disable this behavior with the `clrthm_load_google_fonts` filter and customize URL with `clrthm_google_fonts_url`.

== Installation ==

1. Upload the theme folder to `/wp-content/themes/`.
2. Activate Clear in **Appearance → Themes**.
3. Assign menus in **Appearance → Menus**.
4. Optional: configure presentation settings in **Appearance → Customize**.

== Customization options ==

In **Theme Presentation**:

- Accent color
- Header layout (left or centered)
- Reading time toggle
- Author strip toggle
- Related posts toggle
- Homepage tagline toggle
- Author link toggle
- Footer copyright text
- Optional external Google Fonts toggle

== Menus ==

Clear registers three menu locations:

- Primary Menu
- Utility Menu
- Footer Menu

Unassigned locations do not output empty nav landmarks.

== Post layout tags and media guidance ==

Use categories and tags consistently so archive pages and related posts remain meaningful.

Recommended image sizes:

- Featured image default: 1600x900
- Card (`clrthm-card`): 960x640
- Single hero (`clrthm-single-hero`): 1400x900

== Development & Testing ==

Commands:

- `composer lint`
- `composer phpcs`
- `composer smoke`
- `composer test`
- `composer validate-version -- vX.Y.Z`
- `composer build-release`

Local stack:

1. `docker compose up -d`
2. Open `http://localhost:8080`
3. Activate Clear

== Theme Unit Test ==

Manual import:

1. Download Theme Unit Test XML data.
2. In wp-admin: **Tools → Import → WordPress**.
3. Upload file and assign authors.

WP-CLI import:

1. `wp plugin install wordpress-importer --activate`
2. Download XML from the WPTRT Theme Unit Test repository.
3. `wp import /path/to/themeunittestdata.wordpress.xml --authors=create`

== Release/version process ==

For each release, keep these in sync:

- `style.css` Version
- `readme.txt` Stable tag
- `composer.json` version

Validate with:

- `composer validate-version -- vX.Y.Z`

Then build:

- `composer build-release`

== Changelog ==

= 1.1.4 =
* Version bump.

= 1.1.3 =
* Version bump.

= 1.1.2 =
* Add Inter webfont as the default typography stack with system fallbacks.
* Add `clrthm_show_site_tagline` and `clrthm_link_author_pages` customizer controls.
* Refactor post byline and card layouts for improved responsive featured and entry-list presentation.

= 1.0.4 =
* Style refinements for single post layouts and media presentation.

= 1.0.3 =
* Version alignment updates.

= 1.0.0 =
* Initial release.
