<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $categories = Category::get()->lists('id')->all();

        $product_name = $faker->word;

        foreach(range(1,25) as $index){
            $products = Product::create([
                'product_name' => $product_name,
                'product_price' => $faker->numberBetween(2),
                'long_description' => $faker->paragraph(3),
                'short_description' => $faker->sentence(6),
                'meta_description' => $faker->sentence(1),
                'is_active' => $faker->boolean(50),
                'category_id' => $faker->randomElement($categories),
                'slug' => $product_name
            ]);
        }
    }
}
