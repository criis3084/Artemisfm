<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Paciente;
use App\TipoPaciente;
use App\PersonaSinAcceso;
use Faker\Generator as Faker;

$factory->define(Paciente::class, function (Faker $faker) {
    return [
        'dia_apoyo' => $faker->numberBetween($min = 0, $max = 7),
        'persona_sin_acceso_id' => PersonaSinAcceso::pluck('id')[$faker->numberBetween(1,PersonaSinAcceso::count()-1)],
        'tipo_paciente_id' => TipoPaciente::pluck('id')[$faker->numberBetween(1,TipoPaciente::count()-1)],
        'estado' => $faker->numberBetween($min = 0, $max = 1),
    ];
});
