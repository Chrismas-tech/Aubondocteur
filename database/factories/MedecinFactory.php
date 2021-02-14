<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Medecin;
use Faker\Generator as Faker;

$factory->define(Medecin::class, function (Faker $faker) {
    return [
        'medecin_first_name' => $faker->firstName(),
        'medecin_last_name' => $faker->lastName(),

        'city' => $faker->randomElement(['Nice', 'Cagnes/Mer','Saint-Laurent du Var']),

        'speciality' => $faker->randomElement(['Médecin généraliste', 'Ophtalmologie', 'Pédiatrie', 'Gynécologie obstétrique', 'Dermatologie et vénérologie', 'Oto-Rhino-Laryngologie (ORL) et chirurgien cervico-facial', '	
        Cardiologie', 'Rhumatologie', 'Endocrinologie-diabétologie', 'Chirurgien urologue', 'Chirugien dentiste', 'Allergologie', 'Psychiatre', 'Psychiatre de l`\'enfant et de l\'adolescent', 'Gastro-entérologie et hépatologie', 'Radiologie', 'Pneumologie', 'Radiothérapeute', 'Néphrologie']),
        'phone' => $faker->phoneNumber(),
        'address' => $faker->address(),
        'zip_code' => $faker->randomElement(['06000','06800','06700']),

        'nb_reviews' => $faker->unique()->numberBetween(1, 20),
    ];
});
