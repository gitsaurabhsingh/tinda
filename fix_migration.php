<?php
$dir = __DIR__;
$files = glob($dir . '/database/migrations/*_add_image_to_categories_table.php');
if (!empty($files)) {
    $file = $files[0];
    $content = file_get_contents($file);
    if (!str_contains($content, '->string(\'image\')')) {
        $content = str_replace(
            'public function up(): void
    {
        Schema::table(\'categories\', function (Blueprint $table) {',
            'public function up(): void
    {
        Schema::table(\'categories\', function (Blueprint $table) {
            $table->string(\'image\')->nullable();',
            $content
        );
        
        $content = str_replace(
            'public function down(): void
    {
        Schema::table(\'categories\', function (Blueprint $table) {',
            'public function down(): void
    {
        Schema::table(\'categories\', function (Blueprint $table) {
            $table->dropColumn(\'image\');',
            $content
        );
        file_put_contents($file, $content);
    }
}
