<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project; // Importa correttamente il modello Project
use App\Models\User; // Modello per l'utente
use Illuminate\Support\Facades\Hash; // Importa la classe Hash

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create([
            'title' => 'Progetto 1',
            'description' => 'Descrizione del progetto 1',
        ]);

        Project::create([
            'title' => 'Progetto 2',
            'description' => 'Descrizione del progetto 2',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password-segreta'), // Password hashata
            'is_admin' => true, // Aggiungo un campo is_admin per distinguere l'amministratore
        ]);
    }
}
