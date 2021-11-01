<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TipoPaciente;
use Faker\Generator as Faker;

$factory->define(TipoPaciente::class, function (Faker $faker) {
    return [
        'nombre'=> $faker->word,
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'descripcion'=> $faker->realText($maxNbChars = 100)
    ];
});
