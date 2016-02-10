<?php

$factory->define(App\Photo::class, function (Faker\Generator $faker) {
    return [
        'path' => $faker->imageUrl,

    ];
});
