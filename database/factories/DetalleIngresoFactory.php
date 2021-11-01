<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lote;
use App\DetalleIngreso;
use App\IngresoMedicamento;
use Faker\Generator as Faker;

$factory->define(DetalleIngreso::class, function (Faker $faker) {
    return [
        'ingreso_medicamento_id' => IngresoMedicamento::pluck('id')[$faker->numberBetween(1,IngresoMedicamento::count()-1)],
        'lote_id' => Lote::pluck('id')[$faker->numberBetween(1,Lote::count()-1)],
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
