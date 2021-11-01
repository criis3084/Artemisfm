<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CasaMedica;
use App\Medicamento;
use App\CategoriaMedicamento;
use Faker\Generator as Faker;
$factory->define(Medicamento::class, function (Faker $faker) {
    return [
        'nombre' => $faker->lastName,
        'descripcion' => $faker->text($maxNbChars = 200),
        'stock_general'=> $faker->numberBetween($min = 20, $max = 300),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'categoria_medicamento_id' => factory(App\CategoriaMedicamento::class),
        'casa_medica_id' => factory(App\CasaMedica::class),
    ];
});
