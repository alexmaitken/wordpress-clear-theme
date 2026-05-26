#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

STYLE_FILE="style.css"
README_FILE="readme.txt"
COMPOSER_FILE="composer.json"

extract_style_version() {
  sed -n 's/^Version:[[:space:]]*//p' "$STYLE_FILE" | head -n1 | tr -d '\r'
}

extract_readme_version() {
  sed -n 's/^Stable tag:[[:space:]]*//p' "$README_FILE" | head -n1 | tr -d '\r'
}

extract_composer_version() {
  if [[ -f "$COMPOSER_FILE" ]]; then
    php -r '$j=json_decode(file_get_contents("composer.json"), true); if (isset($j["version"])) { echo $j["version"]; }'
  fi
}

is_semver() {
  [[ "$1" =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]]
}

STYLE_VERSION="$(extract_style_version)"
README_VERSION="$(extract_readme_version)"
COMPOSER_VERSION="$(extract_composer_version)"

if [[ -z "$STYLE_VERSION" ]]; then
  echo "Unable to read Version from $STYLE_FILE" >&2
  exit 1
fi

if [[ -z "$README_VERSION" ]]; then
  echo "Unable to read Stable tag from $README_FILE" >&2
  exit 1
fi

if ! is_semver "$STYLE_VERSION"; then
  echo "style.css version is not valid semver (MAJOR.MINOR.PATCH): $STYLE_VERSION" >&2
  exit 1
fi

if ! is_semver "$README_VERSION"; then
  echo "readme.txt stable tag is not valid semver (MAJOR.MINOR.PATCH): $README_VERSION" >&2
  exit 1
fi

if [[ "$STYLE_VERSION" != "$README_VERSION" ]]; then
  echo "Version mismatch: style.css has $STYLE_VERSION but readme.txt has $README_VERSION" >&2
  exit 1
fi

if [[ -n "$COMPOSER_VERSION" ]]; then
  if ! is_semver "$COMPOSER_VERSION"; then
    echo "composer.json version is not valid semver (MAJOR.MINOR.PATCH): $COMPOSER_VERSION" >&2
    exit 1
  fi

  if [[ "$STYLE_VERSION" != "$COMPOSER_VERSION" ]]; then
    echo "Version mismatch: style.css has $STYLE_VERSION but composer.json has $COMPOSER_VERSION" >&2
    exit 1
  fi
fi

if [[ -n "${1:-}" ]]; then
  TAG_VERSION="${1#v}"
  if ! is_semver "$TAG_VERSION"; then
    echo "Provided tag is not valid semver tag (expected vMAJOR.MINOR.PATCH): $1" >&2
    exit 1
  fi

  if [[ "$STYLE_VERSION" != "$TAG_VERSION" ]]; then
    echo "Version mismatch: project version is $STYLE_VERSION but tag is $1" >&2
    exit 1
  fi
fi

echo "Version validation passed: $STYLE_VERSION"
