<?php

$dir = __DIR__ . '/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

$replacements = [
    '$blog->category->name' => '$blog->categories->first()->name ?? \'Uncategorized\'',
    '$blog->category->image' => '$blog->categories->first()->image ?? \'\'',
    '$newsItem->category->name' => '$newsItem->categories->first()->name ?? \'News\'',
    '$newsItem->category->image' => '$newsItem->categories->first()->image ?? \'\'',
];

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $original = $content;
        
        foreach ($replacements as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }
        
        if ($content !== $original) {
            file_put_contents($file->getPathname(), $content);
            echo "Updated: " . $file->getPathname() . "\n";
        }
    }
}
echo "Done.";
