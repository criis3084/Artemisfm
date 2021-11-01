<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lote;
use App\Medicamento;
use Faker\Generator as Faker;

$factory->define(Lote::class, function (Faker $faker) {
    return [
        'stock'=> $faker->numberBetween($min = 1, $max = 300),
        'fecha_expiracion' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'numero_referencia' => $faker->text($maxNbChars = 19),
        'medicamento_id' => Medicamento::pluck('id')[$faker->numberBetween(1,Medicamento::count()-1)],
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
