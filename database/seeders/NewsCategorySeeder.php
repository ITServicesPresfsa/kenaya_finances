<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Actualités',     'slug' => 'actualites'],
            ['name' => 'Services',       'slug' => 'services'],
            ['name' => 'Partenariats',   'slug' => 'partenariats'],
            ['name' => 'Conseils',       'slug' => 'conseils'],
            ['name' => 'Événements',     'slug' => 'evenements'],
        ];

        foreach ($categories as $cat) {
            NewsCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $this->command->info('✅ Catégories d\'actualités créées.');
    }
}
