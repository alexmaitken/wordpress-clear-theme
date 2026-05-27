# Clear Theme Visual Audit & Implementation Plan

## Scope reviewed
- `style.css`
- `functions.php`
- `header.php`
- `footer.php`
- `home.php`
- `front-page.php`
- `archive.php`
- `search.php`
- `single.php`
- `page.php`
- `404.php`
- `comments.php`
- `template-parts/content-single.php`
- `template-parts/content-card.php`
- `template-parts/related-posts.php`
- `template-parts/author-box.php`
- `assets/css/editor-style.css`
- `README.md`
- `readme.txt`

## 1) Typography issues
- **Frontend/body and editor typography are mismatched**: frontend uses Inter sans stack globally, but editor style is serif (`ui-serif, Georgia...`). This causes WYSIWYG drift and undermines text-first polish.
  - Change targets: `style.css`, `assets/css/editor-style.css`, `functions.php` (editor style support is already enabled).
- **Single post heading/excerpt scale is dramatic and can dominate content flow** (`clamp(2.3rem, 6vw, 4.8rem)` and large excerpt sizing), which can feel more “marketing hero” than editorial reading mode.
  - Change targets: `.single-entry .entry-title`, `.single-entry .single-hero__excerpt` in `style.css`.
- **Tokenized type system is incomplete**: only base body and a few components have explicit rhythm/size tokens; no coherent scale for labels/meta/captions beyond ad-hoc values.
  - Change targets: `:root` in `style.css`, then apply to card/meta/byline/select headings.

## 2) Spacing / rhythm issues
- **Inconsistent border/padding strategy**: early rules define bordered cards/content blocks, later “homepage refresh” section zeroes borders and padding globally for `.post-card` and others, producing layered overrides and inconsistent visual rhythm.
  - Change targets: consolidate `style.css` sections around `.post-card`, `.entry-content`, `.home-author-strip`, `.empty-state`.
- **Header/footer/main rhythm not unified**: fixed values are used (`2rem`, `4rem`) despite `--clrthm-space` token existing; this limits responsive calmness.
  - Change targets: `.site-header`, `.site-main`, `.site-footer`, section spacing classes in `style.css`.
- **Card variants blend layout and skin in one class set**, making spacing harder to reason about for future customization.
  - Change targets: `.post-card--feature-*`, `.post-card--entry-row`, `.featured-grid` in `style.css`; class naming can remain but should split structure vs tone.

## 3) Homepage layout issues
- **`home.php` and `front-page.php` duplicate near-identical layout logic**, increasing maintenance risk and drift.
  - Change targets: `home.php`, `front-page.php` (extract common template part).
- **Featured grid semantics are visual-first but reading order can be uneven**: first 4 posts hard-split into one hero + 3 tiles without editorial controls.
  - Change targets: `home.php`, `front-page.php`, `template-parts/content-card.php`, and optionally customizer controls in `functions.php` for featured count/layout mode.
- **Tagline/intro is only present on `front-page.php`**, while `home.php` omits it, creating inconsistent first impression depending on Settings → Reading configuration.
  - Change targets: `home.php`, `front-page.php`.

## 4) Archive/search pagination issues
- **Pagination is rendered inside `.entry-list` grid wrappers on archive/search**, so nav can inherit grid context or awkward spacing.
  - Change targets: `archive.php`, `search.php` (close list before pagination; use dedicated nav wrapper).
- **Pagination treatment differs between home/front-page and archive/search** (front page has “Read more” section; others do not), reducing consistency.
  - Change targets: `home.php`, `front-page.php`, `archive.php`, `search.php`, shared pagination partial.
- **No explicit numeric/current-page styling beyond basic `.pagination .nav-links`**, so scanning long archives is weaker than Medium-like editorial UX.
  - Change targets: pagination styles in `style.css`.

## 5) Single-post reading experience issues
- **Share UI appears before content and aligned to the right**, which can distract from a text-first read path.
  - Change targets: `template-parts/content-single.php`, `.single-share` styles.
- **Hero section is visually heavy by default** (large media + gradient + oversized heading), potentially reducing focus on article body.
  - Change targets: `template-parts/content-single.php`, hero styles in `style.css`.
- **Byline string is localization-friendly but structurally flat text**, making finer semantic styling harder.
  - Change targets: `functions.php` (`clrthm_get_post_byline`) and associated CSS classes.
- **`the_post_navigation()` is default WordPress markup** with limited editorial affordances.
  - Change targets: `single.php` (custom nav template), `style.css` for stronger next/prev cards.

## 6) Mobile / responsive issues
- **Mobile rule constrains tile/entry media to `max-width: 8rem` even when single-column**, which can produce tiny thumbnails and awkward whitespace.
  - Change targets: `@media (max-width: 40rem)` in `style.css`.
- **Header has no menu toggle/off-canvas pattern**; both primary and utility menus remain wrap-based, which can become crowded on narrow screens.
  - Change targets: `header.php`, `style.css`, `functions.php` (if adding script enqueue for toggle behavior).
