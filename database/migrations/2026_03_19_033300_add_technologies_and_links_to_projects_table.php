<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'technologies')) {
                $table->json('technologies')->nullable()->after('client');
            }

            if (!Schema::hasColumn('projects', 'completion_date')) {
                $table->date('completion_date')->nullable()->after('image');
            }

            if (!Schema::hasColumn('projects', 'project_url')) {
                $table->string('project_url')->nullable()->after('completion_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'project_url')) {
                $table->dropColumn('project_url');
            }

            if (Schema::hasColumn('projects', 'completion_date')) {
                $table->dropColumn('completion_date');
            }

            if (Schema::hasColumn('projects', 'technologies')) {
                $table->dropColumn('technologies');
            }
        });
    }
};

