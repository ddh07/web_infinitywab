<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // vision passe de varchar(255) à text pour porter plusieurs énoncés (JSON) ;
        // ALTER direct plutôt que Schema::table(...)->change() pour éviter d'ajouter
        // doctrine/dbal comme dépendance juste pour cette migration.
        DB::statement('ALTER TABLE companies MODIFY vision TEXT NULL');

        Schema::table('companies', function (Blueprint $table) {
            $table->json('values')->nullable()->after('mission');
        });

        // vision/mission passent d'une phrase unique à une liste (voir Company::$casts) :
        // on enveloppe le contenu texte existant dans un tableau à un élément pour ne
        // rien perdre au passage au nouveau format.
        DB::table('companies')->get()->each(function ($company) {
            $updates = [];
            foreach (['vision', 'mission'] as $field) {
                $value = $company->$field;
                if ($value === null || $value === '') {
                    continue;
                }
                json_decode($value);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $updates[$field] = json_encode([$value]);
                }
            }
            if ($updates) {
                DB::table('companies')->where('id', $company->id)->update($updates);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('values');
        });

        DB::statement('ALTER TABLE companies MODIFY vision VARCHAR(255) NULL');
    }
};
