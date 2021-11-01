<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Proveedor;
use App\PersonaSinAcceso;
use Faker\Generator as Faker;

$factory->define(Proveedor::class, function (Faker $faker) {
    return [
        'nombre' => $faker->firstNameMale,
        'persona_sin_acceso_id' => PersonaSinAcceso::pluck('id')[$faker->numberBetween(1,PersonaSinAcceso::count()-1)],
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
