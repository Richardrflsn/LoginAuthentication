<?php

namespace Database\Seeders;

use App\Models\Books;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 50; $i++){
            Books::create([
                'title' => $faker->sentence,
                'image' => $faker->imageUrl,
                'author' => $faker->name,
                'description' => $faker->paragraph,
                'publish_date' => $faker->date,
            ]);
        }
    }
}
