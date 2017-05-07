<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(),
        'body' => $faker->text($maxNbChars = 4095),
        'image_cover' => $faker->imageUrl($width = 640, $height = 480),
        'image_full' => $faker->imageUrl($width = 1920, $height = 1200),
        'tags' => $faker->words($nb = 5, $asText = false),
    ];
});