<?php

declare(strict_types=1);

$directory = new RecursiveDirectoryIterator(__DIR__ . '/..');
$iterator  = new RecursiveIteratorIterator($directory);
$phpFiles  = [];

foreach ($iterator as $file) {
    if (!$file->isFile()) {
        continue;
    }

    $path = $file->getPathname();

    if (strpos($path, DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR) !== false) {
        continue;
    }

    if (substr($path, -4) === '.php') {
        $phpFiles[] = $path;
    }
}

sort($phpFiles);

$failed = false;

foreach ($phpFiles as $phpFile) {
    $command = sprintf('php -l %s 2>&1', escapeshellarg($phpFile));
    $output = [];
    exec($command, $output, $exitCode);

    echo implode(PHP_EOL, $output) . PHP_EOL;

    if ($exitCode !== 0) {
        $failed = true;
    }
}

if ($failed) {
    fwrite(STDERR, 'PHP lint failed.' . PHP_EOL);
    exit(1);
}

echo 'PHP lint passed.' . PHP_EOL;
