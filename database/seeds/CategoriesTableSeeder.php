<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $category_name = $faker->word;

        foreach(range(1,5) as $index){
            Category::create([
                'category_name' => $category_name,
                'slug' => $category_name
            ]);
        }
    }
}
