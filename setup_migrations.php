<?php

$dir = __DIR__ . '/database/migrations/';
$files = scandir($dir);

foreach ($files as $file) {
    if (str_contains($file, 'create_users_table')) {
        file_put_contents($dir . $file, <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint \$table) {
            \$table->id();
            \$table->string('name');
            \$table->string('email')->unique();
            \$table->timestamp('email_verified_at')->nullable();
            \$table->string('password');
            \$table->text('bio')->nullable();
            \$table->json('social_links')->nullable();
            \$table->string('avatar')->nullable();
            \$table->rememberToken();
            \$table->timestamps();
        });
        Schema::create('password_reset_tokens', function (Blueprint \$table) {
            \$table->string('email')->primary();
            \$table->string('token');
            \$table->timestamp('created_at')->nullable();
        });
        Schema::create('sessions', function (Blueprint \$table) {
            \$table->string('id')->primary();
            \$table->foreignId('user_id')->nullable()->index();
            \$table->string('ip_address', 45)->nullable();
            \$table->text('user_agent')->nullable();
            \$table->longText('payload');
            \$table->integer('last_activity')->index();
        });
    }
    public function down(): void {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
PHP);
    } elseif (str_contains($file, 'create_categories_table')) {
        file_put_contents($dir . $file, <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('categories', function (Blueprint \$table) {
            \$table->id();
            \$table->string('name');
            \$table->string('slug')->unique();
            \$table->text('description')->nullable();
            \$table->string('seo_title')->nullable();
            \$table->text('seo_description')->nullable();
            \$table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('categories');
    }
};
PHP);
    } elseif (str_contains($file, 'create_blogs_table')) {
        file_put_contents($dir . $file, <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('blogs', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('user_id')->constrained()->onDelete('cascade');
            \$table->foreignId('category_id')->constrained()->onDelete('cascade');
            \$table->string('title');
            \$table->string('slug')->unique();
            \$table->longText('content');
            \$table->text('excerpt')->nullable();
            \$table->string('featured_image')->nullable();
            \$table->string('status')->default('draft'); // draft, pending, approved, rejected
            \$table->integer('views')->default(0);
            \$table->integer('reading_time')->default(0);
            \$table->boolean('is_featured')->default(false);
            \$table->boolean('is_trending')->default(false);
            \$table->string('seo_title')->nullable();
            \$table->text('seo_description')->nullable();
            \$table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('blogs');
    }
};
PHP);
    } elseif (str_contains($file, 'create_comments_table')) {
        file_put_contents($dir . $file, <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('comments', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('user_id')->constrained()->onDelete('cascade');
            \$table->foreignId('blog_id')->constrained()->onDelete('cascade');
            \$table->unsignedBigInteger('parent_id')->nullable();
            \$table->text('content');
            \$table->string('status')->default('pending'); // pending, approved
            \$table->timestamps();
            \$table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }
    public function down(): void {
        Schema::dropIfExists('comments');
    }
};
PHP);
    } elseif (str_contains($file, 'create_tags_table')) {
        file_put_contents($dir . $file, <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tags', function (Blueprint \$table) {
            \$table->id();
            \$table->string('name');
            \$table->string('slug')->unique();
            \$table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('tags');
    }
};
PHP);
    } elseif (str_contains($file, 'create_blog_tag_table')) {
        file_put_contents($dir . $file, <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('blog_tag', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('blog_id')->constrained()->onDelete('cascade');
            \$table->foreignId('tag_id')->constrained()->onDelete('cascade');
        });
    }
    public function down(): void {
        Schema::dropIfExists('blog_tag');
    }
};
PHP);
    } elseif (str_contains($file, 'create_subscribers_table')) {
        file_put_contents($dir . $file, <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('subscribers', function (Blueprint \$table) {
            \$table->id();
            \$table->string('email')->unique();
            \$table->string('status')->default('active');
            \$table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('subscribers');
    }
};
PHP);
    } elseif (str_contains($file, 'create_settings_table')) {
        file_put_contents($dir . $file, <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('settings', function (Blueprint \$table) {
            \$table->id();
            \$table->string('key')->unique();
            \$table->text('value')->nullable();
            \$table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('settings');
    }
};
PHP);
    }
}
echo "Migrations updated successfully.";
