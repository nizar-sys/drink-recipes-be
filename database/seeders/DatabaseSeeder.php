<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CommentRecipe;
use App\Models\DrinkRecipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
        // Category::factory(10)->create();.
        // DrinkRecipe::factory(10)->create();
        // CommentRecipe::factory(1)->create();
    }
}
