<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CategoriaMedicamento;
use Faker\Generator as Faker;

$factory->define(CategoriaMedicamento::class, function (Faker $faker) {
    return [
        'nombre'=> $faker->domainWord,
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'descripcion'=> $faker->realText($maxNbChars = 100)
    ];
});
