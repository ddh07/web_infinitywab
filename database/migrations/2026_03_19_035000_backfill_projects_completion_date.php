<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('projects', 'completion_date')) {
            return;
        }

        if (!Schema::hasColumn('projects', 'project_date')) {
            return;
        }

        // In your DB, legacy invalid dates may exist as `0000-00-00` which can break strict mode.
        // Temporarily relax SQL mode for this migration only.
        DB::statement('SET @OLD_SQL_MODE := @@sql_mode');
        DB::statement('SET SESSION sql_mode = "ALLOW_INVALID_DATES"');

        // Backfill `completion_date` from legacy `project_date` for existing rows.
        DB::statement('
            UPDATE projects
            SET completion_date = CASE
                WHEN project_date IS NULL OR project_date = "0000-00-00" THEN NULL
                ELSE project_date
            END
            WHERE (completion_date IS NULL OR completion_date = "0000-00-00")
        ');

        DB::statement('SET SESSION sql_mode = @OLD_SQL_MODE');
    }

    public function down(): void
    {
        // No rollback for data backfill.
    }
};

