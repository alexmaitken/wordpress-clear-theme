# WordPress.org Theme Submission Checklist (Clear)

Date audited: 2026-05-28  
Theme slug/folder: `clear-theme`

## Status legend
- ✅ Pass in repository / automated check exists
- ⚠️ Manual or environment-dependent verification required
- ❌ Fail / must fix before submission

## 1) Required metadata and packaging

- ✅ Required theme header fields present in `style.css`.
- ✅ `readme.txt` exists with matching stable tag.
- ✅ Version consistency tooling exists (`composer validate-version`).
- ⚠️ Add/update `screenshot.png` (recommended 1200x900, representative front-end view).

Commands:

```bash
composer smoke
composer validate-version -- vX.Y.Z
composer build-release
unzip -l dist/clear-theme-$(sed -n 's/^Version:[[:space:]]*//p' style.css | head -n1).zip
```

## 2) Privacy and external requests

- ✅ No remote fonts/scripts required by default.
- ✅ Optional Google Fonts loading is explicit opt-in and documented.
- ⚠️ Re-test in browser network panel after major typography changes.

Commands:

```bash
composer test
```

Manual check:

1. Activate theme in local WP.
2. Open homepage with browser devtools Network tab.
3. Confirm no `fonts.googleapis.com` request unless Customizer opt-in is enabled.

## 3) Accessibility

- ✅ Skip link and focus-visible styles are present.
- ✅ Menus render without JavaScript fallback breakage.
- ⚠️ Manual keyboard and screen-reader checks still required.

Manual checks:

- Keyboard-only navigation through header, menus, search, post links, pagination, comment form.
- Verify visible focus contrast in light/dark monitor settings.
- Check heading order and landmark structure across homepage, archive, single, page, search, 404.

## 4) Internationalization and escaping

- ✅ Text domain is `clear-theme`.
- ✅ Theme strings use translation wrappers.
- ✅ Inputs/URLs/attributes are sanitized and escaped in templates and settings handling.
- ⚠️ Run a final grep pass before release if touching templates.

Commands:

```bash
composer phpcs
```

## 5) Licensing and credits

- ✅ Theme license is GPL-compatible in `style.css` and `readme.txt`.
- ⚠️ If adding third-party assets (fonts, icons, JS, images), document source + license in `readme.txt` Resources section.
- ✅ No bundled proprietary libraries currently detected.

## 6) Plugin-territory boundaries

- ✅ No CPT/taxonomy/shortcode/role/capability/storage features found in theme code.
- ✅ No analytics/telemetry or activation redirects found.
- ⚠️ Reconfirm if new feature work is merged.

Check command:

```bash
composer phpcs
```

## 7) Theme Unit Test and rendering QA

- ⚠️ Must be manually completed before WordPress.org upload.

Commands:

```bash
docker compose up -d
docker compose exec -T wordpress wp theme activate clear-theme --allow-root
docker compose exec -T wordpress wp plugin install wordpress-importer --activate --allow-root
docker compose exec -T wordpress bash -lc 'curl -fsSL https://raw.githubusercontent.com/WPTRT/theme-unit-test/master/themeunittestdata.wordpress.xml -o /tmp/themeunittestdata.wordpress.xml'
docker compose exec -T wordpress wp import /tmp/themeunittestdata.wordpress.xml --authors=create --allow-root
```

Manual pages to verify:

- Galleries/captions/alignment
- Nested comments
- Password-protected posts
- Long titles and long words
- Tables/code/preformatted blocks
- RTL rendering if possible

## 8) Runtime quality and debug checks

- ✅ Automated PHP lint + standards + smoke checks exist.
- ⚠️ Debug log and Theme Check plugin run require local WordPress runtime.

Commands:

```bash
composer test
composer docker:theme-check
```

Manual debug verification:

- Ensure `WP_DEBUG` and `WP_DEBUG_LOG` are enabled.
- Browse templates and confirm no warnings/notices in `wp-content/debug.log`.

## 9) CI/release pipeline checks

- ✅ CI runs lint, PHPCS, smoke (`composer test`).
- ✅ Release workflow validates tag/version consistency and builds zip artifact.
- ⚠️ Keep only one canonical CI workflow long-term to reduce maintenance drift.

## Submission-ready signoff

Before submission, all items below should be true:

- [ ] `composer test` passes locally
- [ ] Theme Unit Test content imported and reviewed
- [ ] Theme Check plugin run reviewed
- [ ] No debug notices/warnings
- [ ] Screenshot included and representative
- [ ] Version values aligned (`style.css`, `readme.txt`, `composer.json`)
- [ ] Final release zip built and contents verified
