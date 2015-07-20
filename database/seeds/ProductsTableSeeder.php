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

        foreach(range(1,50) as $index){
            $products = Product::create([
                'product_name' => $faker->word,
                'product_image' => $faker->imageUrl($width = 400, $height = 400),
                'product_price' => $faker->randomNumber(2),
                'category_id' => $faker->randomElement($categories),
            ]);
        }
    }
}
