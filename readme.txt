=== Clear ===
Contributors: alexaitken
Tags: blog, editorial, minimal
Requires at least: 6.4
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 1.1.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Clear is a minimalist editorial WordPress theme focused on readability and calm visual rhythm.

== Description ==

Clear provides text-first layouts, featured image cards, archive pages, and polished typography using the Inter webfont with system fallbacks.

== Installation ==

1. Upload the theme folder to `/wp-content/themes/`.
2. Activate Clear in Appearance > Themes.
3. Configure menus in Appearance > Menus.


== Menus & Header Behavior ==

Clear registers three menu locations:

- **Primary Menu**: main navigation.
- **Utility Menu**: secondary links (e.g., About, Contact, Subscribe).
- **Footer Menu**: optional links in the site footer.

Navigation landmarks are only rendered when a menu is assigned to that location, so empty `<nav>` landmarks are not output.

On smaller screens, the header uses a progressively enhanced menu toggle. Without JavaScript, assigned menus remain visible. With JavaScript enabled, the toggle controls the menu panel and updates `aria-expanded`.

The header also includes the standard WordPress search form as a low-emphasis affordance.

== Development & Testing ==

Run quality checks locally:

1. `composer install`
2. `composer test`

Available commands:

- `composer lint` for PHP syntax validation.
- `composer phpcs` for WordPress coding standards and theme review sniffs.
- `composer test` for lint + coding standards + smoke checks.

Docker local WordPress environment:

1. `docker compose up -d`
2. Open `http://localhost:8080`
3. Activate **Clear Theme**

The docker configuration enables `WP_DEBUG`, `WP_DEBUG_LOG`, and `SCRIPT_DEBUG`.

Optional Theme Check command:

- `composer docker:theme-check`

Theme Unit Test content import:

- Manual: wp-admin → Tools → Import → WordPress importer.
- WP-CLI: install `wordpress-importer`, download XML from WPTRT, run `wp import`.

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
