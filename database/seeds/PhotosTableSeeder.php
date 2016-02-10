<?php

use Illuminate\Database\Seeder;
use App\Photo;
use App\Product;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $products = Product::get()->lists('id')->all();

        foreach(range(1,200) as $index){
            $photos = Photo::create([
                'path' => $faker->imageUrl(),
                'product_id' => $faker->randomElement($products)
            ]);
        }
    }
}
