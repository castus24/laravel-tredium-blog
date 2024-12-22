<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        Article::factory()
//            ->count(20)
//            ->create();
//
//        Tag::factory()
//            ->count(30)
//            ->create();

        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);
    }
}
