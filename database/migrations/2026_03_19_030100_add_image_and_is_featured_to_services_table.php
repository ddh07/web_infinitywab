<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'image')) {
                $table->string('image')->nullable()->after('icon');
            }

            if (!Schema::hasColumn('services', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_active')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'is_featured')) {
                $table->dropIndex(['is_featured']);
                $table->dropColumn('is_featured');
            }

            if (Schema::hasColumn('services', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};

