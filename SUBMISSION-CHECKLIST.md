# WordPress.org Theme Submission Readiness Checklist (Clear)

Date audited: 2026-05-26
Theme slug/folder: `clear-theme`

## Status legend
- ✅ Pass in current repository
- ⚠️ Needs manual verification or environment-dependent verification
- ❌ Fails / requires changes

## Compliance checklist

### Licensing & attribution
- ✅ GPL-compatible declared in `style.css` header (`GPL v2 or later`).
- ✅ GPL-compatible declared in `readme.txt`.
- ✅ No bundled third-party libraries/assets detected in `assets/` or PHP templates.
- ⚠️ If any assets are added before release, add source + license in `readme.txt` under a dedicated "Resources" section.

### Metadata requirements
- ✅ `style.css` has required header fields (Theme Name, Author, Description, Version, License, Text Domain, etc.).
- ⚠️ `readme.txt` is present and mostly complete, but WordPress.org reviewers prioritize `style.css` metadata; keep `readme.txt` synchronized on each release.

### Prohibited/restricted behaviors
- ✅ No remote scripts/fonts/images enqueued by default.
- ✅ No analytics/tracking/telemetry or opt-out tracking found.
- ✅ No plugin-territory features found (no CPTs/taxonomies/shortcodes/roles/mime type changes/custom blocks).
- ✅ No admin activation redirect found.
- ✅ No admin bar hiding found.
- ✅ No paywalled core WordPress features found.

### Prefixing, i18n, and security
- ✅ Theme functions/settings/hooks use `clrthm_` prefix.
- ✅ Text domain usage is consistently `clear-theme`.
- ✅ Translation wrappers are used for user-facing strings.
- ✅ Escaping/sanitization present broadly; share links were updated to output fully escaped URLs.

### Accessibility & UX
- ✅ Skip link exists and focus styles exist.
- ✅ Keyboard-focus-visible styles are defined globally.
- ⚠️ Manual keyboard navigation walkthrough still required in frontend QA.

### Core feature compatibility
- ✅ Templates exist for comments and password-protected posts behavior.
- ✅ Pagination support present via `the_posts_pagination()` and/or `wp_link_pages()`.
- ✅ HTML5 support enabled for gallery/caption/search-form/comment-form/comment-list/style/script.
- ⚠️ Manual visual checks still required for galleries/captions/embeds/tables/code blocks using Theme Unit Test content.

### Runtime quality
- ✅ PHP syntax lint passes.
- ⚠️ Full Theme Check plugin run is pending local Docker+WP-CLI setup.
- ⚠️ Full Theme Unit Test import/render verification is pending manual test environment.
- ⚠️ WP_DEBUG runtime notice/warning verification requires running WordPress instance and log inspection.

### Packaging
- ✅ `.distignore` exists and excludes development-only files from release zip.
- ✅ `scripts/build-release.sh` builds a release zip from filtered staging directory.
- ⚠️ `screenshot.png` is currently not included in this branch per workflow constraints; add a compliant 1200x900 PNG before final WordPress.org submission package.

## Remaining manual checks before upload
1. Launch local WordPress and activate theme.
2. Import Theme Unit Test data and inspect all edge cases:
   - nested comments
   - paginated posts
   - password-protected posts
   - galleries/captions
   - embeds
   - tables/code/preformatted blocks
3. Run Theme Check plugin and resolve any findings.
4. Browse with keyboard only (header menus, links, forms, comments, pagination).
5. Verify no warnings/notices in `wp-content/debug.log` with `WP_DEBUG=true`.
6. Build final zip and inspect contents to ensure no dev artifacts are included.

## Exact local commands to run before uploading
```bash
# 1) Install QA tooling
composer install

# 2) Static quality checks
composer test

# 3) Start local WordPress stack
docker compose up -d

# 4) Activate theme (if needed)
docker compose exec -T wordpress wp theme activate clear-theme --allow-root

# 5) Run Theme Check plugin
composer docker:theme-check

# 6) (Optional) Import Theme Unit Test content
docker compose exec -T wordpress wp plugin install wordpress-importer --activate --allow-root
docker compose exec -T wordpress bash -lc 'curl -fsSL https://raw.githubusercontent.com/WPTRT/theme-unit-test/master/themeunittestdata.wordpress.xml -o /tmp/themeunittestdata.wordpress.xml'
docker compose exec -T wordpress wp import /tmp/themeunittestdata.wordpress.xml --authors=create --allow-root

# 7) Build distribution zip
composer build-release

# 8) Quick inspect resulting archive
unzip -l dist/clear-theme-$(sed -n 's/^Version:[[:space:]]*//p' style.css | head -n1).zip
```
