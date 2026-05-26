<?php

declare(strict_types=1);

$requiredFiles = [
    'style.css',
    'functions.php',
    'header.php',
    'footer.php',
];

$base = dirname(__DIR__);
$errors = [];

foreach ($requiredFiles as $requiredFile) {
    if (!is_file($base . DIRECTORY_SEPARATOR . $requiredFile)) {
        $errors[] = sprintf('Missing required theme file: %s', $requiredFile);
    }
}

$style = @file_get_contents($base . '/style.css');
if ($style === false) {
    $errors[] = 'Could not read style.css';
} else {
    foreach (['Theme Name:', 'Version:', 'Requires at least:', 'Requires PHP:'] as $header) {
        if (strpos($style, $header) === false) {
            $errors[] = sprintf('style.css is missing header field: %s', $header);
        }
    }
}

if ($errors !== []) {
    foreach ($errors as $error) {
        fwrite(STDERR, $error . PHP_EOL);
    }
    exit(1);
}

echo 'Smoke checks passed.' . PHP_EOL;
