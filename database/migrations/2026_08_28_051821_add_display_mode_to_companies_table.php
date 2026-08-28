<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // Pilote la présentation publique de Mission/Vision/Valeurs (about.blade.php,
            // voir x-ui.content-list) : 'list' (défaut), 'cards' ou 'timeline'.
            $table->string('display_mode')->default('list')->after('values');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('display_mode');
        });
    }
};
