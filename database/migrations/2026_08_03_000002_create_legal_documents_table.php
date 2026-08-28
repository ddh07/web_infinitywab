<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legal_documents', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // 'confidentialite' | 'conditions-utilisation'
            $table->string('title');
            $table->enum('format', ['markdown', 'pdf'])->nullable();
            $table->longText('body')->nullable(); // source markdown brute, parsée à l'affichage
            $table->string('file_path')->nullable(); // chemin public relatif (public/legal/...)
            $table->string('original_filename')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_documents');
    }
};
