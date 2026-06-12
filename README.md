# Clear WordPress Theme

Clear is a minimalist editorial WordPress theme designed for text-first publishing, predictable typography, and privacy-friendly defaults suitable for open-source distribution.

## Theme goals

- Readable, calm layouts for articles and archives.
- Minimal visual noise with good spacing and hierarchy.
- Accessibility-conscious defaults (visible focus, semantic landmarks, keyboard-friendly navigation).
- Privacy-first behavior by default (no external font requests unless explicitly enabled).

## Customization options

In **Appearance → Customize → Theme Presentation**:

- Accent color
- Header layout (left/centered)
- Show/hide reading time
- Show/hide featured author strip on homepage
- Show/hide related posts
- Show/hide homepage tagline
- Link author names/avatars to author pages
- Optional footer copyright text
- Optional opt-in for Google-hosted Inter font
- Social preview fallback image for Open Graph and X/Twitter cards

### Font strategy (privacy by default)

By default, Clear uses a system font stack and makes no remote font requests.

You can opt into Google Fonts either:

1. Via Customizer: enable **"Enable hosted Inter font from Google Fonts (external request)"**.
2. Via filter in a plugin or child theme:

```php
add_filter( 'clrthm_load_google_fonts', '__return_true' );
```

You can also override the URL:

```php
add_filter( 'clrthm_google_fonts_url', function () {
	return 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap';
} );
```

The same behavior applies in both frontend and block editor to keep typography aligned.

## Menu setup

Clear registers three locations:

- **Primary Menu** — main navigation
- **Utility Menu** — secondary links
- **Footer Menu** — footer links

Assign menus in **Appearance → Menus**. Empty locations do not output unused navigation landmarks.

## Post layout notes

Clear supports:

- Featured images with theme-defined crop sizes
- Per-post **Clear post layout** controls in the post editor sidebar (Featured image width + Featured image position)
- Reading-time byline
- Related posts section
- Optional author strip

For single posts, you can set:

- **Featured image width**: Content width, Large, Full width
- **Featured image position**: Above title, Left of title, Right of title

Backwards compatibility: older layout-control tags (`layout-left-image`, `layout-right-image`, `layout-full-width-image`) are still honored when meta settings are not set, and remain hidden from public tag output.

Recommended tags/categories: use meaningful editorial taxonomy (for example, section/category + topic tags) so archive and related content layouts remain useful.

## Recommended image sizes

- Post thumbnail default: `1600 x 900` (hard crop)
- Card image (`clrthm-card`): `960 x 640` (hard crop)
- Single hero (`clrthm-single-hero`): `1400 x 900` (hard crop)

For best results, upload featured images at or above the largest target size.

## Social link previews

Clear outputs Open Graph and X/Twitter Card metadata for single posts and static pages when a dedicated SEO plugin is not already managing those tags. For best results, use preview images sized **1200 × 627px**.

To set the fallback preview image for posts or pages without a featured image, go to **Appearance → Customize → Theme Presentation → Social preview fallback image** and upload or select an image. Featured images take priority over the fallback image.

To verify the rendered tags, open a post or page on the frontend, use your browser's **View Source** command, and search for `og:title`, `og:image`, and `twitter:card`.

Social metadata can be disabled when another plugin already provides it:

```php
add_filter( 'clrthm_enable_social_meta', '__return_false' );
```

The preview description is also available through the `clrthm_social_description` filter.

## Local development

```bash
composer install
composer test
```

Optional local WordPress stack:

```bash
docker compose up -d
```

Then open <http://localhost:8080> and activate **Clear**.

## Testing commands

```bash
composer lint             # PHP syntax checks
composer phpcs            # WPCS + Theme Review sniffs
composer smoke            # required file/header checks
composer test             # lint + phpcs + smoke
composer validate-version -- vX.Y.Z
composer build-release
```

## Theme Unit Test instructions

Manual import:

1. Download the Theme Unit Test XML data.
2. In wp-admin: **Tools → Import → WordPress**.
3. Upload XML and assign authors.

WP-CLI flow:

```bash
docker compose exec -T wordpress wp plugin install wordpress-importer --activate --allow-root
docker compose exec -T wordpress bash -lc 'curl -fsSL https://raw.githubusercontent.com/WPTRT/theme-unit-test/master/themeunittestdata.wordpress.xml -o /tmp/themeunittestdata.wordpress.xml'
docker compose exec -T wordpress wp import /tmp/themeunittestdata.wordpress.xml --authors=create --allow-root
```

## Release/version process

Keep these versions in sync:

- `style.css` → `Version:`
- `readme.txt` → `Stable tag:`
- `composer.json` → `version`

Validate:

```bash
composer validate-version -- vX.Y.Z
```

Build package:

```bash
composer build-release
```

CI and release workflows run these checks automatically.
