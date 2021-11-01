<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CasaMedica;
use Faker\Generator as Faker;

$factory->define(CasaMedica::class, function (Faker $faker) {
    return [
        'nombre'=> $faker->company,
        'estado' => $faker->numberBetween($min = 0, $max = 1)
    ];
});
