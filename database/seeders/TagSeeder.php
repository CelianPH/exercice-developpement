<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    public function run()
    {
        // Exemple de données à insérer dans la table tags
        DB::table('tags')->insert([
            ['name' => 'Événement sportif'],
            ['name' => 'Tournois'],
            ['name' => 'Nourriture'],
            ['name' => 'Musique'],
            ['name' => 'Loisirs'],
        ]);
    }
}
