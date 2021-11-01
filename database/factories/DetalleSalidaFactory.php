<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lote;
use App\DetalleSalida;
use App\SalidaMedicamento;
use Faker\Generator as Faker;

$factory->define(DetalleSalida::class, function (Faker $faker) {
    return [
        'cantidad'=>$faker->numberBetween($min = 1, $max = 15),
        'salida_medicamento_id' => SalidaMedicamento::pluck('id')[$faker->numberBetween(1,SalidaMedicamento::count()-1)],
        'lote_id' => Lote::pluck('id')[$faker->numberBetween(1,Lote::count()-1)],
        'estado' => $faker->numberBetween($min = 0, $max = 1),
    ];
});
