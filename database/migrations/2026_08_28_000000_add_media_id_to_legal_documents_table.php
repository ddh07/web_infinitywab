<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Les documents légaux (PDF/Markdown) passent par la bibliothèque de médias
     * partagée (table `media`) au lieu de leur propre stockage sous public/legal/ —
     * ils y sont réutilisables et bénéficient de la même gestion (suppression,
     * recherche) que les autres fichiers admin.
     */
    public function up(): void
    {
        Schema::table('legal_documents', function (Blueprint $table) {
            $table->foreignId('media_id')->nullable()->after('slug')->constrained('media')->nullOnDelete();
        });

        Schema::table('legal_documents', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'original_filename']);
        });
    }

    public function down(): void
    {
        Schema::table('legal_documents', function (Blueprint $table) {
            $table->string('file_path')->nullable();
            $table->string('original_filename')->nullable();
        });

        Schema::table('legal_documents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('media_id');
        });
    }
};
