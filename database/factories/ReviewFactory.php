<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Review;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'review' => $faker->realtext(),
        'date_rdv' => $faker->date('Y-m-d', 'now'),
        'validation_status' => $faker->numberBetween(0, 3),
        'medecin_id' => $faker->numberBetween(1, 20),
        'user_id' => $faker->numberBetween(1, 40),
    ];
});

