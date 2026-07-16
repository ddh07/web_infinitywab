<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->longText('content');
            $table->text('excerpt')->nullable();

            $table->string('type'); // page, post, article, announcement
            $table->string('status'); // draft, published, archived

            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamp('published_at')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->string('featured_image')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->integer('order')->default(0)->index();

            $table->timestamps();

            $table->index(['type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};

