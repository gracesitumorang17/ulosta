<?php

// Check if can access from browser
$dirs = glob('C:\laragon\www\ulosta\public\storage\products\20\*', GLOB_ONLYDIR);
echo "<pre>";
print_r($dirs);
echo "</pre>";

// Check first image
if (!empty($dirs)) {
    $images = glob($dirs[0] . '\*');
    echo "<h3>Images in " . basename($dirs[0]) . ":</h3>";
    echo "<pre>";
    print_r($images);
    echo "</pre>";
}
