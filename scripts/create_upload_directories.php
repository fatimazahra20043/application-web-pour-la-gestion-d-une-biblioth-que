<?php

/**
 * Script to create necessary upload directories
 * Run this script once to ensure all directories exist
 */

$directories = [
    __DIR__ . '/../public/images',
    __DIR__ . '/../public/images/books',
];

foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
        echo "Created directory: $dir\n";
    } else {
        echo "Directory already exists: $dir\n";
    }
}

echo "\nAll directories are ready for image uploads!\n";
