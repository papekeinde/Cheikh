<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $broken = ['SunuTontine', 'PapiGPT', 'GestionSalaire', 'TestImo'];

        foreach ($broken as $titre) {
            DB::table('projets')
                ->where('titre', $titre)
                ->update(['lien' => null]);
        }
    }

    public function down(): void
    {
        $restore = [
            'SunuTontine' => 'https://sunutontine.onrender.com',
            'PapiGPT' => 'https://papigpt.onrender.com',
            'GestionSalaire' => 'https://gestionsalaire.onrender.com',
            'TestImo' => 'https://testimo.onrender.com',
        ];

        foreach ($restore as $titre => $lien) {
            DB::table('projets')
                ->where('titre', $titre)
                ->update(['lien' => $lien]);
        }
    }
};
