<?php
$content = file_get_contents('resources/views/welcome.blade.php');

// Add the ID for fragment scrolling
$content = str_replace(
    '<div class="container-fluid px-4 px-xl-5 mb-5 mt-4">', 
    '<div id="more-articles" class="container-fluid px-4 px-xl-5 mb-5 mt-4">', 
    $content
);

// Replace the loop variable
$content = str_replace(
    '@forelse($latestBlogs->take(6) as $blog)', 
    '@forelse($paginatedBlogs as $blog)', 
    $content
);

// Add the pagination links after the row ends
$searchString = <<<'HTML'
        @endforelse
    </div>
</div>
HTML;

$replaceString = <<<'HTML'
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-5">
        {{ $paginatedBlogs->links('pagination::bootstrap-5') }}
    </div>
</div>
HTML;

$content = str_replace($searchString, $replaceString, $content);

file_put_contents('resources/views/welcome.blade.php', $content);
echo "Added pagination to welcome.blade.php";
