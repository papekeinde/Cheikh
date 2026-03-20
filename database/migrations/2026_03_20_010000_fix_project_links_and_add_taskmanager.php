<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Fix Portfolio Dynamique link
        DB::table('projets')
            ->where('titre', 'Portfolio Dynamique')
            ->update([
                'lien' => 'https://cheikh-p6j9.onrender.com',
                'github' => 'https://github.com/papechk/foliolara',
            ]);

        // Fix GStockBoncoin tags
        DB::table('projets')
            ->where('titre', 'GStockBoncoin')
            ->update([
                'tags' => json_encode(['Laravel', 'Vue.js', 'Inertia.js', 'Tailwind']),
            ]);

        // Add TaskManager if not exists
        $exists = DB::table('projets')->where('titre', 'TaskManager')->exists();
        if (!$exists) {
            $userId = DB::table('users')->where('role', 'superadmin')->value('id');
            if ($userId) {
                DB::table('projets')->insert([
                    'user_id' => $userId,
                    'titre' => 'TaskManager',
                    'description' => 'Application de gestion de tâches avec système de rôles (admin, manager, utilisateur), assignation de tâches, filtrage par statut/priorité et tableau de bord par rôle.',
                    'image' => 'images/projets/taskmanager.png',
                    'lien' => 'https://taskmanager-uvp6.onrender.com',
                    'github' => 'https://github.com/papechk/TaskManager',
                    'tags' => json_encode(['Laravel', 'Breeze', 'Tailwind', 'Alpine.js']),
                    'ordre' => 2,
                    'complexite' => 75,
                    'type' => 'Web',
                    'status' => 'approved',
                    'progress' => 100,
                    'approved_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('projets')->where('titre', 'TaskManager')->delete();

        DB::table('projets')
            ->where('titre', 'Portfolio Dynamique')
            ->update([
                'lien' => 'https://cheikhkeinde.onrender.com',
                'github' => 'https://github.com/Pkeinde6/portfolio-with-adminPanel',
            ]);

        DB::table('projets')
            ->where('titre', 'GStockBoncoin')
            ->update([
                'tags' => json_encode(['Laravel', 'Breeze', 'MySQL', 'Tailwind']),
            ]);
    }
};
