#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

THEME_SLUG="clear-theme"
DIST_DIR="$ROOT_DIR/dist"
STAGE_DIR="$DIST_DIR/$THEME_SLUG"
DISTIGNORE_FILE="$ROOT_DIR/.distignore"

VERSION="$(sed -n 's/^Version:[[:space:]]*//p' style.css | head -n1 | tr -d '\r')"
if [[ -z "$VERSION" ]]; then
  echo "Could not determine version from style.css" >&2
  exit 1
fi

./scripts/validate-version.sh "v$VERSION"

rm -rf "$DIST_DIR"
mkdir -p "$STAGE_DIR"

RSYNC_EXCLUDES=("--exclude=.git/" "--exclude=.git")

if [[ -f "$DISTIGNORE_FILE" ]]; then
  RSYNC_EXCLUDES+=("--exclude-from=$DISTIGNORE_FILE")
fi

rsync -a "${RSYNC_EXCLUDES[@]}" ./ "$STAGE_DIR/"

ZIP_NAME="$THEME_SLUG-$VERSION.zip"
(
  cd "$DIST_DIR"
  zip -rq "$ZIP_NAME" "$THEME_SLUG"
)

echo "Built release artifact: $DIST_DIR/$ZIP_NAME"
