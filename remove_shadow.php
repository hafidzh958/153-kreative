<?php
$files = glob(__DIR__ . '/resources/views/user/*.blade.php');
foreach ($files as $file) {
    if (is_file($file)) {
        $c = file_get_contents($file);
        $c = str_replace(' shadow-inner', '', $c);
        file_put_contents($file, $c);
    }
}
echo "Removed shadow-inner.\n";