- **Content width is broad (`72rem` global content token) for some text-first contexts**; reading widths should be stricter by template/viewport.
  - Change targets: `--clrthm-content`, single/article width rules in `style.css`.

## 7) Menu / header issues
- **No fallback behavior if menus are unassigned** (`fallback_cb => false`), causing empty nav landmarks.
  - Change targets: `header.php`, `footer.php`; consider theme-safe fallback menus or conditional nav rendering with helpful setup prompts.
- **Header lacks search affordance** for editorial discovery.
  - Change targets: `header.php` + style treatment in `style.css`.
- **Branding and nav alignment logic has layered overrides** (`site-header` rules appear in multiple sections), increasing regressions risk.
  - Change targets: consolidate header CSS blocks in `style.css`.

## 8) SEO / semantic HTML issues
- **No explicit `<article>` list wrappers (`<ul>/<li>`) on archive-like views**; cards are valid as articles but list semantics for collections can improve crawl/readability tools.
  - Change targets: `home.php`, `front-page.php`, `archive.php`, `search.php`, card partial wrappers.
- **Single template lacks structured data output (JSON-LD or microdata hooks)**; generic open-source theme can still provide filterable schema helpers.
  - Change targets: `functions.php`, potentially `header.php`/`single.php` hooks.
- **Search results heading is good, but search forms and empty states can add stronger landmarks/assistive labels**.
  - Change targets: `search.php`, `404.php`, and potential custom `searchform.php` template.

## 9) Accessibility issues
- **Card image links are `aria-hidden="true" tabindex="-1"`**, removing duplicate tab-stops but also reducing expected clickable affordance for keyboard users relying on image-as-link patterns.
  - Change targets: `template-parts/content-card.php` and focus-visible patterns in `style.css`.
- **Color contrast risk in hero overlays and muted text** (`#6c6c6c` on white and white-on-gradient combos) should be verified against WCAG AA across states.
  - Change targets: color tokens and hero/card overlay styles in `style.css`.
- **Navigation landmarks may be empty when menus missing**, which creates low-value landmarks for assistive tech.
  - Change targets: `header.php`, `footer.php`.
- **Comments list markup lacks a dedicated class target and heading hierarchy tuning**, limiting screen-reader and visual consistency.
  - Change targets: `comments.php`, related CSS.

## 10) WordPress Theme Review risks
- **External Google Fonts dependency** in `functions.php` can be flagged or discouraged depending on review expectations/privacy posture.
  - Safer path: optional self-hosted fonts or system-font default with opt-in external font enqueue.
- **Theme metadata is not fully generic for open-source distribution** (`Author URI` points to a personal domain).
  - Change targets: theme header in `style.css`, plus `readme.txt`/`README.md` wording consistency.
- **Potential duplicate/override-heavy CSS architecture** can increase maintenance bugs that surface in review.
  - Change targets: `style.css` cleanup/refactor PR.
- **No explicit Theme Review checklist artifacts** beyond commands; docs could better map features to required supports and accessibility statements.
  - Change targets: `README.md`, `readme.txt`.

---

## Recommended PR sequence (safe, incremental)

### PR 1 — CSS architecture cleanup (no UX redesign yet)
- Normalize and deduplicate `style.css` sections (header, cards, single, breakpoints).
- Introduce consistent spacing/type tokens and replace repeated literals.
- Keep markup unchanged to minimize regression risk.

### PR 2 — Editor/frontend typography parity
- Align `assets/css/editor-style.css` with frontend typography system.
- Tune single-post heading/excerpt/body scale for sustained reading.
- Add docs note about typography goals and token usage.

### PR 3 — Shared home/front-page rendering
- Extract shared homepage rendering into a template part.
- Keep `front-page.php` additions (tagline) configurable and reusable.
- Maintain existing query behavior and pagination semantics.

### PR 4 — Pagination and archive/search structure
- Move pagination outside entry grids and unify patterns across templates.
- Improve nav labels and active/hover states for scanability.
- Add a shared pagination template part for consistency.

### PR 5 — Single reading experience refinement
- Simplify hero treatment and rebalance content-first hierarchy.
- Reposition/share controls with lower visual priority.
- Upgrade previous/next navigation to clearer editorial cards.

### PR 6 — Mobile header and menu ergonomics
- Add accessible menu toggle for narrow screens.
- Ensure utility nav behavior remains optional and non-breaking.
- Keep JavaScript minimal and progressively enhanced.

### PR 7 — Semantics, SEO hooks, and accessibility hardening
- Improve collection/list semantics for archive-like views.
- Add filterable structured-data hooks for single posts/site identity.
- Address contrast/focus/landmark edge cases and comment area semantics.

### PR 8 — Theme Review/documentation polish
- Provide privacy-friendly font strategy options.
- Make metadata and docs explicitly generic/open-source project oriented.
- Add a concise Theme Review compliance checklist to docs.
