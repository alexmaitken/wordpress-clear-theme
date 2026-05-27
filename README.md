# Clear WordPress Theme

A minimalist editorial WordPress theme focused on readability and calm visual rhythm.

## Local quality checks

### 1) Install test tooling

```bash
composer install
```

### 2) Run checks

```bash
composer lint   # PHP syntax checks
composer phpcs  # WordPress Coding Standards + Theme Review sniffs
composer test   # lint + phpcs + smoke tests
```

`composer test` is the primary local and CI command.

## Docker local WordPress environment

Start WordPress + MySQL:

```bash
docker compose up -d
```

Theme mount:

- Current repository is mounted to `/var/www/html/wp-content/themes/clear-theme` in the WordPress container.

Open WordPress at http://localhost:8080 and activate **Clear Theme**.

### Debug mode

`WP_DEBUG`, `WP_DEBUG_LOG`, and `SCRIPT_DEBUG` are enabled by default through `WORDPRESS_CONFIG_EXTRA` in `docker-compose.yml`.

### Optional Theme Check

You can run Theme Check inside the WordPress container (requires running containers):

```bash
composer docker:theme-check
```

## Theme Unit Test data import

You can import the Theme Unit Test XML data either manually in wp-admin or via WP-CLI.

### Manual import

1. Download the Theme Unit Test XML file.
2. In wp-admin, go to **Tools → Import → WordPress**.
3. Upload the XML file and assign authors.

### WP-CLI import (inside container, requires WP-CLI in `wordpress:php8.2-apache`)

> The `wordpress:php8.2-apache` image does not include `wp` by default.
> Install WP-CLI in that container, or run these commands from a dedicated WP-CLI image.

```bash
docker compose exec -T wordpress wp plugin install wordpress-importer --activate --allow-root
docker compose exec -T wordpress bash -lc 'curl -fsSL https://raw.githubusercontent.com/WPTRT/theme-unit-test/master/themeunittestdata.wordpress.xml -o /tmp/themeunittestdata.wordpress.xml'
docker compose exec -T wordpress wp import /tmp/themeunittestdata.wordpress.xml --authors=create --allow-root
```

## CI

GitHub Actions runs the same command used locally:

```bash
composer test
```

Workflow file: `.github/workflows/ci.yml`.


## Release version bumps

When asked to bump the theme version, update all three locations together so release tooling stays in sync:

- `style.css` header `Version:`
- `readme.txt` `Stable tag:`
- `composer.json` `version`

Then validate with:

```bash
composer validate-version -- vX.Y.Z
```

